<?php

namespace App\service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class slugGenerator
{
    public function generateSlug($table,$name)
    {
        $slug = Str::slug($name);

        $count = DB::table($table)->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
