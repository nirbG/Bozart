<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/05/2017
 * Time: 08:44
 */

namespace b\Controleur;

use b\models\C2S;
use b\models\cat2produit;
use b\models\cat2souscat;
use b\models\Categorie;
use b\models\Client;
use b\models\Color;
use b\models\imageadditionnelle;
use b\models\Marque;
use b\models\marque2produit;
use b\models\Panier;
use b\models\prod2couleur;
use b\models\prod2select;
use b\models\Produit;
use b\models\Select;
use b\models\SelectProd2opt;
use b\models\Size;
use b\models\Souliste;
use b\models\sousliste2marque;
use b\models\sousliste2produit;
use b\utils\Authentification;
use b\utils\AuthException;
use b\Vue\VueAdmin;
use Illuminate\Support\Traits\CapsuleManagerTrait;
use Slim\Slim;

class ControleurAdmin
{
    function adminMenu(){
        Authentification::checkAccessRights(2);
        $vue=new VueAdmin();
        echo $vue->render(0);
    }

    function listerProduit($trie){
        Authentification::checkAccessRights(2);
        if($trie=='tous') {
            $p=Produit::orderBy('nom')->get();
        }else{
            if($trie=="sans") {
                $p = Produit::all();
            }else {
                $s = Souliste::where('nom', '=', $trie)->first();
                if ($s == null) {
                    $c = Categorie::where('nom', '=', $trie)->first();
                    $p = $c->Products()->get();
                } else {
                    $p = $s->Products()->get();
                }
            }
        }
        if($trie=='sans') {
            $res = array('trie'=> $trie,'produits' => $p, 'sans' => true);
        }else{
            $res = array('trie'=> $trie,'produits' => $p, 'sans' => false);
        }
        $vue = new VueAdmin($res);
        echo $vue->render(1);
    }
    function ajoutProd(){
        Authentification::checkAccessRights(2);
        $vue = new VueAdmin();
        echo $vue->render(2);
    }
    function saveProd(){
        Authentification::checkAccessRights(2);
        $app=\Slim\Slim::getInstance();
        $nom = $app->request->post('nom');
        $prix = $app->request->post('prix');
        $descCourt = $app->request->post('descCourt');
        $descLong = $app->request->post('descLong');
        $img = $app->request->post('img');
        $promo = $app->request->post('promo');
        $select = $app->request->post('select');
        $Sousliste = $app->request->post('Sousliste');
        $Marque = $app->request->post('Marque');
        $largeur = $app->request->post('largeur');
        $hauteur = $app->request->post('hauteur');

        $EAN=$app->request->post('EAN');
        $id =Produit::max('id')+1;
       $prod=new Produit();
        $prod->id=$id;
        $prod->nom=$nom;
        $prod->prix=floatval($prix);
        $prod->descCourt=$descCourt;
        $prod->descLong=$descLong;
        $prod->img=$img;
        $prod->EAN=$EAN;
        if($promo=='promo'){
            $prod->promo=1;
        }
        if($hauteur!='') {
            $prod->hauteur = floatval($hauteur);
        }
        if($largeur!='') {
            $prod->largeur = floatval($largeur);
        }
        $prod->save();
        if($select!=-1){
            $s=Select::find($select);
            if($s!=null) {
                $select2opt = new prod2select();
                $select2opt->idProd=$id;
                $select2opt->idselect=$s->id;
                $select2opt->save();
            }
        }

        $sous=Souliste::where('nom','=',$Sousliste)->first();
        if($sous==null){
            $sous=Categorie::where('nom','=',$Sousliste)->first();
            $lie=new cat2produit();
            $lie->idCat=$sous->id;
            $lie->idProduit=$id;
            $lie->save();
        }else{
            $lie=new sousliste2produit();
            $lie->idSousliste=$sous->id;
            $lie->idProduit=$id;
            $lie->save();
        }
        if($Marque!=-1){
            $m=Marque::find($Marque);
            if($m!=null){
                $m2p=new marque2produit();
                $m2p->idMarque=$m->id;
                $m2p->idProduit=$id;
                $m2p->save();
            }
        }
        $prod->save();
        if($select==6) {
            $app->redirectTo("AdminmodifPalette", ['id' => $id]);
        }else {
            $app->redirectTo("AdminmodifProd", ['id' => $id]);
        }
    }
    function modifProd($id){
        Authentification::checkAccessRights(2);
        $p=Produit::find($id);
        $sl=$p->sousliste()->first();
        if($sl!=null) {
            $cat = $sl->categorie()->first();
        }else{
            $cat =$p->categorie()->first();
            $sl=$cat;
        }
        $sel=$p->Select()->get();
        $req=array("categorie"=>$cat,"sousliste"=>$sl,"prod"=>$p,"select"=>$sel);
        $vue=new VueAdmin($req);
        $html=$vue->render(3);
        echo $html;
    }
    function modifPalette($id){
        Authentification::checkAccessRights(2);
        $p=Produit::find($id);
        $sl=$p->sousliste()->first();
        if($sl!=null) {
            $cat = $sl->categorie()->first();
        }else{
            $cat =$p->categorie()->first();
            $sl=$cat;
        }
        $color=$p->colors()->get();
        $req=array("categorie"=>$cat,"sousliste"=>$sl,"prod"=>$p,"color"=>$color);
        $vue=new VueAdmin($req);
        $html=$vue->render(13);
        echo $html;
    }

    function updateProd($id,$prod,$redirect){
        Authentification::checkAccessRights(2);
        $app=\Slim\Slim::getInstance();
        switch ($id) {
            case 0:
                $p = Produit::find($prod);
                $p->nom = $app->request->post('nom');
                $p->prix = $app->request->post('prix');
                $p->descCourt = $app->request->post('descCourt');
                $p->descLong = $app->request->post('descLong');
                $p->img = $app->request->post('img');
                $p->EAN=$app->request->post('EAN');
                $promo = $app->request->post('promo');
                if ($promo == 'promo') {
                    $p->promo = 1;
                } else {
                    $p->promo = 0;
                }
                $disponible = $app->request->post('disponible');
                if ($disponible == 'dispo') {
                    $p->disponible = 1;
                } else {
                    $p->disponible = 0;
                }
                $hauteur = $app->request->post('hauteur');
                $largeur = $app->request->post('largeur');
                if ($hauteur != '') {
                    $p->hauteur = floatval($hauteur);
                } else {
                    $p->hauteur = 10000;
                }
                if ($largeur != '') {
                    $p->largeur = floatval($largeur);
                } else {
                    $p->largeur = 10000;
                }
                $sel=$p->Select()->get();
                foreach ($sel as $select){
                    if(($select->id>=2)&&($select->id<=5)) {
                        $SPOs=SelectProd2opt::where(["idprod" => $prod, "idSelect" => $select->id])->get();
                        foreach ($SPOs as $SPO) {
                            $prix = explode(' ', $SPO->nom);
                            $prix = explode('x', $prix[1]);
                            $prix = ((floatval($prix[0]) + floatval($prix[1])) * 1.20 * $p->prix)/100;
                            SelectProd2opt::where(['idSelect' => $select->id, 'idprod' => $prod, 'nom' => $SPO->nom])->update([ "prix" => floatval($prix)]);
                        }
                    }
                }
                $p->save();
                break;
            case 1:
                $select = $app->request->post('select');
                if ($select != -1) {
                    $s = Select::find($select);
                    $p = Produit::find($prod);
                    $sp = $p->Select()->where('id', '=', $select)->first();
                    if (($s != null) && ($sp == null)) {
                        $select2opt = new prod2select();
                        $select2opt->idProd = $prod;
                        $select2opt->idselect = $s->id;
                        $select2opt->save();
                    }
                }
                if($select==6) {
                    $app->redirectTo("AdminmodifPalette", ['id' => $prod]);
                }
                break;
            case 2:
                $nom = $app->request->post('nom');
                $oldnom = $app->request->post('oldnom');
                $prix = $app->request->post('prix');
                $id = $app->request->post('id');
                if (isset($_POST['supp'])) {
                    $option = SelectProd2opt::where(['idSelect' => $id, 'idprod' => $prod, 'nom' => $oldnom]);
                    $option->delete();
                } else {
                    if(($id>=2)&&($id<=5)) {
                        if ($nom != ''){
                            $prod=Produit::find($prod);
                            $prix=explode(' ',$nom);
                            $prix=explode('x',$prix[1]);
                            $prix=((floatval($prix[0])+floatval($prix[1]))*1.20*$prod->prix)/100;
                            $prod=$prod->id;
                        }
                    }
                    if (($nom != '') && ($prix != '')) {
                        SelectProd2opt::where(['idSelect' => $id, 'idprod' => $prod, 'nom' => $oldnom])->update(["nom" => $nom, "prix" => floatval($prix)]);
                    }

                }
                break;
            case 3:
                $nom = $app->request->post('nom');
                $prix = $app->request->post('prix');
                $id = $app->request->post('id');
                if(($id>=2)&&($id<=5)) {
                    if ($nom != '') {
                        $prod = Produit::find($prod);
                        $prix = explode(' ', $nom);
                        $prix = explode('x', $prix[1]);
                        $prix = ((floatval($prix[0]) + floatval($prix[1])) * 1.20 * $prod->prix)/100;
                        $prod=$prod->id;
                    }
                }
                if (($nom != '') && ($prix != '')) {
                    $s = new SelectProd2opt();
                    $s->idSelect = $id;
                    $s->idprod = $prod;
                    $s->nom = $nom;
                    $s->prix = floatval($prix);
                    $s->save();

                }
                break;
            case 4:
                $Sousliste = $app->request->post('Sousliste');
                $OldSousliste = $app->request->post('OldSousliste');
                if($Sousliste!='') {
                    if ($Sousliste != $OldSousliste) {
                        $sous = Souliste::where('nom', '=', $Sousliste)->first();
                        $OldS = Souliste::where('nom', '=', $OldSousliste)->first();
                        if ($OldS == null) {
                            $oldC = Categorie::where('nom', '=', $OldSousliste)->first();
                            if ($oldC != null) {
                                $oldlie = cat2produit::where('idCat', '=', $oldC->id);
                                $oldlie = $oldlie->where('idProduit', '=', $prod);
                                echo "deleteC $oldC->id $prod";
                                $oldlie->delete();
                            }
                        } else {
                            sousliste2produit::where(['idSousliste'=> $OldS->id,'idProduit'=> $prod])->delete();
                        }
                        if ($sous == null) {
                            $sous = Categorie::where('nom', '=', $Sousliste)->first();
                            $lie = new cat2produit();
                            $lie->idCat = $sous->id;
                            $lie->idProduit = $prod;
                            echo "addC $sous->id $prod";
                            $lie->save();
                        } else {
                            $lie = new sousliste2produit();
                            $lie->idSousliste = $sous->id;
                            $lie->idProduit = $prod;
                            echo "addS $lie->idSousliste  $lie->idProduit";
                            $lie->save();
                        }
                    }
                }else{
                    if($OldSousliste!=""){
                        $OldS = Souliste::where('nom', '=', $OldSousliste)->first();
                        sousliste2produit::where(['idSousliste'=>$OldS->id,'idProduit'=> $prod])->delete();
                    }
                }
                break;
            case 5:
                $Marque = $app->request->post("Marque");
                $MarqueO = $app->request->post("MarqueO");
                if ($Marque != $MarqueO) {
                    if ($MarqueO != '-1') {
                        $mO = marque2produit::where('idMarque', '=', $MarqueO);
                        $mO = $mO->where('idProduit', '=', $prod);
                        $mO->delete();
                        $m = new marque2produit();
                        $m->idMarque = $Marque;
                        $m->idProduit = $prod;
                        $m->save();
                    } else {
                        $m = new marque2produit();
                        $m->idMarque = $Marque;
                        $m->idProduit = $prod;
                        $m->save();
                    }
                }
                break;
            case 6:
                $p = Produit::find($prod);
                $p->delete();
                prod2couleur::Where('idprod','=',$prod)->delete();
                prod2select::Where('idProd','=',$prod)->delete();
                sousliste2produit::Where('idProduit','=',$prod)->delete();
                cat2produit::Where('idProduit','=',$prod)->delete();
                marque2produit::Where('idProduit','=',$prod)->delete();
                SelectProd2opt::Where('idprod','=',$prod)->delete();
                $app->redirectTo("AdminlisterProduit",['trie'=>'tous']);
                break;
            case 7:
                $select = $app->request->post("select");
                $a = SelectProd2opt::where('idSelect', '=', $select);
                $a = $a->where('idprod', '=', $prod)->get();
                foreach ($a as $op) {
                    SelectProd2opt::where(['idSelect' => $op->idSelect, 'idprod' => $op->idprod, 'nom' => $op->nom])->delete();
                }
                /*$sp2=prod2select::where('idProd','=',$prod);
                $sp2=$sp2->where('idselect','=',$select)->first();
                $sp2->delete();*/
                prod2select::where(['idProd' => $prod, 'idselect' => $select])->delete();
                break;
            case 8:
                $color = $app->request->post('color');
                $c = prod2couleur::where('idprod', '=', $prod);
                $c = $c->where('idColor', '=', $color)->first();
                if ($c == null) {
                    $p2c = new prod2couleur();
                    $p2c->idprod = $prod;
                    $p2c->idColor = $color;
                    $p2c->save();
                }
                break;
            case 9:
                $color = $app->request->post('color');
                $colors = prod2couleur::where(['idprod' => $prod, 'idColor' => $color])->get();
                foreach ($colors as $c) {
                    C2S::where(['idColor' => $c->idColor])->delete();
                }
                prod2couleur::where(['idprod' => $prod, 'idColor' => $color])->delete();
                break;
            case 10:
                $color = $app->request->post('color');
                $size = $app->request->post('size');
                C2S::where([ 'idColor' => $color, 'idSize' => $size])->delete();
                break;
            case 11:
                $color = $app->request->post('color');
                $size = $app->request->post('size');
                $colors =C2S::where([ 'idColor' => $color, 'idSize' => $size])->first();
                if ($colors == null) {
                    $c2s = new C2S();
                    $c2s->idColor=$color;
                    $c2s->idSize=$size;
                    $c2s->save();
                }
                break;
            case 12:
                $nom = $app->request->post('nom');
                $descImg = $app->request->post('descImg');
                $oldnom = $app->request->post('Onom');
                $olddescImg = $app->request->post('OdescImg');
                if (isset($_POST['supp'])) {
                    $option = imageadditionnelle::where(['idProduit' => $prod, 'nom' => $oldnom, 'descImg' => $olddescImg]);
                    $option->delete();
                } else {
                    if (($nom != '') && ($descImg != '')) {
                        imageadditionnelle::where(['idProduit' => $prod, 'descImg' => $olddescImg, 'nom' => $oldnom])->update(["nom" => $nom, "descImg" => $descImg]);
                    }
                }
                break;
            case 13:
                $nom = $app->request->post('nom');
                $descImg = $app->request->post('descImg');
                $img=new imageadditionnelle();
                $img->idProduit=$prod;
                $img->nom=$nom;
                $img->descImg=$descImg;
                $img->save();
                break;
        }

        if ($redirect==1){
            $app->redirectTo("AdminmodifPalette",['id'=>$prod]);
        }
        $app->redirectTo("AdminmodifProd",['id'=>$prod]);
    }

    function listerCat(){
        Authentification::checkAccessRights(2);
        $c=Categorie::all();
        $res = array('Categories' => $c);
        $vue = new VueAdmin($res);
        echo $vue->render(4);
    }
    function ajoutCat(){
        Authentification::checkAccessRights(2);
        $vue = new VueAdmin();
        echo $vue->render(5);
    }
    function saveCat(){
        Authentification::checkAccessRights(2);
        $app=\Slim\Slim::getInstance();
        $nom = $app->request->post('nom');
        $Banner = $app->request->post('Banner');
        $BannerO = $app->request->post('BannerO');
        $c=Categorie::where('nom','=',$nom)->first();
        if($c==null){
            $c=new Categorie();
            $c->nom=$nom;
            $c->Banner=$Banner;
            $c->BannerO=$BannerO;
            $c->save();
        }else{
            $app->redirectTo('AdminajoutCat');
        }
        $app->redirectTo("AdminmodifCat",['id'=>$c->id]);
    }
    function modifCat($id){
        Authentification::checkAccessRights(2);
        $m=Categorie::find($id);
        $req=array("Categorie"=>$m);
        $vue=new VueAdmin($req);
        $html=$vue->render(6);
        echo $html;
    }
    function updateCat($id,$cat){
        Authentification::checkAccessRights(2);
        $c=Categorie::find($cat);
        $app=\Slim\Slim::getInstance();
        switch ($id) {
            case 0:
                $nom = $app->request->post('nom');
                $Banner = $app->request->post('Banner');
                $BannerO = $app->request->post('BannerO');
                $c->nom=$nom;
                $c->Banner=$Banner;
                $c->BannerO=$BannerO;
                $c->save();
            break;
        }
        $app->redirectTo("AdminmodifCat",['id'=>$cat]);
    }
    function listerSousliste(){
        Authentification::checkAccessRights(2);
        $s=Souliste::all();
        $res = array('Souslistes' => $s);
        $vue = new VueAdmin($res);
        echo $vue->render(7);
    }
    function ajoutSous(){
        Authentification::checkAccessRights(2);
        $vue = new VueAdmin();
        echo $vue->render(8);
    }
    function saveSous(){
        Authentification::checkAccessRights(2);
        $app=\Slim\Slim::getInstance();
        $nom = $app->request->post('nom');
        $affichage = $app->request->post('affichage');
        $Categorie = $app->request->post('Categorie');
        $s=Souliste::where('nom','=',$nom)->first();
        if($s==null) {
            $s = new Souliste();
            $s->nom = $nom;
            if($affichage=='Marque'){
                $s->affichage = $affichage;
            }
            $s->save();
        }else{
            $app->redirectTo("AdminajoutSous");
        }
        $c2s=new cat2souscat();
        $c2s->idcat=$Categorie;
        $c2s->idsouscat=$s->id;
        $c2s->save();
        $app->redirectTo("AdminmodifSous",['id'=>$s->id]);
    }
    function modifSous($id){
        Authentification::checkAccessRights(2);
        $m=Souliste::find($id);
        $cat=$m->categorie()->first();
        $req=array("Sousliste"=>$m,"cat"=>$cat);
        $vue=new VueAdmin($req);
        $html=$vue->render(9);
        echo $html;
    }
    function updateSous($id,$sous){
        Authentification::checkAccessRights(2);
        $c=Souliste::find($sous);
        $app=\Slim\Slim::getInstance();
        switch ($id) {
            case 0:
                $nom = $app->request->post('nom');
                $affichage = $app->request->post('affichage');
                $c->nom=$nom;
                if($affichage=='Marque'){
                    $c->affichage='marque';
                }else{
                    $c->affichage='sousliste';
                }
                $c->save();
                break;
            case 1:
                $Categorie=$app->request->post('Categorie');
                $CategorieO=$app->request->post('OldSousliste');
                if($Categorie!=$CategorieO) {
                    cat2souscat::where(['idcat'=>$CategorieO,'idsouscat'=>$sous])->update(["idcat" =>$Categorie]);
                }
                break;
            case 2:
                $so=Souliste::find($sous);
                $prods=$so->Products()->get();
                foreach ($prods as $p){
                    sousliste2produit::where(['idSousliste'=>$sous,'idProduit'=>$p->id])->delete();
                }
                $so->delete();
                $app->redirectTo("AdminlisterSousliste");
                break;
        }
        $app->redirectTo("AdminmodifSous",['id'=>$sous]);
    }
    function listerMarque(){
        Authentification::checkAccessRights(2);
        $m=Marque::orderBy('nom')->get();
        $res = array('Marques' => $m);
        $vue = new VueAdmin($res);
        echo $vue->render(10);
    }
    function ajoutMar(){
        Authentification::checkAccessRights(2);
        $vue = new VueAdmin();
        echo $vue->render(11);
    }
    function saveMar(){
        Authentification::checkAccessRights(2);
        $app=\Slim\Slim::getInstance();
        $nom = $app->request->post('nom');
        $Banner = $app->request->post('img');
        $imgSmall = $app->request->post('imgSmall');
        $Sousliste = $app->request->post('Sousliste');
        $m=Marque::where('nom','=',$nom)->first();
        if($m==null) {
            $m = new Marque();
            $m->nom = $nom;
            $m->img = $Banner;
            $m->imgSmall = $imgSmall;
            $m->save();
        }else{
            $app->redirectTo('AdminajoutMar');
        }
        if ($Sousliste!=''){
            $sous = Souliste::where('nom', '=', $Sousliste)->first();
            $lie = new sousliste2marque();
            $lie->idSousliste = $sous->id;
            $lie->idMarque = $m->id;
            $lie->save();
        }
        $app->redirectTo("AdminmodifMar", ['id' => $m->id]);

    }
    function modifMar($id){
        Authentification::checkAccessRights(2);
        $m=Marque::find($id);
        $req=array("Marque"=>$m);
        $vue=new VueAdmin($req);
        $html=$vue->render(12);
        echo $html;
    }
    function updateMar($id,$Mar){
        Authentification::checkAccessRights(2);
        $m=Marque::find($Mar);
        $app=\Slim\Slim::getInstance();
        switch ($id) {
            case 0:
                $nom = $app->request->post('nom');
                $img = $app->request->post('img');
                $imgSmall = $app->request->post('imgSmall');
                $m->nom=$nom;
                $m->img=$img;
                $m->imgSmall=$imgSmall;
                $m->save();
                break;
            case 1:
                $sous=$app->request->post('Sousliste');
                $s=sousliste2marque::where(['idSousliste'=>$sous,'idMarque'=>$Mar])->first();
                if($s==null){
                    $s=new sousliste2marque();
                    $s->idSousliste=$sous;
                    $s->idMarque=$Mar;
                    $s->save();
                }
                break;
            case 2:
                $prods=$m->Products()->get();
                foreach ($prods as $p){
                    marque2produit::where(['idMarque'=>$Mar,'idProduit'=>$p->id])->delete();
                }
                $sous=$m->Sousliste()->get();
                foreach ($sous as $s){
                    sousliste2marque::where(['idSousliste'=>$s->id,'idMarque'=>$Mar])->delete();
                }
                $m->delete();
                $app->redirectTo('AdminlisterMarque');
                break;
            case 3:
                $ou=$app->request->post('Sousliste');
                sousliste2marque::where(['idSousliste'=>$ou,'idMarque'=>$Mar])->delete();
                break;
        }
        $app->redirectTo("AdminmodifMar",['id'=>$Mar]);
    }
    function listerColor(){
        Authentification::checkAccessRights(2);
        $m=Color::orderBy('marque')->orderBy('type')->orderBy('nom')->get();
        $res = array('Color' => $m);
        $vue = new VueAdmin($res);
        echo $vue->render(15);
    }
    function ajoutColor(){
        Authentification::checkAccessRights(2);
        $vue = new VueAdmin();
        echo $vue->render(16);
    }
    function saveColor(){
        Authentification::checkAccessRights(2);
        $app=\Slim\Slim::getInstance();
        $nom = $app->request->post('nom');
        $img = $app->request->post('img');
        $marque = $app->request->post('marque');
        $type = $app->request->post('type');
        $m=Color::where(['nom'=>$nom,'marque'=>$marque,'type'=>$type])->first();
        if(($m==null)&&($nom!='')&&($img!='')) {
            $m = new Color();
            $m->nom = $nom;
            $m->marque = $marque;
            $m->img = $img;
            $m->type=$type;
            $m->save();
        }else{
            $app->redirectTo('AdminajoutCol');
        }
        $app->redirectTo("AdminmodifCol", ['id' => $m->id]);

    }
    function modifColor($id){
        Authentification::checkAccessRights(2);
        $m=Color::find($id);
        $req=array("Color"=>$m);
        $vue=new VueAdmin($req);
        $html=$vue->render(17);
        echo $html;
    }
    function updateColor($id,$Mar){
        Authentification::checkAccessRights(2);
        $m=Color::find($Mar);
        $app=\Slim\Slim::getInstance();
        switch ($id) {
            case 0:
                $nom = $app->request->post('nom');
                $img = $app->request->post('img');
                $marque = $app->request->post('marque');
                $type = $app->request->post('type');
                $c=Color::where(['nom'=>$nom,'marque'=>$marque,'type'=>$type])->first();
                if(($c==null)&&($nom!='')&&($img!='')) {
                    $m->nom = $nom;
                    $m->img = $img;
                    $m->marque = $marque;
                    $m->type=$type;
                    $m->save();
                }
                break;
            case 1:
                C2S::where(['idColor'=>$m->id])->delete();
                prod2couleur::where(['idColor'=>$m->id])->delete();
                $m->delete();
                $app->redirectTo('AdminlisterCol');
                break;
            case 2:
                $cond = $app->request->post('cond');
                $c2s=C2S::where(['idColor'=>$m->id,'idSize'=>$cond])->delete();
                break;
            case 3:
                $cond = $app->request->post('cond');
                $c2s=C2S::where(['idColor'=>$m->id,'idSize'=>$cond])->first();
                if($c2s==null){
                    $c2s=new C2S();
                    $c2s->idColor=$m->id;
                    $c2s->idSize=$cond;
                    $c2s->save();
                }
                break;
        }
        $app->redirectTo("AdminmodifCol",['id'=>$Mar]);
    }
    function listerCond(){
        Authentification::checkAccessRights(2);
        $m=Size::all();
        $res = array('Size' => $m);
        $vue = new VueAdmin($res);
        echo $vue->render(18);
    }
    function ajoutCond(){
        Authentification::checkAccessRights(2);
        $vue = new VueAdmin();
        echo $vue->render(19);
    }
    function saveCond(){
        Authentification::checkAccessRights(2);
        $app=\Slim\Slim::getInstance();
        $serie = $app->request->post('serie');
        $taille = $app->request->post('taille');
        $prix = $app->request->post('prix');
        $m=Size::where(['taille'=>$taille,'serie'=>$serie])->first();
        if(($m==null)&&($serie!="")&&($prix!="")&&($taille!="")) {
            $m = new Size();
            $m->serie = $serie;
            $m->taille = $taille;
            $m->prix = $prix;
            $m->save();
        }else{
            $app->redirectTo('AdminajoutCond');
        }
        $app->redirectTo("AdminmodifCond", ['id' => $m->id]);

    }
    function modifCond($id){
        Authentification::checkAccessRights(2);
        $m=Size::find($id);
        $req=array("Size"=>$m);
        $vue=new VueAdmin($req);
        $html=$vue->render(20);
        echo $html;
    }
    function updateCond($id,$Mar){
        Authentification::checkAccessRights(2);
        $m=Size::find($Mar);
        $app=\Slim\Slim::getInstance();
        switch ($id) {
            case 0:
                $serie = $app->request->post('serie');
                $taille = $app->request->post('taille');
                $prix = $app->request->post('prix');
                $p=Size::where(['taille'=>$taille,'serie'=>$serie,'prix'=>$prix])->first();
                if(($p==null)&&($serie!="")&&($prix!="")&&($taille!="")) {
                    $m->serie = $serie;
                    $m->taille = $taille;
                    $m->prix = $prix;
                    $m->save();
                }
                break;
            case 1:
                C2S::where(['idSize'=>$m->id])->delete();
                $m->delete();
                $app->redirectTo("AdminlisterCond");
                break;
        }
        $app->redirectTo("AdminmodifCond",['id'=>$Mar]);
    }
    function adminSearch(){
        Authentification::checkAccessRights(2);
        $app=\Slim\Slim::getInstance();
        $s=$app->request->post('search');
        if($s!=null) {
            $app->redirectTo('adminafficheSearch',['id'=>$s]);
        }else {
            $app->redirectTo('adminMenu');
        }
    }
    function adminafficheSearch($s){
        Authentification::checkAccessRights(2);
        $prod = Produit::where('nom', 'like', '%' . $s . '%')->orWhere('descCourt', 'like', "%$s%")->orWhere('descLong', 'like', "%$s%")->get();
        $EAN=Produit::Where('EAN','like',"%$s%")->get();
        $res = array('produits' => $prod,'ean'=>$EAN, 'recherche' => $s);
        $vue = new VueAdmin($res);
        echo $vue->render(14);
    }

    function listerCompte(){
        $c=Client::all();
        $res = array('Client' => $c);
        $vue = new VueAdmin($res);
        echo $vue->render(21);
    }
    function ClientD($id){
        $c=Client::find($id);
        $res = array('Client' => $c);
        $vue = new VueAdmin($res);
        echo $vue->render(22);
    }

    function listerPanier(){
        $p=Panier::all();
        $res = array('Panier' => $p);
        $vue = new VueAdmin($res);
        echo $vue->render(23);
    }

    function PanierD($id){
        $p=Panier::find($id);
        $res = array('Panier' => $p);
        $vue = new VueAdmin($res);
        echo $vue->render(24);
    }

    function ConfirmPanier($id){
        $p=Panier::find($id);
        $app=\Slim\Slim::getInstance();
        $Transporteur=$app->request->post('Transporteur');
        $code=$app->request->post('code');
        if(($Transporteur!="")&&($code!="")) {
            $p->etat = 'reçu';
            $p->Transporteur=$Transporteur;
            $p->code=$code;
            $p->save();
        }
        $res = array('Panier' => $p);
        $vue = new VueAdmin($res);
        echo $vue->render(24);
    }

}