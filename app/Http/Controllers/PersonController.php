<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Tools;


class PersonController extends Controller
{
    public function createPerson(Request $request){
        $dataCleaned = Tools::cleanData();
    }
}
