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

    protected $queryString = [];

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
    }

    public function toggleStatus($vendorId)
    {
        $vendor = Vendor::find($vendorId);
        if ($vendor) {
            $vendor->status = $vendor->status === 'active' ? 'inactive' : 'active';
            $vendor->save();
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
            ->paginate(10);

        return view('livewire.admin.vendor-table', [
            'vendors' => $vendors,
        ]);
    }
}
