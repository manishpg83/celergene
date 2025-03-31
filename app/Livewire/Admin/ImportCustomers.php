<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ImportCustomers extends Component
{
    use WithFileUploads;

    public $file;
    public $imported = 0;
    public $errors = [];
    public $showPreview = false;
    public $previewData = [];
    protected $rules = [
        'file' => 'required|file|mimes:xlsx,xls|max:10240',
    ];

    public function render()
    {
        return view('livewire.admin.import-customers');
    }

    public function preview()
    {
        set_time_limit(500);

        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $path = $this->file->getRealPath();
        $data = Excel::toArray([], $path)[0];

        $headers = array_shift($data);
        $this->previewData = array_slice($data, 0, 5);
        $this->showPreview = true;
    }

    public function import()
    {
        set_time_limit(0); // Disable time limit
        ini_set('memory_limit', '1024M');
        
        $this->validate();

        try {
            $path = $this->file->getRealPath();
            $data = Excel::toArray([], $path)[0];

            $headers = array_shift($data);

            foreach ($data as $index => $row) {
                try {
                    $rowData = array_combine($headers, $row);

                    $rowValidator = Validator::make($rowData, [
                        'billing_email' => 'required|email',
                        'first_name' => 'required',
                        'last_name' => 'required',
                    ]);

                    if ($rowValidator->fails()) {
                        $this->errors[] = "Row " . ($index + 2) . ": " . implode(' ', $rowValidator->errors()->all());
                        continue;
                    }

                    if (User::where('email', $rowData['billing_email'])->exists()) {
                        $this->errors[] = "Row " . ($index + 2) . ": User with email " . $rowData['billing_email'] . " already exists";
                        continue;
                    }

                    $user = User::create([
                        'name' => trim(($rowData['first_name'] ?? '') . ' ' . ($rowData['last_name'] ?? '')),
                        'first_name' => $rowData['first_name'] ?? null,
                        'last_name' => $rowData['last_name'] ?? null,
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

                    Customer::create([
                        'user_id' => $user->id,
                        'customer_type_id' => $rowData['customer_type_id'] ?? 1,
                        'status' => $rowData['status'] ?? 'active',
                        'first_name' => $rowData['first_name'] ?? null,
                        'last_name' => $rowData['last_name'] ?? null,
                        'mobile_number' => $rowData['resmobile'] ?? null,
                        'email' => $rowData['billing_email'],
                        'company_name' => $rowData['billing_company_name'] ?? null,
                        'business_reg_number' => $rowData['business_reg_number'] ?? null,
                        'vat_number' => $rowData['vat_number'] ?? null,
                        'billing_address' => $rowData['billing_address'] ?? null,
                        'billing_fname' => $rowData['first_name'] ?? null,
                        'billing_lname' => $rowData['last_name'] ?? null,
                        'billing_address_2' => $rowData['billing_address_2'] ?? null,
                        'billing_city' => $rowData['billing_city'] ?? null,
                        'billing_state' => $rowData['billing_state'] ?? null,
                        'billing_phone' => $rowData['billing_phone'] ?? null,
                        'billing_email' => $rowData['billing_email'],
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
                    $this->errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            $this->dispatch('import-complete', imported: $this->imported, errors: count($this->errors));
        } catch (\Exception $e) {
            $this->addError('file', 'Error processing Excel file: ' . $e->getMessage());
        }
    }


    public function cancelPreview()
    {
        $this->reset(['file', 'previewData', 'showPreview']);
    }
}
