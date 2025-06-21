<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function index()
    {
        $queries = \App\Models\Contact::all();
        return view('admin.queries',compact('queries'));
    }
}
