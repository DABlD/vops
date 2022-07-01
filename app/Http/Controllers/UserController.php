<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Auth;

class UserController extends Controller
{
    public function get(Request $req){
        $array = DB::table('users')->select($req->cols);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
        }

        $array = $array->get();

        // IF HAS GROUP
        if($req->group){
            $array = $array->groupBy($req->group);
        }

        echo json_encode($array);
    }

    public function store(Request $req){

    }

    public function update(Request $req){
        DB::table('users')->where('id', $req->id)->update($req->except(['id', '_token']));
    }

    private function _view($view, $data = array()){
        return view('users.' . $view, $data);
    }
}
