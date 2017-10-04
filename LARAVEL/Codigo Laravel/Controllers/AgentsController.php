<?php

namespace App\Http\Controllers;
use App\Models\Propiedad;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AgentsController extends Controller{

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request){
        $this->lang = substr($request->route()->uri, 0, 2);
        app()->setLocale($this->lang);
        return view('agents')->with('controller', $this);
        
    }
}
