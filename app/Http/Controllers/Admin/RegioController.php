<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



      return view('Admin.Regio.regio');
    }


        public function regio_data(Request $request){

            $draw=$request->draw;
            $limit=$request->length;
            $search_value=addslashes($request->search['value']);
            $start=$request->start;
            $order_by=$request->order[0]['dir'];

            $sql="SELECT
        a.id,
        a.regio,
        a.regio_url,
        b.provincie
        FROM regio a, provincie b
        where
        a.provincie=b.id ";
            if($search_value){
                $sql.="and a.regio like '{$search_value}%' ";
            }
            $sql.="order by a.regio {$order_by} limit {$start}, {$limit}";
            $data=DB::select($sql);

            $rows=count($data);
            $sql="select count(a.id) as row from regio a where 1=1";
            if($search_value){
                $sql.=" and a.regio like '{$search_value}%' ";
            }
            $total=DB::select($sql);
            $dataArray=array();
            foreach($data as $thisData){
                $dataArray[]=array(
                    $thisData->id,
                    $thisData->regio,
                    $thisData->regio_url,
                    $thisData->provincie,
                    '<a href="/regio/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="/regio/delete/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>'
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
    public function edit($id)
    {
        $provincie = DB::table('provincie')->get();
        $findRegio = DB::table('regio')->where('id','=',$id)->first();
        return view('Admin.Regio.edit',['data'=>$findRegio,'provincies'=>$provincie]);
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
        $data =array();
        $data['regio'] = $request->regio;
        $data['regio_url'] = $request->regio_url;
        $data['provincie'] = $request->provincie;
        $data['seo_keywords'] = $request->seo_keywords;
        $data['seo_meta'] = $request->seo_meta;

        $update = DB::table('regio')->where('id','=',$id)->update($data);
        return redirect()->route('regio')->with('status','Regio updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteRegioCapcode = DB::table('capcode')->where('regio','=',$id)->delete();
        $delete = DB::table('regio')->where('id','=',$id)->delete();
        return redirect()->route('regio')->with('status','Regio Deleted successfully');
    }
}
