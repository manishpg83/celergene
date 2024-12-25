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
}
