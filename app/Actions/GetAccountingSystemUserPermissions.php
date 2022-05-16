<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Settings\Users\SubModule;

class GetAccountingSystemUserPermissions
{
    use AsAction;

    // TODO: Integrate with Accounting Systems later.

    /**
     * * * SQL Query for getting current users' permissions: * * *
     * 
     * select `sub_modules`.`id`, `sub_modules`.`name`, `t`.`access_level` 
     * from `sub_modules`
     * left join ( 
     *  select `permissions`.`user_id`, `sub_modules`.`id`
     *  from `sub_modules` 
     *  left join `permissions` on `permissions`.`sub_module_id` = `sub_modules`.`id` 
     *  where `permissions`.`user_id` = 2 
     * ) as t on t.id = sub_modules.id
     * where `sub_modules`.`module_id` = 3
     * and `sub_modules`.`duplicate_sub_module_id` is null
     */
    public function handle($modules, $accounting_system_user, $showDuplicates = 0)
    {
        $subQuery = SubModule::select('permissions.access_level', 'sub_modules.id')
            ->leftJoin('permissions', 'permissions.sub_module_id', '=', 'sub_modules.id')
            ->where('permissions.accounting_system_user_id', $accounting_system_user->id);

        for($i = 0; $i < count($modules); $i++)
        {
            $permissions[$i] = $modules[$i]->subModules()
                ->select('sub_modules.id', 'sub_modules.name', 't.access_level', 'sub_modules.url', 'sub_modules.duplicate_sub_module_id')
                ->leftJoinSub($subQuery, 't', function($join){
                    $join->on('t.id', '=', 'sub_modules.id');
                });
            
            if(!$showDuplicates) {
                $permissions[$i]->where(
                    'sub_modules.duplicate_sub_module_id', '=', null)
                    ->orderBy('sub_modules.id', 'ASC');
            }

            $permissions[$i] = $permissions[$i]->get();
        }

        return $permissions;
    }
}
