<?php

namespace App\Http\Controllers;

use DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class Menus extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get($id = null) {
        $list = DB::table('menus')->get();

        return response()->json($list);
    }
}