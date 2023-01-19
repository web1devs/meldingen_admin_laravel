<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.News-Comments.newsComments');
    }

    public function comment_data(Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];

        $sql="SELECT
        a.id,
        a.comments,
        a.posted_at,
        a.published_at,
        a.status
        FROM news_comments a
        where
        1=1 ";
        if($search_value){
            $sql.="and a.comments like '%{$search_value}%' ";
        }
        $sql.="order by a.id {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from news_comments a where 1=1 ";
        if($search_value){
            $sql.="and a.comments like '%{$search_value}%' ";
        }
        $total=DB::select($sql);
        $dataArray=array();
        foreach($data as $thisData){
            $dataArray[]=array(
                '<input class="delete_check" onclick="checkcheckbox();"  type="checkbox" name="id[]" value="'.$thisData->id.'">',
                $thisData->id,
                $thisData->comments,
                ($thisData->status==1?'Approved':'Pending'),
                '
                '.($thisData->status==1?'<a href="/comments/pending/'.$thisData->id.'" class="btn btn-info btn-sm" onclick="return confirm(\'Do you want to meke it pending again?\')"><i class="fa fa-bell"></i></a>':'').'
                <a href="/comments/delete/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>'
            );
        }
        echo'{
            "draw":'.$draw.',
            "recordsTotal": '.$total[0]->row.',
            "recordsFiltered": '.$total[0]->row.',
            "data": '.json_encode($dataArray).'
          }';
    }

    public function bulk_approve(Request $request){
        if(count($request->deleteids_arr)>0){
            $ids=$request->deleteids_arr;
            DB::table('news_comments')->whereIn('id', $ids)->update(['status'=>1,'published_at'=>date("Y-m-d h:i:s")]);
        }
    }

    public function bulk_delete(Request $request){
        if(count($request->deleteids_arr)>0){
            $ids=$request->deleteids_arr;
            DB::table('news_comments')->whereIn('id', $ids)->delete();
        }
    }

    public function pending($id){
        DB::table('news_comments')->where('id', $id)->update(['status'=>0]);
        return redirect('/comments')->with('status', 'Comment status updated as pending!');
    }


    public function delete($id){
        DB::table('news_comments')->where('id', $id)->delete();
        return redirect('/comments')->with('status', 'Comment deleted!');
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
        //
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
        //
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
