<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class marque2produit extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'marque2produit';
    protected $primaryKey = 'idMarque,idProduit';
    public $timestamps = false;

}