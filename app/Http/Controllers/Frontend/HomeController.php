<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

   public function myaccount()
   {
      return view('frontend.profile.account');
   }

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
   
   public function celergenvideo()
   {
      return view('frontend.pages.celergen-video');
   }

   public function celergenfeatures()
   {
      return view('frontend.pages.celergen-features');
   }
}
