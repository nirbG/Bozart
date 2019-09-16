<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class SelectProd2opt extends \Illuminate\Database\Eloquent\Model {

    protected $table = 's&p2option';
    protected $primaryKey = "idSelect,idprod,nom";
    public $timestamps = false;

}