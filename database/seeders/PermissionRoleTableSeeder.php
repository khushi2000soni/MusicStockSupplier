<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // role_create ,role_edit,role_show,  role_access profile_access profile_edit user_change_password dashboard_widget_access staff_access staff_create staff_edit staff_delete staff_print staff_export  supplier_access supplier_create supplier_show supplier_edit supplier_delete supplier_print supplier_export entry_access entry_create entry_edit entry_print entry_export entry_delete payment_receipt_access  payment_receipt_create payment_receipt_edit payment_receipt_delete payment_receipt_print payment_receipt_export setting_access  setting_edit

        $roles = Role::all();
        $superadminpermissionid= Permission::all();

        $adminpermissionid= Permission::whereIn('name',['profile_access', 'profile_edit', 'user_change_password','dashboard_widget_access'])->pluck('id')->toArray();

        foreach ($roles as $role) {
            switch ($role->id) {
                case 1:
                    $role->givePermissionTo($superadminpermissionid);
                    break;
                // case 2:
                //     $role->givePermissionTo($adminpermissionid);
                //     break;
                default:
                    break;
            }
        }
    }
}
