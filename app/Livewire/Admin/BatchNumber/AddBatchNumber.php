<?php

namespace App\Livewire\Admin\BatchNumber;

use App\Models\BatchNumber;
use Livewire\Component;

class AddBatchNumber extends Component
{
    public $batch_number;
    public $status;
    public $batchNumberId;

    public function mount()
    {
        $this->batchNumberId = request()->query('id');
        if ($this->batchNumberId) {
            $batchNumber = BatchNumber::find($this->batchNumberId);
            if ($batchNumber) {
                $this->batch_number = $batchNumber->batch_number;
                $this->status = $batchNumber->status;
            }
        }
    }

    protected $rules = [
        'batch_number' => 'required|string|max:255|unique:batchnumbers,batch_number',
        'status' => 'required|in:active,inactive',
    ];

    public function saveBatchNumber()
    {
        $this->validate();

        if ($this->batchNumberId) {
            $batchNumber = BatchNumber::find($this->batchNumberId);
            $batchNumber->update([
                'batch_number' => $this->batch_number,
                'status' => $this->status,
            ]);
            notyf()->success('Batch number updated successfully.');
        } else {
            BatchNumber::create([
                'batch_number' => $this->batch_number,
                'status' => $this->status,
            ]);
            notyf()->success('Batch number added successfully.');
        }
        return redirect()->route('admin.batchnumber.index');
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->batch_number = '';
        $this->status = 'active';
        $this->batchNumberId = null;
    }

    public function back()
    {
        return redirect()->route('admin.batchnumber.index');
    }

    public function render()
    {
        return view('livewire.admin.batch-number.add-batch-number');
    }
}