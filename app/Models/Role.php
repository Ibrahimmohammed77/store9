<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function abilities()
    {
        return $this->hasMany(RoleAbility::class, 'role_id', 'id');
    }
    public static function createWithAbility(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->post('name'),
            ]);

            foreach ($request->post('abilities') as $abilitiy_code => $abilitiy_value) {
                RoleAbility::create([
                    'role_id' => $role->id,
                    'ability' => $abilitiy_code,
                    'type' => $abilitiy_value
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return $role;
    }
    public  function updateWithAbility(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->update([
                'name' => $request->post('name'),
            ]);
            foreach ($request->post('abilities') as $abilitiy_code => $abilitiy_value) {
                RoleAbility::UpdateOrCreate([
                    'role_id' => $this->id,
                    'ability' => $abilitiy_code,
                ], [
                    'type' => $abilitiy_value
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return $this;
    }
}
