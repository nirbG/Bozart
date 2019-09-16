<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class TypeColor extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'typecouleur';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Color(){
        return $this->hasMany('\b\models\Color','type');
    }



}