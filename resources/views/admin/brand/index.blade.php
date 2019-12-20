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
        <h3>品牌列表</h3><a href="{{url('brand/create')}}">添加</a><hr/>
        <b style="color:red">{{session('msg')}}</b>
        <form action="" method="">
            <input type="text" name="brand_name" value="{{$query['brand_name']??''}}" placeholder="请输入品牌名称关键字">
            <input type="text" name="brand_url" value="{{$query['brand_url']??''}}" placeholder="请输入品牌网址">
            <button>搜索</button>
        </form>
        <table class="table table-hover">

	<thead>
		<tr>
			<th>ID</th>
			<th>品牌名称</th>
			<th>品牌网址</th>
                        <th>品牌LOGO</th>
                        <th>品牌介绍</th>
                        <th>操作</th>
		</tr>
	</thead>
	<tbody>
            @if($data)
            @foreach($data as $v)
		<tr>
			<td>{{$v->brand_id}}</td>
			<td>{{$v->brand_name}}</td>
			<td>{{$v->brand_url}}</td>
                        <td><img src="{{env('UPLOAD_URL')}}{{$v->brand_logo}}" width="100"></td>
                        <td>{{$v->brand_desc}}</td>
                        <td><a href="{{url('brand/edit/'.$v->brand_id)}}"  class="btn btn-info">编辑</a>|<a href="{{url('brand/delete/'.$v->brand_id)}}" class="btn btn-danger">删除</a></td>
		</tr>
           @endforeach
           @endif
           
           <tr><td colspan="6">{{$data->appends($query)->links()}}</td></tr>
	</tbody>
</table>
    </body>
</html>
