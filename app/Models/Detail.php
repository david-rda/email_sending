<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exhibition;
use App\Models\Organization;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "details";

    protected $primaryKey = "id";

    protected $fillable = [
        "exhibition_id",
        "name",
        "position",
        "mobile",
        "email",
        "recomendation",
        "comment",
    ];

    protected $dates = [
        "deleted_at"
    ];

    protected $hidden = [
        "organization"
    ];

    protected $appends = [
        "organizations",
        "exhibition_name"
    ];

    public $timestamps = true;

    public function exhibition() {
        return $this->belongsTo(Exhibition::class, "id", "exhibition_id");
    }

    public function organization() {
        return $this->hasMany(Organization::class, "detail_id", "id");
    }

    public function getOrganizationsAttribute() {
        return $this->organization;
    }

    public function getExhibitionNameAttribute() {
        return Exhibition::where("id", $this->attributes["exhibition_id"])->first()->label;
    }
}
