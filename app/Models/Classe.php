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
class Classe extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $fillable = [
		'libelle_fr',
        'libelle_ar'
	];

    public function etablissement()
    {
        return $this->belongsTo(BEtablissement::class,'b_etablissement_id');
    }

    public function niveaux_pedagogique()
    {
        return $this->belongsTo(NiveauxPedagogique::class);
    }
    public function annees_scolaire()
    {
        return $this->belongsTo(AnneesScolaire::class);
    }

    public function NbCours()
    {
        $nb = 0;
        foreach ($this->classes_matieres as $ch) {

             foreach ($ch->chapitres as $key => $value) {
                 $nb += $value->cours->count();
             }
         }
         return $nb;
    }

    public function classes_matieres()
    {
        return $this->hasMany(ClassesMatiere::class);
    }

    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'classes_matieres')
                    ->withPivot('id', 'pr_pe_formateur_id', 'deleted_at')
					->wherePivot('deleted_at', null)
                    ->withTimestamps();
    }

    public function pr_stagieres()
    {
        return $this->belongsToMany(PrStagiaire::class, 'classes_pr_stagiaires')
                    ->withPivot('id', 'deleted_at')
					->wherePivot('deleted_at', null)
                    ->withTimestamps();
    }

    public function pointages(){
     return    $this->hasMany(pointage::class,'classe_id');
    }

    public function isOnline(): int
    {
        return $this->classes_matieres()->where('online',1)->count();
    }
}
