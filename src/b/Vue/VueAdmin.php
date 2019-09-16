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
use b\models\Client;
use b\models\Color;
use b\models\Contient;
use b\models\imageadditionnelle;
use b\models\Marque;
use b\models\Panier;
use b\models\Select;
use b\models\SelectProd2opt;
use b\models\Size;
use b\models\Souliste;
use b\models\TypeColor;

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

        $urlAcc=$app->urlFor('adminMenu');
        $urlAc=$app->urlFor('accueil');
        $urlAus=$app->urlFor('aboutUs');
        $urlCus=$app->urlFor('contactUS');
        $urlMl=$app->urlFor('MentionLegale');
        $urlCGV=$app->urlFor('CGV');
        $search=$app->urlFor('adminSearch');
        $banner="pageBannerA.jpg";
        switch ($id){
            case 0:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="admin";
                $cont=$this->accueil($chemint);
                break;
            case 1:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="Liste Des produits";
                $cont = $this->listerPresation($chemint);
                break;
            case 2:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Ajout d'un produit";
                $cont = $this->AjoutProduit($chemint);
                break;
            case 3:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="Modification d'un produit";
                $cont = $this->ModfiProduit($chemint);
                break;
            case 4:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Liste des categories";
                $cont = $this->listerCat($chemint);
                break;
            case 5:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Ajout d'une Categorie";
                $cont = $this->AjoutCat($chemint);
                break;
            case 6:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="Modification d'une Categorie";
                $cont = $this->ModfiCat($chemint);
                break;
            case 7:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Liste des souslistes";
                $cont = $this->listerSousliste($chemint);
                break;
            case 8:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Ajout d'une sousliste";
                $cont = $this->AjoutSousliste($chemint);
                break;
            case 9:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="Modification d'une sousliste";
                $cont = $this->ModfiSousliste($chemint);
                break;
            case 10:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="liste des marques";
                $cont = $this->listerMarque($chemint);
                break;
            case 11:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Ajout d'une marque";
                $cont = $this->AjoutMarque($chemint);
                break;
            case 12:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="Modification d'une marque";
                $banner="";
                $cont = $this->ModfiMarque($chemint);
                break;
            case 13:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="Modification d'une Palette";
                $banner="";
                $cont = $this->ModfiPalette($chemint);
                break;
            case 14:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $searchWord=$this->content['recherche'];
                $h1="vous avez cherher '$searchWord'";
                $cont = $this->Search($chemint);
                break;
            case 15:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="liste des Couleurs";
                $cont = $this->listerColor($chemint);
                break;
            case 16:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Ajout d'une Couleur";
                $cont = $this->AjoutColor($chemint);
                break;
            case 17:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="Modif d'une Couleur";
                $cont = $this->ModifColor($chemint);
                break;
            case 18:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Liste des Conditionements";
                $cont = $this->listerCond($chemint);
                break;
            case 19:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Ajout d'un Conditionement";
                $cont = $this->AjoutCond($chemint);
                break;
            case 20:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $h1="Modif d'un Conditionement";
                $cont = $this->ModifCond($chemint);
                break;
            case 21:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Liste des Comptes";
                $cont = $this->listerCompte($chemint);
                break;
            case 22:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $compte=$this->content['Client'];
                $h1="Détail du Compte:<br> $compte->mail";
                $cont = $this->ClientD($chemint);
                break;
            case 23:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $h1="Liste des paniers";
                $cont = $this->listerPanier($chemint);
                break;
            case 24:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $compte=$this->content['Panier'];
                $h1="Détail du Panier:<br> $compte->date";
                $cont = $this->PanierD($chemint);
                break;
        }

        //methode qui cree le contenue
        $navbar="";
        //la page html
        $html = <<<END
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Bozart : Admin</title>
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
							<li><a href="$urlAus">Qui sommes-nous ?</a></li>
							<li><a href="$urlCus">Nous contacter</a></li>
						</ul>					
					</div>
					<div class="span3">
						<h4>À PROPOS</h4>
						<ul class="nav">
							<li><a href="$urlCGV">Conditions générales de ventes</a></li>
							<li><a href="$urlMl">Mentions légales</a></li>
						</ul>
					</div>
					<div class="span3">
						<p class="logo"><img src="$chemint/images/logo.png" class="site_logo" alt=""></p>
						<p>
							<b>Adresse :</b> 118 Boulevard de la Rochelle, 55000 Bar-le-Duc<br/>
							<b>Téléphone :</b> 03 29 77 12 34<br/>
							<b>Mobile :</b> 06 80 05 66 45<br/>
							<b>E-mail:</b> <a href="mailto:contact@bozart.fr">contact@bozart.fr</a>
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
    function accueil($chemin){
        $app=\Slim\Slim::getInstance();
        $urlAlP=$app->urlFor('AdminlisterProduit', ['trie' => 'tous']);
        $urlAlC=$app->urlFor('AdminlisterCat');
        $urlAlS=$app->urlFor('AdminlisterSousliste');
        $urlAlM=$app->urlFor('AdminlisterMarque');
        $urlAlCol=$app->urlFor('AdminlisterCol');
        $urlAlCond=$app->urlFor('AdminlisterCond');
        $urlAlCom=$app->urlFor('AdminlisterCompte');
        $urlAlPan=$app->urlFor('AdminlisterPanier');
        $urlAJP=$app->urlFor('AdminajoutProd');
        $urlAJC=$app->urlFor('AdminajoutCat');
        $urlAJS=$app->urlFor('AdminajoutSous');
        $urlAJM=$app->urlFor('AdminajoutMar');
        $urlAJCol=$app->urlFor('AdminajoutCol');
        $urlAJCond=$app->urlFor('AdminajoutCond');
        return <<<end
                    <a href="$urlAlP">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Liste des produits</h1>
						</div>
					</a>
					 <a href="$urlAJP">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Ajout d'un produit</h1>
						</div>
					</a>
					 <a href="$urlAlC">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Liste des categories</h1>
						</div>
					</a>
					 <a href="$urlAJC">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Ajout d'une categorie</h1>
						</div>
					</a>
					 <a href="$urlAlS">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Liste des souslistes</h1>
						</div>
					</a>
					 <a href="$urlAJS">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Ajout d'une sousliste</h1>
						</div>
					</a>
					 <a href="$urlAlM">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Liste des marques</h1>
						</div>
					</a>
					 <a href="$urlAJM">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Ajout d'une marque</h1>
						</div>
					</a>
					<a href="$urlAlCol">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Liste des couleurs</h1>
						</div>
					</a>
					 <a href="$urlAJCol">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Ajout d'une Couleur </h1>
						</div>
					</a>
					<a href="$urlAlCond">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Liste des conditionements</h1>
						</div>
					</a>
					 <a href="$urlAJCond">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Ajout d'un conditionement</h1>
						</div>
					</a>
					<a href="$urlAlCom">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Liste des comptes</h1>
						</div>
					</a>
					 <a href="$urlAlPan">
						<div class="categorie">
							<img src="$chemin/images/banner/pageBannerASousliste.jpg">
							<h1>Liste des paniers</h1>
						</div>
					</a>
                    <h4 class='title'></h4>
end;


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
        $cont=$cont."<h4 class='title'><span>Nos <strong>produits : </strong>résultat($nbRes)</span></h4>";
        $i=1;
        $catalogue="";
        foreach ($p as $item) {
            $promo="";
            $sel=$item->Select()->get();
            if($sel->count()==0){
                $ajout = $app->urlFor('ajProd', ['id' => $item->id]);
                $button="<form id='form1' method='POST' action='$ajout''>
                    <button class='btn btn-inverse' type='submit'>Ajouter au panier</button>
                </form>";
            }else{
                $aPartit="<h3>À partir de</h3>";
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
            if(($sl->nom!='')&&($urlcat!='')) {
                $catalogue = $catalogue . <<<END
                   <li class="span3S">
						<div class="product-box">
							$promo											
							<a href="$urldetail"><img alt="" src="$chemin/images/Products/all/$item->img"></a><br/>
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
            }else{
                $cont = $cont . <<<END
                   <li class="span3S">
						<div class="product-box">
							$promo											
							<a href="$urldetail"><img alt="" src="$chemin/images/Products/all/$item->img"></a><br/>
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
        }
        //on retourne le message
        return $cont.$catalogue.<<<end
                    	</ul>
					</div>
				</div>
end;
        ;

    }
    function ajoutProduit(){
        $se=Select::all();
        $option="<label class='checkbox'>
                Un type d'option<br>
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
                Une categorie<br>
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
                 Une marque<br>
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
                    <legend>Détail du produit</legend>
                    Nom:<br>
                    <input type="text" name="nom" value=""><br>
                    Prix:<br>
                    <input type="number"  step="any" name="prix" value=""><br>
                    Description courte:<br>
                     <textarea type="text" name="descCourt" value=""></textarea><br>
                    Description longue:<br>
                    <textarea name="descLong" ></textarea><br>
                    Image (Dim 300x300 px):<br>
                    <input type="file" name="img" ><br>
                     Hauteur (mm) :<br>
                    <input type="number"  step="any" name="hauteur" value=""><br>
                     Largeur (mm) :<br>
                    <input type="number"  step="any" name="largeur" value=""><br>
                    EAN :<br>
                    <input type="text" name="EAN" value=""><br>
                    <label>
                        <input type="checkbox" name="promo" id="cbox1" value="promo">
                        Promo
                    </label>
                </fieldset>
                <fieldset >
                    <legend>Lier le produit </legend>
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
                Un type d'option<br>
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
                Une categorie<br>
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
                 Une marque<br>
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
            $listeS.="<div class='optionUpdate'>
                        <form method='post' class='modif ' action='$url'>
                            <input  id='save' type='submit' name='supp' value='X'>
                            <input  id='save' type='hidden' name='select' value='$select->id'>
                            <h5>$select->nom</h5>
                        </form>";
            $o=SelectProd2opt::where('idSelect',"=",$select->id);
            $o=$o->where('idprod',"=",$p->id)->get();
            foreach ($o as $option){

                if(($select->id>=2)&&($select->id<=5)){
                    $prix=" Prix : $option->prix";
                    $i=" ( sous se format 'Dim ?x?')";
                }else{
                    $prix=" Prix :
                            <input type='number'  step='any' name='prix' value='$option->prix'>";
                    $i='';
                }
                $url=$app->urlFor("AdminUpdateProd",['id'=>2,'prod'=>$p->id,'redirect'=>0]);
                $listeS.="<form class='listeOption'  method='post'  action='$url'>
                            <input  id='save' type='submit' name='supp' value='X'>
                            Nom $i :
                            <input type='hidden' name='id' value='$select->id'>
                            <input type='hidden' name='oldnom' value='$option->nom'>
                            <input type='text' name='nom' value='$option->nom'>
                            $prix €
                            <input  id='save' type='submit' value='modifier option'>
                         </form>";
            }
            if(($select->id>=2)&&($select->id<=5)){
                $np=' ';
            }else{
                $np="Prix :
                            <input type='number'  step='any' name='prix' value=''>";
            }
            $url=$app->urlFor("AdminUpdateProd",['id'=>3,'prod'=>$p->id,'redirect'=>0]);
            $listeS.="    <form method='post' class='modif ' action='$url'>
                            Nom :
                            <input type='hidden' name='id' value='$select->id'>
                            <input type='text' name='nom' value=''>
                            $np
                            <input  id='save' type='submit' value='nouvell option'>
                        </form>
                    </div>";
        }
        $imageADD="<div class='optionUpdate'>";
        $imgs=imageadditionnelle::where('idProduit','=',$p->id)->get();
        foreach ($imgs as $i){
            $url=$app->urlFor("AdminUpdateProd",['id'=>12,'prod'=>$p->id,'redirect'=>0]);
            $imageADD.="    <form method='post' class='modif' action='$url'>
                                <input  id='save' type='submit' name='supp' value='X'>
                                Nom :
                                <input  id='save' type='text' name='nom' value='$i->nom'>
                                <input  id='save' type='hidden' name='Onom' value='$i->nom'>
                                Description :
                                <input  id='save' type='test' name='descImg' value='$i->descImg'>
                                <input  id='save' type='hidden' name='OdescImg' value='$i->descImg'>
                                <input  id='save' type='submit' value='modifier image'>
                            </form>";
        }
        $url=$app->urlFor("AdminUpdateProd",['id'=>13,'prod'=>$p->id,'redirect'=>0]);
        $imageADD.="</div>
                    <form method='post' class='modif ' action='$url'>
                    Nom :
                    <input type='text' name='nom' value=''>
                    Description :
                    <input type='text' name='descImg' value=''>
                    <input  id='save' type='submit' value='nouvelle image'>
                    </form>
                    ";
        $urlR=$app->urlFor('AdminlisterProduit', ['trie' => 'tous']);
        $url=$app->urlFor("AdminUpdateProd",['id'=>0,'prod'=>$p->id,'redirect'=>0]);
        $url1=$app->urlFor("AdminUpdateProd",['id'=>4,'prod'=>$p->id,'redirect'=>0]);
        $url2=$app->urlFor("AdminUpdateProd",['id'=>5,'prod'=>$p->id,'redirect'=>0]);
        $url3=$app->urlFor("AdminUpdateProd",['id'=>6,'prod'=>$p->id,'redirect'=>0]);
        $cont=<<<End
        <a href="$urlR">Retour au catalogue des Produit</a>
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>Détail du produit</legend>
                    Nom:<br>
                    <input type="text" name="nom" value="$p->nom"><br>
                    Prix:<br>
                    <input type="number"  step="any" name="prix" value="$p->prix"><br>
                    Description courte:<br>
                     <textarea type="text" name="descCourt" >$p->descCourt</textarea><br>
                    Description longue:<br>
                    <textarea name="descLong" >$p->descLong</textarea><br>
                    Image (Dim 300x300 px):<br>
                    <input type="text" name="img" value="$p->img"><br>
                     Hauteur (mm) :<br>
                    <input type="number"  step="any" name="hauteur" value="$h"><br>
                     Largeur (mm) :<br>
                    <input type="number"  step="any" name="largeur" value="$l"><br>
                    EAN :<br>
                    <input type="text" name="EAN" value="$p->EAN"><br>
                    <label>
                        <input type="checkbox" name="promo" id="cbox1" value="promo" $c>
                        Promo
                    </label>
                    <label>
                        <input type="checkbox" name="disponible" id="cbox1" value="dispo" $ch>
                        En stock
                    </label>
                     <input  id="save" type="submit" value="modifier le Produit">
                </fieldset>
             </form>
             <div> 
                   <fieldset>
                      <legend>Détail des images</legend>
                      $imageADD
                   </fieldset>
                   <fieldset>
                      <legend>Détail des options</legend>
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
              <form method="post" class="AsupProd" action="$url3">
                <input  id="save" type="submit" value="Suprimer le Produit">
              </form>
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
						<h4 class='title'><span>Nos <strong>categorie : </strong>resultat($nbRes)</span></h4>";
        //initialisation du contenu
        $i=1;
        foreach ($m as $item) {
            $url = $app->urlFor('AdminmodifCat', ['id' => $item->id]);
            $cont = $cont . <<<END
                    <a href="$url">
						<div class="categorie">
							<img src="$chemin/images/banner/$item->Banner">
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
                    <legend>Détail de la Categorie</legend>
                    Nom:<br>
                    <input type="text" name="nom" ><br>
                    Image (Dim 950x150 px):<br>
                    <input type="file" name="Banner" ><br>
                    Image sousliste (Dim 950x150 px):<br>
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
        $urlR=$app->urlFor('AdminlisterCat');
        $cont=<<<End
        <a href="$urlR">Retour à la liste des categories</a>
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>Détail de la Categorie</legend>
                    Nom:<br>
                    <input type="text" name="nom" value="$p->nom"><br>
                    Image (Dim 300x300 px):<br>
                    <input type="text" name="Banner" value="$p->Banner"><br>
                    Image sousliste (Dim 950x150 px):<br>
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
						<h4 class='title'><span>Nos <strong>sousliste : </strong>résultat($nbRes)</span></h4>";
        //initialisation du contenu
        $i=1;
        foreach ($m as $item) {
            $url = $app->urlFor('AdminmodifSous', ['id' => $item->id]);
            $cat=$item->categorie()->first();
            $cont = $cont . <<<END
						 <a href="$url">
						<div class="categorie">
							<img src="$chemin/images/banner/$cat->BannerO">
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
                    <legend>Détail de la sousliste</legend>
                    Nom:<br>
                    <input type="text" name="nom" value=""><br>
                    <label>
                        <input type="checkbox" name="affichage" id="cbox1" value="Marque">
                        Marque
                    </label>
                </fieldset>
                <fieldset >
                    <legend>Lier la sousliste </legend>
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
        $urlR=$app->urlFor('AdminlisterSousliste');
        $cont=<<<End
         <a href="$urlR"> retour au catalogue des souslistes</a>
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>Détail de la sousliste</legend>
                    Nom:<br>
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
             <form method="post" class="AsupProd" action="$url2">
                <input  id="save" type="submit" value="Suprimer la Sousliste">
             </form>
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
                <div class='row'>
					<div class='span9S'>								
						<ul class='thumbnails listing-products' id='catalogue'>
						<h4 class='title'><span>Nos <strong>marques : </strong>résultat($nbRes)</span></h4>";
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
                    <legend>Détail de la marque</legend>
                    Nom:<br>
                    <input type="text" name="nom" value=""><br>
                    Image (Dim 300x300 px):<br>
                    <input type="file" name="img" ><br>
                    Petite image(Dim 120x45 px):<br>
                    <input type="file" name="imgSmall" ><br>
                    </fieldset>
                <fieldset >
                    <legend>Lier la marque </legend>
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
        $urlR=$app->urlFor('AdminlisterMarque');
        $cont=<<<End
        <a href="$urlR"> retour au catalogue des Marques</a>
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>Détail de la Marque</legend>
                    Nom:<br>
                    <input type="text" name="nom" value="$m->nom">
                    <br>
                    Image (Dim 300x300 px):<br>
                    <input type="text" name="img" value="$m->img"><br>
                    Petite image(Dim 120x45 px):<br>
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
             <form method="post" class="AsupProd" action="$url2">
                <input  id="save" type="submit" value="Suprimer la Marque">
             </form>
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
                Nos Couleurs<br>
                <select class='mySelect' name='color'>";
        foreach ($se as $s){
            $color.="<option value='$s->id' >$s->nom ($s->marque)</option>";
        }
        $color =$color.<<<END
                </select></label>
END;
        $se=Size::all();
        $size="<label class='checkbox'>
                Nos Conditionements<br>
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
                      <h5>$color->nom ($color->marque)</h5>
                      </form>";
            $o=C2S::where('idColor',"=",$color->id)->get();
            foreach ($o as $option){
                $cond=Size::find($option->idSize);
                $url=$app->urlFor("AdminUpdateProd",['id'=>10,'prod'=>$p->id,'redirect'=>1]);
                $listeS.="<form class='listeOption'  method='post'  action='$url'>
                    <input  id='save' type='submit' name='supp' value='X'>
                    <input type='hidden' name='color' value='$option->idColor'>
                    <input type='hidden' name='size' value='$option->idSize'>
                    Serie : $cond->serie  Taille : $cond->taille  Prix : $cond->prix
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
        $urlR=$app->urlFor('AdminlisterProduit', ['trie' => 'tous']);
        $cont=<<<End
         <a href="$urlR">Retour au catalogue des Produits</a>
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>Détail du produit</legend>
                    Nom:<br>
                    <input type="text" name="nom" value="$p->nom"><br>
                    Prix:<br>
                    <input type="number"  step="any" name="prix" value="$p->prix"><br>
                    Description courte:<br>
                    <textarea type="text" name="descCourt" >$p->descCourt</textarea><br>
                    Description longue:<br>
                    <textarea name="descLong" >$p->descLong</textarea><br>
                    Image (Dim 300x300 px):<br>
                    <input type="text" name="img" value="$p->img"><br>
                    <label>
                        <input type="checkbox" name="promo" id="cbox1" value="promo" $c>
                        Promo
                    </label>
                    <label>
                        <input type="checkbox" name="disponible" id="cbox1" value="dispo" $ch>
                        En stock
                    </label>
                     <input  id="save" type="submit" value="modifier le Produit">
                </fieldset>
             </form>
              <div> 
                   <fieldset>
                      <legend>Détail des Palettes</legend>
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
              <form method="post" class="AsupProd" action="$url3">
                <input  id="save" type="submit" value="Suprimer le Produit">
              </form>
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
        $ean=$this->content['ean'];
        $nbRes=$ean->count();
        $cont=$cont."<h4 class='title'><span>Nos<strong> produit par EAN : </strong>résultat($nbRes)</span></h4>";
        foreach ($ean as $item) {
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
							<a href="$urldetail"><img alt="" src="$chemin/images/Products/all/$item->img"></a><br/>
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
        $nbRes=$p->count();
        $cont=$cont."<h4 class='title'><span>Nos<strong> produit : </strong>résultat($nbRes)</span></h4>";
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
							<a href="$urldetail"><img alt="" src="$chemin/images/Products/all/$item->img"></a><br/>
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

    function listerColor($chemin){
        $app=\Slim\Slim::getInstance();
        $button="";
        $m=$this->content['Color'];
        $nbRes=$m->count();
        $cont="
                <div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
				
                <div class='row'>
					<div class='span9S'>								
						<ul class='thumbnails listing-products' id='catalogue'>
						<h4 class='title'><span>Nos <strong>Couleurs : </strong>résultat($nbRes)</span></h4>";
        //initialisation du contenu


        $i=1;
        foreach ($m as $item) {
            $url = $app->urlFor('AdminmodifCol', ['id' => $item->id]);
            $type=$item->Type()->first();
            $cont = $cont . <<<END
                   <li class="span3S">
						<div class="product-box">
							<span class="sale_tag"></span>												
							<a href="$url"><img alt="" src="$chemin/images/Products/palette/$item->img"></a><br/>
							<div class='desc'>
							    <a href="$url" class="title">$item->nom</a><br/>
							    <span>$item->marque</span><br>
							    <span>$type->nom</span>
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
    function ajoutColor(){
        $app= \Slim\Slim::getInstance();
        $url=$app->urlFor("AdminSaveCol");
        $types=TypeColor::all();
        $tC="
                <select class='mySelect' name='type'>";
        foreach ($types as $type){
            $tC.="<option value='$type->id' >$type->nom</option>";
        }
        $tC.="</select><br>";
        $ms=Marque::all();
        $marque="
                <select class='mySelect' name='marque'>";
        foreach ($ms as $m){
            $marque.="<option value='$m->nom'>$m->nom</option>";
        }
        $marque.="</select><br>";
        $cont=<<<end
             <form class="ajoutTable" method="post" action="$url">
                <fieldset >
                    <legend>Détail de la Couleur</legend>
                    Nom :<br>
                    <input type="text" name="nom" value=""><br>
                    Marque :<br>
                    $marque
                    Image (Dim ?x? px):<br>
                    <input type="file" name="img" ><br>
                    $tC
                    </fieldset>
                <input  id="save" type="submit" value="ajouter la Couleur">
             </form>
             <h4 class="title"></h4>
end;

        return $cont;
    }
    function ModifColor($chemin){

        $app= \Slim\Slim::getInstance();
        $m=$this->content['Color'];
        $types=TypeColor::all();
        $tC="
                <select class='mySelect' name='type'>";
        foreach ($types as $type){
            $s='';
            if($type->id==$m->type){
                $s='selected';
            }
            $tC.="<option value='$type->id' $s>$type->nom</option>";
        }
        $tC.="</select><br>";
        $ms=Marque::all();
        $marque="
                <select class='mySelect' name='marque'>";
        foreach ($ms as $ma){
            $s='';
            if($m->marque==$ma->nom){
                $s='selected';
            }
            $marque.="<option value='$ma->nom' $s>$ma->nom</option>";
        }
        $marque.="</select><br>";
        $conds=Size::all();
        $size="<label class='checkbox'>
                Nos conditionements<br>
                <select class='mySelect' name='cond'>";
        foreach ($conds as $cond){
            $size.="<option value='$cond->id'>$cond->serie - $cond->taille $cond->prix €</option>";
        }
        $size.="</select></label>";
        $Sous=$m->Size()->get();
        $listeS='';
            foreach ($Sous as $option){

                $url2=$app->urlFor("AdminUpdateCol",['id'=>2,'mar'=>$m->id]);
                $listeS.="<form class='listeOption'  method='post'  action='$url2'>
                    <input  id='save' type='submit' name='supp' value='X'>
                    nom :
                    <input type='hidden' name='cond' value='$option->id'>
                    <span>$option->serie - $option->taille </span>
                    prix :
                    <span>$option->prix</span>
                    </form>";
            }
            $url3=$app->urlFor("AdminUpdateCol",['id'=>3,'mar'=>$m->id]);
            $listeS.="<form method='post' class='modif ' action='$url3'>
                    $size
                    <input  id='save' type='submit' value='nouvell option'>
                    </form>";

        $url=$app->urlFor("AdminUpdateCol",['id'=>0,'mar'=>$m->id]);
        $url1=$app->urlFor("AdminUpdateCol",['id'=>1,'mar'=>$m->id]);
        $urlR=$app->urlFor('AdminlisterCol');
        $cont=<<<End
            <a href="$urlR">Retour au catalogue des Couleurs</a>
            <form method="post" class="modif ajoutTable" action="$url">
                <fieldset >
                    <legend>Détail de la Couleur</legend>
                    Nom:<br>
                    <input type="text" name="nom" value="$m->nom">
                    <br>
                    Marque :<br>
                    $marque
                    Image (Dim ?x? px):<br>
                    <input type="text" name="img" value="$m->img"><br>
                    $tC
                    <input  id="save" type="submit" value="modifier le Couleur">
                </fieldset>
             </form>
             <div> 
                   <fieldset>
                      <legend>conditionement</legend>
                      $listeS
                   </fieldset>
             </div>
             <form method="post" class="AsupProd" action="$url1">
                <input  id="save" type="submit" value="Suprimer la Couleur">
             </form>
             <h4 class="title"></h4>
End;
        return $cont;
    }

    function listerCond($chemin){
        $app=\Slim\Slim::getInstance();
        $m=$this->content['Size'];
        $nbRes=$m->count();
        $cont="
                <div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
                <div class='row'>
					<div class='span9S'>								
						<ul class='thumbnails listing-products' id='catalogue'>
						<h4 class='title'><span>Nos<strong> conditionements :</strong> résultat($nbRes)</span></h4>";
        //initialisation du contenu


        $i=1;
        foreach ($m as $item) {
            $url = $app->urlFor('AdminmodifCond', ['id' => $item->id]);
            $cont = $cont . <<<END
                   <li class="span3S">
						<div class="product-box">
							<span class="sale_tag"></span>												
							<a href="$url"><img alt="" src="$chemin/images/banner/pageBannerPienture.jpg"></a><br/>
							<div class='desc'>
							    <a href="$url" class="title">$item->serie $item->taille</a><br/>
							</div>
							<div class='ApS'>
							    <p class="price">$item->prix</p>
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
    function ajoutCond(){
        $app= \Slim\Slim::getInstance();
        $url=$app->urlFor("AdminSaveCond");
        $cont=<<<end
             <form class="ajoutTable" method="post" action="$url">
                <fieldset >
                    <legend>Détail du conditionement</legend>
                    Serie :<br>
                    <input type="text" name="serie" value=""><br>
                    Taille :<br>
                    <input type="text" name="taille" value=""><br>
                    Prix :<br>
                    <input type="number" step="any" name="prix" value=""><br>
                </fieldset>
                <input  id="save" type="submit" value="ajouter le conditionement">
             </form>
             <h4 class="title"></h4>
end;

        return $cont;
    }
    function ModifCond($chemin){
        $app= \Slim\Slim::getInstance();
        $m=$this->content['Size'];
        $url=$app->urlFor("AdminUpdateCond",['id'=>0,'mar'=>$m->id]);
        $url1=$app->urlFor("AdminUpdateCond",['id'=>1,'mar'=>$m->id]);
        $urlR=$app->urlFor('AdminlisterCond');
        $cont=<<<End
         <a href="$urlR">Retour au catalogue des Conditionnements</a>
         <form method="post" class="modif ajoutTable" action="$url">
                <fieldset>
                    <legend>Détail du conditionement</legend>
                    Serie :<br>
                    <input type="text" name="serie" value="$m->serie"><br>
                    Taille :<br>
                    <input type="text" name="taille" value="$m->taille"><br>
                    Prix :<br>
                    <input type="number" step="any" name="prix" value="$m->prix"><br>
                    <input  id="save" type="submit" value="modifier le conditionement">
                </fieldset>
             </form>
             <form method="post" class="AsupProd" action="$url1">
                <input  id="save" type="submit" value="Suprimer le conditionement">
             </form>
             <h4 class="title"></h4>
End;
        return $cont;
    }

    function listerCompte($chemin){
            $app=\Slim\Slim::getInstance();
            $m=$this->content['Client'];
            $nbRes=$m->count();
            $cont="
                <div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
                <div class='row'>
					<div class='span9S'>								
						<ul class='thumbnails listing-products' id='catalogue'>
						<h4 class='title'><span>Nos <strong>Clients : </strong>résultat($nbRes)</span></h4>";
            //initialisation du contenu


            $i=1;
            foreach ($m as $item) {
                $url = $app->urlFor('AdminClientD', ['id' => $item->id]);
                $cont = $cont . <<<END
                   <li class="span3S">
						<div class="product-box">
							<span class="sale_tag"></span>												
							<a href="$url"><img alt="" src="$chemin/images/user.jpg"></a><br/>
							<div class='desc'>
							    <a href="$url" class="title">$item->mail</a><br/>
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
        }
    function ClientD($chemin){

        $app= \Slim\Slim::getInstance();
        $client=$this->content['Client'];
        $paniers=Panier::where('idCreateur','=',$client->id)->get();
        $listeC='';
        if($paniers->count() ==0) {
            $listeC = "<h1>Il n'a pas encore validé de panier</h1>";
        }else {
            foreach ($paniers as $panier){
                $src="";
                if($panier->etat=='reçu'){
                    $src=$chemin."/images/reçu.png";
                }else{
                    $src=$chemin."/images/validé.png";
                }
                $url = $app->urlFor('AdminPanierD', ['id' => $panier->id]);
                $listeC=$listeC.<<<end
                     <div>
                        <img src="$src">
                        <h4 class="title"><strong>Panier du $panier->date</strong></h4>
                        <p>$panier->etat</p>
                        <a href="$url">detail</a>
                    </div>
end;

            }
        }
        $urlR=$app->urlFor('AdminlisterCompte');
        $cont=<<<End
            <a href="$urlR">Retour au catalogue des comptes</a>
                <fieldset >
                    <legend>Détail du Compte</legend>
                    <p>E-mail : $client->mail</p>
                    <h4>Adresse de livraison</h4>
                        <p>Rue : $client->rue</p>
                        <p>Ville : $client->ville</p>
                        <p>Code postal : $client->codePostal</p>
                        <p>Département : $client->departement</p>
                </fieldset>
             <div> 
                   <fieldset>
                      <legend>Ensemble des commandes</legend>
                      <div class="listePanier">
                        <div class="liste">$listeC</div>
                      </div>
                   </fieldset>
             </div>
             <h4 class="title"></h4>
End;
        return $cont;
    }
    function listerPanier($chemin){
        $app=\Slim\Slim::getInstance();
        $m=$this->content['Panier'];
        $nbRes=$m->count();
        $cont="
                <div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
                <div class='row'>
					<div class='span9S'>								
						<ul class='thumbnails listing-products' id='catalogue'>
						<h4 class='title'><span>Nos <strong>Paniers : </strong>résultat($nbRes)</span></h4>";
        //initialisation du contenu


        $i=1;
        foreach ($m as $item) {
            $url = $app->urlFor('AdminPanierD', ['id' => $item->id]);
            $createur=Client::find($item->idCreateur);
            $dispo="disponible.png";
            if($item->etat=="validé"){
                $dispo="indisponible.png";
            }
            $cont = $cont . <<<END
                   <li class="span3S">
						<div class="product-box">
							<span class="sale_tag"></span>												
							<a href="$url"><img alt="" src="$chemin/images/cart.jpg"></a><br/>
							<div class="nom">
							    <img src="$chemin/images/$dispo">
							    <a href="$url" class="title">$createur->mail<br>$item->date</a><br/>
                            </div>
							<div class='ApS'>
							    <p class="price">$item->prix €</p>
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
    }
    function PanierD($chemin){
        $panier=$this->content['Panier'];
        $createur=Client::find($panier->idCreateur);
        $p=Contient::where('idPanier','=',$panier->id)->get();
        $cont='';
        $total=0;
        foreach ($p as $item){
            $prod=$item->produit()->first();
            $q=$item->quantite;
            $opt=$item->Soption;
            $sl=$prod->sousliste()->first();
            if($sl==null){
                $sl=$prod->categorie()->first();
            }
            $prix='';
            $app=\Slim\Slim::getInstance();
            $urlp=$app->urlFor('detail',["nomCat"=>$sl->nom,'id'=>$prod->id]);

            if($opt=='image'){
                $opt='';
                $prix=$prod->prix*$q;
            }else{
                if(strpos($opt, '/')){
                    $array = explode('/', "$opt");
                    $color=Color::where('id','=',$array[0])->first();
                    $size=Size::where('id','=',$array[1])->first();
                    $prix = $size->prix*$q;
                    $opt=$color->nom."<br>".$size->serie.' '.$size->taille;
                    $urlp = $app->urlFor('palette', ['nomCat' => $sl->nom,"nomProduit"=>$prod->nom]);
                }else {
                    $s = SelectProd2opt::where('nom', '=', $opt);
                    $s = $s->where('idprod', '=', $prod->id)->first();
                    if($s!=null) {
                        $prix = $s->prix*$q;
                    }else{
                        $desc = explode(' ', "$opt");
                        $surmesure = explode('x', "$desc[1]");
                        $prix = floatval(($surmesure[0]+$surmesure[1])*1.20*$prod->prix)*$q;
                    }

                }
            }
            $cont=$cont.<<<END
                <tr>
					<td class="cartimg"><a href="$urlp"><img alt="" src="$chemin/images/Products/all/$prod->img"></a></td>
					<td><a href="$urlp">$prod->nom</a> <br> $opt</td>
					<td>$q</td>
	    			<td class="prix">$prix €</td>
				</tr>	
END;
            $total+=$prix;
        }
        $envoi="";
        if($panier->etat=='validé'){
            $url=$app->urlFor('AdminConfirmPanier',['id'=>$panier->id]);
            $envoi="<form method='post' class='AsupProd' action='$url'>
                Transporteur :
                <input name='Transporteur' type='text'>
                code/Lien Pour suivis :
                <input name='code' type='text' >
                <input  id='save' type='submit' value='confirmer l envoi'>
             </form>";
            $etat="<h3>Vous n'avez pas encore confirmé l'expédition du colis</h3>";
        }else{
            $etat="<h3>Vous avez confirmé l'expédition du colis</h3>
                    <p>Transporteur : $panier->Transporteur</p>
                    <p>code :</p>
                    <a href='$panier->code'> $panier->code</a>";
        }
        $urlR=$app->urlFor('AdminlisterPanier');
        return <<<end
                    <a href="$urlR">Retour au catalogue des Paniers</a>
                    <h4 class="title" style="text-align: center"><span class="text"><strong>panier de</strong> $createur->mail</span></h4>
                    <div>
                        $etat
                        <h4>Addresse de livraison</h4>
                        <p>Rue : $createur->rue</p>
                        <p>Ville : $createur->ville</p>
                        <p>Code postal : $createur->codePostal</p>
                        <p>Département : $createur->departement</p>
                    </div>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Image</th>
									<th>Nom du produit</th>
									<th>Quantité</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody class="cart">
								$cont		  
							</tbody>
						</table>
						$envoi
                    <h4 class="title" style="text-align: right">total: $total €</h4>
end;
    }
}