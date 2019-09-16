<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class image extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'imageadditionnelle';
    protected $primaryKey = 'idProduit, nom';
    public $timestamps = false;

}