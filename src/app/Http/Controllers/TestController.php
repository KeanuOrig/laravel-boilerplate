<?php

namespace App\Http\Controllers;

use App\Traits\FileUpload;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'test';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->uploadFile($request->file('file'), 'test');
        return response()->json(array(
            "code" => 200,
            "message" => "Good",
            "result" => $request->file()
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
