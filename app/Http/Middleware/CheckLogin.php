<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    /**
     * Handle an incoming request.
     * 中间件三部曲
     *1: 创建中间件  php artisan make:middleware checkLogin 并编写此文件
     *2：注册中间件 到 app/Http/Kernel.php  第50行左右 protected $routeMiddleware 进行添加
     *3：使用中间件   到web.php 指定的路由上添加->middleware('checkLogin')
     * 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       
        //$user = session('user');
         $user = Auth::user();
         // $user_id = Auth::id();
          //   dd($user);
        if(!$user){
            return redirect('/login');
        }
        return $next($request);
    }
}
