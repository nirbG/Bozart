<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/05/2017
 * Time: 08:50
 */

namespace b\Vue;


use b\models\C2S;
use b\models\Categorie;
use b\models\Color;
use b\models\Marque;
use b\models\Select;
use b\models\SelectProd2opt;
use b\models\Size;
use b\models\Souliste;

class VueAdmin
{
    private $content;

    function __construct($req=null){
        $this->content=$req;
    }
    public function render($id)
    {
        $app= \Slim\Slim::getInstance();
        //initialisation des routes
        $urlAlP=$app->urlFor('AdminlisterProduit', ['trie' => 'tous']);
        $urlAlC=$app->urlFor('AdminlisterCat');
        $urlAlS=$app->urlFor('AdminlisterSousliste');
        $urlAlM=$app->urlFor('AdminlisterMarque');
        $urlAJP=$app->urlFor('AdminajoutProd');
        $urlAJC=$app->urlFor('AdminajoutCat');
        $urlAJS=$app->urlFor('AdminajoutSous');
        $urlAJM=$app->urlFor('AdminajoutMar');
        $urlAcc=$app->urlFor('adminMenu');
        $urlAc=$app->urlFor('accueil');
        $urlAus=$app->urlFor('aboutUs');
        $urlCus=$app->urlFor('contactUS');
        $urlMl=$app->urlFor('MentionLegale');
        $urlCGV=$app->urlFor('CGV');
        $search=$app->urlFor('adminSearch');

        switch ($id){
            case 0:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="admin";
                $banner="";
                $cont="<h1>bienvenue sur votre interface de gestion de BOZART.fr</h1>";
                break;
            case 1:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="Tous les produits";
                $banner="";
                $cont = $this->listerPresation($chemint);
                break;
            case 2:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="ajout d'un produit";
                $banner="";
                $cont = $this->AjoutProduit($chemint);
                break;
            case 3:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="modification d'un produit";
                $banner="";
                $cont = $this->ModfiProduit($chemint);
                break;
            case 4:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Tous les categories";
                $banner="";
                $cont = $this->listerCat($chemint);
                break;
            case 5:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="ajout d'une Categorie";
                $banner="";
                $cont = $this->AjoutCat($chemint);
                break;
            case 6:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="modification d'une Categorie";
                $banner="";
                $cont = $this->ModfiCat($chemint);
                break;
            case 7:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Tous les souslistes";
                $banner="";
                $cont = $this->listerSousliste($chemint);
                break;
            case 8:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="ajout d'une sousliste";
                $banner="";
                $cont = $this->AjoutSousliste($chemint);
                break;
            case 9:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="modification d'une sousliste";
                $banner="";
                $cont = $this->ModfiSousliste($chemint);
                break;
            case 10:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Toutes les marques";
                $banner="";
                $cont = $this->listerMarque($chemint);
                break;
            case 11:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="ajout d'une marque";
                $banner="";
                $cont = $this->AjoutMarque($chemint);
                break;
            case 12:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="modification d'une marque";
                $banner="";
                $cont = $this->ModfiMarque($chemint);
                break;
            case 13:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="modification d'une Palette";
                $banner="";
                $cont = $this->ModfiPalette($chemint);
                break;
            case 14:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $search=$this->content['recherche'];
                $h1="vous avez cherher '$search'";
                $banner="";
                $cont = $this->Search($chemint);
                break;
        }

        //methode qui cree le contenue
        $navbar="";
        //la page html
        $html = <<<END
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Bozart</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<link rel="icon" type="image/png" href="$chemint/images/easel-icon-1.png" />
		<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="themes/images/easel-icon-1.png" /><![endif]-->

		<!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
		<!-- bootstrap -->
		<link href="$cheminb/css/bootstrap.min.css" rel="stylesheet">      
		<link href="$cheminb/css/bootstrap-responsive.min.css" rel="stylesheet">		
		<link href="$chemint/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->
		<link href="$chemint/css/flexslider.css" rel="stylesheet"/>
		<link href="$chemint/css/main.css" rel="stylesheet"/>

		<!-- scripts -->
		<script src="$chemint/js/jquery-1.7.2.min.js"></script>
		<script src="$cheminb/js/bootstrap.min.js"></script>				
		<script src="$chemint/js/superfish.js"></script>	
		<script src="$chemint/js/jquery.scrolltotop.js"></script>
		<!--[if lt IE 9]>			
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>
    <body>
        <p id="templatedirectory" style="display: none">$chemint</p>
		<div id="top-bar" class="container">
		<div class="row">
			<div class="span4b">
				<form method="POST" action="$search" class="search_form">
					<input type="search" name="search" class="input-block-level search-query" Placeholder="Van Gogh">
				</form>
			</div>
			<div class="span8">
				<div class="account pull-right">
				    <ul class="user-menu">		
					    <li ><a href="$urlAc" class="Menucompte">retour au site</a></</li>
				    </ul>
				</div>
			</div>
		</div>
		</div>
		<div id="wrapper" class="container">
			<section class="navbar main-menu">
				<div class="navbar-inner main-menu">
					<a href="$urlAcc" class="logo pull-left"><img src="$chemint/images/logo.png" class="site_logo" alt=""></a>
					<nav id="menu" class="pull-right">
					    <ul>	
                            <li><a href="$urlAlP">ListerProduit</a>
							<li><a href="$urlAJP">ajout Produit </a></li>
							<li><a href="$urlAlM">Lister Marque</a></li>
							<li><a href="$urlAJM">Ajout Marque</a></li>
							<li><a href="$urlAlC">Lister Categorie</a></li>
							<li><a href="$urlAJC">Ajout Categorie</a></li>
							<li><a href="$urlAlS">Lister Sousliste</a></li>
							<li><a href="$urlAJS">Ajout Sousliste</a></li>
                        </ul>	
					</nav>
				</div>
			</section>							
			<section class="header_text sub">
				<img class="pageBanner" src="$chemint/images/banner/$banner" alt="$h1" style="width: 100%" >
				<h1 class="title"><img src="$chemint/images/easel-icon-1.png" alt="Peintures" ><strong>$h1</strong></h1>
			</section>
			<section class="main-content">
			$cont
			</section>
			<section id="footer-bar" >
				<div class="row" id="spanfoot">
					<div class="span3" >
						<h4>BOZART</h4>
						<ul class="nav">
							<li><a href="$urlAus">Qui sommes nous ?</a></li>
							<li><a href="$urlCus">Nous contacter</a></li>
						</ul>					
					</div>
					<div class="span3">
						<h4>A PROPOS</h4>
						<ul class="nav">
							<li><a href="$urlCGV">Conditions générales de ventes</a></li>
							<li><a href="$urlMl">Mentions légales</a></li>
						</ul>
					</div>
					<div class="span3">
						<p class="logo"><img src="$chemint/images/logo.png" class="site_logo" alt=""></p>
						<p>
							<b>Address:</b> 118 Boulevard de la Rochelle, 55000 Bar-le-Duc<br/>
							<b>Phone:</b> 03 29 77 12 34<br/>
							<b>Mobile:</b> 06 80 05 66 45<br/>
							<b>Email:</b> <a href="mailto:contact@bozart.fr">contact@bozart.fr</a>
						</p>
						<div class="social_icons">
							<a class="facebook" href="https://www.facebook.com/Bozart-145441285617240/"><img src="$chemint/images/fb_icon.png"></a>
						</div>
					</div>
				</div>
			</section>
			<section id="copyright">
				<span>Copyright 2017.</span>
			</section>
		</div>
		<script src="$chemint/js/common.js"></script>
		<script>
			$("#mosaique").click(function (event) {
               $('#catalogue .span3,#catalogue .span3S').removeClass("liste");
                $('#catalogue .span3*,#catalogue .span3S').removeClass("product-box");
                $($('#catalogue .span3*,#catalogue .span3S ').children()).removeClass("ligne");
                $($('#catalogue .span3*,#catalogue .span3S ').children()).addClass("product-box");
                $("#mosaique").addClass("press");
                $("#liste").removeClass("press");
            });
            $("#liste").click(function (event) {
                $('#catalogue .span3*,#catalogue .span3S').addClass("liste");
                $('#catalogue .span3*,#catalogue .span3S').addClass("product-box");
                $('#catalogue .span3* div,#catalogue .span3S div').removeClass("product-box");
                $($('#catalogue .span3* ,#catalogue .span3S').children()).addClass("ligne");
                $("#liste").addClass("press");
                $("#mosaique").removeClass("press");
            });
		</script>	
    </body>
</html>
END;


        return $html;
    }
    function listerPresation($chemin){
        $trie=$this->content['trie'];
        $check='';
        $app=\Slim\Slim::getInstance();
        $url=$app->urlFor('AdminlisterProduit', ['trie' => 'tous']);
        if($trie=='tous') {
            $check='check';
        }
        $sous = "<a class='$check' href='$url'>tous</a>";
        $check='';
        $S=Souliste::all();
        $C=Categorie::all();
        foreach ($S as $s){
            $url=$app->urlFor('AdminlisterProduit', ['trie' => $s->nom]);
            if($trie==$s->nom) {
                $check='check';
            }
            $sous.="<a class='$check' href='$url'>$s->nom</a>";
            $check='';
        }
        foreach ($C as $c){
            $url=$app->urlFor('AdminlisterProduit', ['trie' => $c->nom]);
            $s=$c->sousliste()->get();
            if($s->count()==0) {
                if($trie==$c->nom) {
                    $check='check';
                }
                $sous .= "<a class='$check' href='$url'>$c->nom</a>";
            }
            $check='';
        }
        $url=$app->urlFor('AdminlisterProduit', ['trie' => 'sans']);
        if($trie=='sans') {
            $check='check';
        }
        $sous.="<a class='$check' href='$url'>sans Categorie</a>";
        $p=$this->content['produits'];
        $cont="<div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
				<div class='trieProd'>
					$sous
				</div>
                <div class='row'>
					<div class='span9S'>								
						<ul class='thumbnails listing-products' id='catalogue'>";
        //initialisation du contenu

        $nbRes=$p->count();
        $cont=$cont."<h4 class='title'><span>Nos<strong>produit :</strong>resultat($nbRes)</span></h4>";
        $i=1;
        foreach ($p as $item) {
            $promo="";
            $sel=$item->Select()->get();
            if($sel->count()==0){
                $ajout = $app->urlFor('ajProd', ['id' => $item->id]);
                $button="<form id='form1' method='POST' action='$ajout''>
                    <button class='btn btn-inverse' type='submit'>Ajouter au panier</button>
                </form>";
            }else{
                $aPartit="<h3>A Partir de</h3>";
            }
            $sl = $item->sousliste()->first();
            if ($sl != null) {
                $urlcat =$app->urlFor('AdminmodifSous', ['id' => $sl->id]);
                if ($sl->marque == 1) {
                    $m = $item->Marque()->first();
                }
            } else {
                $sl = $item->categorie()->first();
                if($sl!=null) {
                    $urlcat = $app->urlFor('AdminmodifCat', ['id' => $sl->id]);
                }else{
                    $sl=new Categorie();
                    $sl->nom='';
                    $urlcat='';
                }
            }
            if($item->promo==1){
                $promo="<span class='promo sale_tag'><h6>PROMO</h6></span>";
            }
            switch ($sl->nom){
                case 'Acrylique':
                case 'Huile':
                case 'Aquarelle':
                    $urldetail = $app->urlFor('AdminmodifPalette', ['id' => $item->id]);
                    break;
                default:
                    $urldetail = $app->urlFor("AdminmodifProd",['id'=>$item->id]);
                    break;
            }
            $dispo='indisponible.png';
            if($item->disponible==1){
                $dispo='disponible.png';
            }
                $cont = $cont . <<<END
                   <li class="span3S">
						<div class="product-box">
							$promo											
							<a href="$urldetail"><img alt="" src="$chemin/images/Products/$sl->nom/$item->img"></a><br/>
							<div class='desc'>
							    <div class="nom">
									    <img src="$chemin/images/$dispo">
									    <a href="$urldetail" class="title">$item->nom</a><br/>
									</div>
							    <a href="$urlcat" class="category">$sl->nom</a>
							    <p>$item->descCourt</p>
							</div>
							<div class='ApS'>
							    <p class="price">$item->prix €</p>
						    </div>
						 </div>
					</li>
END;
        }
        //on retourne le message
        return $cont.<<<end
                    	</ul>
					</div>
				</div>
end;
        ;

    }
    function ajoutProduit(){
        $se=Select::all();
        $option="<label class='checkbox'>
                un type d'option<br>
                <select class='mySelect' name='select'>
                     <option value='-1' >aucune</option>";
        foreach ($se as $s){
            $option.="<option value='$s->id' >$s->nom</option>";
        }
$option =$option.<<<END
                </select></label>
END;
        $se=Souliste::all();
        $cat="<label class='checkbox'>
                une categorie<br>
                <select class='mySelect' name='Sousliste'>";
        foreach ($se as $s){
            $cat.="<option value='$s->nom' >$s->nom</option>";
        }
        $se=Categorie::all();
        foreach ($se as $s){
            $sous=$s->sousliste()->get();
            if($sous->count()==0) {
                $cat.= "<option value='$s->nom' >$s->nom</option>";
            }
        }
        $cat =$cat.<<<END
                </select></label>
END;
        $se=Marque::all();
        $marque="<label class='checkbox'>
                 une marque<br>
                <select class='mySelect' name='Marque'>
                    <option value='-1' >aucune</option>";
        foreach ($se as $s){
            $marque.="<option value='$s->id'>$s->nom</option>";
        }
        $marque =$marque.<<<END
                </select></label>
END;
        $app= \Slim\Slim::getInstance();
        $url=$app->urlFor("AdminSaveProd");
        $cont=<<<end
             <form method="post" class="ajoutTable" action="$url">
                <fieldset >
                    <legend>detail du produit</legend>
                    nom:<br>
                    <input type="text" name="nom" value=""><br>
                    prix:<br>
                    <input type="number"  step="any" name="prix" value=""><br>
                    description courte:<br>
                     <textarea type="text" name="descCourt" value=""></textarea><br>
                    description longue:<br>
                    <textarea name="descLong" ></textarea><br>
                    image (Dim 300x300 px):<br>
                    <input type="file" name="img" ><br>
                     hauteur:<br>
                    <input type="number"  step="any" name="hauteur" value=""><br>
                     Largeur:<br>
                    <input type="number"  step="any" name="largeur" value=""><br>
                    <label>
                        <input type="checkbox" name="promo" id="cbox1" value="promo">
                        promo
                    </label>
                </fieldset>
                <fieldset >
                    <legend>lier le produit </legend>
                    $cat
                    $marque
                    $option
                </fieldset>
                <input  id="save" type="submit" value="ajouter le Produit">
             </form>
             <h4 class="title"></h4>
end;

    return $cont;
    }
    function ModfiProduit($chenim){
        $p=$this->content['prod'];
        $app= \Slim\Slim::getInstance();
        $c='';
        if($p->promo==1){
            $c='checked';
        }
        $ch='';
        if($p->disponible==1){
            $ch='checked';
        }
        $h=$p->hauteur;
        if($p->hauteur==10000){
            $h='';
        }
        $l=$p->largeur;
        if($p->largeur==10000){
            $l='';
        }
        $se=Select::all();
        $option="<label class='checkbox'>
                un type d'option<br>
                <select class='mySelect' name='select'>
                     <option value='-1' >aucune</option>";
        foreach ($se as $s){
            $option.="<option value='$s->id' >$s->nom</option>";
        }
        $option =$option.<<<END
                </select></label>
END;
        $se=Souliste::all();
        $m=$p->sousliste()->first();
        $oldS='';
        if($m!=null){
            $oldS="<input type='hidden' name='OldSousliste' value='$m->nom'>";
        }
        $cat="<label class='checkbox'>
                une categorie<br>
                <select class='mySelect' name='Sousliste'>
                <option value=''></option>";
        foreach ($se as $s){
            $selected='';
            if($m!=null) {
                if ($s->nom == $m->nom) {
                    $selected = 'selected';
                }
            }
            $cat.="<option value='$s->nom' $selected>$s->nom</option>";
        }
        $m=$p->categorie()->first();
        if($m!=null){
            $oldS="<input type='hidden' name='OldSousliste' value='$m->nom'>";
        }
        $se=Categorie::all();
        foreach ($se as $s){
            $sous=$s->sousliste()->get();
            if($sous->count()==0) {
                $selected='';
                if($m!=null) {
                    if ($s->nom == $m->nom) {
                        $selected = 'selected';
                    }
                }
                $cat.= "<option value='$s->nom' $selected>$s->nom</option>";
            }
        }
        $cat =$cat.<<<END
                </select></label>
                $oldS
END;
        $m=$p->Marque()->first();
        $oldM=-1;
        if($m!=null){
            $oldM=$m->id;
        }
        $se=Marque::all();
        $marque="<label class='checkbox'>
                 une marque<br>
                <input type='hidden' name='MarqueO' value='$oldM'>
                <select class='mySelect' name='Marque'>
                    <option value='-1' >aucune</option>";
        foreach ($se as $s){
            $selected='';
            if($m!=null) {
                if ($s->nom == $m->nom) {
                    $selected = 'selected';
                }
            }
            $marque.="<option value='$s->id' $selected>$s->nom</option>";
        }
        $marque =$marque.<<<END
                </select></label>
END;
        $url=$app->urlFor("AdminUpdateProd",['id'=>1,'prod'=>$p->id,'redirect'=>0]);
        $listeS="<form method='post' class='modif ' action='$url'><br> 
                    $option
                    <input  id='save' type='submit' value='nouvell option'>
                    </form>";
        $s=$p->select()->get();
        foreach ($s as $select){
            $url=$app->urlFor("AdminUpdateProd",['id'=>7,'prod'=>$p->id,'redirect'=>0]);
            $listeS.="<div class='optionUpdate'><form method='post' class='modif ' action='$url'>
                      <input  id='save' type='submit' name='supp' value='X'>
                      <input  id='save' type='hidden' name='select' value='$select->id'>
                      <h5>$select->nom</h5>
                      </form>";
            $o=SelectProd2opt::where('idSelect',"=",$select->id);
            $o=$o->where('idprod',"=",$p->id)->get();
            foreach ($o as $option){
                $url=$app->urlFor("AdminUpdateProd",['id'=>2,'prod'=>$p->id,'redirect'=>0]);
                $listeS.="<form class='listeOption'  method='post'  action='$url'>
                    <input  id='save' type='submit' name='supp' value='X'>
                    nom :
                    <input type='hidden' name='id' value='$select->id'>
                    <input type='hidden' name='oldnom' value='$option->nom'>
                    <input type='text' name='nom' value='$option->nom'>
                    prix :
                    <input type='number'  step='any' name='prix' value='$option->prix'>
                    <input  id='save' type='submit' value='modifier option'>
                    </form>";
            }
            $url=$app->urlFor("AdminUpdateProd",['id'=>3,'prod'=>$p->id,'redirect'=>0]);
            $listeS.="<form method='post' class='modif ' action='$url'>
                    nom :
                    <input type='hidden' name='id' value='$select->id'>
                    <input type='text' name='nom' value=''>
                    prix :
                    <input type='number'  step='any' name='prix' value=''>
                    <input  id='save' type='submit' value='nouvell option'>
                    </form>
                    </div>";
        }

        $url=$app->urlFor("AdminUpdateProd",['id'=>0,'prod'=>$p->id,'redirect'=>0]);
        $url1=$app->urlFor("AdminUpdateProd",['id'=>4,'prod'=>$p->id,'redirect'=>0]);
        $url2=$app->urlFor("AdminUpdateProd",['id'=>5,'prod'=>$p->id,'redirect'=>0]);
        $url3=$app->urlFor("AdminUpdateProd",['id'=>6,'prod'=>$p->id,'redirect'=>0]);
        $cont=<<<End
         <form method="post" class="AsupProd" action="$url3">
            <input  id="save" type="submit" value="Suprimer le Produit">
         </form>
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>detail du produit</legend>
                    nom:<br>
                    <input type="text" name="nom" value="$p->nom"><br>
                    prix:<br>
                    <input type="number"  step="any" name="prix" value="$p->prix"><br>
                    description courte:<br>
                     <textarea type="text" name="descCourt" >$p->descCourt</textarea><br>
                    description longue:<br>
                    <textarea name="descLong" >$p->descLong</textarea><br>
                    image (Dim 300x300 px):<br>
                    <input type="text" name="img" value="$p->img"><br>
                     hauteur:<br>
                    <input type="number"  step="any" name="hauteur" value="$h"><br>
                     Largeur:<br>
                    <input type="number"  step="any" name="largeur" value="$l"><br>
                    <label>
                        <input type="checkbox" name="promo" id="cbox1" value="promo" $c>
                        promo
                    </label>
                    <label>
                        <input type="checkbox" name="disponible" id="cbox1" value="dispo" $ch>
                        en stock
                    </label>
                     <input  id="save" type="submit" value="modifier le Produit">
                </fieldset>
             </form>
             <div> 
                   <fieldset>
                      <legend>detail des options</legend>
                      $listeS
                   </fieldset>
                   <fieldset>
                      <legend>Categorie</legend>
                      <form method='post' class='modif ' action='$url1'>
                        $cat
                        <input  id="save" type="submit" value="modifier le Categorie">
                      </form>
                   </fieldset>
                   <fieldset>
                      <legend>Marque</legend>
                      <form method='post' class='modif ' action='$url2'>                   
                        $marque
                         <input  id="save" type="submit" value="modifier le Marque">
                      </form>
                   </fieldset>
              </div>
             <h4 class="title"></h4>
End;
        return $cont;
    }
    function listerCat($chemin){
        $app=\Slim\Slim::getInstance();
        $m=$this->content['Categories'];
        $nbRes=$m->count();
        $cont=" <div class='row'>
					<div class='span9S'>								
						<h4 class='title'><span>Nos<strong>Categorie :</strong>resultat($nbRes)</span></h4>";
        //initialisation du contenu
        $i=1;
        foreach ($m as $item) {
            $url = $app->urlFor('AdminmodifCat', ['id' => $item->id]);
            $cont = $cont . <<<END
                    <a href="$url">
						<div class="categorie">
							<img src="$chemin/images/banner/$item->BannerO">
							<h1>$item->nom</h1>
						</div>
					</a>
END;
            $i++;
        }
        //on retourne le message
        return $cont.<<<end
					</div>
				</div>
end;
        ;

    }
    function AjoutCat(){
        $app= \Slim\Slim::getInstance();
        $url=$app->urlFor("AdminsaveCat");
        $cont=<<<end
             <form class="ajoutTable" method="post" action="$url">
                <fieldset>
                    <legend>detail de la Categorie</legend>
                    nom:<br>
                    <input type="text" name="nom" ><br>
                    image (Dim 950x150 px):<br>
                    <input type="file" name="Banner" ><br>
                    image sousliste (Dim 950x150 px):<br>
                    <input type="file" name="BannerO" ><br>
                </fieldset>
                <fieldset>
                </fieldset>
                <input  id="save" type="submit" value="ajouter le Produit">
             </form>
             <h4 class="title"></h4>
end;

        return $cont;
    }
    function ModfiCat($chenim){
        $p=$this->content['Categorie'];
        $app= \Slim\Slim::getInstance();
        $url=$app->urlFor("AdminUpdateCat",['id'=>0,'cat'=>$p->id]);
        $cont=<<<End
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>detail de la Categorie</legend>
                    nom:<br>
                    <input type="text" name="nom" value="$p->nom"><br>
                    image (Dim 300x300 px):<br>
                    <input type="text" name="Banner" value="$p->Banner"><br>
                    image sousliste (Dim 950x150 px):<br>
                    <input type="text" name="BannerO" value="$p->BannerO">
                    
                    <input  id="save" type="submit" value="modifier le Categorie">
                </fieldset>
             </form>
             <h4 class="title"></h4>
End;
        return $cont;
    }
    function listerSousliste($chemin){
        $app=\Slim\Slim::getInstance();
        $m=$this->content['Souslistes'];
        $nbRes=$m->count();
        $cont="<div class='row'>
			        <div class='span9S'>								
						<h4 class='title'><span>Nos<strong>Sousliste :</strong>resultat($nbRes)</span></h4>";
        //initialisation du contenu
        $i=1;
        foreach ($m as $item) {
            $url = $app->urlFor('AdminmodifSous', ['id' => $item->id]);
            $cont = $cont . <<<END
						 <a href="$url">
						<div class="categorie">
							<img src="$chemin/images/banner/$item->BannerO">
							<h1>$item->nom</h1>
						</div>
					</a>
					
END;
            $i++;
        }
        //on retourne le message
        return $cont.<<<end
					</div>
				</div>
end;
        ;

    }
    function ajoutSousliste(){
        $cat="<label class='checkbox'>
                une categorie<br>
                <select class='mySelect' name='Categorie'>";
        $se=Categorie::all();
        foreach ($se as $s){
                $cat.= "<option value='$s->id' >$s->nom</option>";

        }
        $cat =$cat.<<<END
                </select></label>
END;
        $app= \Slim\Slim::getInstance();
        $url=$app->urlFor("AdminSaveSous");
        $cont=<<<end
             <form class="ajoutTable" method="post" action="$url">
                <fieldset >
                    <legend>detail de la sousliste</legend>
                    nom:<br>
                    <input type="text" name="nom" value=""><br>
                    <label>
                        <input type="checkbox" name="affichage" id="cbox1" value="Marque">
                        Marque
                    </label>
                </fieldset>
                <fieldset >
                    <legend>lier la sousliste </legend>
                    $cat
                </fieldset>
                <input  id="save" type="submit" value="ajouter la sousliste">
             </form>
             <h4 class="title"></h4>
end;

        return $cont;
    }
    function ModfiSousliste($chemin){
        $p=$this->content['Sousliste'];
        $c=$this->content['cat'];
        $cat="<label class='checkbox'>
                une categorie<br>
                <select class='mySelect' name='Categorie'>";
        $se=Categorie::all();
        $id='';
        foreach ($se as $s){
            if($s->nom==$c->nom) {
                $cat.="<option value='$s->id' selected>$s->nom</option>";
            }else{
                $cat.="<option value='$s->id' >$s->nom</option>";
            }
        }
        $cat =$cat.<<<END
            <input type='hidden' name='OldSousliste' value='$c->id'>
                </select></label>
END;
        $check='';
        if($p->affichage=='marque'){
         $check='checked';
        }
        $app= \Slim\Slim::getInstance();
        $url=$app->urlFor("AdminUpdateSous",['id'=>0,'sous'=>$p->id]);
        $url1=$app->urlFor("AdminUpdateSous",['id'=>1,'sous'=>$p->id]);
        $url2=$app->urlFor("AdminUpdateSous",['id'=>2,'sous'=>$p->id]);
        $cont=<<<End
         <form method="post" class="AsupProd" action="$url2">
            <input  id="save" type="submit" value="Suprimer le Produit">
         </form>
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>detail de la Categorie</legend>
                    nom:<br>
                    <input type="text" name="nom" value="$p->nom">
                    <br>
                    <label>
                        <input type="checkbox" name="affichage" id="cbox1" value="Marque" $check>
                        Marque
                    </label>
                    <input  id="save" type="submit" value="modifier le Categorie">
                </fieldset>
             </form>
             <div> 
                   <fieldset>
                      <legend>Categorie</legend>
                      <form method='post' class='modif ' action='$url1'>
                        $cat
                        <input  id="save" type="submit" value="modifier le Categorie">
                      </form>
                   </fieldset>
             </div>
             <h4 class="title"></h4>
End;
        return $cont;
    }
    function listerMarque($chemin){
        $app=\Slim\Slim::getInstance();
        $button="";
        $m=$this->content['Marques'];
        $nbRes=$m->count();
        $cont="
                <div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
				<div class='trieoption'>
					<a href='#col'>Trier les produits</a>
				</div>
                <div class='row'>
					<div class='span9S'>								
						<ul class='thumbnails listing-products' id='catalogue'>
						<h4 class='title'><span>Nos<strong>Marques :</strong>resultat($nbRes)</span></h4>";
        //initialisation du contenu


        $i=1;
        foreach ($m as $item) {
            $url = $app->urlFor('AdminmodifMar', ['id' => $item->id]);
            $cont = $cont . <<<END
                   <li class="span3S">
						<div class="product-box">
							<span class="sale_tag"></span>												
							<a href="$url"><img alt="" src="$chemin/images/Marque/$item->img"></a><br/>
							<div class='desc'>
							    <a href="$url" class="title">$item->nom</a><br/>
							</div>
							<div class='ApS'>
							    <p class="price"></p>
						    </div>				
						</div>
					</li>
END;
            $i++;
        }
        //on retourne le message
        return $cont.<<<end
                    	</ul>
					</div>
				</div>
end;
        ;
    }
    function ajoutMarque(){
        $se=Souliste::all();
        $cat="<label class='checkbox'>
                une categorie<br>
                <select class='mySelect' name='Sousliste'>
                <option value='' > </option>";
        foreach ($se as $s){
            $cat.="<option value='$s->nom' >$s->nom</option>";
        }
        $cat =$cat.<<<END
        </select></label>
END;
        $app= \Slim\Slim::getInstance();
        $url=$app->urlFor("AdminSaveMar");
        $cont=<<<end
             <form class="ajoutTable" method="post" action="$url">
                <fieldset >
                    <legend>detail de la marque</legend>
                    nom:<br>
                    <input type="text" name="nom" value=""><br>
                    image (Dim 300x300 px):<br>
                    <input type="file" name="img" ><br>
                     petite image(Dim 120x45 px):<br>
                    <input type="file" name="imgSmall" ><br>
                    </fieldset>
                <fieldset >
                    <legend>lier la marque </legend>
                    $cat
                </fieldset>
                <input  id="save" type="submit" value="ajouter la Marque">
             </form>
             <h4 class="title"></h4>
end;

        return $cont;
    }
    function ModfiMarque($chemin){
        $app= \Slim\Slim::getInstance();
        $m=$this->content['Marque'];
        $Sous=$m->sousliste()->get();
        $ListeS='';
        foreach ($Sous as $s){
            $url=$app->urlFor("AdminUpdateMar",['id'=>3,'mar'=>$m->id]);
            $ListeS.="<form class='ajoutTable' method='post' action='$url'>
                      <input type='submit' value='X'>
                      <input type='hidden' name='Sousliste' value='$s->id'>
                      $s->nom
                      </form>";
        }
        $cat="<label class='checkbox'>
                une categorie<br>
                <select class='mySelect' name='Sousliste'>";
        $se=Souliste::all();
        foreach ($se as $s){
                $cat.="<option value='$s->id' >$s->nom</option>";
        }
        $cat =$cat.<<<END
                </select></label>
END;

        $url=$app->urlFor("AdminUpdateMar",['id'=>0,'mar'=>$m->id]);
        $url1=$app->urlFor("AdminUpdateMar",['id'=>1,'mar'=>$m->id]);
        $url2=$app->urlFor("AdminUpdateMar",['id'=>2,'mar'=>$m->id]);
        $cont=<<<End
         <form method="post" class="AsupProd" action="$url2">
            <input  id="save" type="submit" value="Suprimer le Produit">
         </form>
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>detail de la Categorie</legend>
                    nom:<br>
                    <input type="text" name="nom" value="$m->nom">
                    <br>
                    image (Dim 300x300 px):<br>
                    <input type="text" name="img" value="$m->img"><br>
                    petite image(Dim 120x45 px):<br>
                    <input type="text" name="imgSmall" value="$m->imgSmall"><br>
                    <input  id="save" type="submit" value="modifier le Categorie">
                </fieldset>
             </form>
             <div> 
                   <fieldset>
                      <legend>Categorie</legend>
                      $ListeS
                      <form method='post' class='modif ' action='$url1'>
                        $cat
                        <input  id="save" type="submit" value="new le Categorie">
                      </form>
                   </fieldset>
             </div>
             <h4 class="title"></h4>
End;
        return $cont;
    }
    function ModfiPalette($chenim){
        $p=$this->content['prod'];
        $co=$this->content['color'];
        $app= \Slim\Slim::getInstance();
        $c='';
        if($p->promo==1){
            $c='checked';
        }
        $ch='';
        if($p->disponible==1){
            $ch='checked';
        }
        $se=Color::all();
        $color="<label class='checkbox'>
                nos Couleur<br>
                <select class='mySelect' name='color'>";
        foreach ($se as $s){
            $color.="<option value='$s->id' >$s->nom</option>";
        }
        $color =$color.<<<END
                </select></label>
END;
        $se=Size::all();
        $size="<label class='checkbox'>
                nos Conditionement<br>
                <select class='mySelect' name='size'>";
        foreach ($se as $s){
            $size.="<option value='$s->id' >$s->serie $s->taille $s->prix</option>";
        }
        $size =$size.<<<END
                </select></label>
END;
        $se=Souliste::all();
        $m=$p->sousliste()->first();
        $oldS='';
        if($m!=null){
            $oldS="<input type='hidden' name='OldSousliste' value='$m->nom'>";
        }
        $cat="<label class='checkbox'>
                une categorie<br>
                <select class='mySelect' name='Sousliste'>";
        foreach ($se as $s){
            $selected='';
            if($m!=null) {
                if ($s->nom == $m->nom) {
                    $selected = 'selected';
                }
            }
            $cat.="<option value='$s->nom' $selected>$s->nom</option>";
        }
        $m=$p->categorie()->first();
        if($m!=null){
            $oldS="<input type='hidden' name='OldSousliste' value='$m->nom'>";
        }
        $se=Categorie::all();
        foreach ($se as $s){
            $sous=$s->sousliste()->get();
            if($sous->count()==0) {
                $selected='';
                if($m!=null) {
                    if ($s->nom == $m->nom) {
                        $selected = 'selected';
                    }
                }
                $cat.= "<option value='$s->nom' $selected>$s->nom</option>";
            }
        }
        $cat =$cat.<<<END
                </select></label>
                $oldS
END;
        $m=$p->Marque()->first();
        $oldM=-1;
        if($m!=null){
            $oldM=$m->id;
        }
        $se=Marque::all();
        $marque="<label class='checkbox'>
                 une marque<br>
                <input type='hidden' name='MarqueO' value='$oldM'>
                <select class='mySelect' name='Marque'>
                    <option value='-1' >aucune</option>";
        foreach ($se as $s){
            $selected='';
            if($m!=null) {
                if ($s->nom == $m->nom) {
                    $selected = 'selected';
                }
            }
            $marque.="<option value='$s->id' $selected>$s->nom</option>";
        }
        $marque =$marque.<<<END
                </select></label>
END;
        $url=$app->urlFor("AdminUpdateProd",['id'=>8,'prod'=>$p->id,'redirect'=>1]);
        $listeS="<form method='post' class='modif ' action='$url'><br> 
                    $color
                    <input  id='save' type='submit' value='nouvell Couleur'>
                    </form>";
        foreach ($co as $color){
            $url=$app->urlFor("AdminUpdateProd",['id'=>9,'prod'=>$p->id,'redirect'=>1]);
            $listeS.="<div class='optionUpdate'><form method='post' class='modif ' action='$url'>
                      <input  id='save' type='submit' name='supp' value='X'>
                      <input  id='save' type='hidden' name='color' value='$color->id'>
                      <h5>$color->nom</h5>
                      </form>";
            $o=C2S::where('idColor',"=",$color->id);
            $o=$o->where('idprod',"=",$p->id)->get();
            foreach ($o as $option){
                $cond=Size::find($option->idSize);
                $url=$app->urlFor("AdminUpdateProd",['id'=>10,'prod'=>$p->id,'redirect'=>1]);
                $listeS.="<form class='listeOption'  method='post'  action='$url'>
                    <input  id='save' type='submit' name='supp' value='X'>
                    <input type='hidden' name='color' value='$option->idColor'>
                    <input type='hidden' name='size' value='$option->idSize'>
                    serie : $cond->serie  taille : $cond->taille  prix : $cond->prix
                    </form>";
            }
            $url=$app->urlFor("AdminUpdateProd",['id'=>11,'prod'=>$p->id,'redirect'=>1]);
            $listeS.="<form method='post' class='modif ' action='$url'>
                      <input type='hidden' name='color' value='$color->id'>
                      $size
                      <input  id='save' type='submit' value='nouveau Conditionnement'>
                      </form>
                      </div>";
        }

        $url=$app->urlFor("AdminUpdateProd",['id'=>0,'prod'=>$p->id,'redirect'=>1]);
        $url1=$app->urlFor("AdminUpdateProd",['id'=>4,'prod'=>$p->id,'redirect'=>1]);
        $url2=$app->urlFor("AdminUpdateProd",['id'=>5,'prod'=>$p->id,'redirect'=>1]);
        $url3=$app->urlFor("AdminUpdateProd",['id'=>6,'prod'=>$p->id,'redirect'=>1]);
        $cont=<<<End
         <form method="post" class="AsupProd" action="$url3">
            <input  id="save" type="submit" value="Suprimer le Produit">
         </form>
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>detail du produit</legend>
                    nom:<br>
                    <input type="text" name="nom" value="$p->nom"><br>
                    prix:<br>
                    <input type="number"  step="any" name="prix" value="$p->prix"><br>
                    description courte:<br>
                     <textarea type="text" name="descCourt" >$p->descCourt</textarea><br>
                    description longue:<br>
                    <textarea name="descLong" >$p->descLong</textarea><br>
                    image (Dim 300x300 px):<br>
                    <input type="text" name="img" value="$p->img"><br>
                    <label>
                        <input type="checkbox" name="promo" id="cbox1" value="promo" $c>
                        promo
                    </label>
                    <label>
                        <input type="checkbox" name="disponible" id="cbox1" value="dispo" $ch>
                        en stock
                    </label>
                     <input  id="save" type="submit" value="modifier le Produit">
                </fieldset>
             </form>
              <div> 
                   <fieldset>
                      <legend>detail des Palette</legend>
                      $listeS
                   </fieldset>
                   <fieldset>
                      <legend>Categorie</legend>
                      <form method='post' class='modif ' action='$url1'>
                        $cat
                        <input  id="save" type="submit" value="modifier le Categorie">
                      </form>
                   </fieldset>
                   <fieldset>
                      <legend>Marque</legend>
                      <form method='post' class='modif ' action='$url2'>                   
                        $marque
                         <input  id="save" type="submit" value="modifier le Marque">
                      </form>
                   </fieldset>
              </div>
             <h4 class="title"></h4>
End;
        return $cont;
    }
    function Search($chemin){

        $app=\Slim\Slim::getInstance();
        $p=$this->content['produits'];
        $cont="<div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
                <div class='row'>
					<div class='span9S'>								
						<ul class='thumbnails listing-products' id='catalogue'>";
        //initialisation du contenu

        $nbRes=$p->count();
        $cont=$cont."<h4 class='title'><span>Nos<strong>produit :</strong>resultat($nbRes)</span></h4>";
        foreach ($p as $item) {
            $promo="";
            $sl = $item->sousliste()->first();
            if ($sl != null) {
                $urlcat =$app->urlFor('AdminmodifSous', ['id' => $sl->id]);
                if ($sl->marque == 1) {
                    $m = $item->Marque()->first();
                }
            } else {
                $sl = $item->categorie()->first();
                if($sl!=null) {
                    $urlcat = $app->urlFor('AdminmodifCat', ['id' => $sl->id]);
                }else{
                    $sl=new Categorie();
                    $sl->nom='';
                    $urlcat='';
                }
            }
            if($item->promo==1){
                $promo="<span class='promo sale_tag'><h6>PROMO</h6></span>";
            }
            switch ($sl->nom){
                case 'Acrylique':
                case 'Huile':
                case 'Aquarelle':
                    $urldetail = $app->urlFor('AdminmodifPalette', ['id' => $item->id]);
                    break;
                default:
                    $urldetail = $app->urlFor("AdminmodifProd",['id'=>$item->id]);
                    break;
            }
            $dispo='indisponible.png';
            if($item->disponible==1){
                $dispo='disponible.png';
            }
            $cont = $cont . <<<END
                   <li class="span3S">
						<div class="product-box">
							$promo											
							<a href="$urldetail"><img alt="" src="$chemin/images/Products/$sl->nom/$item->img"></a><br/>
							<div class='desc'>
							    <div class="nom">
									    <img src="$chemin/images/$dispo">
									    <a href="$urldetail" class="title">$item->nom</a><br/>
									</div>
							    <a href="$urlcat" class="category">$sl->nom</a>
							    <p>$item->descCourt</p>
							</div>
							<div class='ApS'>
							    <p class="price">$item->prix €</p>
						    </div>
						 </div>
					</li>
END;
        }
        //on retourne le message
        return $cont.<<<end
                    	</ul>
					</div>
				</div>
end;
        ;

    }

}