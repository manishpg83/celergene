<?php

namespace App\Livewire\Admin\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\CustomerInvoice;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CustomerTabs extends Component
{
    use WithPagination, WithFileUploads;
    
    protected $queryString = [];
    protected $paginationTheme = 'bootstrap';
    
    public $customer;
    public $activeTab = 'overview';
    public $invoiceFile;
    
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($customer)
    {
        $this->customer = $customer;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function uploadInvoice()
    {
        $this->validate([
            'invoiceFile' => 'required|mimes:pdf|max:2048',
        ]);
    
        $directory = public_path('admin/invoices');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    
        $originalName = $this->invoiceFile->getClientOriginalName();
        $safeName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) 
                  . '_' . time() 
                  . '.' . $this->invoiceFile->getClientOriginalExtension();
    
        try {
            Storage::disk('public')->putFileAs(
                'admin/invoices',
                $this->invoiceFile,
                $safeName
            );
    
            CustomerInvoice::create([
                'customer_id' => $this->customer->id,
                'invoice_number' => 'INV-' . now()->format('Ymd-His'),
                'invoice_date' => now(),
                'amount' => 0,
                'file_path' => 'admin/invoices/'.$safeName,
                'original_filename' => $originalName,
                'notes' => 'Uploaded on ' . now()->format('Y-m-d'),
            ]);
    
            $this->reset('invoiceFile');
            notyf()->success('PDF uploaded successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to upload: '.$e->getMessage());
        }
    }

    public function clearFile()
    {
        $this->reset('invoiceFile');
    }

    public function downloadInvoice($invoiceId)
    {
        $invoice = CustomerInvoice::findOrFail($invoiceId);
        
        return response()->download(storage_path('app/public/' . $invoice->file_path));
    }    

    public function deleteInvoice($invoiceId)
    {
        $invoice = CustomerInvoice::findOrFail($invoiceId);
        Storage::disk('public')->delete($invoice->file_path);
        $invoice->delete();
        $this->dispatch('refreshComponent');
        session()->flash('message', 'Invoice deleted successfully.');
    }

    public function viewInvoice($invoiceId)
    {
        $invoice = CustomerInvoice::findOrFail($invoiceId);
        return response()->file(storage_path('app/public/' . $invoice->file_path));
    }

    public function render()
    {
        $data = [];
        
        switch ($this->activeTab) {
            case 'overview':
                $data['orders'] = $this->customer->orders()
                    ->orderBy('order_date', 'desc')
                    ->paginate(10, ['*'], 'orders_page');
                break;
                
            case 'invoices':
                $invoices = $this->customer->invoices()
                    ->orderBy('invoice_date', 'desc')
                    ->paginate(10, ['*'], 'invoices_page');
                
                $data['invoices'] = $invoices->setCollection(
                    $invoices->getCollection()->map(function ($item, $key) use ($invoices) {
                        $item->serial = ($invoices->currentPage() - 1) * $invoices->perPage() + $key + 1;
                        return $item;
                    })
                );
                break;
                
            default:
                $data['orders'] = $this->customer->orders()
                    ->orderBy('order_date', 'desc')
                    ->paginate(10, ['*'], 'orders_page');
        }
        
        return view('livewire.admin.customer.customer-tabs', $data);
    }
}