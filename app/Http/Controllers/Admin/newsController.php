<?php

namespace App\Http\Controllers\Admin;

use App\Action\CrudActions;
use App\Http\Controllers\Controller;
use App\service\slugGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class newsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.News.news');
    }

    public function news_data(Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];

        $sql="SELECT
        a.id,
        a.title,
        a.created_at,
        a.postal,
        a.staddress,
        a.city,
        a.state
        FROM news a
        where
        1=1 ";
        if($search_value){
            $sql.="and a.title like '%{$search_value}%' ";
        }
        $sql.="order by a.id {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from news a where 1=1 ";
        if($search_value){
            $sql.="and a.title like '%{$search_value}%' ";
        }
        $total=DB::select($sql);
        $dataArray=array();
        foreach($data as $thisData){
            $dataArray[]=array(
                '<input class="delete_check" onclick="checkcheckbox();"  type="checkbox" name="newsid[]" value="'.$thisData->id.'">',
                $thisData->id,
                $thisData->title,
                $thisData->created_at,
                $thisData->postal,
                $thisData->city,
                $thisData->state,
                '<a href="/nieuws/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="/nieuws/delete/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>'
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
        $provincie = DB::table('provincie')->get();
        $regio = DB::table('regio')->get();
        $stad = DB::table('stad')->get();
        return view('Admin.News.create',['provincies'=>$provincie,'regios'=>$regio,'stads'=>$stad]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,slugGenerator $slugGenerator)
    {
        $insert = DB::table('news')->insert([
            'title'=> addslashes($request->title),
            'post_url'=>$request->post_url,
            'pubdate'=>now(),
            'description'=>addslashes($request->description),
            'content'=>addslashes($request->story),
            'slug'=>$slugGenerator->generateSlug('news',$request->title),
            'created_at'=>Carbon::now(),
            'lat'=>$request->lat,
            'lon'=>$request->lon,
            'tags'=>$request->tags,
            'state'=>$request->provincie,
            'city'=>$request->stad,
            'staddress'=>$request->staddress,
            'postal'=>$request->postal,
            'image'=>$request->image,
            'seo_keywords'=>$request->seo_keyword,
            'seo_meta'=>$request->seo_meta,


        ]);

        return redirect()->route('news')->with('status','Nieuws created successfully');
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
    public function edit($id,CrudActions $crudActions)
    {
        $provincie = DB::table('provincie')->get();
        $regio = DB::table('regio')->get();
        $stad = DB::table('stad')->get();
        $edit = $crudActions->edit_Data('news',$id);
        return view('Admin.News.edit',['provincies'=>$provincie,'regios'=>$regio,'stads'=>$stad,'data'=>$edit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = DB::table('news')->where('id','=',$id)->update([
            'title'=> addslashes($request->title),
            'post_url'=>$request->post_url,
            'description'=>addslashes($request->description),
            'content'=>addslashes($request->story),
            'lat'=>$request->lat,
            'lon'=>$request->lon,
            'tags'=>$request->tags,
            'state'=>$request->provincie,
            'city'=>$request->stad,
            'staddress'=>$request->staddress,
            'postal'=>$request->postal,
            'image'=>$request->image,
            'seo_keywords'=>$request->seo_keyword,
            'seo_meta'=>$request->seo_meta,
        ]);

        return redirect()->route('news')->with('status','Nieuws updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CrudActions $crudActions)
    {
        $delete = $crudActions->deleteValue('news',$id);
        return redirect()->route('news')->with('status','Nieuws deleted successfully');
    }

    public function delete_all(Request $request){
        if(count($request->deleteids_arr)>0){
            $ids=$request->deleteids_arr;
            DB::table('news')->whereIn('id', $ids)->delete();
        }
    }
}
