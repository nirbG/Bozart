<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class Client extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'client';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function role(){
        return $this->belongsTo('\b\models\Role','role_id');
    }

    public function paniers(){
        $this->hasMany('\b\models\Panier','idCreateur','id');
    }

}