<?php

namespace Database\Seeders\dcs;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('sys_users')->count() == 0) {
            \DB::table('sys_users')->insert([
                'name' => 'Admin Dcs',
                'username' => 'admindcs',
                'email' => 'admin@dcs-sarl.com',
                'password' => bcrypt('passer12!'),
                'sys_types_user_id' => 1,
            ]);
        }

        if (\DB::table('sys_droits')->count() == 0) {
            \DB::table('sys_droits')->insert([
                'libelle' => 'Gérer Administration',
                'type_acces' => 0,
                'sys_groupes_traitement_id' => 1,
                'ordre' => 1,
            ]);
        }

        if (\DB::table('sys_groupes_traitements')->count() == 0) {
            \DB::table('sys_groupes_traitements')->insert([
                'libelle' => 'Administration',
                'app' => 'all',
                'ordre' => 1,
            ]);
        }

        if (\DB::table('sys_profiles')->count() == 0) {
            \DB::table('sys_profiles')->insert([
                'libelle' => 'Administrateur',
                'ordre' => 1,
            ]);
        }

        if (\DB::table('sys_profiles_sys_droits')->count() == 0) {
            \DB::table('sys_profiles_sys_droits')->insert([
                'sys_profile_id' => 1,
                'sys_droit_id' => 1,
                'ordre' => 1,
            ]);
        }

        if (\DB::table('sys_profiles_sys_users')->count() == 0) {
            \DB::table('sys_profiles_sys_users')->insert([
                'sys_profile_id' => 1,
                'sys_user_id' => 1,
                'object_id' => NULL,
                'id_objet' => NULL,
                'niveau_objet' => NULL,
                'ordre' => 1,
                'admin_id' => 1,
            ]);
        }

        if (\DB::table('sys_types_users')->count() == 0) {
            \DB::table('sys_types_users')->insert([
                'libelle' => 'DGCT',
                'libelle_ar' => NULL,
                'dashboard' => 'menus',
                'ordre' => 1,
            ]);
        }

        if (\DB::table('sys_types_transactions')->count() == 0) {
            \DB::table('sys_types_transactions')->insert([
                ['id' => '1', 'libelle_fr' => 'Consultation', 'libelle_ar' => 'Consultation'],
                ['id' => '2', 'libelle_fr' => 'Enregistrement  ', 'libelle_ar' => 'Création  '],
                ['id' => '3', 'libelle_fr' => 'Modification', 'libelle_ar' => 'Modification'],
                ['id' => '4', 'libelle_fr' => 'Suppression', 'libelle_ar' => 'Suppression'],
                ['id' => '5', 'libelle_fr' => 'Validation', 'libelle_ar' => 'Validation'],
                ['id' => '6', 'libelle_fr' => 'Dévalidation ', 'libelle_ar' => 'Dévalidation']
            ]);
        }

        if (\DB::table('sys_models')->count() == 0) {
            \DB::table('sys_models')->insert([
                ['libelle_fr' => 'Utilisateurs', 'path' => 'Dcs\Admin\Models\SysUser',],
                ['libelle_fr' => 'Droits', 'path' => 'Dcs\Admin\Models\SysDroit',],
                ['libelle_fr' => 'Groupes de traitements', 'path' => 'Dcs\Admin\Models\SysGroupeTraitement',],
                ['libelle_fr' => 'Profiles', 'path' => 'Dcs\Admin\Models\SysProfile',],
                ['libelle_fr' => 'Types d\'utilisateurs', 'path' => 'Dcs\Admin\Models\SysTypeUser',],
            ]);
        }

        if (\DB::table('sys_types_acces')->count() == 0) {
            \DB::table('sys_types_acces')->insert([
                ['libelle' => 'Consultation', 'libelle_ar' => 'المشاهدة'],
                ['libelle' => 'Enregistrement', 'libelle_ar' => 'التسجيل'],
                ['libelle' => 'Validation', 'libelle_ar' => 'التأكيد'],
                ['libelle' => 'Edition', 'libelle_ar' => 'الطباعة'],
                ['libelle' => 'Suppression', 'libelle_ar' => 'الحذف'],
                ['libelle' => 'Autoriser', 'libelle_ar' => 'Autoriser'],
                ['libelle' => 'Viser', 'libelle_ar' => 'Viser'],
                ['libelle' => 'Confirmer', 'libelle_ar' => 'Confirmer'],
                ['libelle' => 'Dévalider', 'libelle_ar' => 'إلغاء التأكيد'],
                ['libelle' => 'Payer', 'libelle_ar' => 'Payer'],
            ]);
        }
    }
}
