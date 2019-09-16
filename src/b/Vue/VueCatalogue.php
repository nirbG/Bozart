<?php

namespace b\Vue;

use b\models\C2S;
use b\models\image;
use b\models\Produit;
use b\models\SelectProd2opt;
use b\models\Size;
use b\models\sOption;
use Slim\Slim;
use b\Models\Categorie;
use b\Models\sousliste;
class VueCatalogue{

    private $content;

    function __construct($a=null){
        $this->content=$a;
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
        $js="";

        switch ($id){
            case 1:
                $cheminb = "bootstrap";
                $chemint = "themes";
                $cat=$this->content;
                $banner=$cat->Banner;
                $h1=$cat->nom;
                $desc="";
                $cont = $this->Categorie($chemint);
                break;
            case 2:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $sl=$this->content["sousliste"];
                $cat=$this->content["categorie"];
                $h1=$sl->nom;
                $banner=$cat->Banner;
                $desc="";
                $cont = $this->CatalogueByS($chemint);
                break;
            case 3:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $cat=$this->content["categorie"];
                $mar=$this->content["marque"];
                $h1=$mar->nom;
                $banner=$cat->Banner;
                $desc="";
                $cont = $this->CatalogueByM($chemint);
                break;
            case 4:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $sl=$this->content["sousliste"];
                $cat=$this->content["categorie"];
                $h1=$sl->nom;
                $banner=$cat->Banner;
                $desc="";
                $cont = $this->Marque($chemint);
                break;
            case 5:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $sl=$this->content["sousliste"];
                $cat=$this->content["categorie"];
                $prod=$this->content["prod"];
                $h1=$prod->nom;
                $banner=$cat->Banner;
                $desc="";
                $cont = $this->detail($chemint);
                $js=<<<END
                <script src='$chemint/js/detail.js'></script>
END;
                break;
            case 6:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $sl='';
                $cat='';
                $h1="resultat associé à '".$this->content['recherche']."'";
                $desc="";
                $banner='pageBannerSearch.jpg';
                $cont = $this->search($chemint);
                break;
            case 7:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $marque=$this->content['marque'];
                $h1=$marque->nom;
                $desc="";
                $banner='pageBannerSearch.jpg';
                $cont = $this->MarqueD($chemint);
                break;
            case 8:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $cat=$this->content["categorie"];
                $mar=$this->content["marque"];
                $h1=$mar->nom;
                $banner=$cat->Banner;
                $desc="";
                $cont = $this->palette($chemint);
                $js="<script src='$chemint/js/switch.js'></script>
                     <script src='$chemint/js/palette.js'></script>";
                break;
        }
        //methode qui cree le contenue
        $navbar="";
        $cat=Categorie::all();
        foreach ($cat as $item){
            $sl=$item->sousliste()->get();
            if ($sl->count()>0) {
                $urlcat = $app->urlFor('categorie', ['nomCat' => $item->nom]);
            }else {
                $urlcat = $app->urlFor('catalogueSl', ['nomCat' => $item->nom]);
            }
            $navbar=$navbar.<<<END
                            <li><a href="$urlcat">$item->nom</a>					
								<ul>
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
                	</ul>
				</li>
END;
        }
        if(isset($_SESSION["profile"])){
            $compte="<li><a href='$Dcompte' class='Menucompte'>Mon compte</a></li>";
        }else{
            $compte="<li><a href='$formCo' class='Menucompte'>se connecter</a></li>";
        }
        //la page html
        $html = <<<END
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Bozart : $h1</title>
		<meta property="og:site_name" content="Bozart">
		<meta property="og:image" content="themes/images/logo.png">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Bienvenu chez Bozart. 
		Le prix du gros au détail. C'est le choix de la qualité parmi un large éventail de produits concernant les beaux-arts.$desc">
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
		<link href="$chemint/css/jquery.fancybox.css" rel="stylesheet"/>

		<!-- scripts -->
		<script src="$chemint/js/jquery-1.7.2.min.js"></script>
		<script src="$cheminb/js/bootstrap.min.js"></script>				
		<script src="$chemint/js/superfish.js"></script>	
		<script src="$chemint/js/jquery.scrolltotop.js"></script>
		<script src="$chemint/js/jquery.fancybox.js"></script>
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
					<form method="POST"  action="$search" class="search_form">
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
					<a href="$urlAcc" class="logo pull-left"><img src="$chemint/images/logo.png" class="site_logo" alt=""></a>
					<nav id="menu" class="pull-right">
                        <ul>	
                            $navbar
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
				<span>Copyright 2017 </span>
			</section>
		</div>
		<script src="$chemint/js/common.js"></script>
		$js
		<script>
			$("#mosaique").click(function (event) {
               $('#catalogue .span3,#catalogue .span3S').removeClass("liste");
                $('#catalogue .span3*,#catalogue .span3S').removeClass("product-box");
                $($('#catalogue .span3*,#catalogue .span3S ').children()).removeClass("ligne");
                $($('#catalogue .span3*,#catalogue .span3S ').children()).addClass("product-box");
                $("#mosaique").addClass("press");
                $("#liste").removeClass("press");
                $('.desc').css('height', "");
            });
            $("#liste").click(function (event) {
                $('#catalogue .span3*,#catalogue .span3S').addClass("liste");
                $('#catalogue .span3*,#catalogue .span3S').addClass("product-box");
                $('#catalogue .span3* div,#catalogue .span3S div').removeClass("product-box");
                $($('#catalogue .span3* ,#catalogue .span3S').children()).addClass("ligne");
                $("#liste").addClass("press");
                $("#mosaique").removeClass("press");
                 var img=$(".ligne .imgP");
                console.log(img[0].offsetHeight);
                $('.liste .desc').css('height', img[0].offsetHeight+"px");
            });
		</script>
			<script>
			$('.trieoption a').click(function(){
				var the_id = $(this).attr("href");

				$('html, body').animate({
					scrollTop:$(the_id).offset().top
				}, 'slow');
				return false;
			});
		</script>
    </body>
</html>
END;


        return $html;
    }

    public function Categorie($chemin){
        $app=\Slim\Slim::getInstance();
        $cont="<h4 class='title'><span>Nos <strong>Categories :</strong></span></h4>";
        //initialisation du contenu
        $cat=$this->content;
        $sl=$cat->sousliste()->get();
        foreach ($sl as $scat) {
            if($scat->affichage=='marque') {
                $url = $app->urlFor('marque', ['nomCat' => $scat->nom]);
            }else{
                $url = $app->urlFor('catalogueTrie', ['nomCat' => $scat->nom,'id'=>$scat->trie]);
            }
            $cont = $cont . <<<END
                    <a href="$url">
						<div class="categorie">
							<img src="$chemin/images/banner/$cat->BannerO">
							<h1>$scat->nom</h1>
						</div>
					</a>
END;
        }
    //on retourne le message
        return $cont."<h4 class='title'></h4>";

    }

    public function Marque($chemin){
        $app=\Slim\Slim::getInstance();
        $sl=$this->content["sousliste"];
        $cont=" <div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
				<div class='trieoption'>
					<a href='#col'>Trier les produits</a>
				</div>
                <div class='row'>
					<div class='span9'>								
						<ul class='thumbnails listing-products' id='catalogue'>
						<h4 class='title'><span>Nos<strong> marques :</strong></span></h4>";
        //initialisation du contenu
        $i=1;
        foreach ($this->content['marques'] as $item) {
            $url = $app->urlFor('catalogueMq', ['nomCat' => $sl->nom,'nomMarque'=>$item->nom]);
            $urlcat = $app->urlFor('marque', ['nomCat' => $sl->nom]);
            $cont = $cont . <<<END
                   <li class="span3">
						<div class="product-box">
							<span class="sale_tag"></span>												
							<a href="$url"><img  class='imgP' alt="" src="$chemin/images/Marque/$item->img"></a>
							<div class='desc'>
							    <a href="$url" class="title">$item->nom</a><br/>
							    <a href="$urlcat" class="category">$sl->nom</a>
							</div>
							<div class='Ap'>
							    <p class="price"></p>
						    </div>				
						</div>
					</li>
END;
            $i++;
        }
        $urlcatalogue = $app->urlFor('catalogueTrie', ['nomCat' => $sl->nom,'id'=>$sl->trie]);
        $urlTm=$app->urlFor('marque',['nomCat'=>$sl->nom]);
        $R=$this->random($chemin);
        $bs=$this->bestSeller($chemin);
        return $cont.<<<end
                    	</ul>
					</div>
                    <div class="span3" id="col">
						<div class="block ">
							<ul class="nav nav-list">
								<li class="nav-header">Trie</li>
								<li class=""><a href="$urlcatalogue">Tous</a></li>
								<li class="active"><a href="$urlTm">Marque</a></li>
							</ul>
							<br/>
						</div>
						<div class="block">
							<h4 class="title">
								<span class="pull-left"><span class="text">Produits aléatoires</span></span>
								<span class="pull-right">
									<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
								</span>
							</h4>
							<div id="myCarousel" class="carousel slide">
								<div class="carousel-inner">
									<div class="active item">
										<ul class="thumbnails listing-products">
											$R
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="block bye">
							<h4 class="title"><strong>Les plus</strong> vendus</h4>								
							<ul class="small-product">
								$bs  
							</ul>
						</div>
					</div>
				</div>
end;
;

    }
    public function CatalogueByM($chemin){
        $form='';
        $app=\Slim\Slim::getInstance();
        $sl=$this->content["sousliste"];
        $cont="
                <div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
				<div class='trieoption'>
					<a href='#col'>Trier les produits</a>
				</div>
                <div class='row'>
					<div class='span9'>								
						<ul class='thumbnails listing-products' id='catalogue'>
						<h4 class='title'><span>Nos<strong> produits :</strong></span></h4>";
        //initialisation du contenu
        $i=1;
        foreach ($this->content['Products'] as $item) {
            $promo='';
            $form=$this->prix($item);
            $trie=$item->sousliste()->first();
            if($trie==null){
                $trie=$item->categorie()->first();
            }
            if($item->promo==1){
                $promo="<span class='promo sale_tag'><h6>Promotion</h6></span>";
            }
            if($trie->nom==$sl->nom) {
                $url = $app->urlFor('detail', ['nomCat' => $sl->nom, "id" => $item->id]);
                $urlcat = $app->urlFor('marque', ['nomCat' => $sl->nom]);
                $dispo='indisponible.png';
                if($item->disponible==1){
                    $dispo='disponible.png';
                }
                $cont = $cont . <<<END
                   <li class="span3">
						<div class="product-box">
							$promo											
							<a href="$url"><img class='imgP' alt="" src="$chemin/images/Products/all/$item->img"></a>
							<div class='desc'>
							    <div class="nom">
									    <img src="$chemin/images/$dispo">
									    <a href="$url" class="title">$item->nom</a><br/>
									</div>
							    <a href="$urlcat" class="category">$sl->nom</a>
							    <p>$item->descCourt</p>
							</div>
							<div class='Ap'>
                                $form
							</div>
						</div>
					</li>
END;
                $i++;
            }
            $aPartit="";
            $button="";
        }
        $marque='';
        $mar=$this->content["marque"];
        $urlT0=$app->urlFor('catalogueMq',['nomCat'=>$sl->nom,'nomMarque'=>$mar->nom]);
        $urlT1=$app->urlFor('catalogueTrieM',['nomCat'=>$sl->nom,'nomMarque'=>$mar->nom,'id'=>1]);
        $urlT2=$app->urlFor('catalogueTrieM',['nomCat'=>$sl->nom,'nomMarque'=>$mar->nom,'id'=>2]);
        $urlT3=$app->urlFor('catalogueTrieM',['nomCat'=>$sl->nom,'nomMarque'=>$mar->nom,'id'=>3]);
        $urlT4=$app->urlFor('catalogueTrieM',['nomCat'=>$sl->nom,'nomMarque'=>$mar->nom,'id'=>4]);
        $tout="";
        $pc="";
        $pd="";
        $n="";
        $pro="";
        switch ($this->content["trie"]){
            case 0:
                $tout="active";
                break;
            case 1:
                $pc="active";
                break;
            case 2:
                $pd="active";
            break;
            case 3:
                $n="active";
                break;
            case 4:
                $pro="active";
                break;
        }
        $R=$this->random($chemin);
        $bs=$this->bestSeller($chemin);
        return $cont.<<<end
                    	</ul>
					</div>
                    <div class="span3" id="col">
						<div class="block ">
							<ul class="nav nav-list">
								<li class="nav-header">Trie</li>
								<li class="$tout"><a href="$urlT0">Tous</a></li>
								<li class="$pc"><a href="$urlT1">Prix Croissant</a></li>
								<li class="$pd"><a href="$urlT2">Prix Décroissant</a></li>
								<li class="$pro"><a href="$urlT4">Promotion</a></li>
								<li class="$n"><a href="$urlT3">Nom</a></li>
							</ul>
							<br/>
						</div>
						<div class="block">
							<h4 class="title">
								<span class="pull-left"><span class="text">Produits aléatoires</span></span>
								<span class="pull-right">
									<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
								</span>
							</h4>
							<div id="myCarousel" class="carousel slide">
								<div class="carousel-inner">
									<div class="active item">
										<ul class="thumbnails listing-products">
											$R
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="block bye">
							<h4 class="title"><strong>Les plus</strong> vendus</h4>								
							<ul class="small-product">
								$bs  
							</ul>
						</div>
					</div>
				</div>
end;
        ;

    }

    public function CatalogueByS($chemin){
        $aPartit="";
        $form='';
        $app=\Slim\Slim::getInstance();
        $sl=$this->content["sousliste"];
        $button="";
        $cont="
                <div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
				<div class='trieoption'>
					<a href='#col'>Trier les produits</a>
				</div>
                <div class='row'>
					<div class='span9'>								
						<ul class='thumbnails listing-products' id='catalogue'>
						<h4 class='title'><span>Nos<strong> produits :</strong></span></h4>";
        //initialisation du contenu
        $i=1;
        foreach ($this->content['Products'] as $item) {
            $promo="";
            $form=$this->prix($item);
            if($item->promo==1){
                $promo="<span class='promo sale_tag'><h6>Promotion</h6></span>";
            }
            if($sl->affichage=='palette'){
                $url = $app->urlFor('palette', ['nomCat' => $sl->nom,"nomProduit"=>$item->nom]);
            }else {
                $url = $app->urlFor('detail', ['nomCat' => $sl->nom,"id"=>$item->id]);
            }
            $urlcat = $app->urlFor('marque', ['nomCat' => $sl->nom]);
            $dispo='indisponible.png';
            if($item->disponible==1){
                $dispo='disponible.png';
            }
            $cont = $cont . <<<END
                   <li class="span3">
						<div class="product-box">
							$promo											
							<a href="$url"><img class='imgP' alt="" src="$chemin/images/Products/all/$item->img"></a>
							<div class='desc'>
							    <div class="nom">
									<img src="$chemin/images/$dispo">
									<a href="$url" class="title">$item->nom</a><br/>
								</div>
							    <a href="$urlcat" class="category">$sl->nom</a>
							    <p>$item->descCourt</p>
							</div>
							<div class='Ap'>
							    $form
						    </div>
						 </div>
					</li>
END;
            $i++;
            $aPartit="";
            $button="";
        }
        //on retourne le message
        $marque='';
        $urlT0 = $app->urlFor('catalogueTrie', ['nomCat' => $sl->nom,'id'=>$sl->trie]);
        $tout="";
        $pc="";
        $pd="";
        $n="";
        $pro="";
        switch ($this->content["trie"]){
            case 0:
            case 5:
                $tout="active";
                break;
            case 1:
                $pc="active";
                break;
            case 2:
                $pd="active";
                break;
            case 3:
                $n="active";
                break;
            case 4:
                $pro="active";
                break;
        }
        if($sl->affichage=='marque') {
            $urlTm=$app->urlFor('marque',['nomCat'=>$sl->nom]);
            $marque = "<li class=''><a href='$urlTm'>Marque</a></li>";
        }
        $urlT1=$app->urlFor('catalogueTrie',['nomCat'=>$sl->nom,'id'=>1]);
        $urlT2=$app->urlFor('catalogueTrie',['nomCat'=>$sl->nom,'id'=>2]);
        $urlT3=$app->urlFor('catalogueTrie',['nomCat'=>$sl->nom,'id'=>3]);
        $urlT4=$app->urlFor('catalogueTrie',['nomCat'=>$sl->nom,'id'=>4]);
        $R=$this->random($chemin);
        $bs=$this->bestSeller($chemin);
        return $cont.<<<end
                    	</ul>
					</div>
                    <div class="span3" id="col">
						<div class="block">
							<ul class="nav nav-list">
								<li class="nav-header">Trie</li>
								<li class="$tout"><a href="$urlT0">Tous</a></li>
								$marque
								<li class="$pc"><a href="$urlT1">Prix Croissant</a></li>
								<li class="$pd"><a href="$urlT2">Prix Décroissant</a></li>
								<li class="$pro"><a href="$urlT4">Promotion</a></li>
								<li class="$n"><a href="$urlT3">Nom</a></li>
							</ul>
							<br/>
						</div>
						<div class="block">
							<h4 class="title">
								<span class="pull-left"><span class="text">Produits aléatoires</span></span>
								<span class="pull-right">
									<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
								</span>
							</h4>
							<div id="myCarousel" class="carousel slide">
								<div class="carousel-inner">
									<div class="active item">
										<ul class="thumbnails listing-products">
											$R
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="block bye">
							<h4 class="title"><strong>Les plus</strong> vendus</h4>								
							<ul class="small-product">
								$bs
							</ul>
						</div>
					</div>
				</div>
end;
        ;

    }

    function detail($chemin){
        $prod=$this->content["prod"];
        $sl=$this->content["sousliste"];
        $va=$this->content["VousAimerai"];
        $pallette="";
        $palletteBut='';
        $option="";
        $button="";
        $css='';
        $app=\Slim\Slim::getInstance();
        $ajout = $app->urlFor('ajProd', ['id' => $prod->id]);
        $sel=$prod->Select()->get();
        if($sel->count()!=0) {
            $option = "<label class='checkbox'>";
            $option = "<select class='myOption' name='option'>";
            foreach ($sel as $itsel) {
                $option = $option . <<<END
							 <option value="$itsel->id">$itsel->nom</option>
END;
            }
            $option = $option . <<<END
                </select><br>
END;
            foreach ($sel as $itsel) {
                $opt = SelectProd2opt::where('idSelect', '=', $itsel->id);
                $opt=$opt->where('idprod','=',$prod->id)->orderBy('prix')->get();
                if($itsel->id!=8){
                    $option = $option . <<<END
							<select class="mySelect" id="$itsel->id" name="$itsel->id">
END;
                    foreach ($opt as $optIt) {
                        if ($itsel->id != 7) {
                            $o = $optIt->prix;
                        } else {
                            $o = $optIt->nom;
                        }
                        $option = $option . <<<END
                        <option value="$o" prix="$optIt->prix">$optIt->nom - $optIt->prix €</option>
END;
                    }
                    $option = $option . <<<END
                </select><br>
END;
                }else{
                    $option = $option . <<<END
                        <div id="$itsel->id" class="mySelect">
                         <p>Prix au mètre : <span>$prod->prix</span> €</p>
                         largeur (cm):<input type='number' name='largeur' step="any" value=''><br>
                         longueur (cm):<input type='number' name='longueur' step="any" value=''><br>
                         <a id="CalculerPrix">Calculer le prix</a>
                        </div>
END;
                }
            }
            $option = $option . <<<END
                </select><br>
END;
        }
        $button=<<<end
                        <label>Quantité :</label>
									    <input type="text" name="quantite" class="span1" placeholder="1">                                   
                                        <button class='btn btn-inverse' type='submit'>Ajouter au panier</button>
end;

        $option = $option . <<<END
                </label>
				<br>
                <p>&nbsp;</p>
END;
        $img=$this->imageAdd($chemin);
        $addinfo=$this->info();
        $dispo='Indisponible pour le moment, mais vous pouvez le commander';
        if($prod->disponible==1){
            $dispo='En stock';
        }
        $prix="$prod->prix €";
        $cont=<<<END
            <section class="main-content">				
				<div class="row">						
					<div class="span9d" $css>
						<div class="row">
							<div class="span4">
								<a href="$chemin/images/Products/all/$prod->img" class="thumbnail" data-fancybox-group="group1" title="$prod->nom"><img alt="" src="$chemin/images/Products/all/$prod->img"></a>
								<ul class="thumbnails small">								
                                    $img
								</ul>
							</div>
							<div class="span5d">
								<address>
									<strong>Description :</strong> <span>$prod->descCourt</span><br>
									<strong>Disponibilité :</strong> <span>$dispo</span>
								</address>									
								<h4 class="price"><strong>$prix</strong></h4>
							</div>
							<div class="span5d">
								<form class="form-inline" id='form1' method='POST' action='$ajout'>
								    $option
									$button
								</form>
							</div>							
						</div>
						<div class="row">
							<div class="span9d" style="width: 100%;">
								<ul class="nav nav-tabs" id="myTab">
									<li class="active"><a href="#home">Description supplémentaire</a></li>
									<li class=""><a href="#profile">Information Additionnelle</a></li>
								</ul>							 
								<div class="tab-content">
									<div class="tab-pane active" id="home">$prod->descLong</div>
									<div class="tab-pane" id="profile">
										<table class="table table-striped shop_attributes">	
											<tbody>
												$addinfo
											</tbody>
										</table>
									</div>
								</div>							
							</div>
							<div class="span9d" style="width: 100%;">
								<br>
								<h4 class="title">
									<span class="pull-left"><span class="text"><strong>Vous aimeriez </strong>peu être </span></span>
									<span class="pull-right">
										<a class="left button" href="#myCarousel-1" data-slide="prev"></a><a class="right button" href="#myCarousel-1" data-slide="next"></a>
									</span>
								</h4>
								<div id="myCarousel-1" class="carousel slide">
									<div class="carousel-inner">
                                        <div class="active item">
                                            <ul class="thumbnails listing-products">		
END;
        $i=0;
        foreach ($va as $item) {
            $promo='';
            $m = "";
            $form=$this->prix($item);
            $sl = $item->sousliste()->first();
            if ($sl != null) {
                if ($sl->marque == 1) {
                    $m = $item->Marque()->first();
                }
            } else {
                $sl = $item->categorie()->first();
            }
            if ($i >= 3) {
                $i = 0;
                $cont = $cont . <<<END
                        </ul>
                    </div>
                    <div class="item"> 
                        <ul class="thumbnails listing-products">		
END;
            }
            if($item->promo==1){
                $promo="<span class='promo sale_tag'><h6>Promotion</h6></span>";
            }
            $app = \Slim\Slim::getInstance();
            $urldetail = $app->urlFor('detail', ["nomCat" => $sl->nom, 'id' => $item->id]);
            if ($m != null) {
                $urlcat = $app->urlFor("catalogueMq", ['nomCat' => $sl->nom, 'nomMarque' => $m->nom]);
            } else {
                $urlcat = $app->urlFor('catalogueSl', ['nomCat' => $sl->nom]);
            }
            if ($i > 0) {
                $bye = 'bye';
            } else {
                $bye = '';
            }
            $dispo='indisponible.png';
            if($item->disponible==1){
                $dispo='disponible.png';
            }
            $cont = $cont . <<<END
							<li class="span3 $bye">
								<div class="product-box">
									$promo
									<p><a href="$urldetail"><img src="$chemin/images/Products/all/$item->img" alt="" /></a></p>
									<div class="nom">
									    <img src="$chemin/images/$dispo">
									    <a href="$urldetail" class="title">$item->nom</a><br/>
									</div>
				    				<a href="$urlcat" class="category">$sl->nom</a>
									$form
								</div>
							</li>
END;
            $i++;
        }
        $cont = $cont . <<<END
                                            </ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
END;
                    $cat=$prod->sousliste()->first();
                    if($cat==null){
                        $cat=$prod->categorie()->first();
                    }else {
                        $cat=$cat->categorie()->first();
                    }
                        $R=$this->random($chemin);
                        $bs=$this->bestSeller($chemin);
                        $cont = $cont . <<<END
					<div class="span3" id="col">
						<div class="block bye">
							<ul class="nav nav-list">
							
							</ul>
							<br/>
						</div>
						<div class="block">
							<h4 class="title">
								<span class="pull-left"><span class="text">Produits aléatoires</span></span>
								<span class="pull-right">
									<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
								</span>
							</h4>
							<div id="myCarousel" class="carousel slide">
								<div class="carousel-inner">
									<div class="active item">
										<ul class="thumbnails listing-products">
											$R
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="block bye">
							<h4 class="title"><strong>Les plus</strong> vendus</h4>								
							<ul class="small-product">
								$bs
							</ul>
						</div>
					</div>
				</div>
			</section>
END;

        return $cont;

    }
    function random($chemin){
        $app = \Slim\Slim::getInstance();
        $R='';
        $form='';
        $rand=$this->content["random"];
        $i=0;
        foreach ($rand as $item) {
            $promo='';
            $m = "";
            $sl = $item->sousliste()->first();
            if ($sl != null) {
                if ($sl->marque == 1) {
                    $m = $item->Marque()->first();
                }
            } else {
                $sl = $item->categorie()->first();
            }
            if ($i >= 1) {
                $i = 0;
                $R = $R . <<<END
                        </ul>
                    </div>
                    <div class="item"> 
                        <ul class="thumbnails listing-products">		
END;
            }
            $form=$this->prix($item);
            if($item->promo==1){
                $promo="<span class='promo sale_tag'><h6>PROMO</h6></span>";
            }
            switch ($sl->nom){
                case 'Acrylique':
                case 'Huile':
                case 'Aquarelle':
                    $urldetail = $app->urlFor('palette', ["nomCat" => $sl->nom, 'nomProduit' => $item->nom]);
                    break;
                default:
                    $urldetail = $app->urlFor('detail', ["nomCat" => $sl->nom, 'id' => $item->id]);
                    break;
            }
            if ($m != null) {
                $urlcat = $app->urlFor("catalogueMq", ['nomCat' => $sl->nom, 'nomMarque' => $m->nom]);
            } else {
                $urlcat = $app->urlFor('catalogueSl', ['nomCat' => $sl->nom]);
            }
            if ($i > 0) {
                $bye = 'bye';
            } else {
                $bye = '';
            }
            $dispo='indisponible.png';
            if($item->disponible==1){
                $dispo='disponible.png';
            }
            $R = $R . <<<END
							<li class="span3d $bye">
								<div class="product-box">
									$promo
									<p><a href="$urldetail"><img src="$chemin/images/Products/all/$item->img" alt="" /></a></p>
									<div class="nom">
									    <img src="$chemin/images/$dispo">
									    <a href="$urldetail" class="title">$item->nom</a><br/>
									</div>
				    				<a href="$urlcat" class="category">$sl->nom</a>
				    				$form
								</div>
							</li>
END;
            $i++;
        }
        return $R;
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
    function bestSeller($chemin){
        $cont='';
        $bs=$this->content['bestSeller'];
        $app=\Slim\Slim::getInstance();
        foreach ($bs as $prod){
            $p=Produit::where('id','=',$prod->idProd)->first();
            $sl = $p->sousliste()->first();
            if ($sl == null) {
                $sl = $p->categorie()->first();
            }
            switch ($sl->nom){
                case 'Acrylique':
                case 'Huile':
                case 'Aquarelle':
                    $urldetail = $app->urlFor('palette', ["nomCat" => $sl->nom, 'nomProduit' => $p->nom]);
                    break;
                default:
                    $urldetail = $app->urlFor('detail', ["nomCat" => $sl->nom, 'id' => $p->id]);
                    break;
            }
            $cont=$cont.<<<end
                        <li>
							<a href="$urldetail" title="$p->nom">
								<img src="$chemin/images/Products/all/$p->img" alt="$p->nom">
							</a>
							<a href="$urldetail">$p->nom</a>
						</li>
end;
        }
        return $cont;

    }
    function search($chemin){
        $aPartit="";
        $app=\Slim\Slim::getInstance();
        $button="";
        $m=$this->content['Marque'];
        $p=$this->content['produits'];
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
						<h4 class='title'><span>Nos<strong> marques :</strong> résultat ($nbRes)</span></h4>";
        //initialisation du contenu


        $i=1;
        foreach ($m as $item) {
            $url=$app->urlFor('MarqueD',['nomMarque'=>$item->nom,'id'=>0]);
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
        $nbRes=$p->count();
        $cont=$cont."<h4 class='title'><span>Nos<strong> produit :</strong> résultat($nbRes)</span></h4>";
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
                $aPartit="<h3>À partir de</h3>";
            }
            $sl = $item->sousliste()->first();
            if ($sl != null) {
                if ($sl->marque == 1) {
                    $m = $item->Marque()->first();
                }
            } else {
                $sl = $item->categorie()->first();
            }
            if($item->promo==1){
                $promo="<span class='promo sale_tag'><h6>Promotion</h6></span>";
            }
            switch ($sl->nom){
                case 'Acrylique':
                case 'Huile':
                case 'Aquarelle':
                    $urldetail = $app->urlFor('palette', ["nomCat" => $sl->nom, 'nomProduit' => $item->nom]);
                    break;
                default:
                    $urldetail = $app->urlFor('detail', ["nomCat" => $sl->nom, 'id' => $item->id]);
                    break;
            }
            $dispo='indisponible.png';
            if($item->disponible==1){
                $dispo='disponible.png';
            }
            $form=$this->prix($item);
            $urlcat = $app->urlFor('marque', ['nomCat' => $sl->nom]);
            $cont = $cont . <<<END
                   <li class="span3S">
						<div class="product-box">
							$promo											
							<a href="$urldetail"><img alt="" src="$chemin/images/Products/all/$item->img"></a>
							<div class='desc'>
							    <div class="nom">
									    <img src="$chemin/images/$dispo">
									    <a href="$urldetail" class="title">$item->nom</a><br/>
									</div>
							    <a href="$urlcat" class="category">$sl->nom</a>
							    <p>$item->descCourt</p>
							</div>
							<div class='Ap'>
							    $form
						    </div>
						 </div>
					</li>
END;
            $i++;
            $button='';
            $aPartit="";
        }
        //on retourne le message
        return $cont.<<<end
                    	</ul>
					</div>
				</div>
end;
        ;

    }
    function MarqueD($chemin){
        $aPartit="";
        $app=\Slim\Slim::getInstance();
        $button="";
        $p=$this->content['produits'];
        $cont="
                <div class='affichageoption'>
					<button class='btn press' type='submit' id='mosaique'><img src='$chemin/images/Mosaique_icon.png'></button>
					<button class='btn ' type='submit' id='liste'><img src='$chemin/images/liste_icon.png'></button>
				</div>
				<div class='trieoption'>
					<a href='#col'>Trier les produits</a>
				</div>
                <div class='row'>
					<div class='span9'>								
						<ul class='thumbnails listing-products' id='catalogue'>
						<h4 class='title'><span>Nos<strong> produits :</strong></span></h4>";
        //initialisation du contenu
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
            if ($sl == null) {
                $sl = $item->categorie()->first();
            }
            if($item->promo==1){
                $promo="<span class='promo sale_tag'><h6>Promotion</h6></span>";
            }
            switch ($sl->nom){
                case 'Acrylique':
                case 'Huile':
                case 'Aquarelle':
                    $urldetail = $app->urlFor('palette', ["nomCat" => $sl->nom, 'nomProduit' => $item->nom]);
                    break;
                default:
                    $urldetail = $app->urlFor('detail', ["nomCat" => $sl->nom, 'id' => $item->id]);
                    break;
            }
            $dispo='indisponible.png';
            if($item->disponible==1){
                $dispo='disponible.png';
            }
            $form=$this->prix($item);
            $urlcat = $app->urlFor('marque', ['nomCat' => $sl->nom]);
            $cont = $cont . <<<END
                   <li class="span3">
						<div class="product-box">
							$promo											
							<a href="$urldetail"><img alt="" src="$chemin/images/Products/all/$item->img"></a>
							<div class='desc'>
							    <div class="nom">
									    <img src="$chemin/images/$dispo">
									    <a href="$urldetail" class="title">$item->nom</a><br/>
									</div>
							    <a href="$urlcat" class="category">$sl->nom</a>
							    <p>$item->descCourt</p>
							</div>
							<div class='Ap'>
							    $form
						    </div>
						 </div>
					</li>
END;
            $i++;
            $button='';
            $aPartit="";
        }
        //on retourne le message
        $marque='';
        $m=$this->content['marque'];
        $urlT0=$app->urlFor('MarqueD',['nomMarque'=>$m->nom,'id'=>0]);
        $tout="";
        $pc="";
        $pd="";
        $n="";
        $pro="";
        switch ($this->content["trie"]){
            case 0:
                $tout="active";
                break;
            case 1:
                $pc="active";
                break;
            case 2:
                $pd="active";
                break;
            case 3:
                $n="active";
                break;
            case 4:
                $pro="active";
                break;
        }
        $urlT1=$app->urlFor('MarqueD',['nomMarque'=>$m->nom,'id'=>1]);
        $urlT2=$app->urlFor('MarqueD',['nomMarque'=>$m->nom,'id'=>2]);
        $urlT3=$app->urlFor('MarqueD',['nomMarque'=>$m->nom,'id'=>3]);
        $urlT4=$app->urlFor('MarqueD',['nomMarque'=>$m->nom,'id'=>4]);
        $R=$this->random($chemin);
        $bs=$this->bestSeller($chemin);
        return $cont.<<<end
                    	</ul>
					</div>
                    <div class="span3" id="col">
						<div class="block">
							<ul class="nav nav-list">
								<li class="nav-header">Trie</li>
								<li class="$tout"><a href="$urlT0">Tous</a></li>
								<li class="$pc"><a href="$urlT1">Prix Croissant</a></li>
								<li class="$pd"><a href="$urlT2">Prix Décroissant</a></li>
								<li class="$pro"><a href="$urlT4">Promotion</a></li>
								<li class="$n"><a href="$urlT3">Nom</a></li>
							</ul>
							<br/>
						</div>
						<div class="block">
							<h4 class="title">
								<span class="pull-left"><span class="text">Produits aléatoires</span></span>
								<span class="pull-right">
									<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
								</span>
							</h4>
							<div id="myCarousel" class="carousel slide">
								<div class="carousel-inner">
									<div class="active item">
										<ul class="thumbnails listing-products">
											$R
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="block bye">
							<h4 class="title"><strong>Les plus</strong> vendus</h4>								
							<ul class="small-product">
								$bs  
							</ul>
						</div>
					</div>
				</div>
end;
        ;

    }

    function palette($chemin){
        $palette=<<<end
                                <div class="tab-pane" id="palette">
									<table class="table table-striped shop_attributes">	
										<tbody class="nuancier">
end;
        $colors=$this->content['Color'];
        $prod=$this->content['marque'];
        foreach ($colors as $color) {
            $app=\Slim\Slim::getInstance();
            $ajout = $app->urlFor('ajProd', ['id' => $prod->id]);
            $condi="<select class='mySelectP' name='6' size='1' >";
            $size=C2S::where('idColor','=',$color->id)/*;
            $size=$size->where('idprod','=',$prod->id)*/->get();
            foreach ($size as $opt){
                $opt=Size::where('id','=',$opt->idSize)->first();
                $condi.="<option value='$color->id/$opt->id' prix='$opt->prix'>$opt->taille $opt->serie - $opt->prix €</option>";
            }
            $condi.="</select>";
            $palette =$palette.<<<END
                        <tr class="itemNuancier">
				     		<form class="form-inline" id='form1' method='POST' action='$ajout'>
				     		<input type="hidden" name="option" value="6">
				     		<th>
								<img src="$chemin/images/Products/palette/$color->img">
							</th>
							<td>
								<div class="couleurC">
	    							<h4>$color->nom</h4>
	    							$condi
	    						</div>
		    					<div class="couleurP">
		    						<button class="btn btn-inverse" type="submit" style="float: right;">Ajouter</button>
	    	    	  				<label><h4 class="price palleteprice"><strong>Prix: 0.00€</strong></h4></label>
	    	    	  				<span>Quantité:<input type="number" min="1" name="quantite" class="span1 spanPalette" placeholder="1"></span>
			   					</div>
	    					</td>
	    					</form>
						</tr>
END;
        }
        return $palette."</tbody></table></div>";
    }
    function imageAdd($chemin){
        $sl=$this->content['sousliste'];
        $prod=$this->content['prod'];
        $img="";
        $images=image::where('idProduit','=',$prod->id)->get();
        foreach ($images as $image){
            $img.=<<<end
                    <li class="span1">
						<a href="$chemin/images/Products/all/$image->nom" class="thumbnail" data-fancybox-group="group1" title="$image->descImg"><img src="$chemin/images/Products/all/$image->nom" alt=""></a>
					</li>
end;
        }
        return $img;
    }
    function info(){
        $prod=$this->content["prod"];
        $m=$prod->Marque()->first();
        if($m ==null){
            $marque='non disponible';
        }else{
            $marque=$m->nom;
        }
        if($prod->hauteur == 10000){
            $h='non disponible';
        }else{
            $h=$prod->hauteur;
        }
        if($prod->largeur == 10000){
            $l='non disponible';
        }else{
            $l=$prod->largeur;
        }
        return <<<end
                <tr class="">
					<th>Marque</th>
					<td>$marque</td>
				</tr>		
				<tr class="">
		    		<th>Hauteur (mm)</th>
					<td>$h</td>
				</tr>
                <tr class="">
		    		<th>Largeur (mm)</th>
					<td>$l</td>
				</tr>
                <tr class="alt">
		    		<th>EAN</th>
					<td>$prod->EAN</td>
				</tr>
end;
    }



}