<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        return $this->_view('welcome', [
            'title' => "Virtual OPS",
        ]);
    }

    private function _view($view, $data = array()){
        return view($view, $data);
    }
}
