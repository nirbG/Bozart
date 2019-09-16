<?php
/**
 * Created by PhpStorm.
 * User: quent
 * Date: 10/01/2017
 * Time: 15:53
 */

namespace b\utils;


use b\models\Client;

class Authentification
{
    public static function createUser($email, $password, $passwordConfirm)
    {
        if ($password != null && $password === $passwordConfirm && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $tmp = Client::where('mail', '=', $email)->first();
            if ($tmp == NULL) {

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $client = new Client();
                $client->mail = $email;
                $client->mdp = $hash;
                $client->role_id = 1;
                $client->save();
                $_SESSION["ins"]=$client->mail;
            } else {
                return '2';
            }
        } else {
            return '3';
        }
        return null;
    }
    public static function addInfo($email,$r,$v,$cd,$d){
        if ($r != null && $v != null && $cd != null && $d != null &&  is_numeric($cd) ) {
            $tmp = Client::where('mail', '=', $email)->first();
            if ($tmp != NULL) {

                $tmp->rue = $r;
                $tmp->ville =$v ;
                $tmp->CodePostal = $cd;
                $tmp->departement = $d;
                $tmp->save();
            } else {
                return '1';
            }
        }else{
            return '3';
        }
        return null;
    }
    public static function confirmMp($mp){
        if ($mp != null) {
            $p = $_SESSION['profile'];
            $client = Client::where('id', '=', $p['userid'])->first();
            if (password_verify($mp, $client->mdp)) {

            } else {
                return '4';
            }
        } else {
            return '3';
        }
        return null;
    }
    public static function newMP($mp,$c)
    {
        if ($mp != null && $c!=null &&  $mp === $c ) {
            $p = $_SESSION['profile'];
            $client = Client::where('id', '=', $p['userid'])->first();
            $hash = password_hash($mp, PASSWORD_DEFAULT);
            if ($client !=null ) {
                $client->mdp = $hash;
                $client->save();
            } else {
                return '1';
            }
        } else {
            return '3';

        }
        return null;
    }
    public static function authenticate($email, $password)
    {
// charger utilisateur $user
// vérifier $user->hash == hash($password)
// charger profil ($user->id)
        $client = Client::where('mail', '=', $email)->first();
        if ($client != NULL) {

            $hash = $client->mdp;
            if (password_verify($password, $hash)) {
                self::loadProfile($client->id);
            } else {
                return '4';
            }
        } else {
                return '1';
        }
        return null;
    }

    private static function loadProfile($uid)
    {
// charger l'utilisateur et ses droits
// détruire la variable de session
// créer variable de session = profil chargé
        $client = Client::where('id', '=', $uid)->first();
        $profile = array('user_mail' => $client->mail,
            'userid' => $client->id,
            'role_id' => $client->role->id,
            'auth_level' => $client->role->auth_level);
        $_SESSION['profile'] = $profile;
    }

    public static function checkAccessRights($required)
    {
        if (isset($_SESSION['profile'])) {
            if ($_SESSION['profile']['auth_level'] < $required)
                throw new AuthException("access denied");
        }
        else{
            throw new AuthException("access denied");
        }
    }

}