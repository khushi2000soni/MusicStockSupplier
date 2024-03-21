<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $updateDate = $createDate = date('Y-m-d H:i:s');
        $permissions = [
            // [
            //     'name'      => 'permission_create',
            //     'guard_name'=>'web',
            //     'route_name'=>'permissions',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],
            // [
            //     'name'      => 'permission_edit',
            //     'guard_name'=>'web',
            //     'route_name'=>'permissions',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],
            // [
            //     'name'      => 'permission_show',
            //     'guard_name'=>'web',
            //     'route_name'=>'permissions',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],
            // [
            //     'name'      => 'permission_delete',
            //     'guard_name'=>'web',
            //     'route_name'=>'permissions',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],
            // [
            //     'name'      => 'permission_access',
            //     'guard_name'=>'web',
            //     'route_name'=>'permissions',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],
            [
                'name'      => 'role_access',
                'title'      => 'Menu Access',
                'guard_name'=>'web',
                'route_name'=>'roles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            // [
            //     'name'      => 'role_create',
            //     'title'      => 'Add',
            //     'guard_name'=>'web',
            //     'route_name'=>'roles',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],
            [
                'name'      => 'role_edit',
                'title'      => 'Edit',
                'guard_name'=>'web',
                'route_name'=>'roles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'role_show',
                'title'      => 'View',
                'guard_name'=>'web',
                'route_name'=>'roles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'profile_access',
                'title'      => 'View',
                'guard_name'=>'web',
                'route_name'=>'profiles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'profile_edit',
                'title'      => 'Edit',
                'guard_name'=>'web',
                'route_name'=>'profiles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'user_change_password',
                'title'      => 'Change Password',
                'guard_name'=>'web',
                'route_name'=>'profiles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'dashboard_widget_access',
                'title'      => 'Dashboard Widget Access',
                'guard_name'=>'web',
                'route_name'=>'dashboard',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'staff_access',
                'title'      => 'Menu Access',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'staff_create',
                'title'      => 'Add',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'staff_edit',
                'title'      => 'Edit',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'staff_delete',
                'title'      => 'Delete',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'staff_print',
                'title'      => 'Print',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'staff_export',
                'title'      => 'Export',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'supplier_access',
                'title'      => 'Menu Access',
                'guard_name'=>'web',
                'route_name'=>'suppliers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'supplier_create',
                'title'      => 'Add',
                'guard_name'=>'web',
                'route_name'=>'suppliers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'supplier_show',
                'title'      => 'View',
                'guard_name'=>'web',
                'route_name'=>'suppliers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'supplier_edit',
                'title'      => 'Edit',
                'guard_name'=>'web',
                'route_name'=>'suppliers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'supplier_delete',
                'title'      => 'Delete',
                'guard_name'=>'web',
                'route_name'=>'suppliers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'supplier_print',
                'title'      => 'Print',
                'guard_name'=>'web',
                'route_name'=>'suppliers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'supplier_export',
                'title'      => 'Export',
                'guard_name'=>'web',
                'route_name'=>'suppliers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'entry_access',
                'title'      => 'Menu Access',
                'guard_name'=>'web',
                'route_name'=>'entries',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'entry_create',
                'title'      => 'Add',
                'guard_name'=>'web',
                'route_name'=>'entries',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'entry_edit',
                'title'      => 'Edit',
                'guard_name'=>'web',
                'route_name'=>'entries',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'entry_print',
                'title'      => 'Print',
                'guard_name'=>'web',
                'route_name'=>'entries',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'entry_export',
                'title'      => 'Export',
                'guard_name'=>'web',
                'route_name'=>'entries',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'entry_delete',
                'title'      => 'Delete',
                'guard_name'=>'web',
                'route_name'=>'entries',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'payment_receipt_access',
                'title'      => 'Menu Access',
                'guard_name'=>'web',
                'route_name'=>'payment_receipt',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'payment_receipt_create',
                'title'      => 'Add',
                'guard_name'=>'web',
                'route_name'=>'payment_receipt',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'payment_receipt_edit',
                'title'      => 'Edit',
                'guard_name'=>'web',
                'route_name'=>'payment_receipt',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'payment_receipt_delete',
                'title'      => 'Delete',
                'guard_name'=>'web',
                'route_name'=>'payment_receipt',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'payment_receipt_print',
                'title'      => 'Print',
                'guard_name'=>'web',
                'route_name'=>'payment_receipt',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'payment_receipt_export',
                'title'      => 'Export',
                'guard_name'=>'web',
                'route_name'=>'payment_receipt',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'setting_access',
                'title'      => 'Setting Menu Access',
                'guard_name'=>'web',
                'route_name'=>'settings',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'setting_edit',
                'title'      => 'Edit',
                'guard_name'=>'web',
                'route_name'=>'settings',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ]

        ];

        Permission::insert($permissions);
    }
}
