<?php
namespace b\models;
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/04/2017
 * Time: 16:55
 */
class sousliste2marque extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'sousliste2marque';
    protected $primaryKey = 'idSousliste,idMarque';
    public $timestamps = false;

}