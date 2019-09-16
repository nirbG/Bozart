<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class prod2select extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'prod2select';
    protected $primaryKey = 'idProd,idselect';
    public $timestamps = false;

}