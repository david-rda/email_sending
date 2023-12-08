<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmailReceiver;

class Exhibition extends Model
{
    use HasFactory;

    protected $table = "exhibitions";

    protected $primaryKey = "id";

    protected $fillable = [
        "title",
    ];

    public $timestamps = true;

    public function email_receiver() {
        return $this->hasMany(EmailReceiver::class, "exhibition_id", "id");
    }

    public function exhibition() {
        return $this->hasMany(Detail::class, "exhibition_id", "id");
    }
}

?>