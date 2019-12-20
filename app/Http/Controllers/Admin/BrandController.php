<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Brand;
use App\Http\Requests\StoreBrandPost;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreBrand;
use Illuminate\Support\Facades\Auth;
#use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * 列表展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        $brand_name = request()->brand_name;
      //  echo $brand_name;
        $where = [];
        if( $brand_name ){
            $where[] = ['brand_name','like',"%$brand_name%"];
        }
        $brand_url = request()->brand_url;
        if( $brand_url ){
            $where[] = ['brand_url','like',"%$brand_url%"];
        }
        //Cache::flush();
        $page = request()->page;
        
        //$data =  Cache::get('data_'.$page.'_'.$brand_name.'_'.$brand_url);
        //$data = cache('data_'.$page.'_'.$brand_name.'_'.$brand_url);
       // echo 'data_'.$page.'_'.$brand_name.'_'.$brand_url;
        
      //  Redis::del('data_'.$page.'_'.$brand_name.'_'.$brand_url);
         $data = Redis::get('data_'.$page.'_'.$brand_name.'_'.$brand_url);
         $data = unserialize($data);
       // dump($data);die;
        if(!$data){
            
            echo "走DB";
    
            $pageSize = config('app.pageSize');

            //DB::connection()->enableQueryLog();
            $data = Brand::where($where)->orderBy('brand_id','desc')->paginate($pageSize);
            //Cache::put(['data_'.$page.'_'.$brand_name.'_'.$brand_url=>$data],30);
            //cache(['data_'.$page.'_'.$brand_name.'_'.$brand_url=>$data],30);
           
            //dd($data);
            Redis::setex('data_'.$page.'_'.$brand_name.'_'.$brand_url, 20,serialize($data));
       }
//        $logs = DB::getQueryLog();
//        dump($logs);
        //dd($data);
        $query = request()->all();
       // dd($query);
        return view('admin.brand.index',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     * 添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(StoreBrand $request)
    public function store(Request $request)
    {
        //第一种验证
//        $request->validate([
//            'brand_name' => 'required|unique:brand|max:255',
//            'brand_url' => 'required',
//        ],[
//            'brand_name.required'=>'名称必填',
//            'brand_name.unique'=>'名称已存在',
//            'brand_url.required'=>'网址必填',
//        ]);

        //接收所有值
        $post = $request->except('_token');
        //dd($post);
        $validator = Validator::make($post, [
            'brand_name' => 'required|unique:brand|max:255',
            'brand_url' => 'required',
        ],[
            'brand_name.required'=>'名称必填',
            'brand_name.unique'=>'名称已存在',
            'brand_url.required'=>'网址必填',
        ]);
        if ($validator->fails()) {
            return redirect('brand/create')
                ->withErrors($validator)
                ->withInput();
         }
        
        
        
        //dd($post);
       // $post = $request->only(['brand_name']);
        
      
        //单文件上传
        //先判断有无文件上传
        if ($request->hasFile('brand_logo')) {
            $post['brand_logo'] =$this->upload('brand_logo');
        }
        
        //多文件上传
        if ($request->hasFile('brand_logo2')) {
           
           $imgs =$this->upload('brand_logo2');
           $post['brand_logo2'] = implode('|',$imgs);
        }
        
       //dd($post);
        
        //$res = DB::table('brand')->insert($post);
  
        //ORM
        //$res = Brand::create($post);
        $brand = new Brand();
        $brand->brand_name = $post['brand_name'];
        $brand->brand_url = $post['brand_url'];
        $brand->brand_logo = $post['brand_logo']??'';
        $brand->brand_desc = $post['brand_desc'];
        $res =  $brand->save();
         //$res = Brand::insert($post);
      
        if( $res ){
            return redirect('brand');
        }
    }
    /**
     * 支持单、多文件上传
     * @param type $file
     * @return typed
     */
    public function upload($file){
        $imgs = request()->file($file);
        if(is_array($imgs)){
           //多文件上传 
            $result = [];
            foreach($imgs as $v){
                 //验证文件是否上传成功
                if ($v->isValid()){
                    //接收文件并上传
                    $result[] = $v->store('uploads');
                } 
            }
            return $result; 
        }else{
            //单文件上传
              //验证文件是否上传成功
            if ($imgs->isValid()){
                //接收文件并上传
                $path = request()->file($file)->store('uploads');
                //返回上传的文件路径
                return $path;
            } 
        }

        exit('文件上传出错！');
    }
    


    /**
     * Display the specified resource.
     *  展示详情页
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *  编辑页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //根据记录id查询
        //$data = DB::table('brand')->where('brand_id',$id)->first();
         //ORM
        $data = Brand::find($id);
        return view('admin.brand.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     * 执行修改
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        
        $validator = Validator::make($post, [
            //'brand_name' => 'required|unique:brand|max:12|min:2',
            'brand_name' => [
                'required',
                Rule::unique('brand')->ignore($id,'brand_id'),
                'max:12',
                'min:2'
            ],
            'brand_url' => 'required',
        ],[
            'brand_name.required'=>'品牌名称必填',
            'brand_name.unique'=>'品牌名称已存在',
            'brand_name.max'=>'品牌名称最大长度为12位',
            'brand_name.min'=>'品牌名称最小长度为2位',
            'brand_url.required'=>'品牌网址必填',
        ]);
        if ($validator->fails()) {
            return redirect('brand/edit/'.$id)
                    ->withErrors($validator)
                    ->withInput();
         }
        
        
        
         //文件上传
        //先判断有无文件上传
        if ($request->hasFile('brand_logo')) {
            $post['brand_logo'] =$this->upload('brand_logo');
        }
        //dd($post);
        //DB::table('brand')->where('brand_id', $id)->update($post);
        //ORM
//        $brand = Brand::find($id);
//        $brand->brand_name = $post['brand_name'];
//        $brand->brand_url = $post['brand_url'];
//        $brand->brand_logo = $post['brand_logo'];
//        $brand->brand_desc = $post['brand_desc'];
//        $brand->save();
        Brand::where('brand_id', $id)->update($post);
        return redirect('brand')->with('msg','修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *  删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$res = DB::table('brand')->where('brand_id',$id)->delete();
        //ORM
        //$res = Brand::destroy($id);
        $res = Brand::where('brand_id',$id)->delete();
        if( $res ){
            echo "<script>alert('删除成功');location.href='/brand';</script>";
           //return redirect('brand')->with('msg','删除成功'); 
        }
    }
    
    
    public function checkonly(){
        $brand_name = request()->brand_name;
        $where=[];
        if($brand_name){
            $where['brand_name'] = $brand_name;
        }
        $count = Brand::where($where)->count();
        echo $count;
    }
    

    
    
    
}
