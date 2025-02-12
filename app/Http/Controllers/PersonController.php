<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Tools;
use App\Http\Helpers\PersonTools;
use Illuminate\Http\Response;
use  App\Models\Person;

 

class PersonController extends Controller
{
    public static  function createPerson(Request $request){

        $dataCleaned = Tools::cleanData($request, ['name','lastname', 'born_date','state','id']);

        if (!PersonTools::ValidateData($dataCleaned)) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => 'Invalid input data'
            ], 422);
        }

        try {
            $person = Person::create($dataCleaned);
            return [
                'success' => true,
                'person' => $person
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => $th->getMessage()
            ];
        }

    }

    public function getAll(){
        $person = Person::all();

        if ($person->isEmpty()) {
            return response()->json([
                "data" => "data not found, is empty",
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            "data" => $person,
        ], Response::HTTP_OK);
    }
}
