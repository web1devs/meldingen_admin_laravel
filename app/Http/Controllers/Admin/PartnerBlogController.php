<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\service\imageService;
use App\service\slugGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.partner_blog.partner-blog');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('Admin.partner_blog.create');
    }

    public function blog_data(Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];

        $sql="SELECT
        a.*
        FROM partner_blogs a
        where 1=1 ";
        if($search_value){
            $sql.="and a.blog_title like '{$search_value}%' ";
        }
        $sql.="order by a.blog_title {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from partner_blogs a where 1=1";
        if($search_value){
            $sql.=" and a.blog_title like '{$search_value}%' ";
        }
        $total=DB::select($sql);
        $dataArray=array();
        foreach($data as $thisData){
            $dataArray[]=array(
                $thisData->id,

                $thisData->status === 'published' ? "<a style='text-decoration: none' target='_blank' href='/partnerbijdrage/.$thisData->slug./$thisData->id'>$thisData->blog_title</a>" : $thisData->blog_title,

                stripslashes( $thisData->description),
//                $thisData->categories,
                $thisData->slug,
                $thisData->status,



                '<a href="/partner-blogs/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="/partner-blogs/delete/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>'
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
    public function store(Request $request, imageService $imageService,slugGenerator $slugGenerator)
    {
        $validate = $request->validate([
            'title'=>'required',
            'short_description'=>'required',
            'blog_content'=>'required',
            'images'=>'required|mimes:jpeg,png,gif'
        ]);
        $image_name = $imageService->insertImage($request,'partner_blog');
        $seo_keyword = addslashes($request->seo_keyword);
        $seo_meta = addslashes($request->seo_meta);

        $slug= $slugGenerator->generateSlug('partner_blogs',$request->title);

        $data = [
            'blog_title'=>addslashes($request->title),
            'description'=>addslashes($request->short_description),
            'content'=> addslashes($request->blog_content),
            'images'=> $image_name,
            'seo_keywords'=>$seo_keyword,
            'seo_meta'=>$seo_meta,
            'slug'=>$slug,
            'created_at'=>Carbon::now(),
            'status'=>$request->status,
        ];


        $insert  = DB::table('partner_blogs')->insert($data);

        return redirect()->route('partner-blogs')->with('status','Blog Created Successfully');
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
       $findBlog = DB::table('partner_blogs')->where('id','=',$id)->first();
       return view('Admin.partner_blog.edit',['data'=>$findBlog]);
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
            $findImage = PartnerBlog::where('id',$id)->first();
            $oldImage = $findImage->images;

            $path = public_path($oldImage);

            if(is_file($path)){
                unlink($oldImage);
            }

            $data['blog_title'] = addslashes($request->title);
            $data['description'] = addslashes($request->short_description);
            $data['content'] = addslashes($request->blog_content);
            $data['seo_keywords'] = $seo_keyword;
            $data['seo_meta'] = $seo_meta;
            $data['slug']= $request->slugs;
            $data['images'] = $imageService->insertImage($request,'partner_blog');
            $data['status']= $request->status;
            $update = DB::table('partner_blogs')->where('id',$id)->update($data);

        }else{
            $data['blog_title'] = addslashes($request->title);
            $data['description'] = addslashes($request->short_description);
            $data['content'] = addslashes($request->blog_content);
            $data['seo_keywords'] = $seo_keyword;
            $data['seo_meta'] = $seo_meta;
            $data['slug']= $request->slugs;
            $data['status']= $request->status;
            $update =DB::table('partner_blogs')->where('id',$id)->update($data);
        }
        return redirect()->route('partner-blogs')->with('status','Partner Blog updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findImage = DB::table('partner_blogs')->where('id','=',$id)->first();
        $oldImage = $findImage->images;
        $path = public_path($oldImage);

        if(is_file($path)){
            unlink($oldImage);
        }

        $deleteBlogs = DB::table('partner_blogs')->where('id','=',$id)->delete();
        return redirect()->route('partner-blogs')->with('status','Blog  Deleted successfully');
    }
}
