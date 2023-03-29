<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Oct 2018 16:23:19 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

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
class ClassesPrStagiaire extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function pr_stagiaire()
    {
        return $this->belongsTo(PrStagiaire::class);
    }


}
