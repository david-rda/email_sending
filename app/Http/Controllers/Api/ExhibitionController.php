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
            "title" => "required",
            "country" => "required",
            "datetime" => "required"
        ]);

        try {
            $exhibition = new Exhibition();
            $exhibition->title = $request->title;
            $exhibition->country = $request->country;
            $exhibition->datetime = $request->datetime;
            $exhibition->save();

            // foreach($request->emails as $emails) {
            //     Emails::insert([
            //         "exhibition_id" => $exhibition->id,
            //         "email" => $emails,
            //         "created_at" => Carbon::now(),
            //         "updated_at" => Carbon::now(),
            //     ]);
            // }

            return response()->json([
                "success" => "გამოფენა დაემატა.",
                "data" => Exhibition::all()
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
    // public function update(Request $request, int $id)
    // {
    //     $this->validate($request, [
    //         "title" => "required",
    //         "datetime" => "required",
    //         "country" => "required"
    //     ]);

    //     try {
    //         $exhibition = Exhibition::find($id);
    //         $exhibition->title = $request->title;
    //         $exhibition->country = $request->country;
    //         $exhibition->datetime = $request->datetime;
    //         $exhibition->save();

    //         return response()->json([
    //             "success" => "გამოფენა განახლდა."
    //         ], 200);
    //     }catch(Exception $e) {
    //         return response()->json([
    //             "error" => "გამოფენა ვერ განახლდა."
    //         ], 422);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $exhibition_delete = Exhibition::find($id)->delete();

        if($exhibition_delete) {
            return response()->json([
                "success" => "გამოფენა წაიშალა.",
                "data" => Exhibition::all()
            ], 200);
        }else {
            return response()->json([
                "error" => "გამოფენა ვერ წაიშალა."
            ], 422);
        }
    } 
}
