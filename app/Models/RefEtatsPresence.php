<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefEtatsPresence extends Model
{
    use HasFactory;

    public function detailsPointage(){
        return $this->hasMany(DetailsPointage::class);
    }
}
