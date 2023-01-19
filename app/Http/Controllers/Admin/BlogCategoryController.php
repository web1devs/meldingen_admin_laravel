<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\service\imageService;
use App\service\slugGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('Admin.Blog_category.blog_category');
    }

    public function Categories_data (Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];

        $sql="SELECT
        a.*
        FROM blog_categories a
        where 1=1 ";
        if($search_value){
            $sql.="and a.category_name like '{$search_value}%' ";
        }
        $sql.="order by a.category_name {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from blog_categories a where 1=1";
        if($search_value){
            $sql.=" and a.category_name like '{$search_value}%' ";
        }
        $total=DB::select($sql);
        $dataArray=array();
        foreach($data as $thisData){
            $dataArray[]=array(
                $thisData->id,
                $thisData->category_name,
                $thisData->category_title,
                Str::limit($thisData->short_description,100),
                $thisData ->slug,
                '<a href="/blog-category/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="/blog-category/delete/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>'
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Blog_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,imageService $imageService, slugGenerator $slugGenerator)
    {
        $validate = $request->validate([
            'category_name'=>'required|max:255|unique:blog_categories,category_name',
            'category_title'=>'required',
            'images'=>'required|mimes:jpeg,png,gif',
            'short_description'=>'required',
        ]);
        $slug = $slugGenerator->generateSlug('blog_categories',$request->category_name);
        $image_name = $imageService->insertImage($request,'Blog-category');
        $seo_keywords = $request->seo_keywords;
        $seo_meta = $request->seo_meta;
        $insert  = DB::table('blog_categories')->insert([
            'category_name' => $request->category_name,
            'category_title'=> $request->category_title,
            'short_description'=>addslashes($request->short_description),
            'slug' =>$slug,
            'created_at'=>Carbon::now(),
            'seo_keywords'=>$seo_keywords,
            'seo_meta'=>$seo_meta,
            'images'=>$image_name,
        ]);

        return redirect()->route('blog_category')->with('status','Blog category created successfully');
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
        $data = DB::table('blog_categories')->where('id','=',$id)->first();
        return view('Admin.Blog_category.edit',['data'=>$data]);
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
        $seo_keyword = $request->seo_keywords;
        $seo_meta = $request->seo_meta;

        if($request->hasFile('images')){
            $findImage = DB::table('blog_categories')->where('id','=',$id)->first();
            $oldImage = $findImage->images;
            $path = public_path($oldImage);

            if(is_file($path)){
                unlink($oldImage);
            }


            $data['category_name'] = $request->category_name;
            $data['category_title'] = $request->category_title;
            $data['short_description'] = addslashes($request->short_description);

            $data['slug']= $request->slug;
            $data['seo_keywords'] = $seo_keyword;
            $data['seo_meta'] = $seo_meta;
            $data['images'] = $imageService->insertImage($request,'Blog-category');
            $update = DB::table('blog_categories')->where('id',$id)->update($data);
        }else{
            $data['category_name'] = $request->category_name;
            $data['category_title'] = $request->category_title;
            $data['short_description'] = addslashes($request->short_description);

            $data['slug']= $request->slug;
            $data['seo_keywords'] = $seo_keyword;
            $data['seo_meta'] = $seo_meta;
            $update = DB::table('blog_categories')->where('id',$id)->update($data);
        }

        return redirect()->route('blog_category')->with('status','Blog category updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findImage = DB::table('blog_categories')->where('id','=',$id)->first();
        $oldImage = $findImage->images;
        $path = public_path($oldImage);

        if(is_file($path)){
            unlink($oldImage);
        }

        $deleteCategory = DB::table('blog_categories')->where('id','=',$id)->delete();
        return redirect()->route('blog_category')->with('status','Blog category Deleted successfully');
    }
}
