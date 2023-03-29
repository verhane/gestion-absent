<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Oct 2018 16:23:19 +0000.
 */

namespace App\Models;

use Carbon\Carbon;
use Dcs\Ref\Models\RefCommune;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PrStagiaire
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $nni
 * @property \Carbon\Carbon $date_naissance
 * @property string $lieu_naissance
 * @property int $sexe
 * @property int $tel
 * @property int $email
 * @property string $commentaire
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection $pr_echantillons
 * @property \Illuminate\Database\Eloquent\Collection $pr_evalutations
 * @property \Illuminate\Database\Eloquent\Collection $b_etablissements
 *
 * @package App\Models
 */
class PrStagiaire extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $fillable = [
		'nom',
		'prenom',
		'nni',
		// 'date_naissance',
		'lieu_naissance',
		'sexe',
		'tel',
		'email',
		'commentaire'
	];

	// public function pr_echantillons()
	// {
	// 	return $this->belongsToMany(\App\Models\PrEchantillon::class, 'pr_echantillons_pr_stagiaires', 'pr_stagiaires_id', 'pr_echantillons_id')
	// 				->withPivot('id', 'ref_motifs_abscences_id', 'ordre', 'deleted_at')
	// 				->withTimestamps();
	// }

	public function pr_evalutations()
	{
		return $this->hasMany(\App\Models\PrEvalutation::class, 'pr_enquetes_pr_stagiaires_id');
	}

	public function b_etablissements()
	{
		return $this->belongsToMany(\App\Models\BEtablissement::class, 'pr_stagiaires_b_etablissements', 'pr_stagiaires_id', 'b_etablissements_id')
					->withPivot('id', 'b_specialites_id', 'date_inscription', 'langue', 'ref_niveaux_formations_id', 'ref_modes_formations_id', 'deleted_at')
					->withTimestamps();
	}

	public function pr_stagiaires_b_etablissements()
	{
		return $this->hasMany(\App\Models\PrStagiairesBEtablissement::class, 'pr_stagiaires_id');
	}
    public function specialite_libelle()
    {
        return $this->classes()->where('annees_scolaire_id',AnneesScolaire::where('actif',1)->first()->id)->first();
    }
	public function classes()
	{
		return $this->belongsToMany(Classe::class, 'classes_pr_stagiaires')
					->wherePivotNull('deleted_at')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}
	public function classes_pr_stagiaires()
	{
		return $this->hasMany(ClassesPrStagiaire::class, 'pr_stagiaire_id');
	}
    public function detailPointag(){
        return $this->hasMany(DetailsPointage::class,'Eleves_id');
    }

    public function age()
    {
        $years=0;
        $dateOfBirth = $this->date_naissance;
        try {
            $date = Carbon::createFromFormat('Y-m-d',$dateOfBirth);
            $years = Carbon::parse($dateOfBirth)->age;
        } catch(\InvalidArgumentException $e) {
            $years=0;
        }
        return $years;
    }

	public function formation_en_cours()
	{
		if($this->pr_stagiaires_b_etablissements->count())
			return $this->pr_stagiaires_b_etablissements()->latest()->first();
		else
			return null;
	}

	public function classe_en_cours()
	{
		$current_classe_query = $this->classes()->where('annees_scolaire_id',AnneesScolaire::where('actif',1)->first()->id);
		if($current_classe_query->exists())
			return $current_classe_query->first();
		else
			return null;
	}

	public function getGenreAttribute()
	{
		if($this->sexe)
			return $this->sexe == 1 ? trans('text.homme') : trans('text.femme');
		else
			return null;
	}

	public function getLieuNaissanceAttribute($value)
	{
		if(is_numeric($value) && RefCommune::find($value))
			return RefCommune::find($value)->libelle;
		else
			return $value;
	}

}
