<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdsResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\Ads;
use App\Models\Category;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function createPermission(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        DB::table('model_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Permission::insert([
            ['name' => 'ads','guard_name' => 'web'],
            ['name' => 'users','guard_name' => 'web'],
            ['name' => 'store','guard_name' => 'web'],
            ['name' => 'subscription','guard_name' => 'web'],
            ['name' => 'statistics','guard_name' => 'web'],
            ['name' => 'support','guard_name' => 'web'],
            ['name' => 'authorization','guard_name' => 'web'],
            ['name' => 'setting','guard_name' => 'web']
        ]);
        $s = User::create([
            'first_name' => 'super admin',
            'last_name' => '',
            'email' => 'taregh1996nazari@gmail.com',
            'password' => Hash::make('Admin@2352!PQz#33Zv%'),
            'mobile' => '09186152691',
            'free_ads_number' => '10000',
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'user_type' => 1,
            'registered_at' => now()->toDateTimeString()
        ]);
        $s->givePermissionTo(['ads', 'users','store','subscription','statistics','support','authorization','setting']);
        $m = User::create([
            'first_name' => 'minoo',
            'last_name' => 'vosoghian',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin@2352!PQz#33Zv%'),
            'mobile' => '09058312797',
            'free_ads_number' => '10000',
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'user_type' => 1,
            'registered_at' => now()->toDateTimeString()
        ]);
        $m->givePermissionTo(['ads', 'users','store','subscription','statistics','support','authorization','setting']);

    }

    public function storeRole(Request $request){
        $request->validate([
            'title' => ['required','string','max:255','unique:roles,name'],
            'permissions' => ['required','array','exists:permissions,id'],
        ]);

        $role = Role::create([
            'name' => $request->title,
            'guard_name' => 'web'
        ]);
        $permissions = Permission::whereIn('id',$request->permissions)->get()->pluck('name')->toArray();
        $role->syncPermissions($permissions);
        
        return response([],200);
    }

    public function getPermissions(){
        $permissions = Permission::get();
        return response($permissions,200);
    }
    public function getRoles(){
        $roles = Role::with('permissions')->get();
        return response($roles,200);
    }

    public function assignRole(Request $request){
        
        $request->validate([
            'role_id' => ['required','exists:roles,id'],
            'user_id' => ['required','exists:users,id'],
        ]);

        $user = User::where('id',$request->user_id)->first();
        $role = Role::where('id',$request->role_id)->first();
        $permissions = $role->permissions->pluck('id')->toArray();
        $user->permissions()->sync($permissions);
        $user->syncRoles([$role->name]);

        return response([],200);

    }
    
    public function revokeRole(Request $request){
        
        $request->validate([
            'role_id' => ['required','exists:roles,id'],
            'user_id' => ['required','exists:users,id'],
        ]);
        $user = User::where('id',$request->user_id)->first();
        $role = Role::where('id',$request->role_id)->first();
        $user->permissions()->sync([]);
        $user->removeRole($role->name);

        return response([],200);

    }
}
