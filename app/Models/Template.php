<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Emails;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "templates";

    protected $primaryKey = "id";

    protected $fillable = [
        "exhibition_id",
        "datetime",
        "text",
        "link"
    ];

    protected $dates = [
        "deleted_at"
    ];

    public $timestamps = true;

    public function getDateTimeAttribute($value) {
        return $this->asDateTime($value)->setTimezone('Asia/Tbilisi')->format("Y-m-d H:i"); 
    }
}
