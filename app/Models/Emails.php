<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    use HasFactory;

    protected $table = "emails";

    protected $primaryKey = "id";

    protected $fillable = [
        "exhibition_id",
        "email",
    ];

    public $timestamps = true;
}

?>