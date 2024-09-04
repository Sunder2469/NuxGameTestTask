<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'random_number',
        'result',
        'prize'
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
