<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Exhibition;
use Mail;
use Carbon\Carbon;

class EmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will send emails in every 3 months';

    /**
     * Execute the console command.
     */
    public function handle() {
        $exhibitions = Exhibition::all();

        $current_date = Carbon::now()->format("Y-m-d H:i");

        foreach($exhibitions as $exhibition) {
            foreach($exhibition->emails as $email) {
                
                try {
                    $mails = Emails::where("exhibition_id", $exhibition->id)->where("id", $email["id"])->first();
                    
                    // if($current_date == $exhibition->template[0]["datetime"] && $mails->sent_status == 0) {
                        Mail::send("mail.template", ["text" => $exhibition->template[0]["text"], "link" => $exhibition->template[0]["link"]], function($message) use($mails) {
                            $message->to($mails->email);
                            $message->from("harvester@mailgun.rda.gov.ge", "სოფლის განვითარების სააგენტო - (RDA)");
                            $message->subject("დაგეგმილი გამოფენა");
                        });
                    // }

                    $mails->sent_status = 1;
                    $mails->save();
    
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
}
