<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.seo-data.seo_data');
    }

    public function seo_data(Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];

        $sql="SELECT
        a.*
        FROM seo_data_tables a
        where 1=1 ";
        if($search_value){
            $sql.="and a.page like '{$search_value}%' ";
        }
        $sql.="order by a.page {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from seo_data_tables a where 1=1";
        if($search_value){
            $sql.=" and a.page like '{$search_value}%' ";
        }
        $total=DB::select($sql);
        $dataArray=array();
        foreach($data as $thisData){
            $dataArray[]=array(
                stripslashes($thisData->title),
                $thisData->page,
                $thisData->seo_keywords,
                $thisData->seo_meta,

//                $thisData->categories,





//                '<a href="/admin/edit-seo-data/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>              '
//                <a href="/admin/seo_data/delete?'.$thisData->page.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-close"></i></a>
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($page)
    {
       $pageData = DB::table('seo_data_tables')->where('page','=',$page)->first();

       return view('Admin.seo-data.edit',['data'=>$pageData]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $page)
    {
        $updateData = DB::table('seo_data_tables')->where('page','=',$page)->update([
            'title'=>addslashes($request->title),
            'seo_keywords'=>$request->seo_keyword,
            'seo_meta'=>$request->seo_meta,
            'structured_data'=>$request->structured_data,
        ]);

        return redirect()->route('seo_data')->with('status','SEO data updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
