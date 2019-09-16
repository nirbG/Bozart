<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class Contient extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'contient';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function produit(){
        return $this->belongsTo('\b\models\Produit','idProd');
    }
}