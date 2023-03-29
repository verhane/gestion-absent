<?php

namespace App\Dcs\Facades;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;


class Helper extends Facade {

   public static function getFieldTranslated($object, $field = 'libelle')
   {
//       dd($object);
       if (App::getLocale() && $object->{$field.'_'.App::getLocale()})
           $valeur = $object->{$field.'_'.App::getLocale()};
       elseif ($object->{$field.'_fr'})
           $valeur = $object->{$field.'_fr'};
       else
           $valeur = $object->{$field.'_ar'};
       return $valeur;
   }

    public static function checkNni($nni): bool
    {
        return $nni % 97 != 1;
    }

    // check number if start with 1,2,3
    public static function checkPhoneNumber($number){
        return preg_match('/^[2-4]/', $number);
    }

}
