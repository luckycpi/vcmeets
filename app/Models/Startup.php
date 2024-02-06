<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    use HasFactory;

    public function votes() {
        return $this->hasMany(StartupVotes::class)->where('user_id', auth()->id());
    }
}
