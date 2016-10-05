<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SkaicController extends Controller
{

     public function getIndex()
     {

         return view('index');
     }

     public function postIndex(request $request)
     {
         $this->validate($request, [
             'input' => 'required' ,
             'type' => 'required',
             'r_type' => 'required',
         ]);

         $model = new \App\Convert;
         $model->load($request->input());
         $model->convert();

         return view('index', [
             'model' => $model,
             'i' => $model->input_type,
             'o' => $model->output_type,
         ]);
     }
}
