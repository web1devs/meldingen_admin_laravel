<?php

namespace App\Http\Controllers\Admin;

use App\Action\CrudActions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ADSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('Admin.ADS.ads');
    }

    public function ads_data(Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];



        $sql="SELECT
        a.*
        FROM ads a
        where 1=1 ";
        if($search_value){
            $sql.="and a.title like '{$search_value}%' ";
        }
        $sql.="order by a.title {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from ads a where 1=1";
        if($search_value){
            $sql.=" and a.title like '{$search_value}%' ";
        }
        $total=DB::select($sql);

        $dataArray=array();
        foreach($data as $thisData){
            $section ='';
            if($thisData->section == 1){
                $section = 'Meldingen Home 1';
            }elseif ($thisData->section == 2){
                $section = 'Meldingen Home 2';
            }
            elseif ($thisData->section == 3){
                $section = 'Meldingen Home 3';
            }
            elseif ($thisData->section == 4){
                $section = 'Meldingen Details 1';
            }
            elseif ($thisData->section == 5){
                $section = 'Meldingen Details 2';
            }
            elseif ($thisData->section == 6){
                $section = 'News 1';
            }
            elseif ($thisData->section == 7){
                $section = 'News 2';
            }
            elseif ($thisData->section == 8){
                $section = 'News 3';
            }elseif ($thisData->section == 9){
                $section = 'News Details 1';
            }
            elseif ($thisData->section == 10){
                $section = 'News Details 2';
            }
            elseif ($thisData->section == 11){
                $section = 'News Details 3';
            }

            $status = [];
            if($thisData->status ===1){
                $status = 'Active';
            }else{
                $status = 'inactive';
            }
            $dataArray[]=array(
                $thisData->id,
                $thisData->title,

//                $thisData->categories,

                $section,
                $status,



                '<a href="/ads/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="/ads/delete/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>


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
       return view('Admin.ADS.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title'=>'required',
            'ads_code'=>'required',
            'section'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',


        ]);

        $status = [];
        if($request->status === null){
            $status = 0;
        }else{
            $status = $request->status;
        }

        $insert = DB::table('ads')->insert([
            'title'=> addslashes($request->title),
            'content'=> $request->ads_code,
            'section'=>$request->section,
            'from_hr'=>$request->start_time,
            'to_hr' => $request->end_time,
            'status'=>$status,
        ]);
        return redirect()->route('ADS')->with('status','ADS created');
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
        $findAds = $crudActions->edit_Data('ads',$id);
        return view('Admin.ADS.edit',['data'=>$findAds]);
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
        $data = array();

        $status = [];
        if($request->status === null){
            $status = 0;
        }else{
            $status = $request->status;
        }
        $data['title']= $request->title;
        $data['content']= $request->ads_code;
        $data['section']=$request->section;
        $data['from_hr'] = $request->start_time;
        $data['to_hr'] = $request->end_time;
        $data['status'] = $status;

        $update = DB::table('ads')->where('id','=',$id)->update($data);
        return redirect()->route('ADS')->with('status','ADS updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CrudActions $deleteAction)
    {
        $delete = $deleteAction->deleteValue('ads',$id);
        return redirect()->route('ADS')->with('status','ADS Deleted Successfully');
    }
}
