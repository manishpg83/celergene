<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;

class EntityManager extends Component
{
    public $entities;
    public $entity;
    public $isEditing = false;
    public $confirmingDeletion = false;

    protected $rules = [
        'entity.company_name' => 'required|string|max:255',
        'entity.address' => 'required|string',
        'entity.country' => 'required|string|max:100',
        'entity.postal_code' => 'required|string|max:20',
        'entity.business_reg_number' => 'nullable|string|max:50',
        'entity.vat_number' => 'nullable|string|max:50',
        'entity.bank_account_name' => 'required|string|max:255',
        'entity.bank_account_number' => 'required|string|max:50',
        'entity.currency' => 'required|string|size:3',
        'entity.bank_name' => 'required|string|max:255',
        'entity.bank_address' => 'required|string',
        'entity.bank_swift_code' => 'nullable|string|max:11',
        'entity.bank_iban_number' => 'nullable|string|max:34',
        'entity.bank_code' => 'nullable|string|max:255',
        'entity.bank_branch_code' => 'nullable|string|max:255',
        'entity.is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->resetEntity();
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

    public function resetEntity()
    {
        $this->entity = new Entity();
        $this->entity->is_active = true;
    }

    public function create()
    {
        $this->resetEntity();
        $this->isEditing = true;
    }

    public function edit(Entity $entity)
    {
        $this->entity = $entity;
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate();

        if (!$this->entity->id) {
            $this->entity->created_by = Auth::id();
        }

        $this->entity->save();
        $this->isEditing = false;
        $this->loadEntities();
        session()->flash('message', 'Entity saved successfully.');
    }

    public function confirmDelete(Entity $entity)
    {
        $this->entity = $entity;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        $this->entity->delete();
        $this->confirmingDeletion = false;
        $this->loadEntities();
        session()->flash('message', 'Entity deleted successfully.');
    }

    public function toggleActive(Entity $entity)
    {
        $entity->is_active = !$entity->is_active;
        $entity->save();
        $this->loadEntities();
        session()->flash('message', 'Entity status updated successfully.');
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->resetEntity();
    }
}
