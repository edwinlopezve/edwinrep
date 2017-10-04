<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Poblacion;
use App\Models\Propiedad;

class propertyDetailController extends Controller
{
   public function index($id=null){
	
   	   
        app()->setLocale($this->lang);
	   return view('partials.agents.propertyInfo')->with('id', $id);
   }
}
