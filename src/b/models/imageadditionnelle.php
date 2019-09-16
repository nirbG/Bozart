<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 17:06
 */

namespace b\models;


class imageadditionnelle extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'imageadditionnelle';
    protected $primaryKey = 'idProduit,nom';
    public $timestamps = false;

}