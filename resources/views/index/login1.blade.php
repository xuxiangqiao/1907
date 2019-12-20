<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Login</h1>
<!--        <form method="post" action="{{url('dologin')}}">-->
        <form method="post" action="{{route('do')}}">
            
         @csrf
           
        <input type="text" name="name">
        <input type="text" name="pwd">
        <input type="submit">
        </form>
    </body>
</html>
