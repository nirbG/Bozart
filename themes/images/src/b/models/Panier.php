<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class Panier extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'panier';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function createur(){
        return $this->belongsTo('\b\models\Client','idCreateur');
    }

}