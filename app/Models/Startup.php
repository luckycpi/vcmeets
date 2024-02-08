<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Startup extends Model
{
    use HasFactory, SoftDeletes;

    public function votes() {
        return $this->hasMany(StartupVotes::class)->where('user_id', auth()->id());
    }
}
