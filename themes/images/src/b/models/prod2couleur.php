<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class prod2couleur extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'prod2couleur';
    protected $primaryKey = 'idprod,idColor';
    public $timestamps = false;

}