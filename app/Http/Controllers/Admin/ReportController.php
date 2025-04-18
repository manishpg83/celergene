<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderInvoice;
use App\Models\Customer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function ytd()
    {
        return view('admin.reports.ytd');
    }

    public function business()
    {
        return view('admin.reports.business');
    }

    public function country()
    {
        return view('admin.reports.country');
    }
   
}