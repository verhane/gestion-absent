<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Oct 2018 16:23:19 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Models\pointage ;
/**
 * Class BFiliere
 *
 * @property int $id
 * @property string $libelle
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $b_specialites
 *
 * @package App\Models
 */
class AnneesScolaire extends Eloquent
{

    protected $table = 'annees_scolaires';
    public function classes(){
        return $this->hasMany(Classe::class,'annees_scolaire_id');
    }

}
