<?php

namespace App\Livewire\Admin\Currency;

use App\Models\Currency;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class CurrencyList extends Component
{
    use WithPagination;

    public $perPage = 25;
    public $search = '';
    public $confirmingDeletion = false;
    public $currencyId;

    protected $listeners = [
        'refreshList' => '$refresh'
    ];

    public function confirmDelete($id)
    {
        $currency = Currency::withTrashed()->findOrFail($id);
        $this->currencyId = $id;
        
        if ($currency->trashed()) {
            $this->confirmingDeletion = true;
        } else {
            $this->delete();
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $currency = Currency::withTrashed()->findOrFail($this->currencyId);
            
            if ($currency->trashed()) {
                $currency->forceDelete();
                notyf()->success('Currency permanently deleted.');
            } else {
                $currency->status = 'inactive';
                $currency->save();
                $currency->delete();
                notyf()->success('Currency suspended. Click delete again to permanently remove.');
            }
            
            DB::commit();
            $this->confirmingDeletion = false;
        } catch (\Exception $e) {
            DB::rollBack();
            notyf()->error('Failed to delete currency.');
        }
    }

    public function restore($id)
    {
        $currency = Currency::withTrashed()->findOrFail($id);
        $currency->restore();
        $currency->status = 'active';
        $currency->save();
        notyf()->success('Currency restored successfully.');
    }

    public function editCurrency($id)
    {
        $currency = Currency::withTrashed()->find($id);

        if ($currency->trashed()) {
            notyf()->error('Cannot edit a suspended currency. Please restore it first.');
            return;
        }

        $this->dispatch('openEditTab', route('admin.currency.add', ['id' => $id]));
    }

    public function toggleActive(Currency $currency)
    {
        if (!$currency->trashed()) {
            try {
                $newStatus = $currency->status === 'active' ? 'inactive' : 'active';
                $currency->update(['status' => $newStatus]);
                notyf()->success('Currency status updated successfully.');
            } catch (\Exception $e) {
                notyf()->error('Failed to update currency status.');
            }
        }
    }

    public function render()
    {
        $currencies = Currency::where(function($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('code', 'like', '%' . $this->search . '%');
        })
        ->withTrashed()
        ->orderBy('id')
        ->paginate($this->perPage);

        return view('livewire.admin.currency.currency-list', [
            'currencies' => $currencies,
            'perpagerecords' => perpagerecords(),
        ]);
    }
}
