<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {

        $test = Test::paginate(10);
        // $test = Test::all();
        return response()->json([
            'status' => 1,
            'message' => 'data dapat ditampilkan',
            'data' => $test,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $test = Test::create([
            'id' => $request->id,
            'name' => $request->name,
            'date' => $request->date,
        ]);
        return response()->json([
            'status' => 1,
            'message' => 'data dapat disimpan',
            'data' => $test,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return JsonResponse
     */
    public function show(Test $test)
    {
        return response()->json([
            'status' => 1,
            'message' => $test->name.' data didapatkan ',
            'data' => $test,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    // public function edit(Test $test)
    // {
    //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return JsonResponse
     */
    public function update(Request $request, Test $test)
    {
        $test->name = $request->name;
        $test->date = $request->date;
        $test->save();

        return response()->json([
            'status' => 1,
            'message' => 'data dapat diupdate',
            'data' => $test,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return JsonResponse
     */
    public function destroy(Test $test)
    {
        $test->delete();

        return response()->json([
            'status' => 1,
            'message' => 'data dapat dihapus'
        ]);
    }
}
