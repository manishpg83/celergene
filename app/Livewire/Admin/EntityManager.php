<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class EntityManager extends Component
{
    use WithPagination;

    public $entityId;
    public $company_name, $address, $country, $postal_code;
    public $business_reg_number, $vat_number;
    public $bank_account_name, $bank_account_number;
    public $currency, $bank_name, $bank_address;
    public $bank_swift_code, $bank_iban_number, $bank_code, $bank_branch_code;
    public $is_active, $search = '', $status = 'all', $perPage = 5, $isEditing = false, $confirmingDeletion = false;
    public $sortField = 'company_name';
    public $sortDirection = 'asc';

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
    }

    public function render()
    {
        $query = Entity::query()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('company_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('country', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('is_active', $this->status === 'active');
            })
            ->withTrashed()
            ->orderBy($this->sortField, $this->sortDirection);

        $entities = $query->paginate($this->perPage);

        return view('livewire.admin.entity-manager', [
            'entities' => $entities,
        ]);
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }

    public function updatedStatus($value)
    {
        $this->status = $value;
        $this->resetPage();
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
        return redirect()->route('admin.entities.add', ['id' => $entity->id]);
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
            $entity->forceDelete();
            notyf()->success('Entity permanently deleted.');
        } else {
            $entity->is_active = false;
            $entity->save();
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
            $this->delete();
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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }
}
