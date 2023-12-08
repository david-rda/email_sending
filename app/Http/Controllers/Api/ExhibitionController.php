<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exhibition;

class ExhibitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Exhibition::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required"
        ]);

        try {
            $exhibition = new Exhibition();
            $exhibition->title = $request->title;
            $exhibition->save();

            return response()->json([
                "success" => "გამოფენა დაემატა."
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "error" => "გამოფენა ვერ დაემატა."
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return Exhibition::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            "title" => "required"
        ]);

        try {
            $exhibition = Exhibition::find($id);
            $exhibition->title = $request->title;
            $exhibition->save();

            return response()->json([
                "success" => "გამოფენა განახლდა."
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "error" => "გამოფენა ვერ განახლდა."
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $exhibition_delete = Exhibition::find($id)->delete();

        if($exhibition_delete) {
            return response()->json([
                "success" => "გამოფენა წაიშალა."
            ], 200);
        }else {
            return response()->json([
                "error" => "გამოფენა ვერ წაიშალა."
            ], 422);
        }
    } 
}
