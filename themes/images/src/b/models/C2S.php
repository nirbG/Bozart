<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class C2S extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'color2size';
    protected $primaryKey = 'idColor, idprod';
    public $timestamps = false;

}