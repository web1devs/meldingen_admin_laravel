<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CookiebeleidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.coockie.cookiebeleid');
    }

    public function cookie_data(Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];



        $sql="SELECT
        a.*
        FROM cookie a
        where 1=1 ";
        if($search_value){
            $sql.="and a.title like '{$search_value}%' ";
        }
        $sql.="order by a.title {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from cookie a where 1=1";
        if($search_value){
            $sql.=" and a.title like '{$search_value}%' ";
        }
        $total=DB::select($sql);

        $dataArray=array();
        foreach($data as $thisData){

            $dataArray[]=array(
                $thisData->id,
                $thisData->title,





                '<a href="/Cookiebeleid/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('Admin.coockie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $insert = DB::table('cookie')->insert([
           "title"=> stripslashes($request->title),
           "content"=> $request->content,
           "created_at"=>Carbon::now()
       ]);

       return redirect()->route('/Cookiebeleid')->with('status','created successfully');
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
        $data = DB::table('cookie')->first();
        return view('Admin.coockie.edit',['data'=>$data]);
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
       $update = DB::table('cookie')->where('id','=',$id)->update([
           "title"=> stripslashes($request->title),
           "content"=> $request->content,
       ]);

        return redirect()->route('Cookiebeleid')->with('status','updated successfully');

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
