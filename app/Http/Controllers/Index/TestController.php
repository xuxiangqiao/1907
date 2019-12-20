<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
     public function index(){
        echo 456;die;
    }
    
    public function login(){
        return view('index.login');
    }
   public function dologin(Request $request){
       //$post = request()->all();
       // $post = request()->input();
        $post = $request->input();
       //$post = request()->name;
       dd($post);
        //return view('index.login');
    }
    
    
    public function goods($id,$name){
        echo $id;
        echo $name;
    }
}
