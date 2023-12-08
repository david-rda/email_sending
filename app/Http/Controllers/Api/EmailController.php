<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Emails::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email|unique"
        ]);

        try {
            $email = new Emails();
            $email->email = $request->email;
            $email->save();

            return response()->json([
                "success" => "ელ.ფოსტა დაემატა."
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "error" => "ელ.ფოსტა ვერ დაემატა."
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Emails::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            "email" => "required"
        ]);

        try {
            $email = Email::find($id);
            $email->email = $request->email;
            $email->save();

            return response()->json([
                "success" => "ელ.ფოსტა განახლდა."
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "error" => "ელ.ფოსტა ვერ განახლდა."
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $email_delete = Emails::find($id)->delete();

        if($email_delete) {
            return response()->json([
                "success" => "ელ.ფოსტა წაიშალა."
            ], 200);
        }else {
            return response()->json([
                "error" => "ელ.ფოსტა ვერ წაიშალა."
            ], 422);
        }
    }
}
