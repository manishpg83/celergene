<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use App\Models\Country;
use App\Models\CurrencyRate;

class CountryManager extends Component
{
    public $countries, $name, $currency_code, $currency_name, $currency_symbol, $rate, $countryId;

    public function mount()
    {
        $this->countries = Country::with('currencyRates')->get();
    }

    public function addCountry()
    {
        $this->validate([
            'name' => 'required|string',
            'currency_code' => 'required|string',
            'currency_name' => 'required|string',
            'currency_symbol' => 'nullable|string',
            'rate' => 'required|numeric',
        ]);

        $country = Country::create([
            'name' => $this->name,
            'currency_code' => $this->currency_code,
            'currency_name' => $this->currency_name,
            'currency_symbol' => $this->currency_symbol,
        ]);

        CurrencyRate::create([
            'country_id' => $country->id,
            'rate' => $this->rate,
        ]);

        $this->resetInputs();
        $this->mount();
    }

    public function resetInputs()
    {
        $this->name = '';
        $this->currency_code = '';
        $this->currency_name = '';
        $this->currency_symbol = '';
        $this->rate = '';
        $this->countryId = null;
    }

    public function render()
    {
        return view('livewire.admin.country-manager');
    }
}
