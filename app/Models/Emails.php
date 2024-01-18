<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Exhibition;

class Emails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "emails";

    protected $primaryKey = "id";

    protected $dates = [
        "deleted_at"
    ];

    protected $fillable = [
        "exhibition_id",
        "email",
    ];
    
    public $timestamps = true;
}

?>