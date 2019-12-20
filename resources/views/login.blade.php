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
        <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">  
	<script src="/static/admin/js/jquery-3.2.1.min.js"></script>
	<script src="/static/admin/js/bootstrap.min.js"></script>
    </head>
    <body>
        <h3>登录</h3><hr/>

<!--        @if ($errors->any())
        <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        </div>
        @endif-->
       <b style="color:red">{{session('msg')}}</b>
        <form class="form-horizontal" action="{{url('logindo')}}" role="form" method="post" enctype="multipart/form-data">
            @csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">用户名</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="name" id="firstname" 
				   placeholder="请输入用户名">
                        <b style="color:red">{{$errors->first('brand_name')}}</b>
                       
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">密码</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="password" id="lastname" 
				   placeholder="请输入密码">
                        <b style="color:red">{{$errors->first('brand_url')}}</b>
                      
		</div>
	</div>
        
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">登录</button>
		</div>
	</div>
</form>
    </body>
</html>
