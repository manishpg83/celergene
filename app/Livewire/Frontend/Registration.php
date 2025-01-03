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
    public $g_recaptcha_response;
    public $currentYear;
    protected $listeners = [
        'g-recaptcha-response' => 'updateCaptchaResponse',
    ];
    public function mount()
    {
        // Initialize current year dynamically
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
            'g_recaptcha_response' => 'required',
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
        'g_recaptcha_response' => 'CAPTCHA',
    ];
    
    public function register()
    {
        $this->validate();

        $dob = $this->dob_year . '-' . str_pad($this->dob_month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($this->dob_day, 2, '0', STR_PAD_LEFT);
        if (empty($this->g_recaptcha_response)) {
            session()->flash('captcha_error', 'CAPTCHA is required.');
            return;
        }
    
        $secretKey = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';
        $response = Http::post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => $secretKey,
            'response' => $this->g_recaptcha_response,
        ]);
    
        if (!$response->json('success')) {
            session()->flash('captcha_error', 'CAPTCHA verification failed. Please try again.');
            return;
        }
        DB::beginTransaction();

        try {
            $existingCustomer = Customer::where('email', $this->reg_email)->first();

            if ($existingCustomer) {
                if ($existingCustomer->user_id === null) {
                    $user = User::create([
                        'first_name' => $this->reg_firstname,
                        'last_name' => $this->reg_lastname,
                        'email' => $this->reg_email,
                        'password' => Hash::make($this->reg_pass),
                        'name' => $this->reg_firstname . ' ' . $this->reg_lastname,
                        'phone' => $this->reg_phone ?? null,
                        'company' => $this->reg_company ?? null,
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

            $existingUser = User::where('email', $this->reg_email)->first();
            if ($existingUser) {
                throw new \Exception('Email already registered');
            }

            $user = User::create([
                'first_name' => $this->reg_firstname,
                'last_name' => $this->reg_lastname,
                'email' => $this->reg_email,
                'password' => Hash::make($this->reg_pass),
                'name' => $this->reg_firstname . ' ' . $this->reg_lastname,
                'phone' => $this->reg_phone ?? null,
                'company' => $this->reg_company ?? null,
                'date_of_birth' => $dob,
                'type' => 'customer',
                'status' => 'active'
            ]);

            $defaultCustomerTypeId = 1;
            $customer = Customer::create([
                'user_id' => $user->id,
                'customer_type_id' => $defaultCustomerTypeId,
                'first_name' => $this->reg_firstname,
                'last_name' => $this->reg_lastname,
                'email' => $this->reg_email,
                'mobile_number' => $this->reg_phone ?? '',
                'company_name' => $this->reg_company ?? null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'status' => 'active',
                'payment_term_display' => 'Standard',
                'credit_rating' => 'N/A',
                'billing_address' => 'N/A',
                'billing_country' => 'N/A',
                'billing_postal_code' => 'N/A',
                'shipping_address_receiver_name_1' => $user->name,
                'shipping_address_1' => 'N/A',
                'shipping_country_1' => 'N/A',
                'shipping_postal_code_1' => 'N/A',
                'allow_consignment' => 0,
                'must_receive_payment_before_delivery' => 0,
            ]);

            DB::commit();

            session()->flash('message', 'Registration completed successfully');
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

