<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;

class AdminEntityController extends Controller
{
    public function index()
    {
        return view('admin.entities.index');
    }

    public function add()
    {
        return view('admin.entities.add');
    }

    public function showAddEntityForm($id)
    {
        $entity = Entity::findOrFail($id);

        return view('livewire.admin.entity.add-entity', compact('entity'));
    }
}
