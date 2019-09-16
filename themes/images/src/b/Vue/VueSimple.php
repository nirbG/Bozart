<?php

namespace b\Vue;

use b\Models\Categorie;
use b\models\Color;
use b\models\Produit;
use b\models\Select;
use b\models\SelectProd2opt;
use b\models\Souliste;
use b\Models\sousliste;
use b\Models\Size;
use Slim\Slim;

class VueSimple{

    private $content;

    function __construct($req=null){
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
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->CGV();
                break;
            case 2:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->Ml();
                break;
            case 3:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->aUS();
                break;
            case 4:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->cUS();
                break;
            case 5:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont=$this->Cart($chemint);
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
						$compte
						<li><a href="$cart" class="Menucompte">Mon panier($nbprod)</a></li>
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
			$cont
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
			var cart={
			    module:{},
			};
			cart.module.app=(function () {
			    return{
			        Start : function () {
                        cart.module.prix.init();
                    }
				}
            })();
			cart.module.prix=(function(){
			    return{
			        init:function () {
                        $(".plus").click(function (event){
                             var tr=$(event.target).closest('tr'); 
                             var prix=tr.attr('postoption');
                             var url=tr.attr('plus');
                             var opt=tr.attr('opt');
                             if((opt!='image')&&(opt!='palette')){
                                prix=parseFloat(prix);
                             }
                             console.log('1 '+opt+' '+prix+' '+url);
                              console.log('1 '+opt+' '+prix+' '+url);
                             var data='quantite=' + 1 + '&dmc=' + opt+'&'+opt+'='+prix;
                             console.log(data);
                             return $.ajax(url, {
                             type: 'POST',
                             dataType : 'text',
                             data: data ,
                             xhrFields: {withCredentials: true},
                             error: function (resultat, statut, erreur) {
                                 console.log(erreur);
                            }
                            }).done(function (reponse, status, jqXHR) {
                                 var h8=$($(event.target).parent()).find("h8");
                                 h8.text(parseInt(h8.text()) + 1);
                                 cart.module.prix.modifprix(h8);
                            });
                        });
                        $(".moins").click(function (event) {
                             var tr=$(event.target).closest('tr'); 
                             var url=tr.attr('moins');
                             return $.ajax(url, {
                             type: 'GET',
                             context:this,
                             xhrFields: {withCredentials: true},
                             error: function (resultat, statut, erreur) {
                                 console.log(erreur);
                            }
                            }).done(function (reponse, status, jqXHR) {
                                 var h8=$($(event.target).parent()).find("h8");
                                 if(h8.text()!=1) {
                                    h8.text(parseInt(h8.text()) - 1);
                                 }else{
                                    window.location.href=window.location.href;
                                }
                                cart.module.prix.modifprix(h8);
                            });
                        });
                        console.log('init');
                        $.each($('h8'), function (index, value) {
                            var qt=parseInt($(value).text());
                            var p=$($(value).closest("tr")).find(".prix");
                            var pU=$($(value).closest("tr")).find(".prixU");
                             console.log(qt);
                             console.log(pU.text());
                            p.text(parseFloat(qt*parseFloat(pU.text())).toFixed(2)+"€");
                        });
                        cart.module.prix.modiftotal();
                    },
                    modifprix:function (event) {
                        var qt=parseInt($(event).text());
                        var p=$($(event).closest("tr")).find(".prix");
                        var pU=$($(event).closest("tr")).find(".prixU");
                        p.text(parseFloat(qt*parseFloat(pU.text())).toFixed(2)+"€");
                        cart.module.prix.modiftotal();
                    },
                    modiftotal:function () {
                        var nP=0;
                        $.each($('.prix'), function (index, value) {
                            var i=parseFloat($(value).text()).toFixed(2);
                            nP+=(+i);
                        });
                        $(".total").html("<strong>Total</strong>:"+nP+"€");
                        $(".cart-total").html("<br><strong>Total HT</strong>:"+parseFloat(nP*0.80).toFixed(2)+"€"+"<br><strong>TVA</strong>:"+parseFloat(nP*0.20).toFixed(2)+"€"+"<br><strong>Total TTC</strong>:"+nP+"€");
                    }
				}
			})();
            $(document).ready(function() {
                cart.module.app.Start();
            });
		</script>
    </body>
</html>
END;


        return $html;
    }
    function CGV(){
        $cont=<<<END
        <section class="header_text sub">
				<h1>CONDITIONS GÉNÉRALES DE VENTE</h1>
			</section>
			<section class="main-content">				
				<div class="row">
					<div class="span9C">
						<p>
							Toute commande passée à Bozart entraîne l'adhésion sans réserve aux présentes
							conditions générales de vente auxquelles il ne pourra en aucun cas être dérogé
							, sauf accord express et écrit.
						</p>
						<h4 class="title">A. LES COMMANDES </h4>
						<p>Les commandes sont acceptées :</p>
						<ul>
							<li>Pour les commandes écrites ou passées par fax ou téléphone :
								Au comptant à la commande par chèque bancaire ou postal, mandat cash ou carte bancaire
								Avec versement d'un acompte de 20% à la commande, le solde étant payé contre remboursement,
								lors de la livraison, moyennant des frais supplémentaires de 16 euros.</li>
							<li>
								Pour les commandes passées par internet et réglées sur site sécurisé :
								Au comptant à la commande par carte bancaire exclusivement.
							</li>
						</ul>
						<h4 class="title">B. LES FRAIS DE PORT</h4>
						<ul>
							<li>France Métropolitaine hors Corse
								Le franco de port et d’emballage est accordé à partir d’une facturation de 350 euros. Au
								dessous de ce montant, les frais de port et d’emballage sont fixés forfaitairement à 15
								euros (avec une majoration de 5 euros si la commande contient des cadres et des chassis)
							</li>
						</ul>
						<h3>
							Pour une commande de peinture, le franco de port et d’emballage est accordé à partir d’une
							facturation de 100 euros. Au dessous de ce montant, les frais de port et d’emballage sont
							fixés forfaitairement à 15 euros.
						</h3>
						<br>
						<h3>
							Pour une commande de pinceaux, le franco de port et d’emballage est accordé à partir d’une
							facturation de 60 euros. Au dessous de ce montant, les frais de port et d’emballage sont
							fixés forfaitairement à 10 euros.
						</h3>
						<ul>
							<li><p>Corse </p><p>Les frais de port et d’emballage sont fixés forfaitairement à 30 euros,
								quelle que soit le montant de la commande passée.</p>
							</li>
							<li><p>Belgique et Luxembourg </p><p>Les frais de port et d’emballage sont fixés en fonction du montant de la commande :<br>
								Commande d’un montant de 0 à 100 € : 16 € de frais de port TTC<br>
								Commande d’un montant de 101 à 300 € : 34 € de frais de port TTC<br>
								Commande d’un montant supérieur à 301 € : 52 € de frais de port TTC</p>
							</li>
							<li><p>Suisse </p><p>Les frais de port et d’emballage sont fixés en fonction du montant de la commande :<br>
								Commande d’un montant de 0 à 100 € : 16 € de frais de port TTC<br>
								Commande d’un montant de 101 à 300 € : 34 € de frais de port TTC<br>
								Commande d’un montant supérieur à 301 € : 52 € de frais de port TTC</p>
							</li>
						</ul>
						<h4 class="title">C. DÉLAIS DE LIVRAISON </h4>
						<p>Notre objectif est de vous livrer sous 3 à 5 jours, à partir de la date de réception de votre
							commande de produits courants. Ces délais sont purement indicatifs et leur respect est sans
							garantie, trop de paramètres rentrant en jeu. Nous nous réservons le droit d'annuler toutes
							commandes (en partie ou en totalité) en cas de force majeure. Tous les articles présentés
							sur www.bozart.fr sont livrables dans la limite des stocks disponibles. Pour les paiements
							par chèque, les produits sont expédiés dès lors que nous avons reçu votre bon de commande
							accompagné de votre règlement. Dans ce cas de figure, merci d'imprimer le bon de commande
							ou d'inscrire le numéro de commande au dos du chèque et de nous faire parvenir votre
							règlement par courrier à l'adresse suivante :BOZART - 118 boulevard de La Rochelle - 55000
							BAR LE DUC - FRANCE</p>
						<h4 class="title">D. LES TARIFS</h4>
						<p>Nos prix sont mentionnés en euros, toutes taxes comprises.
							Nous nous réservons le droit de les modifier en cas de changement du taux de la TVA.
							Ils sont valables jusqu'au 31 décembre 2013.</p>
						<h4 class="title">E. SPÉCIFICITÉ DES ARTICLES PRÉSENTÉS PAR BOZART </h4>
						<p>Les photos et les nuanciers présentés par Bozart ne sont pas contractuels.
							Il n'existe pas de norme standard ou homologuée pour les pinceaux et les couleurs.
							Les techniques d'impression et de reproduction peuvent déformer certaines nuances.
							Un écart de coloris ne peut donner lieu à aucune contestation ou remettre en cause la commande.
							Les commandes sont réglables uniquement en euros.</p>
						<h4 class="title">F. EXPÉDITION, CLAUSES DE RÉSERVE DE PROPRIÉTÉ, RÉCLAMATION </h4>
						<p>Les marchandises voyagent au risque et périls du destinataire.
							Il lui appartient d'annoter ses réserves immédiatement auprès du transporteur, à la réception
							des marchandises, en mentionnant sur les bons de livraison les défauts constatés (colis écrasés,
							déformés, abîmés ; troués, tachés... cette liste n'étant pas exhaustive) et de confirmer cette
							réserve par lettre recommandée avec accusé de réception adressée au transporteur dans les 48 heures de la réception.
							ATTENTION : La mention " sous réserve de déballage " est sans valeur.<br>
							Les marchandises ne sont considérées comme acquises par l'acheteur qu'après paiement intégral de la facture.
							La livraison ne représentant en aucun cas un transfert de propriété : loi n°80335 du 12 mai 1980.<br>
							Les marchandises défectueuses doivent être retournées à BOZART - 118 boulevard de La Rochelle - 55000 BAR LE DUC - FRANCE, sous leur emballage d'origine, dans les 8 jours qui suivent la réception.
							Tout défaut dûment constaté fera l'objet d'un remplacement pur et simple de la marchandise jugée défectueuse, à l'exclusion de toute indemnité.
							<br>Aucune réclamation ne sera acceptée passé un délai de 8 jours, à compter de la réception de la marchandise.
							Une indemnité forfaitaire de 40€ pour frais de recouvrement sera aplliquée en cas de retard de paiement conformément aux articles L.441-3 et L.411-6 du Code du commerce.</p>
						<h4 class="title">G. CONTESTATION </h4>
						<p>Pour toute contestation, quelle qu'en soit la cause, il est fait par dérogation attribution
							expresse de juridiction au Tribunal de Commerce de Bar le Duc.Les effets, chèques ou tout
							autre mode de règlement, ne font pas novation aux clauses ci-dessus qui sont expressément
							attributives de la juridiction du Tribunal de Commerce de Bar le Duc.</p>
						<h4 class="title">H. DROITS D'ACCÈS AUX FICHIERS</h4>
						<p>Le client dispose conformément à la loi Informatique et Libertés d'un droit d'accès et de
							rectification relatif aux données le concernant ainsi qu'un droit d'opposition.
							Pour exercer l'un de ces droits, le client devra adresser un simple mail à contact@bozart.fr</p>
					</div>
				</div>
			</section>
END;
        return $cont;
    }
    function Ml(){
        $cont=<<<END
        <section class="header_text sub">
				<h1>MENTION LEAGLE</h1>
			</section>
			<section class="main-content">				
				<div class="row">
					<div class="span9C">
						<p>
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
							blablablablablablablablablablablablablablablablablablablablablablablablablablabla
						</p>
					</div>
				</div>
			</section>
END;
    return $cont;
    }
    function aUS(){
        $cont=<<<END
        <section class="google_map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8697.140494566731!2d5.165251599999997!3d48.7708915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xdc13acd5d2e767f9!2sLeroux+Patrice!5e1!3m2!1sfr!2sfr!4v1493104955515" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen style="display:none"></iframe>
			</section>
			<section class="header_text sub">
				<h4><span>About Us</span></h4>
			</section>
			<section class="main-content">				
				<div class="row">				
					<div class="span5">
						<div>
							<h5>ADDITIONAL INFORMATION</h5>
							<p>
								<strong>adresse:</strong>Address: 118 Boulevard de la Rochelle, 55000 Bar-le-Duc<br>
								<strong>telephone:</strong>03 29 77 12 34<br>
								<strong>mobile:</strong>06 80 05 66 45<br>
								<strong>Email:</strong>&nbsp;<a href="#">contact@bozart.fr</a>
							</p>
							<br/>
						</div>
					</div>
					<div class="span7">
						<p>Bozart est une entreprise crée en 1995 ,par Patrice Leroux a bar le Duc (Meuse), c'est un magasin crée par un passioné  pour
							les passionné d'art. Bozart propose de nombeux produit dans de nombreux domaine Artistique comme la peinture, le dessin, l'Art
							graphique... Il propose aussi d'encadrer vos oeuvres ou les oeuvres des membres de votre famille. Si vous avez des besoin de conseil
							passez nous voir ou envoyer nous un mail.</p>

					</div>				
				</div>
			</section>
END;
        return $cont;
    }
    function cUS(){
        $app= \Slim\Slim::getInstance();
        $sendM=$app->urlFor('sendM');
        $cont=<<<END
<section class="google_map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8697.140494566731!2d5.165251599999997!3d48.7708915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xdc13acd5d2e767f9!2sLeroux+Patrice!5e1!3m2!1sfr!2sfr!4v1493104955515" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen style="display:none"></iframe>
			</section>
			<section class="header_text sub">
				<h4><span>Contact Us</span></h4>
			</section>
			<section class="main-content">				
				<div class="row">				
					<div class="span5">
						<div>
							<h5>ADDITIONAL INFORMATION</h5>
							<p>
								<strong>adresse:</strong>Address: 118 Boulevard de la Rochelle, 55000 Bar-le-Duc<br>
								<strong>telephone:</strong>03 29 77 12 34<br>
								<strong>mobile:</strong>06 80 05 66 45<br>
								<strong>Email:</strong>&nbsp;<a href="#">contact@bozart.fr</a>
							</p>
							<br/>
						</div>
					</div>
					<div class="span7">
						<p>N'hesitez pas si vous avez besoin de conseil, des probleme avac la marchandise reçu.<br><strong>Envoyez votre Numeros de téléphone dans le message pour qu'on vous rappelle pour en discuter.</strong></Strong></p>
						<form method="post" action="$sendM">
							<fieldset>
								<div class="clearfix">
									<label for="name"><span>Name:</span></label>
									<div class="input">
										<input tabindex="1" size="18" id="name" name="name" type="text" value="" class="input-xlarge" placeholder="Name" style="width: 50%">
									</div>
								</div>
								
								<div class="clearfix">
									<label for="email"><span>Email:</span></label>
									<div class="input">
										<input tabindex="2" size="25" id="email" name="email" type="text" value="" class="input-xlarge" placeholder="Email Address" style="width: 50%">
									</div>
								</div>
								
								<div class="clearfix">
									<label for="message"><span>Message:</span></label>
									<div class="input">
										<textarea tabindex="3" class="input-xlarge" id="message" name="body" rows="7" placeholder="message (n'oublier pas de nous donner votre numero de telephone)" style="width: 100%"></textarea>
									</div>
								</div>
								
								<div class="actions">
									<button tabindex="3" type="submit" class="btn btn-inverse">Send message</button>
								</div>
							</fieldset>
						</form>
					</div>				
				</div>
			</section>
END;
        return $cont;
    }
    function Cart($chemin){
        $cart="";
        $app=\Slim\Slim::getInstance();
        $valider=$app->urlFor('valider');
        foreach ($this->content as $item){
            $prod=$item["prod"];
            $q=$item['quantite'];
            $opt=$item["option"];
            $sl=$prod->sousliste()->first();
            if($sl==null){
                $sl=$prod->categorie()->first();
            }
            $prix='';
            $app=\Slim\Slim::getInstance();
            $urlp=$app->urlFor('detail',["nomCat"=>$sl->nom,'id'=>$prod->id]);
            if($opt=='image'){
                $desc='';
                $prix=$prod->prix;
                $postoption='image';
                $o=$item["option"];
            }else{
                if($opt=='palette'){
                    $color=Color::where('id','=',$item['Color'])->first();
                    $size=Size::where('id','=',$item['size'])->first();
                    $postoption=$item['Color']."/".$item['size'];
                    $desc="$color->nom <br> $size->serie $size->taille";
                    $prix = $size->prix;
                    $o=$opt;
                    $item["option"]=$item['Color']."&".$item['size'];
                    $urlp = $app->urlFor('palette', ['nomCat' => $sl->nom,"nomProduit"=>$prod->nom]);
                }else{
                    $s = SelectProd2opt::where('idprod', '=', $prod->id);
                    $s = $s->where('nom', '=', $opt)->first();
                    $o=Select::where('id','=',$s->idSelect)->first();
                    $o=$o->nom;
                    $prix = $s->prix;
                    $desc=$opt;
                    $postoption=$prix;
                }
            }
            $app=\Slim\Slim::getInstance();
            $urlsupp=$app->urlFor('supProd',['id'=>$prod->id,'qt'=>-1,'opt'=>$item["option"]]);
            $urlmoins1=$app->urlFor('supProd',['id'=>$prod->id,'qt'=>1,'opt'=>$item["option"]]);
            $urlajout1=$app->urlFor('ajProd',['id'=>$prod->id]);
            $cart=$cart.<<<END
                <tr  moins="$urlmoins1" plus="$urlajout1" id="$prod->id" opt="$o" postoption="$postoption">
					<td class="poubelle"><a href="$urlsupp"><img class="supp" src="$chemin/images/p_icon.png"></a></td>
					<td class="cartimg"><a href="$urlp"><img alt="" src="$chemin/images/Products/$sl->nom/$prod->img"></a></td>
					<td><a href="$urlp">$prod->nom</a> <br> $desc</td>
					<td><img class="moins" src="$chemin/images/moins_icon.png"> <h8>$q</h8> <img class="plus" src="$chemin/images/plus_icon.png"></td>
					<td class="prixU">$prix €</td>
	    			<td class="prix">$prix €</td>
				</tr>	
END;
        }
        $cont=<<<END
            <section class="header_text sub">
			    <img class="pageBanner" src="$chemin/images/banner/pageBannerCart.jpg" alt="New products" >
				<h4><span>Validation du Panier</span></h4>
			</section>
			<section class="main-content">				
				<div class="row">
					<div class="span9C">
						<h4 class="title"><span class="text"><strong>Votre</strong> Panier</span></h4>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>supprimer</th>
									<th>Image</th>
									<th>nom du produit</th>
									<th>qunatité</th>
									<th>prix unitaire</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody class="cart">
								$cart
								<tr class="total">
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td class="total"><strong>$3,600.00</strong></td>
								</tr>		  
							</tbody>
						</table>
						<h4>What would you like to do next?</h4>
						<p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
						<label class="radio">
							<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
							Use Coupon Code
						</label>
						<label class="radio">
							<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
							Estimate Shipping &amp; Taxes
						</label>
						<hr>
						<p class="cart-total right">
							<strong>Sub-Total</strong>:	$100.00<br>
							<strong>Eco Tax (-2.00)</strong>: $2.00<br>
							<strong>VAT (17.5%)</strong>: $17.50<br>
							<strong>Total</strong>: $119.50
						</p>
						<hr/>
						<p>Pour chaque commande, vous avez la possibilité de régler par chèque ou par carte bancaire. Dans
							ce dernier cas, le système de paiement sécurisé grâce à la technologie SSL est assuré par Paypal.
							En aucun cas votre numéro de carte bancaire ne circule en clair et il n'est transmis qu'à votre banquier. </p>
						<hr/>
						<p class="buttons center">				
							<!--<button class="btn" type="button">Update</button>-->
							<a href="$valider"><button class="btn btn-inverse"  type="submit">Valider votre Panier</button></a>
							<!--<button class="btn btn-inverse" type="submit" id="checkout">Checkout</button>-->
						</p>					
					</div>
				</div>
			</section>
END;
    return $cont;
    }
}