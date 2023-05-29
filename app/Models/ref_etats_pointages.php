<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_etats_pointages extends Model
{
    use HasFactory;

    public function pointages(){
        return $this->hasMany(Pointage::class);
    }
}
