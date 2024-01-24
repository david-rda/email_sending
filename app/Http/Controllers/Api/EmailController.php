<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emails;
use App\Models\Exhibition;
use Carbon\Carbon;
use Mail;

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
            "emails" => "required|array",
            "emails.*" => "required|email",
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
    public function sentEmails(int $exhibition_id = null) {
        if(!isset($exhibition_id)) return Emails::where("sent_status", 1)->get();
        else return Emails::where("sent_status", 1)->where("exhibition_id", $exhibition_id)->get();
    }

    /**
     * @method POST
     * კონკრეტულ მისამართზე ელ. ფოსტის გაგზავნის მეტოდი
     */
    public function send(int $id, int $exhibition_id) {
        try {
            $exhibition = Exhibition::find($exhibition_id);

            $email = Emails::where("id", $id)->where("exhibition_id", $exhibition_id)->first();

            Mail::send("mail.template", ["text" => $exhibition->template[0]["text"], "link" => $exhibition->template[0]["link"]], function($message) use($email) {
                $message->to($email->email);
                $message->from("harvester@mailgun.rda.gov.ge", "სოფლის განვითარების სააგენტო - (RDA)");
                $message->subject("დაგეგმილი გამოფენა");
            });

            $email->sent_status = 1;
            $email->sent_date = Carbon::now();
            $email->save();

            return response()->json([
                "success" => "ელ. ფოსტა გაიგზავნა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "error" => "ელ. ფოსტა ვერ გაიგზავნა"
            ], 422);
        }
    }
}
