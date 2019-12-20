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
        <h3>品牌编辑</h3><a href="{{url('brand')}}">列表</a><hr/>
        <form class="form-horizontal" action="{{url('brand/update/'.$data->brand_id)}}" role="form" method="post" enctype="multipart/form-data">
            @csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">品牌名称</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" value="{{$data->brand_name}}" name="brand_name" id="firstname" 
				   placeholder="请输入品牌名称">
                        <b style="color:red">{{$errors->first('brand_name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌网址</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" value="{{$data->brand_url}}" name="brand_url" id="lastname" 
				   placeholder="请输入品牌网址">
                        <b style="color:red">{{$errors->first('brand_url')}}</b>
		</div>
	</div>
         <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌LOGO</label>
		<div class="col-sm-10">
                    <img src="{{env('UPLOAD_URL')}}{{$data->brand_logo}}" width="100">
			<input type="file" class="form-control" name="brand_logo" id="lastname" 
				   placeholder="请输入品牌LOGO">
		</div>
	</div>
       <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌简介</label>
		<div class="col-sm-10">
			<textarea type="file" class="form-control" name="brand_desc" id="lastname" 
                                  placeholder="请输入品牌简介">{{$data->brand_desc}}</textarea>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">修改</button>
		</div>
	</div>
</form>
    </body>
</html>
