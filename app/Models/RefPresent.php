<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPresent extends Model
{
    use HasFactory;
    protected $table='ref_presents';
    public function detailsPointage(){
        return $this->hasMany(DetailsPointage::class,'presence_id');
    }
}
