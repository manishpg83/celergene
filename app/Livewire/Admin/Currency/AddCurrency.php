<?php

namespace App\Livewire\Admin\Currency;

use App\Models\Currency;
use Livewire\Component;
use Illuminate\Validation\Rule;

class AddCurrency extends Component
{
    public $name;
    public $code;
    public $symbol;
    public $rate;
    public $status = 'active';
    public $currencyId;

    public function mount()
    {
        $this->currencyId = request()->query('id');
        if ($this->currencyId) {
            $currency = Currency::find($this->currencyId);
            if ($currency) {
                $this->name = $currency->name;
                $this->code = $currency->code;
                $this->symbol = $currency->symbol;
                $this->rate = $currency->rate;
                $this->status = $currency->status;
            }
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'size:3',
                Rule::unique('currency')->ignore($this->currencyId)
            ],
            'symbol' => 'required|string|max:10',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function saveCurrency()
    {
        $this->validate();

        try {
            if ($this->currencyId) {
                $currency = Currency::findOrFail($this->currencyId);
                $currency->update([
                    'name' => $this->name,
                    'code' => strtoupper($this->code),
                    'symbol' => $this->symbol,
                    'rate' => $this->rate,
                    'status' => $this->status,
                ]);
                notyf()->success('Currency updated successfully.');
            } else {
                Currency::create([
                    'name' => $this->name,
                    'code' => strtoupper($this->code),
                    'symbol' => $this->symbol,
                    'rate' => $this->rate,
                    'status' => $this->status,
                ]);
                notyf()->success('Currency added successfully.');
            }
            return redirect()->route('admin.currency.index');
        } catch (\Exception $e) {
            notyf()->error('An error occurred while saving the currency.');
        }
    }

    public function back()
    {
        return redirect()->route('admin.currency.index');
    }

    public function render()
    {
        return view('livewire.admin.currency.add-currency');
    }
}
