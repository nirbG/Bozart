<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class Marque extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'marque';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function sousliste(){
        return $this->belongsToMany('b\models\Souliste','sousliste2marque' ,'idMarque', 'idSousliste' );
    }
    public function Products(){
        return $this->belongsToMany('b\models\Produit','marque2produit' ,'idMarque', 'idProduit' );
    }
}