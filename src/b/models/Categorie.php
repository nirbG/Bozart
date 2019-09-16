<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class Categorie extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function sousliste(){
        return $this->belongsToMany('b\models\Souliste','cat2souscat' ,'idcat', 'idsouscat' );
    }
    public function Products(){
        return $this->belongsToMany('b\models\Produit','Cat2produit' ,'idCat', 'idProduit' );
    }
}