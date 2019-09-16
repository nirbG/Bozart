<?php

namespace b\Controleur;



use b\models\Client;
use b\models\Panier;
use b\models\Select;
use b\models\SelectProd2opt;
use b\models\Size;
use b\models\Souliste;
use b\Vue\VueAccueil;
use b\Vue\VueCatalogue;
use b\Models\Categorie;
use b\Models\sousliste;
use b\Models\Marque;
use b\Models\Produit;
use b\Models\Contient;
use b\Vue\VueSimple;
use b\Vue\VueCompte;
use b\utils\Authentification;

class ControleurCompte {

    //Méthode qui definit l'accueil du site giftBox
    function form($erreur){
        $vue=new VueCompte($this->erreur($erreur));
        echo $vue->render(1);
    }

    function connexion(){
        $app=\Slim\Slim::getInstance();
        $email = $app->request->post('email');
        $pass = $app->request->post('password');

        $erreur=Authentification::authenticate($email,$pass);
        if($erreur!=null) {
            $app->redirect($app->urlFor('form',['erreur'=>$erreur]));
        }
        $app->redirect($app->urlFor('compte'));
    }
    function inscription($erreur){
        $vue=new VueCompte($this->erreur($erreur));
        echo $vue->render(3);
    }
    function sInscrire(){
        $app = \Slim\Slim::getInstance();

        $email = $app->request->post('email');
        $pass = $app->request->post('password');
        $confirm = $app->request->post('confirm');
        $erreur=Authentification::createUser($email,$pass,$confirm);
        if($erreur!=null){
            $app->redirect($app->urlFor('ins',['erreur'=>$erreur]));
        }
        $app->redirect($app->urlFor('ins2',['erreur'=>'input']));

    }
    function inscription2($erreur){
        $vue=new VueCompte($this->erreur($erreur));
        echo $vue->render(4);
    }
    function sInscrire2(){
        $app = \Slim\Slim::getInstance();
        $mail = $_SESSION["ins"];
        $rue = $app->request->post('rue');
        $ville = $app->request->post('ville');
        $cd = $app->request->post('cd');
        $dep = $app->request->post('departement');
        $erreur=Authentification::addInfo($mail,$rue,$ville,$cd,$dep);
        if($erreur!=null){
            $app->redirect($app->urlFor('ins2',['erreur'=>$erreur]));
        }
        $app->redirect($app->urlFor('form',['erreur'=>'input']));
    }
    function setinfo(){
        $app = \Slim\Slim::getInstance();
        $mail=$_SESSION['profile'];
        $mail=$mail['user_mail'];
        $rue = $app->request->post('rue');
        $ville = $app->request->post('ville');
        $cd = $app->request->post('cd');
        $dep = $app->request->post('departement');
        $erreur=Authentification::addInfo($mail,$rue,$ville,$cd,$dep);
        if($erreur!=null){
            $app->redirect($app->urlFor('modifierCoor',['erreur'=>$erreur]));
        }
        $app->redirect($app->urlFor('compte'));
    }
    function detail(){
        $vue=new VueCompte();
        echo $vue->render(5);
    }

    function deco(){
        $app = \Slim\Slim::getInstance();
        unset( $_SESSION['profile']);
        $app->redirect($app->urlFor('accueil'));

    }
    function modifierCoor($erreur=0){
        $vue=new VueCompte($this->erreur($erreur));
        echo $vue->render(6);
    }

    function ConfirmationMP($erreur){
        $vue=new VueCompte($this->erreur($erreur));
        echo $vue->render(7);
    }
    function confirmMP(){
        $app = \Slim\Slim::getInstance();
        $mp = $app->request->post('password');
        $erreur=Authentification::confirmMp($mp);
        if($erreur!=null){
            $app->redirect($app->urlFor('ConfirmationMP',['erreur'=>$erreur]));
        }
        $app->redirect($app->urlFor('saisiMP',['erreur'=>'input']));

    }
    function saisiMP($erreur){
        $vue=new VueCompte($this->erreur($erreur));
        echo $vue->render(8);
    }
    function enregistreMP(){
        $app = \Slim\Slim::getInstance();
        $mp = $app->request->post('password');
        $c = $app->request->post('confirm');
        $erreur=Authentification::newMP($mp,$c);
        if($erreur!=null){
            $app->redirect($app->urlFor('saisiMP',['erreur'=>$erreur]));
        }
        $app->redirect($app->urlFor('compte'));
    }

    function erreur($id){
        switch ($id){
            case '1':
                return "le compte n'existe pas";
                break;
            case '2':
                return 'ce compte existe deja';
                break;
            case '3':
                return "l'une ou plusieur de valeur saisi ne sont pas correct ou non rempli";
                break;
            case '4':
                return "le mot de passe saisi n'est pas correct";
                break;
            case '5':
                return "vous n'avez pas rempli les champs obligatoire ou il ne sont pas identique";
                break;
            case 'input':
                return "";
                break;
        }
    }
    function valider(){
        $app = \Slim\Slim::getInstance();
        if(sizeof($_SESSION['panier'])>0){
            $p=new Panier();

            if(isset($_SESSION['profile'])) {
                $profile=$_SESSION['profile'];
                $p->idCreateur = $profile['userid'];
                $p->prix = 0;
                $p->save();
                $prix = 0;
                foreach ($_SESSION['panier'] as $idItem => $value) {
                    $array = explode('/', "$idItem");
                    $prod = Produit::where('id', '=', $array[0])->first();
                    $c = new Contient();
                    $c->idPanier = $p->id;
                    $c->idProd = $array[0];
                    if(sizeof($array)!=3) {
                        $c->Soption = $array[1];
                        if ($array[1] == 'image') {
                            $prix += $prod->prix * intval($value);
                        } else {
                            $opt = SelectProd2opt::where('idprod', '=', $array[0]);
                            $opt = $opt->where('nom', 'like', $array[1])->first();
                            if($opt!=null) {
                                $prix += $opt->prix * intval($value);
                            }else{
                                $desc = explode(' ', "$array[1]");
                                $surmesure = explode('x', "$desc[1]");
                                $prix += floatval($surmesure[0]+$surmesure[1]*1.20*$prod->prix);
                            }
                        }
                    }else{
                        $c->Soption = $array[1].'/'.$array[2];
                        $size=Size::where('id','=',$array[2])->first();
                        $prix += $size->prix * intval($value);
                    }
                    $c->quantite = $value;
                    $c->save();
                }
                $_SESSION['panier'] = [];
                $p->prix = $prix;
                $p->save();
                $app->redirect($app->urlFor('payer'));
            }else{
                $app->redirect($app->urlFor('form'));
            }
        }else{
            $app->redirect($app->urlFor('accueil'));
        }
    }
    function payer(){
        $vue=new VueCompte();
        echo $vue->render(9);
    }

    function PanierDetail($id){
        $p=Contient::where('idPanier','=',$id)->get();
        $vue=new VueCompte(array('contient'=>$p,'panier'=>Panier::find($id)));
        echo $vue->render(10);
    }
    function sendMessage(){
        $app=\Slim\Slim::getInstance();
        $mail="contact@bozart.fr";
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
        {
            $passage_ligne = "\r\n";
        } else {
            $passage_ligne = "\n";
        }
//=====Déclaration des messages au format texte et au format HTML.
        $name=$app->request->post('name');
        $email=$app->request->post('email');
        $message_txt = $app->request->post('message');
//==========
//=====Création de la boundary

        $boundary = "-----=".md5(rand());
//==========
//=====Définition du sujet.

        $sujet = "SAV site";
//=========
//=====Création du header de l'e-mail.

        $header = "From: \"$name\"<$email>".$passage_ligne;
        $header.= "Reply-to: \"$name\" <$email>".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
//=====Création du message.

        $message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.

        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_txt.$passage_ligne;
//==========

//=====Envoi de l'e-mail.

        mail($mail,$sujet,$message,$header);
        $app=\Slim\Slim::getInstance();
        $app->redirectTo("accueil");
    }

    function saisirEmail($erreur){
        $vue=new VueCompte($this->erreur($erreur));
        echo $vue->render(11);
    }

    function verifEmail(){
        $app=\Slim\Slim::getInstance();
        $email=$app->request->post('email');
        $e=Client::where("mail","=",$email)->first();
        if($e!=null) {
            $email=hash("md5",$email);
            echo $email;
            $this->sendMessageToChangeMDp($email);
            //$app->redirect($app->urlFor('ModMp',['mail'=>$email,'erreur'=>'input']));
        }else{
            $app->redirect($app->urlFor('saisirEmail',['erreur'=>'1']));
        }
    }

    function sendMessageToChangeMDp($e){
        $app=\Slim\Slim::getInstance();
        $mail="contact@bozart.fr";
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
        {
            $passage_ligne = "\r\n";
        } else {
            $passage_ligne = "\n";
        }
//=====Déclaration des messages au format texte et au format HTML.
        $email=$e;
        $url=$app->urlFor('ModMp',['mail'=>$email,'erreur'=>'input']);
        $message_html = <<<end
            <p> pour changer votre mot de passe vous devez cliquez sur ce lien</p>
            <a href="$url">changer votre mot de passe</a>
end;
//==========
//=====Création de la boundary

        $boundary = "-----=".md5(rand());
//==========
//=====Définition du sujet.

        $sujet = "SAV site";
//=========
//=====Création du header de l'e-mail.

        $header = "From: \"$email\"<$email>".$passage_ligne;
        $header.= "Reply-to: \"$email\" <$email>".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========

//=====Création du message.
        $message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;
//==========
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========

//=====Envoi de l'e-mail.

        mail($mail,$sujet,$message,$header);
        $app=\Slim\Slim::getInstance();
        $app->redirectTo("accueil");
    }

    function ModMp($email,$erreur){
        $vue=new VueCompte(array('erreur'=>$this->erreur($erreur),'email'=>$email));
        echo $vue->render(12);
    }

    function enrmdp(){
        $app=\Slim\Slim::getInstance();
        $email=$app->request->post('email');
        $mp = $app->request->post('password');
        $c = $app->request->post('confirm');
        $erreur=Authentification::MPOublié($email,$mp,$c);
        if(($erreur=='1')||($erreur=='3')){
            $app->redirect($app->urlFor('ModMp',['mail'=>$email,'erreur'=>$erreur]));
        }
        echo
        $erreur=Authentification::authenticate($erreur,$mp);
        if($erreur!=null) {
            $app->redirect($app->urlFor('form',['erreur'=>$erreur]));
        }
        $app->redirect($app->urlFor('compte'));

    }
}