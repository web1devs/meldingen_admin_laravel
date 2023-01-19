<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('Admin.User.user');
    }

    public function user_data(Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];



        $sql="SELECT
        a.*
        FROM users a
        where 1=1 ";
        if($search_value){
            $sql.="and a.name like '{$search_value}%' ";
        }
        $sql.="order by a.id {$order_by}  limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from users a where 1=1";
        if($search_value){
            $sql.=" and a.name like '{$search_value}%' ";
        }
        $total=DB::select($sql);

        $dataArray=array();
        foreach($data as $thisData){
            $status = [];
            if($thisData->status ===1){
                $status = 'Active';
            }else{
                $status = 'inactive';
            }

            $role =[];
            if($thisData->role === 1){
                $role = "admin";
            }else{
                $role = "user";
            }

            $dataArray[]=array(
                $thisData->id,
                $thisData->name,
                $thisData->email,
                $status,
                $role,



                '<a href="/user/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="/user/delete/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>


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
       return view('Admin.User.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hashed_password = Hash::make($request->password);
        $insert = DB::table('users')->insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$hashed_password,
            'role'=>$request->role,
            'status'=>$request->status,
        ]);

        return redirect()->route('user')->with('status','User Created Successfully');
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
        $find_user = DB::table('users')->where('id',$id)->first();


        return view('Admin.User.edit',['users'=>$find_user]);
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
        $new_password = Hash::make($request->password);

        $update = DB::table('users')->where('id',$id)->update([
            'name'=>$request->name,
            'password'=>$new_password,
            'role'=>$request->role,
            'status'=>$request->status,
        ]);
        return redirect()->route('user')->with('status','User info updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $find_user = DB::table('users')->where('id',$id)->delete();
       return redirect()->route('user')->with('status','User Deleted Successfully');
    }
}
