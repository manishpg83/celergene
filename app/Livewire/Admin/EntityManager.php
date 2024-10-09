<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class EntityManager extends Component
{
    use WithPagination;

    private $entities; // Change to private
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
    public $search = '';
    public $status = 'all'; // Default status
    public $perPage = 5; // Default perPage
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
        $this->search = '';
        $this->status = 'all';
        $this->perPage = 5;
    }

    public function render()
    {
        $query = Entity::query()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('company_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('country', 'LIKE', '%' . $this->search . '%');
                });
            });

        // Filter by status if it's not 'all'
        if ($this->status !== 'all') {
            $query->where('is_active', $this->status === 'active');
        }

        // Include soft deleted entities if needed
         $query->withTrashed();

        $this->entities = $query->paginate($this->perPage);

        return view('livewire.admin.entity-manager', [
            'entities' => $this->entities,
        ]);
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value; // Update perPage value
        $this->resetPage(); // Reset pagination
    }

    public function updatedStatus($value)
    {
        $this->status = $value; // Update status value
        $this->resetPage(); // Reset pagination
    }

    public function getEntities()
    {
        return $this->entities;
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

        notyf()->success('Entity saved successfully.');
    }

    public function delete()
    {
        $entity = Entity::withTrashed()->find($this->entityId);

        if ($entity->trashed()) {
            // If already soft deleted, permanently delete
            $entity->forceDelete();
            notyf()->success('Entity permanently deleted.');
        } else {
            // If not soft deleted, perform soft delete
            $entity->delete();
            notyf()->success('Entity soft deleted. Click delete again to permanently remove.');
        }

        $this->confirmingDeletion = false;
    }

    public function confirmDelete($id)
    {
        $this->entityId = $id;
        $entity = Entity::withTrashed()->find($id);

        if ($entity->trashed()) {
            $this->confirmingDeletion = true;
        } else {
            $this->delete(); // Directly soft delete without confirmation
        }
    }

    public function restore($id)
    {
        $entity = Entity::withTrashed()->find($id);
        $entity->restore();

        notyf()->success('Entity restored successfully.');
    }

    public function toggleActive(Entity $entity)
    {
        $entity->is_active = !$entity->is_active;
        $entity->save();

        notyf()->success('Entity status updated successfully.');
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->resetFields();
    }
}
