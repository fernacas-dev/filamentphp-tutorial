<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'name',
        'state_id'
    ];

    public function state() {
        return $this->belongsTo(States::class);
    }
}
