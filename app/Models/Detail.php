<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Connection;
use App\Models\ProductInfo;
use App\Models\Organization;

class Detail extends Model
{
    use HasFactory;

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

    protected $hidden = [
        "organization"
    ];

    protected $appends = [
        "organizations"
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
}
