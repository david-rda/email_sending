<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
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
