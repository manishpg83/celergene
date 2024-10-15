<?php

namespace App\Livewire\Admin\Entity;

use Livewire\Component;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;

class AddEntity extends Component
{
    public $entityId;
    public $company_name;
    public $address;
    public $country;
    public $postal_code;
    public $business_reg_number;
    public $vat_number;
    public $gst_number;
    public $currency;
    public $bank_account_name;
    public $bank_account_number;
    public $bank_name;
    public $bank_address;
    public $bank_swift_code;
    public $bank_iban_number;
    public $bank_code;
    public $bank_branch_code;
    public $is_active = true;

    protected $rules = [
        'company_name' => 'required|string|max:255',
        'address' => 'required|string',
        'country' => 'required|string|max:100',
        'postal_code' => 'required|string|max:20',
        'business_reg_number' => 'nullable|string|max:50',
        'vat_number' => 'nullable|string|max:50',
        'gst_number' => 'nullable|string|max:50',
        'currency' => 'required|string|max:3',
        'bank_account_name' => 'required|string|max:255',
        'bank_account_number' => 'required|string|max:50',
        'bank_name' => 'required|string|max:255',
        'bank_address' => 'required|string',
        'bank_swift_code' => 'nullable|string|max:11',
        'bank_iban_number' => 'nullable|string|max:34',
        'bank_code' => 'nullable|string|max:255',
        'bank_branch_code' => 'nullable|string|max:255',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->entityId = request()->query('id');

        if ($this->entityId) {
            $entity = Entity::find($this->entityId);
            if ($entity) {
                $this->company_name = $entity->company_name;
                $this->address = $entity->address;
                $this->country = $entity->country;
                $this->postal_code = $entity->postal_code;
                $this->business_reg_number = $entity->business_reg_number;
                $this->vat_number = $entity->vat_number;
                $this->gst_number = $entity->gst_number;
                $this->currency = $entity->currency;
                $this->bank_account_name = $entity->bank_account_name;
                $this->bank_account_number = $entity->bank_account_number;
                $this->bank_name = $entity->bank_name;
                $this->bank_address = $entity->bank_address;
                $this->bank_swift_code = $entity->bank_swift_code;
                $this->bank_iban_number = $entity->bank_iban_number;
                $this->bank_code = $entity->bank_code;
                $this->bank_branch_code = $entity->bank_branch_code;
                $this->is_active = $entity->is_active;
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.entity.add-entity');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $entity = $this->entityId ? Entity::find($this->entityId) : new Entity();

        $entity->fill($this->all());

        if (Auth::check()) {
            $entity->created_by = Auth::id();
        } else {
            session()->flash('error', 'You must be logged in to create an entity.');
            return;
        }

        $entity->save();

        notyf()->success('Entity Added successfully.');
        return redirect()->route('admin.entities.index');
    }

    public function back()
    {
        return redirect()->route('admin.entities.index');
    }
}
