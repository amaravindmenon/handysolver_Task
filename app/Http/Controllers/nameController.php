<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoName;
use App\Models\Todo;

class nameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $names =  TodoName::select('todo_names.id', 'todo_names.name', 'todo_names.created_at', 'to.category_id' )->join('todos as to', 'to.id','=', 'todo_names.category_id')->get();
 
        if($names) {
            return response()->json(['message'=>'data found',
            'code'=>200,
            'data' => $names
        ]);
        }else{
            return response()->json(['message'=>'error', 'code'=>500]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todoName = new TodoName;
        $todoName->category_id = $request->category_id;
        $todoName->name = $request->name;

        $result = $todoName->save();

        if($result) {
            return response()->json(['message'=>'success',
            'code'=>200
        ]);
        }else{
            return response()->json(['message'=>'error', 'code'=>500]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        /*
        $result = TodoName::where('id',$request->id)->first();

        if($result) {
            return response()->json(['message'=>'data found',
            'code'=>200,
            'data' => $result
        ]);
        }else{
            return response()->json(['message'=>'error', 'code'=>500]);
        }
        */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $result = TodoName::where('id',$request->id)->delete();
        if($result) {
            return response()->json(['message'=>'deleted',
            'code'=>200
        ]);
        }else{
            return response()->json(['message'=>'error', 'code'=>500]);
        }
    }
}
