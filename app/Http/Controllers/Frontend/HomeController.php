<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OrderMaster;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function login()
    {
        return view('frontend.auth.login');
    }

    public function register()
    {
        return view('frontend.auth.register');
    }

    public function getTotalOrders()
    {
        return OrderMaster::count();
    }

    public function getTotalPendingOrders()
    {
        return OrderMaster::where('status', 'pending')->count();
    }

    public function myAccount()
    {
        $auth = Auth::user();
        $customer = Customer::where('user_id', $auth->id)->first();

        if ($customer) {
            $customerId = $customer->id;

            $totalOrders = OrderMaster::where('customer_id', $customerId)->count();
            $totalPendingOrders = OrderMaster::where('customer_id', $customerId)
                ->where('order_status', 'pending')
                ->count();
        } else {
            $totalOrders = 0;
            $totalPendingOrders = 0;
        }

        return view('frontend.profile.account', compact('customer', 'totalOrders', 'totalPendingOrders'));
    }

    public function myOrders()
    {
        return view('frontend.profile.account-orders');
    }

    public function Orderview($order_id = null)
    {
        return view('frontend.profile.order-view', ['order_id' => $order_id]);
    }

    public function myProfile()
    {
        return view('frontend.profile.account-profile');
    }

    public function billingaddress()
    {
        return view('frontend.profile.account-billing-address');
    }

    public function addbillingaddress($id = null)
    {
        return view('frontend.profile.account-add-billing-address', ['id' => $id]);
    }

    public function shippingaddress()
    {
        return view('frontend.profile.account-shipping-address');
    }

    public function addshippingaddress($addressNumber = null)
    {
        return view('frontend.profile.account-add-shipping-address', ['addressNumber' => $addressNumber]);
    }

    /*    public function addbillingaddress($id = null)
   {
       return view('frontend.profile.add-billing-address', [
           'customerId' => $id
       ]);
   } */

    /*    public function addshippingaddress($addressNumber = null)
   {
       return view('frontend.profile.add-shipping-address', [
           'addressNumber' => $addressNumber
       ]);
   } */

    public function about()
    {
        return view('frontend.pages.about');
    }

    public function serumroyale()
    {
        return view('frontend.pages.serum-royale');
    }

    public function energyandvitality()
    {
        return view('frontend.pages.energy-and-vitality');
    }

    public function joinpainreduction()
    {
        return view('frontend.pages.join-pain-reduction');
    }

    public function moodelevation()
    {
        return view('frontend.pages.mood-elevation');
    }

    public function staminaandrecovery()
    {
        return view('frontend.pages.stamina-and-recovery');
    }

    public function beautyenhancement()
    {
        return view('frontend.pages.beauty-enhancement');
    }

    public function increaselibido()
    {
        return view('frontend.pages.increase-libido');
    }

    public function lowersglycmicindex()
    {
        return view('frontend.pages.lowers-glycmic-index');
    }

    public function clinicalstudies()
    {
        return view('frontend.pages.clinical-studies');
    }

    public function celergenreviews()
    {
        return view('frontend.pages.celergen-reviews');
    }

    public function celergenvideo($videoId = null)
    {
        $videos = [
            [
                'id' => 1,
                'youtube_id' => 'pM3r9Q3F_C8',
                'title' => 'EXPERT REVIEW',
                'presenter' => 'Dr. Juan Remos',
                'thumbnail' => 'videothumb1.jpg',
                'url' => 'celergenvideo',
            ],
            [
                'id' => 2,
                'youtube_id' => 'XVczQRgM9dM',
                'title' => 'EXPERT REVIEW',
                'presenter' => 'Dr. Ghislaine Beilin',
                'thumbnail' => 'videothumb2.jpg',
            ],
            [
                'id' => 3,
                'youtube_id' => 'MkOys2XLZ5M',
                'title' => 'EXPERT REVIEW',
                'presenter' => 'Dr. Michael Klentze',
                'thumbnail' => 'videothumb3.jpg',
            ],
            [
                'id' => 4,
                'youtube_id' => '7lMmVZNelKg',
                'title' => 'MOUNTAIN CLIMBING EXPEDITION',
                'presenter' => 'Celergen Mexico Team',
                'thumbnail' => 'videothumb4.jpg',
            ],
            [
                'id' => 5,
                'youtube_id' => 'UzyuE4ekfuQ',
                'title' => 'CELERGEN CORPORATE',
                'presenter' => 'Celergen Swiss',
                'thumbnail' => 'videothumb5.jpg',
            ],
            [
                'id' => 6,
                'youtube_id' => 'W-DwU8v9AqY',
                'title' => 'CUSTOMER TESTIMONIAL',
                'presenter' => 'Aaron Younger',
                'thumbnail' => 'videothumb6.jpg',
            ],
            [
                'id' => 7,
                'youtube_id' => 'EprOfkVgxUk',
                'title' => 'CUSTOMER TESTIMONIAL',
                'presenter' => 'Sarah Corbettw',
                'thumbnail' => 'videothumb7.jpg',
            ],
        ];

        $currentVideo = null;
        if ($videoId) {
            $currentVideo = collect($videos)->firstWhere('id', (int) $videoId);
        }

        return view('frontend.pages.celergen-video', compact('videos', 'currentVideo'));
    }

    public function celergenfeatures()
    {
        return view('frontend.pages.celergen-features');
    }

    public function cart()
    {
        return view('frontend.profile.cart');
    }

    public function checkout()
    {
        return view('frontend.profile.checkout');
    }
}
