<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class Role extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'role';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function clients(){
        return $this->hasMany('\b\models\Client','role_id');
    }

}