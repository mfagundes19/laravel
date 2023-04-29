<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Role extends Model
{
    use HasFactory;

    protected $table = ("role");
    protected $fillable = [];
    protected static $logName = "Roles";
    protected static $logAttributes = ['name', 'text'];

    /**
     * Reference for User 
     *
     * @return Model
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'foreign_key');
    }

    /**
     * Verify if role has permission in resource / (module/permission)
     * 
     * @param $module
     * @param $permission
     * 
     * @return boolean
     */
    public function hasPermission($module, $permission)
    {
        $RolePermission = new \App\Models\RolePermission(); 
        $allow = false;
        $stmt = $RolePermission->select('*')->join('module', 'role_permission.module_id', '=', 'module.id')->where([['role_id','=',$this->id],['module.module','LIKE','%'.$module.'%']])->get();
        foreach($stmt as $element)
        {
            switch($permission)
            {
                case 'view':
                    if(isset($element->allow_view) && !empty($element->allow_view))
                    {
                        $allow = true;
                    }
                break;
                case 'create':
                    if(isset($element->allow_create) && !empty($element->allow_create))
                    {
                        $allow = true;
                    }
                break;
                case 'edit':
                    if(isset($element->allow_edit) && !empty($element->allow_edit))
                    {
                        $allow = true;
                    }
                break;
                case 'delete':
                    if(isset($element->allow_delete) && !empty($element->allow_delete))
                    {
                        $allow = true;
                    }
                break;
                case 'extra':
                    if(isset($element->allow_extra) && !empty($element->allow_extra))
                    {
                        $allow = true;
                    }
                break;
            }
        }
        //debug, remove this line
        $allow = true;
        return $allow;
    }
    
}//end class
