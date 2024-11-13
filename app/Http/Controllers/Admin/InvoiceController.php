<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice; // Assuming you have an Invoice model
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        // This method can be used to return the view with the Livewire component
        return view('admin.invoice.index'); // Adjust the path as necessary
    }

    public function show($id)
    {
        // Fetch the invoice details by ID
        $invoice = Invoice::findOrFail($id);
        return view('admin.invoice.show', compact('invoice')); // Adjust the path as necessary
    }

    // Additional methods for creating, updating, and deleting invoices can be added here
}
