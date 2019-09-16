<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 17:06
 */

namespace b\models;


class Souliste extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'souliste';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function categorie(){
        return $this->belongsToMany('\b\models\Categorie','cat2souscat' ,'idsouscat', 'idcat' );
    }
    public function marques(){
        return $this->belongsToMany('\b\models\Marque','sousliste2marque' ,'idSousliste', 'idMarque' );
    }
    public function Products(){
        return $this->belongsToMany('b\models\Produit','sousliste2produit' ,'idSousliste', 'idProduit' );
    }
}