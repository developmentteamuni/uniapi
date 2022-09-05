<?php

namespace App\Http\Controllers;

use App\Models\University;
use Goutte\Client;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function index()
    {
        $client = new Client();
        $url = 'https://www.act.org/content/act/en/research/reports/act-publications/college-choice-report-class-of-2013/college-majors-and-occupational-choices/college-majors-and-occupational-choices.html';
        $crawler = $client->request('GET', $url);
        $crawler->filter('.text-block-body-content')->each(function ($node) {
          echo response([
            'message' => 'success',
            'data' => $node->text(),
          ]);
        });

        // $uni = University::latest()->get();

        // return response([
        //     'uni' => $uni
        // ], 200);
    }

    public function uni() 
    {
        $client = new Client();
        $url = 'https://www.4icu.org/us/a-z/';
        $crawler = $client->request('GET', $url);
        $crawler->filter('.table-responsive')->each(function ($node) {
          echo response([
            'message' => 'success',
            'data' => $node->text(),
          ], 200);
        });
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'university' => 'required|max:100'
    //     ]);

    //     $uni = University::create([
    //         'university' => $request->university
    //     ]);

    //     return response([
    //         'uni' => $uni
    //     ], 201);
    // }

    // public function update(Request $request, University $university)
    // {
    //     $request->validate([
    //         'university' => 'required|max:100'
    //     ]);

    //     $uni = $university->update([
    //         'university' => $request->university
    //     ]);

    //     return response([
    //         'message' => 'success',
    //         'uni' => $uni
    //     ], 201);
    // }
    

    // public function delete(University $university)
    // {
    //     $university->delete();

    //     return response([
    //         'message' => 'deleted'
    //     ], 200);
    // }
}
