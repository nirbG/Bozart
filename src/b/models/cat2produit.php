<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class cat2produit extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'cat2produit';
    protected $primaryKey = 'idCat,idProduit';
    public $timestamps = false;

}