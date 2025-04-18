<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class YtdReportExport implements WithMultipleSheets
{
    protected $year;
    protected $customerTypes;
    protected $onlineCountries;
    protected $corporateCountries;
    
    public function __construct($year, $customerTypes, $onlineCountries, $corporateCountries)
    {
        $this->year = $year;
        $this->customerTypes = $customerTypes;
        $this->onlineCountries = $onlineCountries;
        $this->corporateCountries = $corporateCountries;
    }
    
    public function sheets(): array
    {
        return [
            new YtdCustomerTypeSheet($this->year, $this->customerTypes),
            new YtdOnlineCountriesSheet($this->year, $this->onlineCountries),
            new YtdCorporateCountriesSheet($this->year, $this->corporateCountries),
        ];
    }
}

class YtdCustomerTypeSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $year;
    protected $data;
    
    public function __construct($year, $data)
    {
        $this->year = $year;
        $this->data = $data;
    }
    
    public function collection()
    {
        return collect($this->data);
    }
    
    public function headings(): array
    {
        return [
            'Customer Type',
            'Number of Boxes',
            'Total Amount (USD)'
        ];
    }
    
    public function title(): string
    {
        return 'Sales by Customer Type';
    }
}

class YtdOnlineCountriesSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $year;
    protected $data;
    
    public function __construct($year, $data)
    {
        $this->year = $year;
        $this->data = $data;
    }
    
    public function collection()
    {
        return collect($this->data);
    }
    
    public function headings(): array
    {
        return [
            'Country',
            'Number of Boxes',
            'Total Amount (USD)'
        ];
    }
    
    public function title(): string
    {
        return 'Online Sales by Country';
    }
}

class YtdCorporateCountriesSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $year;
    protected $data;
    
    public function __construct($year, $data)
    {
        $this->year = $year;
        $this->data = $data;
    }
    
    public function collection()
    {
        return collect($this->data);
    }
    
    public function headings(): array
    {
        return [
            'Country',
            'Number of Boxes',
            'Total Amount (USD)'
        ];
    }
    
    public function title(): string
    {
        return 'Corporate Sales by Country';
    }
}