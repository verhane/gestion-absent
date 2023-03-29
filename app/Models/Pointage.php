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
    protected $table = 'pointages';
    public  function classes(){
         return $this->belongsTo(Classe::class,'classe_id');
    }

    public function detailsPointage()
    {
        return $this->hasMany(DetailsPointage::class,'pointage_id');
    }
    public function pointeur(): BelongsTo
    {
        return $this->belongsTo(SysUser::class,'personne');
    }
}
