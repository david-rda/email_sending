<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use Mail;
use Carbon\Carbon;

class SendEmailController extends Controller
{
    public function sendEmail() {
        $templates = Template::all();

        $current_date = Carbon::now()->format("Y-m-d H:i");

        foreach($templates as $template) {
            $mail = [];

            foreach($template->emails as $email) {
                array_push($mail, $email["email"]);
            }

            if($current_date == $template->datetime) {
                Mail::send("mail.template", ["text" => $template->text, "link" => $template->link], function($message) use($template, $mail) {
                    $message->to($mail);
                    $message->from("harvester@mailgun.rda.gov.ge", "სოფლის განვითარების სააგენტო - (RDA)");
                    $message->subject("დაგეგმილი გამოფენა");
                });
            }
        }
    }
}
