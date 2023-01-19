<?php

namespace App\Http\Controllers\Admin;

use App\Action\CrudActions;
use App\Http\Controllers\Controller;
use App\service\slugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvincieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.provincie.provincie');
    }

    public function provincie_data(Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];

        $sql="SELECT
        a.*
        FROM provincie a
        where 1=1 ";
        if($search_value){
            $sql.="and a.provincie like '{$search_value}%' ";
        }
        $sql.="order by a.provincie {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from provincie a where 1=1";
        if($search_value){
            $sql.=" and a.provincie like '{$search_value}%' ";
        }
        $total=DB::select($sql);
        $dataArray=array();
        foreach($data as $thisData){
            $dataArray[]=array(
                $thisData->id,
                $thisData->provincie,
                $thisData->provincie_url,
                $thisData ->slug,
                '<a href="/provincie/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="/provincie/delete/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>'
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
       return view('Admin.provincie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,slugGenerator $slugGenerator)
    {

        $validate = $request->validate([
            'provincie'=>'required|unique:provincie,provincie',
            'provincie_url'=>'required',
        ]);

        $slug = $slugGenerator->generateSlug('provincie',$request->provincie);

        $insert = DB::table('provincie')->insert([
            'provincie'=>$request->provincie,
            'provincie_url'=>$request->provincie_url,
            'seo_keywords'=>$request->seo_keywords,
            'seo_meta'=>$request->seo_meta,
            'slug'=>$slug,
        ]);

        return redirect()->route('provincie')->with('status','provincie created successfully');
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
    public function edit($id,CrudActions $edit_data)
    {
      $edit = $edit_data->edit_Data('provincie',$id);

       return view('Admin.provincie.edit',['data'=>$edit]);
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
        $data['provincie'] = $request->provincie;
        $data['provincie_url'] = $request->provincie_url;
        $data['seo_keywords'] = $request->seo_keywords;
        $data['seo_meta'] = $request->seo_meta;

        $update = DB::table('provincie')->where('id','=',$id)->update($data);
        return redirect()->route('provincie')->with('status','provincie updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, CrudActions $deleteData)
    {
        $delete = $deleteData->deleteValue('provincie',$id);
        return redirect()->route('provincie')->with('status','provincie deleted successfully');

    }
}
