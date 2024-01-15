<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Emails;

class Template extends Model
{
    use HasFactory;

    protected $table = "templates";

    protected $primaryKey = "id";

    protected $fillable = [
        "exhibition_id",
        "datetime",
        "text",
        "link"
    ];

    public $timestamps = true;

    public function getDateTimeAttribute($value) {
        return $this->asDateTime($value)->setTimezone('Asia/Tbilisi')->format("Y-m-d H:i"); 
    }
}
