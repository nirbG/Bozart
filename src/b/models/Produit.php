<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class Produit extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'produit';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function sousliste(){
        return $this->belongsToMany('b\models\Souliste','sousliste2produit' ,'idProduit', 'idSousliste' );
    }
    public function categorie(){
        return $this->belongsToMany('b\models\Categorie','cat2produit' ,'idProduit', 'idCat' );
    }
    public function Marque(){
        return $this->belongsToMany('b\models\Marque','marque2produit' ,'idProduit', 'idMarque' );
    }
    public function Select(){
        return $this->belongsToMany('b\models\Select','prod2select' ,'idProd', 'idselect' );
    }

    public function colors(){
        return $this->belongsToMany('b\models\Color','prod2couleur' ,'idprod', 'idColor' );
    }

}