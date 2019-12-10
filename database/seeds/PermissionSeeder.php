<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $permissions = [
            ['name' => 'company_create', 'display_name' => 'Company [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_read', 'display_name' => 'Company [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_update', 'display_name' => 'Company [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_destroy', 'display_name' => 'Company [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'company_branch_create', 'display_name' => 'Branch [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_branch_read', 'display_name' => 'Branch [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_branch_update', 'display_name' => 'Branch [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_branch_destroy', 'display_name' => 'Branch [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'company_status_create', 'display_name' => 'Company Status [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_status_read', 'display_name' => 'Company Status [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_status_update', 'display_name' => 'Company Status [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_status_destroy', 'display_name' => 'Company Status [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'company_contact_create', 'display_name' => 'Contact [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_contact_read', 'display_name' => 'Contact [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_contact_update', 'display_name' => 'Contact [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_contact_destroy', 'display_name' => 'Contact [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'workforce_create', 'display_name' => 'Workforce [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workforce_read', 'display_name' => 'Workforce [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workforce_update', 'display_name' => 'Workforce [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workforce_destroy', 'display_name' => 'Workforce [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'role_create', 'display_name' => 'Role [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'role_read', 'display_name' => 'Role [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'role_update', 'display_name' => 'Role [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'role_destroy', 'display_name' => 'Role [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'workschedule_create', 'display_name' => 'Workschedule [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workschedule_read', 'display_name' => 'Workschedule [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workschedule_update', 'display_name' => 'Workschedule [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workschedule_destroy', 'display_name' => 'Workschedule [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'workday_create', 'display_name' => 'Workday [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workday_read', 'display_name' => 'Workday [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workday_update', 'display_name' => 'Workday [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workday_destroy', 'display_name' => 'Workday [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'user_create', 'display_name' => 'User [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user_read', 'display_name' => 'User [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user_update', 'display_name' => 'User [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user_destroy', 'display_name' => 'User [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'workschedule_workforces_read', 'display_name' => 'Workschedule Workforces [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workschedule_workforces_create', 'display_name' => 'Workschedule Workforces [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'workschedule_workforces_destroy', 'display_name' => 'Workschedule Workforces [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'doc_folder_create', 'display_name' => 'Doc Folder [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'doc_folder_read', 'display_name' => 'Doc Folder [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'doc_folder_update', 'display_name' => 'Doc Folder [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'doc_folder_destroy', 'display_name' => 'Doc Folder [delete]', 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'doc_create', 'display_name' => 'Doc [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'doc_read', 'display_name' => 'Doc [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'doc_update', 'display_name' => 'Doc [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'doc_destroy', 'display_name' => 'Doc [delete]', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'sales_activity_type_create', 'display_name' => 'Sales Activity Type [create]', 'created_at'=> now(), 'updated_at'=> now()],
            ['name' => 'sales_activity_type_read', 'display_name' => 'Sales Activity Type [read]', 'created_at'=> now(), 'updated_at'=> now()],
            ['name' => 'sales_activity_type_update', 'display_name' => 'Sales Activity Type [update]', 'created_at'=> now(), 'updated_at'=> now()],
            ['name' => 'sales_activity_type_destroy', 'display_name' => 'Sales Activity Type [delete]', 'created_at'=> now(), 'updated_at'=> now()],

            //Sales Activity
            ['name' => 'sales_activity_create', 'display_name' => 'Sales Activity [create]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sales_activity_read', 'display_name' => 'Sales Activity [read]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sales_activity_update', 'display_name' => 'Sales Activity [update]', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sales_activity_destroy', 'display_name' => 'Sales Activity [delete]', 'created_at' => now(), 'updated_at' => now()],

            //User Settings
            ['name' => 'user_settings_read', 'display_name' => 'User Settings [read]', 'created_at'=> now(), 'updated_at'=> now()],
            ['name' => 'user_settings_update', 'display_name' => 'User Settings [update]', 'created_at'=> now(), 'updated_at'=> now()],

            ['name' => 'org_settings_read', 'display_name' => 'Org Settings [read]', 'created_at'=> now(), 'updated_at'=> now()],
            ['name' => 'org_settings_update', 'display_name' => 'Org Settings [update]', 'created_at'=> now(), 'updated_at'=> now()],
        ];
        
        DB::table('permissions')->insert($permissions);
    }
}
