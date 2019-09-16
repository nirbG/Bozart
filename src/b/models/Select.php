<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class Select extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'select';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Products(){
        return $this->belongsToMany('b\models\Produit','sousliste2produit' ,'idProduit', 'idSousliste' );
    }

}