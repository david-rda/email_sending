<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Exhibition;
use App\Models\Emails;
use Mail;
use Carbon\Carbon;

class SendEmailController extends Controller
{
    public function sendEmail() {
        $exhibitions = Exhibition::all();

        $current_date = Carbon::now()->format("Y-m-d H:i");

        foreach($exhibitions as $exhibition) {
            foreach($exhibition->emails as $email) {
                if($email->sent_status == 1 || $email->email == "1") continue;
                else {
                    try {
                        if($current_date == $exhibition->template[0]["datetime"]){
                            Mail::send("mail.template", ["text" => $exhibition->template[0]["text"], "link" => $exhibition->template[0]["link"]], function($message) use($email) {
                                $message->to($email->email);
                                $message->from("harvester@mailgun.rda.gov.ge", "სოფლის განვითარების სააგენტო - (RDA)");
                                $message->subject("დაგეგმილი გამოფენა");
                            });
        
                            $mails = Emails::where("exhibition_id", $exhibition->id)->where("email", $email->email)->where("sent_status", 0)->get();

                            foreach($mails as $mail) {
                                $mail->sent_status = 1;
                                $mail->sent_date = Carbon::now();
                                $mail->save();
                            }
                        }else {
                            echo "Can't send email at this moment.";
                        }
                    }catch(Exception $e) {
                        return response()->json([
                            "error" => "დაფიქსირდა შეცდომა."
                        ], 422);
                    }
                }
            }
        }
    }
}
