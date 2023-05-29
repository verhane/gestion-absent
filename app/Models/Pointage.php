<?php

namespace App\Models;

use Dcs\Admin\Models\SysUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classe;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pointage extends Model
{
    use HasFactory;
    protected $dates = [
        'date'=>'date_format:d/m/yyyy',	];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function details_pointages()
    {
        return $this->hasMany(DetailsPointage::class);
    }

    public function pointeur()
    {
        return $this->belongsTo(SysUser::class, 'sys_user_id');
    }
    public function ref_etats_pointage()
    {
        return $this->belongsTo(ref_etats_pointages::class, 'ref_etats_pointage_id');
    }
}
