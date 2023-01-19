<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\service\slugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.category.category');
    }

    public function categories_data(Request $request){
        $draw=$request->draw;
        $limit=$request->length;
        $search_value=addslashes($request->search['value']);
        $start=$request->start;
        $order_by=$request->order[0]['dir'];

        $sql="SELECT
        a.*
        FROM categorie a
        where 1=1 ";
        if($search_value){
            $sql.="and a.categorie like '{$search_value}%' ";
        }
        $sql.="order by a.categorie {$order_by} limit {$start}, {$limit}";
        $data=DB::select($sql);

        $rows=count($data);
        $sql="select count(a.id) as row from categorie a where 1=1";
        if($search_value){
            $sql.=" and a.categorie like '{$search_value}%' ";
        }
        $total=DB::select($sql);
        $dataArray=array();
        foreach($data as $thisData){
            $dataArray[]=array(
                $thisData->id,
                $thisData->categorie,
               $thisData->categorie_url,
               $thisData ->slug,
                '<a href="/category/edit/'.$thisData->id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="/category/delete/'.$thisData->id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you confirm to delete?\')"><i class="fa fa-trash"></i></a>'
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
        return view('Admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,slugGenerator $slugGenerator)
    {//
        $validate = $request->validate([
            'category_name'=>'required|unique:categorie,categorie',
            'category_url'=>'required',
        ]);

        $slug = $slugGenerator->generateSlug('categorie',$request->category_name);

        $insert = DB::table('categorie')->insert([
            'categorie'=>$request->category_name,
            'categorie_url'=>$request->category_url,
            'seo_keywords'=>$request->seo_keywords,
            'seo_meta'=>$request->seo_meta,
            'slug'=>$slug
        ]);
        return redirect()->route('category')->with('status','Category created successfully');


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
       $findCategory = DB::table('categorie')->where('id','=',$id)->first();
       return view('Admin.category.edit',['data'=>$findCategory]);
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
      $data['categorie'] = $request->category_name;
      $data['categorie_url'] =  $request->category_url;
      $data['slug'] = $request->slug;
      $data['seo_keywords'] = $request->seo_keywords;
      $data['seo_meta'] = $request->seo_meta;

      $update = DB::table('categorie')->where('id','=',$id)->update($data);
        return redirect()->route('category')->with('status','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $Delete = DB::table('categorie')->where('id','=',$id)->delete();
        return redirect()->route('category')->with('status','Category Deleted successfully');

    }
}
