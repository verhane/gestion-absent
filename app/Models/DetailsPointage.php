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
            return $this->belongsTo(Pointage::class);
      }

      public function pr_stagiaire(){
            return $this->belongsTo(PrStagiaire::class);
      }

      public function ref_etats_presence(){
            return $this->belongsTo(RefPresent::class);
      }

}
