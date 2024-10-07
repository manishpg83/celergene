<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Builder;

class VendorTable extends Component
{
    use WithPagination;

    public $searchVendor = '';
    public $status = 'all';
    public $perPage = 5;
    public $vendorToDelete = null;
    public $vendorToEdit = null;
    public $confirmingDeletion = false;
    public $showEditModal = false;
    public $editingVendorStatus = '';

    public $editingVendor = [
        'id' => '',
        'name' => '',
        'email' => '',
        'status' => ''
    ];

    protected $queryString = [
        'searchVendor' => ['except' => ''],
        'status' => ['except' => 'all'],
    ];

    public function updatingSearchVendor()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchVendor = '';
        $this->status = 'all';
        $this->perPage = 5;
    }

    public function toggleStatus($vendorId)
    {
        $vendor = Vendor::find($vendorId);
        if ($vendor) {
            $vendor->status = $vendor->status === 'active' ? 'inactive' : 'active';
            $vendor->save();
        }
        notyf()->success('Vendor Status updated successfully.');
    }

    public function editVendor($vendorId)
    {
        $vendor = Vendor::find($vendorId);
        if ($vendor) {
            $this->editingVendor = [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'email' => $vendor->email,
                'status' => $vendor->status
            ];
            $this->showEditModal = true;
        }
    }

    public function confirmDelete($vendorId)
    {
        $this->vendorToDelete = $vendorId;
        $this->confirmingDeletion = true;
    }

    public function saveVendor()
    {
        $vendor = Vendor::find($this->editingVendor['id']);
        if ($vendor) {
            $vendor->update([
                'name' => $this->editingVendor['name'],
                'email' => $this->editingVendor['email'],
                'status' => $this->editingVendor['status']
            ]);
            notyf()->success('Vendor updated successfully.');
            $this->showEditModal = false;
            $this->editingVendor = ['id' => '', 'name' => '', 'email' => '', 'status' => ''];
        }
    }

    public function deleteVendor()
    {
        if ($this->vendorToDelete) {
            Vendor::destroy($this->vendorToDelete);
            notyf()->success('Vendor deleted successfully.');
            $this->vendorToDelete = null;
            $this->confirmingDeletion = false;
        }
    }

    public function render()
    {
        $vendors = Vendor::query()
            ->when($this->searchVendor, function (Builder $query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->searchVendor . '%')
                        ->orWhere('email', 'like', '%' . $this->searchVendor . '%');
                });
            })
            ->when($this->status !== 'all', function (Builder $query) {
                $query->where('status', $this->status);
            })
            ->paginate($this->perPage);

        return view('livewire.admin.vendor-table', [
            'vendors' => $vendors,
        ]);
    }
}
