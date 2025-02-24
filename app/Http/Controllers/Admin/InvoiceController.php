<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('admin.invoice.index');
    }

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);

        return view('admin.invoice.show', compact('invoice'));
    }
}
