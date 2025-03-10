<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatchNumber;

class BatchNumberController extends Controller
{
    public function index()
    {
        return view('admin.batchnumber.index');
    }

    public function add()
    {
        return view('admin.batchnumber.add');
    }

    public function showAddEntityForm($id)
    {
        $batchnumber = BatchNumber::findOrFail($id);

        return view('livewire.admin.batchnumber.add-batch-number', compact('batchnumber'));
    }
}