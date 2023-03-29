<?php

/**
 * Created by Illuminate Model.
 * Date: Sat, 11 Jul 2020 11:30:54 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class EnteteCommune
 *
 * @property int $id
 * @property int $commune_id
 * @property string $titre1
 * @property string $titre1_ar
 * @property string $titre2
 * @property string $titre2_ar
 * @property string $titre3
 * @property string $titre3_ar
 * @property string $logo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Entete extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
	];

	protected $fillable = [
		'titre1',
		'titre1_ar',
		'titre2',
		'titre2_ar',
		'titre3',
		'titre3_ar',
		'logo'
	];
}
