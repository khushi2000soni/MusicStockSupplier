<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $settings = [
            // [
            //     'key'    => 'site_logo',
            //     'value'  => null,
            //     'type'   => 'image',
            //     'details' => null,
            //     'display_name'=>'Site Logo',
            //     'group'  => 'web',
            //     'status' => 1,
            //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            //     'created_by' => 1,
            // ],
            // [
            //     'key'    => 'favicon',
            //     'value'  => null,
            //     'type'   => 'image',
            //     'details' => null,
            //     'display_name'=>'Favicon',
            //     'group'  => 'web',
            //     'status' => 1,
            //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            //     'created_by' => 1,
            // ],
            [

                'key'    => 'company_name',
                'value'  => 'Music Stock Supplier',
                'type'   => 'text',
                'display_name'  => 'Company Name [Login Page,Sidebar Top Title]',
                'group'  => 'web',
                'details' => null,
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
            ]
        ];

        Setting::insert($settings);
    }
}
