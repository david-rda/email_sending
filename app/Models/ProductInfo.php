<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TemplateInfo;

class ProductInfo extends Model
{
    use HasFactory;

    protected $table = "product_infos";

    protected $primaryKey = "id";

    protected $fillable = [
        "status"
        
    ];

    public $timestamps = true;
}
