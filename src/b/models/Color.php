<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class Color extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'couleur';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Type(){
        return $this->belongsTo('\b\models\TypeColor','type');
    }

    public function Size(){
        return $this->belongsToMany('b\models\Size','color2size' ,'idColor', 'idSize' );
    }


}