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
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <h3>品牌添加</h3><a href="{{url('brand')}}">列表</a><hr/>

<!--        @if ($errors->any())
        <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        </div>
        @endif-->
        <form class="form-horizontal" action="{{url('brand/store')}}" role="form" method="post" enctype="multipart/form-data">
            @csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">品牌名称</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="brand_name" id="firstname" 
				   placeholder="请输入品牌名称">
                        <b style="color:red">{{$errors->first('brand_name')}}</b>
                       
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌网址</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="brand_url" id="lastname" 
				   placeholder="请输入品牌网址">
                        <b style="color:red">{{$errors->first('brand_url')}}</b>
                      
		</div>
	</div>
         <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌LOGO</label>
		<div class="col-sm-10">
			<input type="file" class="form-control" name="brand_logo" id="lastname" 
				   placeholder="请输入品牌LOGO">
		</div>
	</div>
            
        <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">多文件上传品牌LOGO</label>
		<div class="col-sm-10">
			<input type="file" class="form-control" name="brand_logo2[]" id="lastname" 
				   placeholder="请输入品牌LOGO">
                        <input type="file" class="form-control" name="brand_logo2[]" id="lastname" 
				   placeholder="请输入品牌LOGO">
                        <input type="file" class="form-control" name="brand_logo2[]" id="lastname" 
				   placeholder="请输入品牌LOGO">
		</div>
	</div>     
        
       <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌简介</label>
		<div class="col-sm-10">
			<textarea type="file" class="form-control" name="brand_desc" id="lastname" 
                                  placeholder="请输入品牌简介"></textarea>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="button" class="btn btn-default">添加</button>
		</div>
	</div>
            <script>
                $('#firstname').blur(function(){
                     checkName(); 
                });
                
                $('input[name="brand_url"]').blur(function(){   
                     checkUrl();
                });
                
                $('.btn-default').click(function(){
                    //品牌名称
                    var NameFlag = checkName();
                    
                    //品牌网址
                    var UrlFlag = checkUrl();
            
                    //提交
                    if( NameFlag && UrlFlag ){
                       // alert(123);
                       $('.form-horizontal').submit();
                     }
                    //return false;
                });
                function checkUrl(){
                     $('input[name="brand_url"]').next().text('');
                     var brand_url = $('input[name="brand_url"]').val();
                     var reg = /^http:\/\/+/;
            
                     if(!reg.test(brand_url)){
                         $('input[name="brand_url"]').next().text('品牌网址为http://开头');
                         return false;
                     }  
                     return true;
                }
                
                function checkName(){
                    $('#firstname').next().text('');
                     var brand_name = $('#firstname').val();
                     var reg = /^[\u4e00-\u9fa5\w]{2,12}$/;
                     if(!reg.test(brand_name)){
                         $('#firstname').next().text('品牌名称需是中文数字字母下划线组成长度为2-12位');
                         return false;
                    } 
                    return checkOnly(brand_name);
                }
                
                function checkOnly(brand_name){
                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        });
                      var flag = true;  
                     //唯一性验证
                     $.ajax({
                        method: "POST",
                        url: "/brand/checkonly",
                        async:false,
                        data: { brand_name: brand_name }
                      }).done(function( msg ) {
                        if(msg>0){
                          $('#firstname').next().text('品牌名称已存在');  
                          flag = false;  
                        }
                     });
                     return flag;  
                }
                
            </script>    
</form>
    </body>
</html>
