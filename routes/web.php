<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SendEmailController;

Route::get("/send", [SendEmailController::class, "sendEmail"]);

?>