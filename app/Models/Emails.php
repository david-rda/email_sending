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
        "sent_status",
        "filled_status",
    ];

    protected $appends = [
        "exhibition_name"
    ];
    
    public $timestamps = true;

    public function getExhibitionNameAttribute() {
        return Exhibition::where("id", $this->attributes["exhibition_id"])->first()->label;
    }
}

?>