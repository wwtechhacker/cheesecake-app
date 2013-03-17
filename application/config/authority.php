<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Initialize User Permissions Based On Roles
    |--------------------------------------------------------------------------
    |
    | This closure is called by the Authority\Ability class' "initialize" method
    |
    */

    'initialize' => function($user)
    {
        //$path = __DIR__.DS.'application'.DS.'config'.DS.'roles'.DS; 
        // The initialize method (this Closure function) will be ran on every page load when the bundle get's started.
        // A User Object will be passed into this method and is available via $user
        // The $user variable is a instantiated User Object (application/models/user.php)

        // First, let's group together some "Actions" so we can later give a user access to multiple actions at once
        Authority::action_alias('manage', array('create'));
        Authority::action_alias('moderate', array('update', 'delete', 'lock', 'sticky'));

        // If a user doesn't have any roles, we don't have to give him permissions so we can stop right here.
        if(count($user->roles) === 0) return false;

        if($user->has_role('administrator'))
        {
            Authority::allow('manage', 'all');
            Authority::allow('moderate', 'all');
            //include($path.'admin.php');

            Authority::deny('delete', 'User', function($that_user) use ($user) {
                // If he tries to delete himself, we return true, setting the deny rule
                return (int)$that_user->id === (int)$user->id;
            });
        }

        /*
        if($user->has_role('store_owner'))
        {
            // What if the logged in User has the role "store_owner", let's allow the user to manage his own store
            Authority::allow('manage', 'Store', function($store) use ($user)
            {
                return is_null(DB::table('stores')->where_id($store->id)->where_user_id($user->id)->first());
            });

            // We can also allow "Actions" on certain "Resources" by results we get from somewhere else, look closely at the next example
            foreach(DB::table('permissions')->where_user_id($user->id)->get() as $permission)
            {
                if($permission->type === 'allow')
                {
                    Authority::allow($permission->action, $permission->resource);
                }
                else
                {
                    Authority::deny($permission->action, $permission->resource);    
                }
            }
        }*/
    }

);