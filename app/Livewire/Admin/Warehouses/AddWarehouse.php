<?php

namespace App\Livewire\Admin\Warehouses;

use Livewire\Component;
use App\Models\Warehouse;
use App\Models\Supplier;
use App\Models\WarehouseEmail;
use Illuminate\Support\Facades\Auth;

class AddWarehouse extends Component
{
    public $warehouse_id, $warehouse_name, $country, $type, $types, $phone, $remarks, $address;
    public $emails = [];
    public $isEditMode = false;
 

    protected $listeners = ['editWarehouse'];

    public function mount()
    {
        $this->types = getWarehouseTypes();
        $this->type = '';
        $this->warehouse_id = request()->query('id');

        if ($this->warehouse_id) {
            $warehouse = Warehouse::with('emails')->find($this->warehouse_id);
            if ($warehouse) {
                $this->warehouse_name = $warehouse->warehouse_name;
                $this->country = $warehouse->country;
                $this->type = $warehouse->type;
                $this->remarks = $warehouse->remarks;
                $this->phone = $warehouse->phone;
                $this->address = $warehouse->address;
                $this->emails = $warehouse->emails->pluck('email')->toArray();
                $this->isEditMode = true;
            }else{
                $this->emails = [''];
            }
        }else{
            $this->emails = [''];
        }
    }

    public function resetFields()
    {
        $this->warehouse_id = null;
        $this->warehouse_name = '';
        $this->country = '';
        $this->type = '';
        $this->remarks = '';
        $this->phone = '';
        $this->address = '';
        $this->emails = [];
        $this->isEditMode = false;
    }

    public function addEmailField()
    {
        if (count($this->emails) < 5) {
            $this->emails[] = '';
        } else { 
            notyf()->error('You can only add up to 5 emails.');    

        }
    }
    
    public function removeEmailField($index)
    {
        unset($this->emails[$index]);
        $this->emails = array_values($this->emails);
    }

    public function saveWarehouse()
    {
        $this->validate([
            'warehouse_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_keys($this->types)),
            'remarks' => 'nullable|string',
            'phone' => 'nullable|string',
            'emails' => 'array|max:5',
            'emails.*' => [
                'required',
                'email',
                'distinct',
                function ($attribute, $value, $fail) {
                    /* if (WarehouseEmail::where('email', $value)->where('warehouse_id', '!=', $this->warehouse_id)->exists()) {
                        $fail("The email {$value} is already in use.");
                    } */
                }
            ],
            'address' => 'required|string|max:500',
        ]);

        $warehouse = Warehouse::updateOrCreate(
            ['id' => $this->warehouse_id],
            [
                'warehouse_name' => $this->warehouse_name,
                'country' => $this->country,
                'type' => $this->type,
                'remarks' => $this->remarks,
                'phone' => $this->phone,
                'address' => $this->address,
                'created_by' => Auth::id(),
                'modified_by' => Auth::id(),
            ]
        );
        $warehouse->emails()->delete();
        foreach ($this->emails as $email) {
            $warehouse->emails()->create(['email' => $email]);
        }

        notyf()->success($this->warehouse_id ? 'Warehouse updated successfully.' : 'Warehouse created successfully.');
        $this->resetFields();
        return redirect()->route('admin.warehouses.index');
    }

    public function back()
    {
        return redirect()->route('admin.warehouses.index');
    }

    public function render()
    {
        return view('livewire.admin.warehouses.add-warehouse', [
            'types' => $this->types,
        ]);
    }
}
