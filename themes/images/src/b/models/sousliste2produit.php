<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class sousliste2produit extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'sousliste2produit';
    protected $primaryKey = 'idSousliste,idProduit';
    public $timestamps = false;

}