<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeldingenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       return view('Admin.Meldingen.meldingen');
    }

    public function meldingen_data (Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];

        $sql="SELECT
        a.id,
        a.p2000,
        a.straat,
        a.straat_url,
        a.lat,
        a.lng,
        a.prio,
        a.timestamp,
        a.dienst

        FROM melding a
        where
        1=1 ";
        if($search_value){
            $sql.="and (a.p2000 like '{$search_value}%' ";
            $sql.="OR a.timestamp like '{$search_value}%' ";
            $sql.="OR a.straat like '{$search_value}%' ";
            $sql.="OR a.straat_url like '{$search_value}%' ";
            $sql.="OR a.provincie like '{$search_value}%') ";

        }
        $sql.="order by a.id {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from melding a where 1=1 ";
        if($search_value){
            $sql.="and (a.p2000 like '{$search_value}%' ";
            $sql.="OR a.timestamp like '{$search_value}%' ";
            $sql.="OR a.straat like '{$search_value}%' ";
            $sql.="OR a.straat_url like '{$search_value}%' ";
            $sql.="OR a.provincie like '{$search_value}%' ) ";
        }
        $total=DB::select($sql);
        $dataArray=array();
        foreach($data as $thisData){
            $dataArray[]=array(
                $thisData->id,
                $thisData->p2000,
               date('m/d/y', $thisData->timestamp),
               $thisData->prio,

//                 <a href="/delete/meldingen/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>

                '<a href="/meldingen/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
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
        $findMeldingen = DB::table('melding')->where('id','=',$id)->first();
        $dienst = DB::table('dienst')->get();
        $category = DB::table('categorie')->get();
        $provincie = DB::table('provincie')->get();
        $regio = DB::table('regio')->get();
        $stad = DB::table('stad')->get();

        return view('Admin.Meldingen.edit',['data'=>$findMeldingen,'diensts'=>$dienst,'categories'=>$category,'provincies'=>$provincie,

            'regios'=>$regio,'stads'=>$stad]);
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
        $data['p2000'] = $request->description;
        $data['straat'] = $request->straat;
        $data['straat_url'] = $request->straat_url;
        $data['lat'] = $request->lat;
        $data['lng'] = $request->lng;
        $data['prio'] = $request->prio;
        $data['dienst'] = $request->dienst;
        $data['categorie'] = $request->category;
        $data['provincie'] = $request->provincie;
        $data['regio'] = $request->regio;
        $data['stad'] = $request->stad;
        $data['seo_keywords'] = $request->seo_keywords;
        $data['seo_meta'] = $request->seo_meta;


        $update = DB::table('melding')->where('id','=',$id)->update($data);


        return redirect()->route('meldingen')->with('status','Meldingen updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteForeignData = DB::table('eenheden')->where('melding','=',$id)->delete();
        $delete = DB::table('melding')->where('id','=',$id)->delete();
        return redirect()->route('meldingen')->with('status','Meldingen deleted successfully');
    }
}
