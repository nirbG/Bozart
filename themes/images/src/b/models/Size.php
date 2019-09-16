<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class Size extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'conditionement';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function marque(){
        return $this->belongsTo('\b\models\Marque','idMarque');
    }

    public function Colors(){
        return $this->belongsToMany('b\models\Color','color2size' ,'idSize', 'idColor' );
    }



}