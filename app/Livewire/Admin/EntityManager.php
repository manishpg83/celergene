<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class EntityManager extends Component
{
    use WithPagination;

    public $entities;
    public $entityId;
    public $company_name;
    public $address;
    public $country;
    public $postal_code;
    public $business_reg_number;
    public $vat_number;
    public $bank_account_name;
    public $bank_account_number;
    public $currency;
    public $bank_name;
    public $bank_address;
    public $bank_swift_code;
    public $bank_iban_number;
    public $bank_code;
    public $bank_branch_code;
    public $is_active;

    public $isEditing = false;
    public $confirmingDeletion = false;

    protected $rules = [
        'company_name' => 'required|string|max:255',
        'address' => 'required|string',
        'country' => 'required|string|max:100',
        'postal_code' => 'required|string|max:20',
        'business_reg_number' => 'nullable|string|max:50',
        'vat_number' => 'nullable|string|max:50',
        'bank_account_name' => 'required|string|max:255',
        'bank_account_number' => 'required|string|max:50',
        'currency' => 'required|string|size:3',
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
        $this->resetFields();
        $this->loadEntities();
    }

    public function render()
    {
        return view('livewire.admin.entity-manager');
    }

    public function loadEntities()
    {
        $this->entities = Entity::all();
    }

    public function resetFields()
    {
        $this->reset([
            'entityId',
            'company_name',
            'address',
            'country',
            'postal_code',
            'business_reg_number',
            'vat_number',
            'bank_account_name',
            'bank_account_number',
            'currency',
            'bank_name',
            'bank_address',
            'bank_swift_code',
            'bank_iban_number',
            'bank_code',
            'bank_branch_code',
            'is_active'
        ]);
        $this->is_active = true;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function create()
    {
        $this->resetFields();
        $this->isEditing = true;
    }

    public function edit(Entity $entity)
    {
        $this->entityId = $entity->id;
        $this->company_name = $entity->company_name;
        $this->address = $entity->address;
        $this->country = $entity->country;
        $this->postal_code = $entity->postal_code;
        $this->business_reg_number = $entity->business_reg_number;
        $this->vat_number = $entity->vat_number;
        $this->bank_account_name = $entity->bank_account_name;
        $this->bank_account_number = $entity->bank_account_number;
        $this->currency = $entity->currency;
        $this->bank_name = $entity->bank_name;
        $this->bank_address = $entity->bank_address;
        $this->bank_swift_code = $entity->bank_swift_code;
        $this->bank_iban_number = $entity->bank_iban_number;
        $this->bank_code = $entity->bank_code;
        $this->bank_branch_code = $entity->bank_branch_code;
        $this->is_active = $entity->is_active;

        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate();

        $entity = $this->entityId ? Entity::find($this->entityId) : new Entity();
        $entity->fill($this->only([
            'company_name',
            'address',
            'country',
            'postal_code',
            'business_reg_number',
            'vat_number',
            'bank_account_name',
            'bank_account_number',
            'currency',
            'bank_name',
            'bank_address',
            'bank_swift_code',
            'bank_iban_number',
            'bank_code',
            'bank_branch_code',
            'is_active'
        ]));

        if (Auth::check()) {
            $entity->created_by = Auth::id();
        } else {
            notyf()->error('You must be logged in to create an entity.');
            return;
        }

        $entity->save();
        $this->isEditing = false;
        $this->loadEntities();
        notyf()->success('Entity saved successfully.');
    }

    public function confirmDelete(Entity $entity)
    {
        $this->entityId = $entity->id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        $entity = Entity::find($this->entityId);
        $entity->delete();
        $this->confirmingDeletion = false;
        $this->loadEntities();
        notyf()->success('Entity deleted successfully.');
    }

    public function toggleActive(Entity $entity)
    {
        $entity->is_active = !$entity->is_active;
        $entity->save();
        $this->loadEntities();
        notyf()->success('Entity status updated successfully.');
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->resetFields();
    }
}
