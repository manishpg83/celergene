<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class ImportCustomers extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $file;
    public $imported = 0;
    public $skippedDuplicates = 0;
    public $duplicateEmails = [];
    public $skippedInvalid = 0;
    public $errors = [];
    public $showPreview = false;
    public $previewData = [];
    public $totalRows = 0;
    public $allData = [];
    public $startRow = 1;
    public $endRow;
    public $rangeValidationError = '';
    public $previewPerPage = 10;
    public $currentPage = 1;
    public $generatedEmails = [];

    protected $rules = [
        'file' => 'required|file|mimes:xlsx,xls|max:10240',
        'startRow' => 'required|integer|min:1',
        'endRow' => 'nullable|integer|min:1',
    ];

    public function updatedStartRow()
    {
        $this->validateRange();
    }

    public function updatedEndRow()
    {
        $this->validateRange();
    }

    private function validateRange()
    {
        $this->rangeValidationError = '';

        if (!$this->totalRows) {
            return;
        }

        if ($this->startRow < 1) {
            $this->rangeValidationError = 'Start row must be at least 1';
            return;
        }

        if ($this->startRow > $this->totalRows) {
            $this->rangeValidationError = 'Start row exceeds total number of rows';
            return;
        }

        if (!empty($this->endRow)) {
            if ($this->endRow < $this->startRow) {
                $this->rangeValidationError = 'End row must be greater than or equal to start row';
                return;
            }

            if ($this->endRow > $this->totalRows) {
                $this->rangeValidationError = 'End row exceeds total number of rows';
                return;
            }
        }
    }

    public function render()
    {
        $paginatedPreviewData = collect([]);

        if ($this->showPreview && !empty($this->previewData)) {
            $offset = ($this->currentPage - 1) * $this->previewPerPage;
            $paginatedPreviewData = collect(array_slice($this->previewData, $offset, $this->previewPerPage));

            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedPreviewData,
                count($this->previewData),
                $this->previewPerPage,
                $this->currentPage
            );

            $paginator->withPath('');
        }

        return view('livewire.admin.import-customers', [
            'paginatedPreviewData' => $paginatedPreviewData,
            'paginator' => $paginator ?? null
        ]);
    }

    public function gotoPage($page)
    {
        $this->currentPage = $page;
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
        }
    }

    public function nextPage()
    {
        $maxPage = ceil(count($this->previewData) / $this->previewPerPage);
        if ($this->currentPage < $maxPage) {
            $this->currentPage++;
        }
    }

    public function preview()
    {
        set_time_limit(500);
        $this->validate(['file' => 'required|file|mimes:xlsx,xls']);

        try {
            $path = $this->file->getRealPath();
            $data = Excel::toArray([], $path)[0];
            $headers = array_shift($data);


            $this->allData = [];
            foreach ($data as $row) {
                if (count($headers) == count($row)) {
                    $this->allData[] = array_combine($headers, $row);
                }
            }

            $this->totalRows = count($this->allData);
            $this->endRow = $this->totalRows;

            $this->updatePreviewData();
            $this->showPreview = true;
            $this->currentPage = 1;

        } catch (\Exception $e) {
            Log::error('Customer import preview failed', [
                'error' => $e->getMessage(),
                'file' => $this->file->getClientOriginalName()
            ]);
            $this->addError('file', 'Preview failed: ' . $e->getMessage());
        }
    }

    public function updatePreviewData()
    {
        if (empty($this->allData)) {
            return;
        }

        $startIndex = max(0, $this->startRow - 1);
        $endIndex = empty($this->endRow) ? $this->totalRows : min($this->endRow, $this->totalRows);

        $this->previewData = array_slice($this->allData, $startIndex, $endIndex - $startIndex);

        $this->currentPage = 1;
    }

    public function import()
    {
        set_time_limit(3600);
        ini_set('memory_limit', '1024M');
        gc_enable();

        $this->validate();
        $this->validateRange();

        if (!empty($this->rangeValidationError)) {
            return;
        }
        $existingMax = User::where('email', 'regexp', '^developer\\+[0-9]+@predsolutions\\.com$')
        ->selectRaw('MAX(CAST(REGEXP_SUBSTR(email, \'[0-9]+\') AS UNSIGNED)) as max_counter')
        ->value('max_counter') ?? 0;
        $blankEmailCounter = $existingMax + 1;
        $this->generatedEmails = [];
        $this->duplicateEmails = [];
        $importStartTime = now();

        try {
            $startIndex = max(0, $this->startRow - 1);
            $endIndex = empty($this->endRow) ? $this->totalRows : min($this->endRow, $this->totalRows);
            $dataToImport = array_slice($this->allData, $startIndex, $endIndex - $startIndex);

            $this->imported = 0;
            $this->skippedDuplicates = 0;
            $this->skippedInvalid = 0;
            $this->errors = [];
           
            foreach ($dataToImport as $index => $rowData) {
                try {
                    $rowNumber = $startIndex + $index + 2;

                    if (empty($rowData['billing_email'])) {
                        $generatedEmail = "developer+{$blankEmailCounter}@predsolutions.com";
                        $rowData['billing_email'] = $generatedEmail;
                        $this->generatedEmails[] = [
                            'row' => $rowNumber,
                            'email' => $generatedEmail
                        ];
                        $blankEmailCounter++;
                    }

                    if (User::where('email', $rowData['billing_email'])->exists()) {
                        $this->duplicateEmails[] = [
                            'email' => $rowData['billing_email'],
                            'row' => $rowNumber
                        ];
                        $this->skippedDuplicates++;
                        Log::warning('Duplicate email skipped', [
                            'row' => $rowNumber,
                            'email' => $rowData['billing_email']
                        ]);
                        continue;
                    }

                    // Create User
                    $user = User::create([
                        'name' => trim(($rowData['first_name'] ?? '') . ' ' . ($rowData['last_name'] ?? '')),
                        'first_name' => $rowData['first_name'] ?? null,
                        'last_name' => $rowData['last_name'] ?? 'N/A',
                        'email' => $rowData['billing_email'],
                        'password' => Hash::make($rowData['password'] ?? Str::random(10)),
                        'company' => $rowData['billing_company_name'] ?? null,
                        'phone' => $rowData['billing_phone'] ?? null,
                        'address' => $rowData['billing_address'] ?? null,
                        'city' => $rowData['billing_city'] ?? null,
                        'state' => $rowData['billing_state'] ?? null,
                        'zip' => $rowData['billing_postal_code'] ?? null,
                        'country' => $rowData['billing_country'] ?? null,
                        'date_of_birth' => $rowData['date_of_birth'] ?? null,
                        'status' => $rowData['status'] ?? 'active',
                        'type' => 'customer',
                        'created_by' => auth()->id(),
                    ]);

                    // Create Customer record
                    Customer::create([
                        'user_id' => $user->id,
                        'customer_type_id' => $rowData['customer_type_id'] ?? 1,
                        'status' => $rowData['status'] ?? 'active',
                        'first_name' => $rowData['first_name'] ?? null,
                        'last_name' => $rowData['last_name'] ?? 'N/A',
                        'mobile_number' => $rowData['resmobile'] ?? null,
                        'email' => $rowData['billing_email'],
                        'company_name' => $rowData['billing_company_name'] ?? null,
                        'business_reg_number' => $rowData['business_reg_number'] ?? null,
                        'vat_number' => $rowData['vat_number'] ?? null,
                        'billing_address' => $rowData['billing_address'] ?? null,
                        'billing_fname' => $rowData['first_name'] ?? null,
                        'billing_lname' => $rowData['last_name'] ?? 'N/A',
                        'billing_address_2' => $rowData['billing_address_2'] ?? null,
                        'billing_city' => $rowData['billing_city'] ?? null,
                        'billing_state' => $rowData['billing_state'] ?? null,
                        'billing_phone' => $rowData['billing_phone'] ?? null,
                        'billing_email' => $rowData['billing_email'] ?? null,
                        'billing_company_name' => $rowData['billing_company_name'] ?? null,
                        'billing_country' => $rowData['billing_country'] ?? null,
                        'billing_postal_code' => $rowData['billing_postal_code'] ?? null,
                        'shipping_address_receiver_lname_1' => $rowData['shipping_address_receiver_lname_1'] ?? null,
                        'shipping_address_1' => $rowData['shipping_address_1'] ?? null,
                        'shipping_address_1_1' => $rowData['shipping_address_1_1'] ?? null,
                        'shipping_city_1' => $rowData['shipping_city_1'] ?? null,
                        'shipping_state_1' => $rowData['shipping_state_1'] ?? null,
                        'shipping_phone_1' => $rowData['shipping_phone_1'] ?? null,
                        'shipping_email_1' => $rowData['shipping_email_1'] ?? null,
                        'shipping_country_1' => $rowData['shipping_country_1'] ?? null,
                        'shipping_postal_code_1' => $rowData['shipping_postal_code_1'] ?? $rowData['offpincode'] ?? null,
                        'created_by' => $rowData['created_by'] ?? auth()->id(),
                        'updated_by' => $rowData['updated_by'] ?? auth()->id(),
                        'created_at' => $rowData['created_at'] ?? now(),
                        'updated_at' => $rowData['updated_at'] ?? now(),
                    ]);

                    $this->imported++;

                } catch (\Exception $e) {
                    $errorMsg = "Row {$rowNumber}: " . $e->getMessage();
                    $this->errors[] = $errorMsg;
                    $this->skippedInvalid++;
                }
            }

            $importDuration = now()->diffInSeconds($importStartTime);

            Log::info('Customer import completed', [
                'imported' => $this->imported,
                'skipped_duplicates' => $this->skippedDuplicates,
                'duplicate_emails' => $this->duplicateEmails,
                'errors' => count($this->errors),
                'duration_seconds' => $importDuration,
                'row_range' => "{$this->startRow}-{$this->endRow}",
            ]);

            $this->dispatch('import-complete', [
                'imported' => $this->imported,
                'skippedDuplicates' => $this->skippedDuplicates,
                'duplicateEmails' => $this->duplicateEmails,
                'skippedInvalid' => $this->skippedInvalid,
                'errors' => count($this->errors),
            ]);

        } catch (\Exception $e) {
            Log::error('Customer import failed', [
                'error' => $e->getMessage(),
                'file' => $this->file->getClientOriginalName()
            ]);
            $this->addError('file', 'Error processing Excel file: ' . $e->getMessage());
        }
    }

    public function cancelPreview()
    {
        $this->reset(['file', 'previewData', 'showPreview', 'allData', 'totalRows', 'startRow', 'endRow', 'rangeValidationError', 'currentPage']);
    }

    public function downloadLog()
    {
        $importId = 'import_' . date('Ymd_His');
        $fileName = 'customer_import_log_' . $importId . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($importId) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Import ID: ' . $importId,
                'Date: ' . now()->format('Y-m-d H:i:s'),
                'Total Records: ' . $this->totalRows,
                'Imported: ' . $this->imported,
                'Skipped Duplicates: ' . $this->skippedDuplicates,
                'Skipped Invalid: ' . $this->skippedInvalid,
                'Row Range: ' . $this->startRow . '-' . (empty($this->endRow) ? $this->totalRows : $this->endRow)
            ]);

            fputcsv($file, []);

            if (count($this->duplicateEmails) > 0) {
                fputcsv($file, ['SKIPPED_DUPLICATE', 'Row', 'Email']);
                foreach ($this->duplicateEmails as $duplicate) {
                    fputcsv($file, ['SKIPPED_DUPLICATE', $duplicate['row'], $duplicate['email']]);
                }
                fputcsv($file, []);
            }
            if (count($this->generatedEmails) > 0) {
                fputcsv($file, ['GENERATED_EMAIL', 'Row', 'Email']);
                foreach ($this->generatedEmails as $generated) {
                    fputcsv($file, ['GENERATED_EMAIL', $generated['row'], $generated['email']]);
                }
                fputcsv($file, []);
            }

            if (count($this->errors) > 0) {
                fputcsv($file, ['SKIPPED_ERROR', 'Details']);
                foreach ($this->errors as $error) {
                    fputcsv($file, ['SKIPPED_ERROR', $error]);
                }
            }

            fclose($file);
        };
        // Do not Remove this log code its use for logdownloading
        Log::info('Customer import log downloaded', [
            'import_id' => $importId,
            'user_id' => auth()->id(),
            'imported' => $this->imported,
            'skipped' => $this->skippedDuplicates + $this->skippedInvalid
        ]);

        return response()->stream($callback, 200, $headers);
    }
}