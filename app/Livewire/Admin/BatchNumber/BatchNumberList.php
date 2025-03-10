<?php

namespace App\Livewire\Admin\BatchNumber;

use App\Models\BatchNumber;
use Livewire\Component;
use Livewire\WithPagination;

class BatchNumberList extends Component
{
    use WithPagination;

    public $batch_number, $batchNumberId;
    public $perPage = 25;
    public $status = 'active';
    public $search = '';
    public $confirmingDeletion = false;

    public function mount()
    {
        $this->resetForm();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete()
    {
        $batchNumber = BatchNumber::withTrashed()->find($this->batchNumberId);

        if ($batchNumber->trashed()) {
            $batchNumber->forceDelete();
            notyf()->success('Batch number permanently deleted.');
        } else {
            $batchNumber->status = 'inactive';
            $batchNumber->save();
            $batchNumber->delete();
            notyf()->success('Batch number suspended. Click delete again to permanently remove.');
        }

        $this->confirmingDeletion = false;
    }

    public function confirmDelete($id)
    {
        $this->batchNumberId = $id;
        $batchNumber = BatchNumber::withTrashed()->find($id);

        if ($batchNumber->trashed()) {
            $this->confirmingDeletion = true;
        } else {
            $this->delete();
        }
    }

    public function restore($id)
    {
        $batchNumber = BatchNumber::withTrashed()->find($id);
        $batchNumber->restore();
        $batchNumber->status = 'active';
        $batchNumber->save();
        notyf()->success('Batch number restored successfully.');
    }

    public function editBatchNumber($id)
    {
        $batchNumber = BatchNumber::withTrashed()->find($id);

        if ($batchNumber->trashed()) {
            notyf()->error('Cannot edit a suspended batch number. Please restore it first.');
            return;
        }
        $this->dispatch('openEditTab', route('admin.batchnumber.add', ['id' => $id]));
    }

    public function updateBatchNumber()
    {
        $this->validate([
            'batch_number' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $batchNumber = BatchNumber::find($this->batchNumberId);
        $batchNumber->update([
            'batch_number' => $this->batch_number,
            'status' => $this->status,
        ]);

        $this->resetForm();

        session()->flash('message', 'Batch number updated successfully.');
    }

    private function resetForm()
    {
        $this->batch_number = '';
        $this->status = 'active';
        $this->batchNumberId = null;
    }

    public function toggleActive(BatchNumber $batchNumber)
    {
        if (!$batchNumber->trashed()) {
            $batchNumber->status = $batchNumber->status === 'active' ? 'inactive' : 'active';
            $batchNumber->save();
            notyf()->success('Batch number status updated successfully.');
        }
    }

    public function render()
    {
        $batchNumbers = BatchNumber::query()
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('batch_number', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            })
            ->withTrashed()
            ->orderBy('id')
            ->paginate($this->perPage);
        $perpagerecords = perpagerecords();

        return view('livewire.admin.batch-number.batch-number-list', [
            'batchNumbers' => $batchNumbers,
            'perpagerecords' => $perpagerecords,
        ]);
    }
}
