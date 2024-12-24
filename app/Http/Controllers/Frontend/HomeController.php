<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
}
