<?php

namespace b\Controleur;



use b\models\Color;
use b\models\Contient;
use b\models\image;
use b\models\marque2produit;
use b\models\Select;
use b\models\SelectProd2opt;
use b\models\Souliste;
use b\Vue\VueAccueil;
use b\Vue\VueCatalogue;
use b\Models\Categorie;
use b\Models\sousliste;
use b\Models\Marque;
use b\Models\Produit;
use b\Vue\VueSimple;

class ControleurCatalogue  {

    //Méthode qui definit l'accueil du site giftBox
    function accueil(){
        $p=Produit::orderBy('AddDate', 'desc')->take(12)->get();
        $pr=Produit::where('promo','=',1)->get();
        $m = marque2produit::select('idMarque', \Illuminate\Database\Capsule\Manager::raw('count(*) as total'))
            ->groupBy('idMarque')->orderBy('total','desc')->take(12)->get();
        $req=array("promo"=>$pr,"newProd"=>$p,"marque"=>$m);
        $vue=new VueAccueil($req);
        $html=$vue->render(1);
        echo $html;
    }
    function CGV(){
        $vue =new VueSimple();
        $html=$vue->render(1);
        echo $html;
    }
    function MentionLegale(){
        $vue =new VueSimple();
        $html=$vue->render(2);
        echo $html;
    }
    function aboutUs(){
        $vue =new VueSimple();
        $html=$vue->render(3);
        echo $html;
    }
    function contactUs(){
        $vue =new VueSimple();
        $html=$vue->render(4);
        echo $html;
    }
    function cart(){
        $tab = [];
        if (empty($_SESSION['panier'])){

        } else {
            foreach ($_SESSION['panier'] as $idPrest => $value) {
                //echo $idPrest."$"."$value <br>";
                $array = explode('/', "$idPrest");
                $prod = Produit::where('id', '=', $array[0])->first();
                if(sizeof($array)==3){
                    $tab[] = ["quantite" => $value, "prod" => $prod, "option" =>'palette','Color'=>$array[1],'size'=>$array[2]];
                }else {
                    $tab[] = ["quantite" => $value, "prod" => $prod, "option" => $array[1]];
                }
               // echo "q: $value p: $prod opt: $array[1]<br>";
            }
        }
        $vue =new VueSimple($tab);

        $html=$vue->render(5);
       echo $html;
    }

    function cat($nom){
        $cat=Categorie::where('nom','like',$nom)->first();
        $vue=new VueCatalogue($cat);
        $html=$vue->render(1);
        echo $html;
    }
    function catalogueBySl($nom,$id=0){
        $sl=Souliste::where('nom','like',$nom)->first();
        if($sl!=null) {
            $prod = $sl->Products();
            $cat = $sl->categorie()->first();
        }else{
            $cat =Categorie::where('nom','like',$nom)->first();
            $sl=$cat;
            $prod =$cat->Products();
        }
        switch($id){
            case 0:
                $prod=$prod->orderBy('nom')->get();
                break;
            case 1:
                $prod=$prod->orderBy('prix')->get();
            break;
            case 2:
                $prod=$prod->orderBy('prix','desc')->get();
            break;
            case 3:
                $prod=$prod->orderBy('nom')->get();
            break;
            case 4:
                $prod=$prod->where('promo','=',1)->get();
            break;
            case 5:
                $prod=$prod->orderBy('largeur')->get();
            break;
        }
        $random=Produit::where('id','like','%'.rand(1, 9).'%')->take(3)->get();
        $bS=$this->bestSeller();
        $req=array("sousliste"=>$sl,"Products"=>$prod,"categorie"=>$cat,'trie'=>$id,"random"=>$random,'bestSeller'=>$bS);
        $vue=new VueCatalogue($req);
        $html=$vue->render(2);
        echo $html;
    }
    function catalogueByMq($nom ,$marque,$id=0){
        $sl=Souliste::where('nom','like',$nom)->first();
        $marque=Marque::where('nom','like',$marque)->first();
        $prod=$marque->Products();
        switch($id){
            case 0:
                $prod=$prod->orderBy('nom')->get();
                break;
            case 1:
                $prod=$prod->orderBy('prix')->get();
                break;
            case 2:
                $prod=$prod->orderBy('prix','desc')->get();
                break;
            case 3:
                $prod=$prod->orderBy('nom')->get();
                break;
            case 4:
                $prod=$prod->where('promo','=',1)->get();
                break;
        }
        $cat=$sl->categorie()->first();
        $random=Produit::where('id','like','%'.rand(1, 9).'%')->take(3)->get();
        $bS=$this->bestSeller();
        $req=array("sousliste"=>$sl,"Products"=>$prod,"marque"=>$marque,"categorie"=>$cat,'trie'=>$id,"random"=>$random,'bestSeller'=>$bS);
        $vue=new VueCatalogue($req);
        $html=$vue->render(3);
        echo $html;
    }

    function palette($nomCat,$nomProduit){
        $sl=Souliste::where('nom','like',$nomCat)->first();
        $prod=Produit::where('nom','like',$nomProduit)->first();
        $cat=$sl->categorie()->first();;
        $color=$prod->colors()->get();
        $req=array("sousliste"=>$sl,"Color"=>$color,"categorie"=>$cat,"marque"=>$prod);
        $vue=new VueCatalogue($req);
        $html=$vue->render(8);
        echo $html;
    }
    function Marque($nom){
        $sl=Souliste::where('nom','like',$nom)->first();
        $marque=$sl->marques()->get();
        $cat=$sl->categorie()->first();
        $random=Produit::where('id','like','%'.rand(1, 9).'%')->take(3)->get();
        $bS=$this->bestSeller();
        $req=array("sousliste"=>$sl,"marques"=>$marque,"categorie"=>$cat,"random"=>$random,'bestSeller'=>$bS);
        $vue=new VueCatalogue($req);
        $html=$vue->render(4);
        echo $html;
    }
    function MarqueD($id,$m){
        $m=Marque::where('nom','like',$m)->first();
        $prod=$m->Products();
        switch($id){
            case 0:
                $prod=$prod->get();
                break;
            case 1:
                $prod=$prod->orderBy('prix')->get();
                break;
            case 2:
                $prod=$prod->orderBy('prix','desc')->get();
                break;
            case 3:
                $prod=$prod->orderBy('nom')->get();
                break;
            case 4:
                $prod=$prod->where('promo','=',1)->get();
                break;
        }
        $random=Produit::where('id','like','%'.rand(1, 9).'%')->take(3)->get();
        $bS=$this->bestSeller();
        $req=array("marque"=>$m,'produits'=>$prod,"random"=>$random,'trie'=>$id,'bestSeller'=>$bS);
        $vue=new VueCatalogue($req);
        echo $vue->render(7);
    }
    function detail($nom,$id){
        $sl=Souliste::where('nom','like',$nom)->first();
        if($sl!=null) {
            $cat = $sl->categorie()->first();
        }else{
            $cat =Categorie::where('nom','like',$nom)->first();
            $sl=$cat;
        }
        $prod=Produit::where('id','=',$id)->first();
        $Va=$sl->Products()->where('id','!=',$id)->get();
        $random=Produit::where('id','like','%'.rand(1, 9).'%')->take(3)->get();
        $bS=$this->bestSeller();
        $req=array("categorie"=>$cat,"sousliste"=>$sl,"prod"=>$prod,"VousAimerai"=>$Va,"random"=>$random,"bestSeller"=>$bS);
        $vue=new VueCatalogue($req);
        $html=$vue->render(5);
        echo $html;
    }

    function ajProd($id){
        $app=\Slim\Slim::getInstance();
        $q = $app->request->post('quantite');
        $dmc = $app->request->post('option');
        $s = $app->request->post($dmc);
        $select=Select::where('id','=',$dmc)->first();
        if($select!=null) {
            if ($select->id == 8) {
                $largeur = $app->request->post('largeur');
                $longueur = $app->request->post('longueur');
                $option = "Dim $largeur" . "x" . "$longueur";
                if (($largeur < 1) || ($longueur < 1) || ($largeur == null) || ($longueur == null)) {
                    header("Location: {$_SERVER['HTTP_REFERER']}");
                    exit;
                }
            }
        }
        $option='image';
        if($select!=null) {
            if($select->id!=6) {
                if($select->id==7){
                    $option=$s;
                }else {
                    if($select->id==8){
                        $largeur = $app->request->post('largeur');
                        $longueur = $app->request->post('longueur');
                        $option="Dim $largeur"."x"."$longueur";
                    }else{
                        $option = SelectProd2opt::where('idProd', '=', $id);
                        $option = $option->where('idSelect', '=', $select->id);
                        $option = $option->where('prix', '=', $s)->first();
                        $option = $option->nom;
                    }
                }
            }else{
                $option=$s;
            }
        }
        if($q==null){
            $q=1;
        }
        $prod = Produit::where('id', '=', $id)->first();
        if ($prod != null) {
            if (isset($_SESSION['panier']["$id"."/"."$option"])){
                $_SESSION['panier']["$id"."/"."$option"] +=$q;
            }
            else{
                $_SESSION['panier']["$id"."/"."$option"] = $q;
            }
        }
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;

    }

    function supProd($id,$qt,$opt){
        echo "$id $qt $opt";
        $app=\Slim\Slim::getInstance();
        if(strpos($opt, '&')){
            $array = explode('&', "$opt");
            $opt=$array[0].'/'.$array[1];
        }
        if ($_SESSION['panier']["$id"."/"."$opt"] != null) {
            $Prod = Produit::where('id', '=', $id)->first();

            if ($Prod != null) {
                if($qt<0){
                    unset($_SESSION['panier']["$id"."/"."$opt"]);
                }
                if(isset($_SESSION['panier']["$id"."/"."$opt"])){
                    $_SESSION['panier']["$id"."/"."$opt"] -=$qt;

                    if($_SESSION['panier']["$id"."/"."$opt"] <= 0)
                        unset($_SESSION['panier']["$id"."/"."$opt"]);

                }
            }
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
    }

    function search(){
        $app=\Slim\Slim::getInstance();
        $s=$app->request->post('search');
        if($s!=null) {
            $app->redirectTo('affichesearch',['id'=>$s]);
        }else {
            $app->redirectTo('accueil');
        }
    }
    function afficheSearch($s){
        $m = Marque::where('nom', 'like', '%' . $s . '%')->get();
        $prod = Produit::where('nom', 'like', '%' . $s . '%')->orWhere('descCourt', 'like', "%$s%")->orWhere('descLong', 'like', "%$s%")->orWhere('EAN','like',"%$s%")->get();
        $res = array('Marque' => $m, 'produits' => $prod, 'recherche' => $s);
        $vue = new VueCatalogue($res);
        echo $vue->render(6);
    }
    function bestSeller(){
        $app=\Slim\Slim::getInstance();
        $user_info = Contient::select('idProd', \Illuminate\Database\Capsule\Manager::raw('count(*) as total'))
            ->groupBy('idProd')->orderBy('total','desc')->take(4)->get();
        return $user_info;
    }
    //exemple de modification avec eloquent
    /*function test(){
        ini_set('max_execution_time',-1);
            $opts = SelectProd2opt::whereBetween('idSelect', [1, 5])->get();
            foreach ($opts as $opt) {
                echo "$opt->nom";
                $a = rtrim ( $opt->nom, " " );
               // echo "$a";
                //SelectProd2opt::where(['idSelect' => $opt->idSelect, 'idprod' => $opt->idprod, 'nom' => $opt->nom])->update(["nom"=>$a]);

            }
            /*$option = SelectProd2opt::where('idProd', '=', 20);
            $option = $option->where('idSelect', '=', 1);
            $option = $option->where('nom', '=', 'N°70 - 65.00€')->first();
            echo $option->nom;

            $a = explode('-', $option->nom);
            SelectProd2opt::where(['idSelect' => $option->idSelect, 'idprod' => $option->idprod, 'nom' => $option->nom])->update(["nom"=>$a[0]]);
            echo $option->nom;
           /*$r=image::get();
            foreach ($r as $a){
                echo $a->b;
                image::where(['a' => $a->a, 'b' => $a->b])->update(["b"=>3]);
                echo $a->b;

            }
    }*/
}