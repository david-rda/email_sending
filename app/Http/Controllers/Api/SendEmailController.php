<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Exhibition;
use Mail;
use Carbon\Carbon;

class SendEmailController extends Controller
{
    public function sendEmail() {
        $exhibitions = Exhibition::all();

        $current_date = Carbon::now()->format("Y-m-d H:i");

        return $exhibitions;

        foreach($exhibitions as $exhibition) {
            $mail = [];

            foreach($exhibition->emails as $email) {
                array_push($mail, $email["email"]);
            }
            
            try {
                if($current_date == $exhibition->template[0]["datetime"]) {
                    Mail::send("mail.template", ["text" => $exhibition->template[0]["text"], "link" => $exhibition->template[0]["link"]], function($message) use($mail) {
                        $message->to($mail);
                        $message->from("harvester@mailgun.rda.gov.ge", "სოფლის განვითარების სააგენტო - (RDA)");
                        $message->subject("დაგეგმილი გამოფენა");
                    });
                }

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
}
