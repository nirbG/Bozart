<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class cat2souscat extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'cat2souscat';
    protected $primaryKey = 'idcat,idsouscat';
    public $timestamps = false;

}