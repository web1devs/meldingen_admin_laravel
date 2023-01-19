<?php

namespace App\Action;

use Illuminate\Support\Facades\DB;

class CrudActions
{
    public function deleteValue($table,$id){
       $delete = DB::table($table)->where('id','=',$id)->delete();
       return $delete;
    }

    public function edit_Data($table,$id){
        $findProvincie = DB::table($table)->where('id','=',$id)->first();
        return $findProvincie;
    }
}
