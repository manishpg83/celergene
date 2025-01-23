<?php

namespace App\Livewire\Frontend;

use App\Models\User;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class Registration extends Component
{
    public $firstname, $lastname, $email, $pass, $pass_confirmation, $dob_day, $dob_month, $dob_year, $phone, $company;

    public $currentYear;

    public function mount()
    {
        $this->currentYear = date('Y');
    }

    protected function rules()
    {
        return [
            'firstname' => 'required|string|max:25',
            'lastname' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'pass' => 'required|min:8|confirmed',
            'dob_day' => 'required|numeric|min:1|max:31',
            'dob_month' => 'required|numeric|min:1|max:12',
            'dob_year' => 'required|numeric|min:1900|max:' . $this->currentYear,
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:100',
        ];
    }

    protected $validationAttributes = [
        'firstname' => 'first name',
        'lastname' => 'last name',
        'email' => 'email',
        'pass' => 'password',
        'pass_confirmation' => 'password confirmation',
        'dob_day' => 'day of birth',
        'dob_month' => 'month of birth',
        'dob_year' => 'year of birth',
        'phone' => 'phone number',
        'company' => 'company name',
    ];

    public function register()
    {
        $this->validate();
        Log::info('Register method triggered', $this->all());

        Log::info('Register method invoked');

        $dob = $this->dob_year . '-' . str_pad($this->dob_month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($this->dob_day, 2, '0', STR_PAD_LEFT);

        DB::beginTransaction();

        try {
            $existingCustomer = Customer::where('email', $this->email)->first();

            if ($existingCustomer) {
                if ($existingCustomer->user_id === null) {
                    $user = User::create([
                        'first_name' => $this->firstname,
                        'last_name' => $this->lastname,
                        'email' => $this->email,
                        'password' => Hash::make($this->pass),
                        'name' => $this->firstname . ' ' . $this->lastname,
                        'phone' => $this->phone ?? null,
                        'company' => $this->company ?? null,
                        'date_of_birth' => $dob,
                        'type' => 'customer',
                        'status' => 'active'
                    ]);
                    $existingCustomer->update([
                        'user_id' => $user->id,
                        'status' => 'active'
                    ]);

                    DB::commit();

                    session()->flash('message', 'Registration completed successfully');
                    return redirect()->route('login');
                } else {
                    throw new \Exception('Email already registered');
                }
            }

            $existingUser = User::where('email', $this->email)->first();
            if ($existingUser) {
                throw new \Exception('Email already registered');
            }

            $user = User::create([
                'first_name' => $this->firstname,
                'last_name' => $this->lastname,
                'email' => $this->email,
                'password' => Hash::make($this->pass),
                'name' => $this->firstname . ' ' . $this->lastname,
                'phone' => $this->phone ?? null,
                'company' => $this->company ?? null,
                'date_of_birth' => $dob,
                'type' => 'customer',
                'status' => 'active'
            ]);

            $defaultCustomerTypeId = 1;
            $customer = Customer::create([
                'user_id' => $user->id,
                'customer_type_id' => $defaultCustomerTypeId,
                'first_name' => $this->firstname,
                'last_name' => $this->lastname,
                'email' => $this->email,
                'mobile_number' => $this->phone ?? null,
                'company_name' => $this->company ?? null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'status' => 'active',
                'payment_term_display' => 'Standard',
                'credit_rating' => null,
                'billing_address' => null,
                'billing_country' => null,
                'billing_postal_code' => null,
                'shipping_address_receiver_name_1' => null,
                'shipping_address_1' => null,
                'shipping_country_1' => null,
                'shipping_postal_code_1' => null,
                'allow_consignment' => 0,
                'must_receive_payment_before_delivery' => 0,
            ]);

            DB::commit();

            notyf()->success(' Registration completed successfully!');
            return redirect()->route('login');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration failed' . $e->getMessage());
            session()->flash('error', $e->getMessage() ?: 'Registration failed');
        }
    }

    public function render()
    {
        return view('livewire.frontend.registration');
    }
}
