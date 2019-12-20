<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function dologin(){
        $post = request()->except('_token');
        //dd($post);
//        
//        $user = \DB::table('admin')->where($post)->first();
//        
//        if( $user ){
//            session(['user'=>$user]);
//            request()->session()->save();
//            
//            return redirect('/brand');
//        }
        
        if (Auth::attempt($post)) {
            
            // 认证通过...
            return redirect()->intended('brand');
        }
 
    }
    
    
    
    public function logindo(){
        $post = request()->except('_token');
        //dd(Auth::attempt($post)); 
        if(Auth::attempt($post)){
            return redirect('/brand');
        }else{
           return redirect('/login')->with('msg','账户或密码错误'); 
        }
    }
}
