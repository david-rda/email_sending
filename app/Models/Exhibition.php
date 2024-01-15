<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use HasFactory;

    protected $table = "exhibitions";

    protected $primaryKey = "id";

    protected $fillable = [
        "title",
        "country",
        "datetime"
    ];

    protected $appends = [
        "label"
    ];

    public $timestamps = true;

    protected $hidden = [
        "created_at",
        "updated_at",
        "title",
        "email"
    ];

    public function getLabelAttribute() {
        return $this->getAttribute("title");
    }

    public function email() {
        return $this->hasMany(Emails::class, "exhibition_id", "id");
    }

    public function getEmailsAttribute() {
        return $this->email;
    }

    public function getDateTimeAttribute($value) {
        return $this->asDateTime($value)->setTimezone('Asia/Tbilisi')->format("Y-m-d H:i");
    }

    public function setDateTimeAttribute($value) {
        $this->attributes["datetime"] = $this->asDateTime($value)->setTimezone('Asia/Tbilisi')->format("Y-m-d H:i");
    }
}

?>