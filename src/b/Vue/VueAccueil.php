<?php

namespace b\Vue;

use b\Models\Categorie;
use b\models\Marque;
use b\Models\sousliste;
use Slim\Slim;

class VueAccueil
{

    private $content;

    function __construct($req){
    $this->content=$req;
}
    public function render($id)
    {
        $app= \Slim\Slim::getInstance();
        $nbprod=sizeof($_SESSION['panier']);
        //initialisation des routes
        $urlAcc=$app->urlFor('accueil');
        $urlAus=$app->urlFor('aboutUs');
        $urlCus=$app->urlFor('contactUS');
        $urlMl=$app->urlFor('MentionLegale');
        $urlCGV=$app->urlFor('CGV');
        $cart=$app->urlFor('cart');
        $formCo=$app->urlFor('form',['erreur'=>'input']);
        $Dcompte=$app->urlFor('compte');
        $search=$app->urlFor('search');
        $chemin = "web/css";

        switch ($id){
            case 1:
                $cont = $this->Accueil();
                break;
        }
        //methode qui cree le contenue
        $navbar="";
        $cat=Categorie::all();
        foreach ($cat as $item){
            $sl=$item->sousliste()->get();
            if ($sl->count()>0) {
                $ul="<ul>";
                $ful="</ul>";
                $urlcat = $app->urlFor('categorie', ['nomCat' => $item->nom]);
            }else {
                $ul="";
                $ful="";
                $urlcat = $app->urlFor('catalogueSl', ['nomCat' => $item->nom]);
            }
            $navbar=$navbar.<<<END
                            <li><a href="$urlcat">$item->nom</a>					
								$ul
END;
            foreach ($sl as $req) {
                if($req->affichage=='marque') {
                    $urlcatalogue = $app->urlFor('marque', ['nomCat' => $req->nom]);
                }else{
                    $urlcatalogue = $app->urlFor('catalogueTrie', ['nomCat' => $req->nom,'id'=>$req->trie]);
                }
                $navbar = $navbar . <<<END
                    <li><a href="$urlcatalogue">$req->nom</a></li>
END;
            }
            $navbar=$navbar.<<<END
                	$ful
				</li>
END;
        }
        $marques='';
        foreach ($this->content['marque'] as $m){
            $m=Marque::find($m->idMarque);
            $urlT0=$app->urlFor('MarqueD',['nomMarque'=>$m->nom,'id'=>0]);
            $marques=$marques.<<<end
                    <div class="span2" >
						<a href="$urlT0"><img alt="" src="themes/images/clients/$m->imgSmall"></a>						
					</div>
end;

        }
        //la page html
        if(isset($_SESSION["profile"])){
            $compte="<li><a href='$Dcompte' class='Menucompte'>Mon compte</a></li>";
        }else{
            $compte="<li><a href='$formCo' class='Menucompte'>se connecter</a></li>";
        }
        $html = <<<END
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Bozart</title>
		<meta property="og:site_name" content="Bozart">
		<meta property="og:image" content="themes/images/logo.png">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Bienvenu chez Bozart. 
		Le prix du gros au détail. C'est le choix de la qualité parmi un large éventail de produits concernant les beaux-arts">
		<link rel="icon" type="image/png" href="themes/images/easel-icon-1.png" />
		<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="themes/images/easel-icon-1.png" /><![endif]-->

		<!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
		<!-- bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">      
		<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		
		<link href="themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->
		<link href="themes/css/flexslider.css" rel="stylesheet"/>
		<link href="themes/css/main.css" rel="stylesheet"/>

		<!-- scripts -->
		<script src="themes/js/jquery-1.7.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>				
		<script src="themes/js/superfish.js"></script>	
		<script src="themes/js/jquery.scrolltotop.js"></script>
		<!--[if lt IE 9]>			
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>
    <body>		
		<p id="templatedirectory" style="display: none">themes</p>
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
							$compte
							<li><a href="$cart" class="Menucompte">Mon panier ($nbprod)</a></li>
							<!-- <li><a href="checkout.html" id="Menucompte">Checkout</a></li>-->
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="wrapper" class="container">
			<section class="navbar main-menu">
				<div class="navbar-inner main-menu">				
					<a href="$urlAcc" class="logo pull-left"><img src="themes/images/logo.png" class="site_logo" alt=""></a>
					<nav id="menu" class="pull-right">
                        <ul>	
                            $navbar
                        </ul>					
					</nav>
				</div>
			</section>
			<section  class="homepage-slider" id="home-slider">
				<div class="flexslider">
					<ul class="slides">
						<li>
							<img src="themes/images/carousel/1.jpg" alt="" />
							<div class="intro">
								<h1>Bienvenue chez Bozart</h1>
								<p><span>Le prix du gros au détail</span></p>
								<p><span>C'est le choix de la qualité parmi un large éventail de produits concernant les beaux-arts</span></p>
							</div>
						</li>
						<li>
							<img src="themes/images/carousel/2.jpg" alt="" />
							<div class="intro">
								<h1>vente de pienture et pinceau</h1>
								<p><span>Nous vous proposons un large choix de marque</span></p>
								<p><span>Rembrandt, Van Gogh, Amsterdam ...</span></p>
							</div>
						</li>
						<li>
							<img src="themes/images/carousel/3.jpg" alt="" />
							<div class="intro">
								<h1>Vente de cadre et baguette</h1>
								<p><span>Nous vous offrons de quoi immortaliser vos œuvres</span></p>
								<!-- <p><span>REMBRANDT, DERWENT, Moulin du coq</span></p> -->
							</div>
						</li>
						<li>
							<img src="themes/images/carousel/4.jpg" alt="" />
							<div class="intro">
								<h1>Vente de carnet et crayon</h1>
								<p><span>Nous vous offrons de quoi faire vivre votre imagination</span></p>
								<p><span>Rembrandt, Derwent, Moulin du coq</span></p>
							</div>
						</li>
					</ul>
				</div>			
			</section>
			<section class="header_text">
				Bienvenue sur notre site, nous vous proposons un large choix de produit d'art.  
				<br/>Ce qui fera de vous un vrai artiste.
			</section>
			$cont
			<section class="our_client">
				<h4 class="title"><span class="text">Nos principaux <strong>partenaires</strong></span></h4>
				<div class="row" id="marque">
					$marques
				</div>
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
						<p class="logo"><img src="themes/images/logo.png" class="site_logo" alt=""></p>
						<p>
							<b>Adresse :</b> 118 Boulevard de la Rochelle, 55000 Bar-le-Duc<br/>
							<b>Téléphone :</b> 03 29 77 12 34<br/>
							<b>Mobile :</b> 06 80 05 66 45<br/>
							<b>E-mail:</b> <a href="mailto:contact@bozart.fr">contact@bozart.fr</a>
						</p>
						<div class="social_icons">
							<a class="facebook" href="https://www.facebook.com/Bozart-145441285617240/"><img src="themes/images/fb_icon.png"></a>
						</div>
					</div>
				</div>	
			</section>
			<section id="copyright">
				<span>Copyright 2017 </span>
			</section>
		</div>
		<script src="themes/js/common.js"></script>
		<script src="themes/js/jquery.flexslider-min.js"></script>
		<script type="text/javascript">
			$(function() {
				$(document).ready(function() {
					$('.flexslider').flexslider({
						animation: "fade",
						slideshowSpeed: 4000,
						animationSpeed: 600,
						controlNav: false,
						directionNav: false,
						controlsContainer: ".flex-container" // the container that holds the flexslider
					});
				});
			});
		</script>
		<script>
            $("#marque div").mouseenter(function (e) {

                console.log(e.currentTarget);
				$($(e.currentTarget).find('p')).fadeIn();
            });
            $("#marque div").mouseleave(function (e) {
                console.log(e.currentTarget);
                console.log("leave")
                $($(e.currentTarget).find("p")).fadeOut();
            });
		</script>
    </body>
</html>
END;


        return $html;
    }

    public function Accueil(){
        $form="";
        $app = \Slim\Slim::getInstance();
        //initialisation du contenu
        $cont = <<<END
<section class="main-content">
				<div class="row">
					<div class="span12">													
						<div class="row">
							<div class="span12">
								<h4 class="title">
									<span class="pull-left"><span class="text"><span class="line">Promotion de la  <strong>Semaine</strong></span></span></span>
									<span class="pull-right">
										<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
									</span>
								</h4>
END;
        $promo = $this->content["promo"];
        $i = 0;
        //initialisation du contenu
        $cont = $cont . <<<END
        <div id="myCarousel" class="myCarousel carousel slide">
			<div class="carousel-inner">
                  <div class="active item">
                        <ul class="thumbnails">		
END;
        foreach ($promo as $item) {
            $form=$this->prix($item);
            $m = "";
            $sl = $item->sousliste()->first();
            if ($sl != null) {
                if ($sl->affichage=='marque') {
                    $m = $item->Marque()->first();
                }
            } else {
                $sl = $item->categorie()->first();
            }
            if($sl!=null) {
                if ($i >= 4) {
                    $i = 0;
                    $cont = $cont . <<<END
                        </ul>
                    </div>
                    <div class="item"> 
                        <ul class="thumbnails">		
END;
                }
                $urldetail = $app->urlFor('detail', ["nomCat" => $sl->nom, 'id' => $item->id]);
                switch ($sl->nom) {
                    case 'Acrylique':
                    case 'Huile':
                    case 'Aquarelle':
                        $urldetail = $app->urlFor('palette', ['nomCat' => $sl->nom, "nomProduit" => $item->nom]);
                        break;
                }
                if ($m != null) {
                    $urlcat = $app->urlFor("catalogueMq", ['nomCat' => $sl->nom, 'nomMarque' => $m->nom]);
                } else {
                    $urlcat = $app->urlFor('catalogueTrie', ['nomCat' => $sl->nom, 'id' => $sl->trie]);
                }
                if ($i > 0) {
                    $bye = 'bye';
                } else {
                    $bye = '';
                }
                $dispo = 'indisponible.png';
                if ($item->disponible == 1) {
                    $dispo = 'disponible.png';
                }
                $cont = $cont . <<<END
							<li class="spaan3carousel $bye">
								<div class="product-box">
									<span class="promo sale_tag"><h6>PROMO</h6></span>
									<p><a href="$urldetail"><img src="themes/images/Products/all/$item->img" alt="" /></a></p>
									<div class="nom">
									    <img src="themes/images/$dispo">
									    <a href="$urldetail" class="title">$item->nom</a><br/>
									</div>
				    				<a href="$urlcat" class="category">$sl->nom</a>
									$form
								</div>
							</li>
END;
                $i++;
            }
        }
        $cont = $cont . <<<END
                                            </ul>
										</div>
									</div>							
								</div>
							</div>						
						</div>
						<br/>
						<div class="row">
							<div class="span12">
								<h4 class="title">
									<span class="pull-left"><span class="text"><span class="line">Nouveaux <strong>Produits</strong></span></span></span>
									<span class="pull-right">
										<a class="left button" href="#myCarousel-2" data-slide="prev"></a><a class="right button" href="#myCarousel-2" data-slide="next"></a>
									</span>
								</h4>
								<div id="myCarousel-2" class="myCarousel carousel slide">
									<div class="carousel-inner">
END;
        $promo = $this->content["newProd"];
        $i = 0;
        //initialisation du contenu
        $cont = $cont . <<<END
                  <div class="active item">
                        <ul class="thumbnails">		
END;
        foreach ($promo as $item) {
            $promo="";
            $form=$this->prix($item);
            $m = "";
            $sl = $item->sousliste()->first();
            if ($sl != null) {
                if ($sl->affichage=='marque') {
                    $m = $item->Marque()->first();
                }
            } else {
                $sl = $item->categorie()->first();
            }
            if($sl!=null) {
                if ($i >= 4) {
                    $i = 0;
                    $cont = $cont . <<<END
                        </ul>
                    </div>
                    <div class="item"> 
                        <ul class="thumbnails">		
END;
                }
                if ($item->promo == 1) {
                    $promo = "<span class='promo sale_tag'><h6>PROMO</h6></span>";
                }
                $app = \Slim\Slim::getInstance();
                $urldetail = $app->urlFor('detail', ["nomCat" => $sl->nom, 'id' => $item->id]);
                switch ($sl->nom) {
                    case 'Acrylique':
                    case 'Huile':
                    case 'Aquarelle':
                        $urldetail = $app->urlFor('palette', ['nomCat' => $sl->nom, "nomProduit" => $item->nom]);
                        break;
                }
                if ($m != null) {
                    $urlcat = $app->urlFor("catalogueMq", ['nomCat' => $sl->nom, 'nomMarque' => $m->nom]);
                } else {
                    $urlcat = $app->urlFor('catalogueTrie', ['nomCat' => $sl->nom, 'id' => $sl->trie]);
                }
                if ($i > 0) {
                    $bye = 'bye';
                } else {
                    $bye = '';
                }
                $dispo = 'indisponible.png';
                if ($item->disponible == 1) {
                    $dispo = 'disponible.png';
                }
                $cont = $cont . <<<END
							<li class="spaan3carousel $bye">
								<div class="product-box">
									$promo
									<p><a href="$urldetail"><img src="themes/images/Products/all/$item->img" alt="" /></a></p>
									<div class="nom">
									    <img src="themes/images/$dispo">
									    <a href="$urldetail" class="title">$item->nom</a><br/>
									</div>
				    				<a href="$urlcat" class="category">$sl->nom</a>
									$form
								</div>
							</li>
END;
                $i++;
            }
        }
        $cont = $cont . <<<END
                                            </ul>
										</div>
									</div>							
								</div>
							</div>						
						</div>
						<div class="row feature_box">						
							<div class="span4">
								<div class="service">
									<div class="responsive">	
										<img src="themes/images/feature_img_2.png" alt="" />
										<h4>Vendeur de matériel<strong> D'art</strong></h4>
										<p>C'est le choix de la qualité parmi un large éventail de produits concernant la peinture.</p>									
									</div>
								</div>
							</div>
							<div class="span4">	
								<div class="service">
									<div class="customize">			
										<img src="themes/images/feature_img_1.png" alt="" />
										<h4>Livraison   à<strong> Domicile</strong></h4>
										<p>Vous pouvez retrouver votre commande dans notre magasin où on vous l'envoie.</p>
									</div>
								</div>
							</div>
							<div class="span4">
								<div class="service">
									<div class="support">	
										<img src="themes/images/feature_img_3.png" alt="" />
										<h4>Retouver nous en <strong>Magasin</strong></h4>
										<p>Vous pouvez visiter notre magasin à Bar-le-Duc.</p>
									</div>
								</div>
							</div>	
						</div>		
					</div>				
				</div>
			</section>
END;
        //on retourne le message
        return $cont;

    }

    function prix($item){
        $app=\Slim\Slim::getInstance();
        $sel=$item->Select()->get();
        if($sel->count()==0){
            $ajout = $app->urlFor('ajProd', ['id' => $item->id]);
            $form="<form id='form1' method='POST' action='$ajout''>
                            <p class=\"price\">$item->prix €</p>
                             <button class='btn btn-inverse' type='submit'>Ajouter au panier</button>
                        </form>";
        }else{
            $form="<h3>À partir de</h3><p class='price'>$item->prix €</p>";
        }
        return $form;
    }
}