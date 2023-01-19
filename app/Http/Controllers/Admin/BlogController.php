<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\service\imageService;
use App\service\slugGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Blog.blog');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('blog_categories')->get();
        return view('Admin.Blog.create',['categories'=>$categories]);
    }

    public function blog_data(Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];



        $sql="SELECT
        a.*
        FROM blogs a
        where 1=1 ";
        if($search_value){
            $sql.="and a.blog_title like '{$search_value}%' ";
        }
        $sql.="order by a.blog_title {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from blogs a where 1=1";
        if($search_value){
            $sql.=" and a.blog_title like '{$search_value}%' ";
        }
        $total=DB::select($sql);

        $dataArray=array();
        foreach($data as $thisData){
            $dataArray[]=array(
                $thisData->id,

             stripslashes($thisData->blog_title),


                stripslashes($thisData->description),

                $thisData->slug,
                $thisData->status,



                '<a href="/blogs/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="/blogs/delete/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>


                '
            );
        }
        echo'{
            "draw":'.$draw.',
            "recordsTotal": '.$total[0]->row.',
            "recordsFiltered": '.$total[0]->row.',
            "data": '.json_encode($dataArray).'
          }';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,imageService $imageService,slugGenerator $slugGenerator)
    {
        $validate = $request->validate([
            'title'=>'required',
            'short_description'=>'required',
            'blog_content'=>'required',
            'category'=>'required',
            'images'=>'required',

        ]);
        $image_name = $imageService->insertImage($request,'blog');
        $seo_keyword = addslashes($request->seo_keyword);
        $seo_meta = addslashes($request->seo_meta);

        $slug= $slugGenerator->generateSlug('blogs',$request->title);

        $insert  = DB::table('blogs')->insert([
            'blog_title'=>addslashes($request->title),
            'categories'=>implode(',', (array) $request->input('category', [])),
            'description'=>addslashes($request->short_description),
            'content'=> addslashes($request->blog_content),
            'images'=> $image_name,
            'seo_keywords'=>$seo_keyword,
            'seo_meta'=>$seo_meta,
            'slug'=>$slug,
            'status'=>$request->status,
            'created_at'=>Carbon::now(),
        ]);

        return redirect()->route('blogs')->with('status','Blog Created Successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = DB::table('blog_categories')->get();
        $find = DB::table('blogs')->where('id','=',$id)->first();

        return view('Admin.Blog.edit',['categories'=>$categories,'data'=>$find]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,imageService $imageService)
    {
        $data = array();

        $seo_keyword = addslashes($request->seo_keyword);
        $seo_meta = addslashes($request->seo_meta);

        if($request->hasFile('images')){
            $findImage =DB::table('blogs')->where('id',$id)->first();
            $oldImage = $findImage->images;
            $path = public_path($oldImage);

            if(is_file($path)){
                unlink($oldImage);
            }

            $data['blog_title'] = addslashes($request->title);
            $data['categories'] = implode(',', (array) $request->input('category', []));
            $data['description'] = addslashes($request->short_description);
            $data['content'] = addslashes($request->blog_content);
            $data['seo_keywords'] = $seo_keyword;
            $data['seo_meta'] = $seo_meta;
            $data['slug']= $request->slugs;
            $data['images'] = $imageService->insertImage($request,'blog');
            $data['status'] = $request->status;
            $update = DB::table('blogs')->where('id',$id)->update($data);

        }else{
            $data['blog_title'] = addslashes($request->title);
            $data['categories'] = implode(',', (array) $request->input('category', []));
            $data['description'] = addslashes($request->short_description);
            $data['content'] = addslashes($request->blog_content);

            $data['seo_keywords'] = $seo_keyword;
            $data['seo_meta'] = $seo_meta;
            $data['slug']= $request->slugs;
            $data['status'] = $request->status;
            $update =DB::table('blogs')->where('id',$id)->update($data);

        }

        return redirect()->route('blogs')->with('status','Blog updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findImage = DB::table('blogs')->where('id','=',$id)->first();
        $oldImage = $findImage->images;
        $path = public_path($oldImage);

        if(is_file($path)){
            unlink($oldImage);
        }

        $deleteBlogs = DB::table('blogs')->where('id','=',$id)->delete();
        return redirect()->route('blogs')->with('status','Blog  Deleted successfully');
    }
}
