<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsPointage extends Model
{
    use HasFactory;
    protected $table="details_pointages";

    public function pointage()
    {
        return $this->belongsTo(Pointage::class,'pointage_id');
  }
  public function pr_stagaire(){
        return $this->belongsTo(PrStagiaire::class,'Eleves_id');
  }
  public function presences(){
        return $this->belongsTo(RefPresent::class,'presence_id');
  }

}
