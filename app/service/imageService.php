<?php

namespace App\service;

use Illuminate\Http\Request;

class imageService
{
    public function insertImage (Request $request,$path){
        $image = $request->file('images');
        $randomName_gen = hexdec(uniqid());
        $image_extesion = strtolower($image->getClientOriginalExtension());
        $image_name = $randomName_gen . '.' . $image_extesion;
        $upload_dir = 'images/'.$path.'/';
        $final_name = $upload_dir . $image_name;
        $image->move($upload_dir, $image_name);
//        $image_id = DB::table('attachments')->insertGetId([
//            'images'=>$final_name
//        ]);
        return $final_name;


    }
}
