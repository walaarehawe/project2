<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\User;
class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create roles:
        $customerRole = Role::create(['name'=>'customer','team_id'=>1]);
        $waiterRole   = Role::create(['name'=>'waiter']);
        $casherRole   = Role::create(['name'=>'casher']);
        $deliveryRole = Role::create(['name'=>'delivery']);
        $managerRole  = Role::create(['name'=>'manager','team_id'=>null]);
        $chefRole     = Role::create(['name'=>'chef']);
      
        // Guard name should match
        
        //define permissions: 
        $permissions = [
            'register'
            ,'login'
        ];
        foreach($permissions as $permission){
            Permission::findOrCreate($permission , 'web');
        }


        // $permissions = Permission::pluck('id', 'id')->all();
        $customerRole->givePermissionTo(['register' , 'login']);
        $casherRole  ->givePermissionTo(['register']);
        $managerRole->givePermissionTo(['register']);
        



        //create manage account:

        $managerUser = User::create([
            'name'=>'walaa rehawi',
            'phone'=>'0937530968',
            'password'=>bcrypt('123456789'),
        ]);
// dd("jkll");        
        //give manager rule
        setPermissionsTeamId(1);
        $managerUser->assignRole($managerRole );
// give manager permission 



    }
}
