<?php

namespace App\Livewire\Admin\Entity;

use Livewire\Component;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;

class AddEntity extends Component
{
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

        $entity = new Entity();
        $entity->fill($this->all());

        if (Auth::check()) {
            $entity->created_by = Auth::id();
        } else {
            session()->flash('error', 'You must be logged in to create an entity.');
            return;
        }

        $entity->save();

        session()->flash('success', 'Entity saved successfully.');
        return redirect()->route('admin.entities.index');
    }

    public function back()
    {
        return redirect()->route('admin.entities.index');
    }
}
