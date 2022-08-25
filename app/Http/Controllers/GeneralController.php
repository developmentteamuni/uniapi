<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function index()
    {
        $uni = University::latest()->get();

        return response([
            'uni' => $uni
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'university' => 'required|max:100'
        ]);

        $uni = University::create([
            'university' => $request->university
        ]);

        return response([
            'uni' => $uni
        ], 201);
    }

    public function update(Request $request, University $university)
    {
        $request->validate([
            'university' => 'required|max:100'
        ]);

        $uni = $university->update([
            'university' => $request->university
        ]);

        return response([
            'message' => 'success',
            'uni' => $uni
        ], 201);
    }
    

    public function delete(University $university)
    {
        $university->delete();

        return response([
            'message' => 'deleted'
        ], 200);
    }
}
