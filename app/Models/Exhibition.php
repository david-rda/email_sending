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
    ];

    protected $appends = [
        "label"
    ];

    public $timestamps = true;

    protected $hidden = [
        "created_at",
        "updated_at",
        "title",
    ];

    public function getLabelAttribute() {
        return $this->getAttribute("title");
    }
}

?>