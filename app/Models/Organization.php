<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Detail;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "organizations";

    protected $primaryKey = "id";

    protected $dates = [
        "deleted_at"
    ];

    protected $fillable = [
        "detail_id",
        "company_name",
        "activity_name",
        "country",
        "stage_name",
        "target_country_name",
        "template_volume",
        "template_price",
        "product_volume",
        "product_price",
    ];

    public $timestamps = true;

    public function detail() {
        return $this->belongsTo(Detail::class, "id", "detail_id");
    }
}
