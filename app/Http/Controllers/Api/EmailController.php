<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emails;
use Carbon\Carbon;

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
            "email" => "required|email"
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
    public function show(int $id)
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
            $email = Emails::find($id);
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
    public function destroy(int $id, int $exhibition_id)
    {
        $email_delete = Emails::find($id)->delete();

        if($email_delete) {
            return response()->json([
                "success" => "ელ.ფოსტა წაიშალა.",
                "data" => Emails::where("exhibition_id", $exhibition_id)->get()
            ], 200);
        }else {
            return response()->json([
                "error" => "ელ.ფოსტა ვერ წაიშალა."
            ], 422);
        }
    }

    /**
     * @method GET
     * @param Request
     */
    public function addEmailToExhibition(Request $request) {
        $this->validate($request, [
            "emails" => "required"
        ]);

        try {
            foreach($request->emails as $emails) {
                Emails::insert([
                    "exhibition_id" => $request->exhibition_id,
                    "email" => $emails,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);
            }

            return response()->json([
                "success" => "ელ. ფოსტები დაემატა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "error" => "ელ. ფოსტები ვერ დაემატა"
            ], 422);
        }
    }

    /**
     * @method GET
     * @param null
     * 
     * გაგზავნილი/ვერ გაგზავნილი ელ. ფოსტების სია
     */
    public function sentEmails() {
        return Emails::get();
    }
}
