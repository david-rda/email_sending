<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Emails;
use App\Models\Exhibition;
use App\Models\Template;

class Exhibition extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "exhibitions";

    protected $primaryKey = "id";

    protected $fillable = [
        "title",
        "country",
        "datetime"
    ];

    protected $dates = [
        "deleted_at"
    ];

    protected $appends = [
        "label",
        "emails",
        "templates"
    ];

    public $timestamps = true;

    protected $hidden = [
        "created_at",
        "updated_at",
        "title",
        "email",
        "template",
    ];

    public function getLabelAttribute() {
        return $this->getAttribute("title");
    }

    public function email() {
        return $this->hasMany(Emails::class, "exhibition_id", "id");
    }

    public function template() {
        return $this->hasMany(Template::class, "exhibition_id", "id");
    }

    public function getEmailsAttribute() {
        return $this->email;
    }

    public function getTemplatesAttribute() {
        return $this->template;
    }

    public function getDateTimeAttribute($value) {
        return Carbon::parse($value)->format("Y-m-d");
    }

    public function setDateTimeAttribute($value) {
        $this->attributes["datetime"] = $this->asDateTime($value)->setTimezone('Asia/Tbilisi')->format("Y-m-d");
    }
}

?>