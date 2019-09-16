<?php

namespace b\Vue;

use b\Models\Categorie;
use b\models\Client;
use b\models\Color;
use b\models\Panier;
use b\models\Produit;
use b\models\SelectProd2opt;
use b\models\Size;
use b\models\Souliste;
use b\Models\sousliste;
use Slim\Slim;
use b\utils\AuthException;

class VueCompte{

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
                $cont = $this->form();
                break;
            case 2:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = 'connexion';
                break;
            case 3:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->inscription();
                break;
            case 4:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->inscription2();
                break;
            case 5:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->detail($chemint);
                break;
            case 6:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->modifierCoor();
                break;
            case 7:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->modiPassword();
                break;
            case 8:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->saisimp();
                break;
            case 9:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->payer();
                break;
            case 10:
                $cheminb = "../../bootstrap";
                $chemint = "../../themes";
                $id=$this->content['panier'];
                $this->content=$this->content['contient'];
                $cont = $this->Pdetail($chemint,$id);
                break;
            case 11:
                $cheminb = "../bootstrap";
                $chemint = "../themes";
                $cont = $this->saisirEmail($chemint);
                break;
            case 12:
                $cheminb = "../../../bootstrap";
                $chemint = "../../../themes";
                $email=$this->content['email'];
                $this->content=$this->content['erreur'];
                $cont = $this->ModMp($email);
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
		<title>Bozart : Mon Compte</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Bienvenu chez Bozart. 
		Le prix du gros au détail. C'est le choix de la qualité parmi un large éventail de 
		produits concernant les beaux-arts. acceder a votre compte pour modifier vos coordonnée ou voir le detail de vos commande et les suivre.">
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
			$cont
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
    </body>
</html>
END;


        return $html;
    }

    function  form(){
        $erreur="";
        if($this->content!=null){
            $erreur="<p class='erreurCo'>$this->content </p>";
        }
        $app=\Slim\Slim::getInstance();
        $urlCo=$app->urlFor("co");
        $urlins=$app->urlFor("ins",['erreur'=>'input']);
        $saisirEmail=$app->urlFor("saisirEmail",['erreur'=>'input']);
       $cont=<<<end
            <section class="main-content">				
				<div class="row">
					<div class="seconnecter">					
						<h4 class="title"><span class="text"><strong>Se</strong> Connecter</span></h4>
						$erreur
						<form  method="post" action="$urlCo" >
							<input type="hidden" name="next" value="/">
							<fieldset>
								<div class="control-group">
									<label class="control-label">Nom d'utilisateur</label>
									<div class="controls">
										<input type="email" name="email" placeholder="entrer votre email" id="username" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Mot de passe</label>
									<div class="controls">
										<input type="password" name="password" placeholder="entrer votre mot de passe" id="password" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
								    <p class="reset"><a tabindex="4" href="$saisirEmail" title="Recover your username or password">Mot de passe Oublié</a></p>
									<input tabindex="3" class="btn btn-inverse large" type="submit" value="Sign into your account">
									<hr>
									<p class="reset">vous n'avez pas de compte,<a tabindex="4" href="$urlins" title="Recover your username or password"> inscrivez vous</a></p>
								</div>
							</fieldset>
						</form>				
					</div>
                </div>
            </section>
end;
        return $cont;
    }

    function inscription(){
        $erreur="";
        if($this->content!=null){
            $erreur="<p class='erreur'>$this->content </p>";
        }
        $app=\Slim\Slim::getInstance();
        $url=$app->urlFor('Sins');
        $cont=<<<end
                    <div class="inscription">					
						<h4 class="title"><span class="text"><strong>Register</strong> Form</span></h4>
						$erreur
						<form action="$url" method="post" class="form-stacked">
							<fieldset>
								<div class="control-group">
									<label class="control-label">email</label>
									<div class="controls">
										<input type="email" name="email" placeholder="Enter your username" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Password:</label>
									<div class="controls">
										<input type="password" name="password" placeholder="Enter your email" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Password confirmation:</label>
									<div class="controls">
										<input type="password" name="confirm" placeholder="Enter your password" class="input-xlarge">
									</div>
								</div>							                            
								<div class="control-group">
									<p>Now that we know who you are. I'm not a mistake! In a comic, you know how you can tell who the arch-villain's going to be?</p>
								</div>
								<hr>
								<div class="actions"><input tabindex="9" class="btn btn-inverse large" type="submit" value="Create your account"></div>
							</fieldset>
						</form>					
					</div>				
				
end;
        return $cont;

    }


    function inscription2(){
        $erreur="";
        if($this->content!=null){
            $erreur="<p class='erreur'>$this->content </p>";
        }
        $app=\Slim\Slim::getInstance();
        $url=$app->urlFor('Sins2');
        $cont=<<<end
                    <div class="inscription">					
						<h4 class="title"><span class="text"><strong>Register</strong> Form</span></h4>
						$erreur
						<form action="$url" method="post" class="form-stacked">
							<fieldset>
								<div class="control-group">
									<label class="control-label">rue</label>
									<div class="controls">
										<input type="text" name="rue" placeholder="Enter your username" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">ville</label>
									<div class="controls">
										<input type="text" name="ville" placeholder="Enter your email" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Code Postal</label>
									<div class="controls">
										<input type="number" name="cd" placeholder="Enter your password" class="input-xlarge">
									</div>
								</div>	
								<div class="control-group">
									<label class="control-label">Departemt</label>
									<div class="controls">
										<input type="text" name="departement" placeholder="Enter your password" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<p>Now that we know who you are. I'm not a mistake! In a comic, you know how you can tell who the arch-villain's going to be?</p>
								</div>
								<hr>
								<div class="actions"><input tabindex="9" class="btn btn-inverse large" type="submit" value="Create your account"></div>
							</fieldset>
						</form>					
					</div>				
				
end;
        return $cont;

    }
    function modifierCoor(){
        $erreur="";
        if($this->content!=null){
            $erreur="<p class='erreur'>$this->content </p>";
        }
        $app=\Slim\Slim::getInstance();
        $profile=$_SESSION['profile'];
        $client=Client::where('id','=',$profile['userid'])->first();
        $url=$app->urlFor('setinfo');
        $cont=<<<end
                    <div class="inscription">					
						<h4 class="title"><span class="text"><strong>modifier</strong> modifier</span></h4>
						$erreur
						<form action="$url" method="post" class="form-stacked">
							<fieldset>
								<div class="control-group">
									<label class="control-label">rue</label>
									<div class="controls">
										<input type="text" name="rue" placeholder="Enter your username" class="input-xlarge" value="$client->rue">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">ville</label>
									<div class="controls">
										<input type="text" name="ville" placeholder="Enter your email" class="input-xlarge" value="$client->ville">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Code Postal</label>
									<div class="controls">
										<input type="number" name="cd" placeholder="Enter your password" class="input-xlarge" value="$client->codePostal" >
									</div>
								</div>	
								<div class="control-group">
									<label class="control-label">Departemt</label>
									<div class="controls">
										<input type="text" name="departement" placeholder="Enter your password" class="input-xlarge" value="$client->departement">
									</div>
								</div>
								<div class="control-group">
									<p>Now that we know who you are. I'm not a mistake! In a comic, you know how you can tell who the arch-villain's going to be?</p>
								</div>
								<hr>
								<div class="actions"><input tabindex="9" class="btn btn-inverse large" type="submit" value="enregistre les modification"></div>
							</fieldset>
						</form>					
					</div>				
				
end;
        return $cont;

    }
    function modiPassword(){
        $erreur="";
        if($this->content!=null){
            $erreur="<p class='erreur'>$this->content </p>";
        }
        $app=\Slim\Slim::getInstance();
        $url=$app->urlFor('confirmMP');
        $cont=<<<end
                    <div class="inscription">					
						<h4 class="title"><span class="text"><strong>modifier</strong> mot de passe</span></h4>
						$erreur
						<form action="$url" method="post" class="form-stacked">
							<fieldset>
								<div class="control-group">
									<label class="control-label">confirmer l'ancien mot de passe</label>
									<div class="controls">
										<input type="password" name="password" placeholder="Enter your username" class="input-xlarge">
									</div>
								</div>							                            
								<div class="actions"><input tabindex="9" class="btn btn-inverse large" type="submit" value="continuer"></div>
							</fieldset>
						</form>					
					</div>				
				
end;
        return $cont;

    }
    function saisimp(){
        $erreur="";
        if($this->content!=null){
            $erreur="<p class='erreur'>$this->content </p>";
        }
        $app=\Slim\Slim::getInstance();
        $url=$app->urlFor('enregistreMP');
        $cont=<<<end
                    <div class="inscription">					
						<h4 class="title"><span class="text"><strong>modifier</strong> mot de passe</span></h4>
						$erreur
						<form action="$url" method="post" class="form-stacked">
							<fieldset>
								<div class="control-group">
									<label class="control-label">nouveau  mot de passe</label>
									<div class="controls">
										<input type="password" name="password" placeholder="Enter your username" class="input-xlarge">
									</div>
								</div>		
								<div class="control-group">
									<label class="control-label">confirme</label>
									<div class="controls">
										<input type="password" name="confirm" placeholder="Enter your username" class="input-xlarge">
									</div>
								</div>
								<div class="actions"><input tabindex="9" class="btn btn-inverse large" type="submit" value="continuer"></div>
							</fieldset>
						</form>					
					</div>				
				
end;
        return $cont;

    }
    function detail($chemint){
        $app=\Slim\Slim::getInstance();
        $deco=$app->urlFor('deco');
        $sav=$app->urlFor('contactUS');
        $mC=$app->urlFor('modifierCoor',['erreur'=>'input']);
        $mMP=$app->urlFor('ConfirmationMP',['erreur'=>'input']);
        $profile=$_SESSION['profile'];
        $client=Client::where('id','=',$profile['userid'])->first();
        $paniers=Panier::where('idCreateur','=',$client->id)->orderBy('date','desc')->get();
        $liste='';

        if($paniers->count() ==0) {
            $liste = "<h1>Vous n'avez pas encore valider de panier</h1>";
        }else {
            foreach ($paniers as $panier){
                    $src="";
                    if($panier->etat=='reçu'){
                        $src=$chemint."/images/reçu.png";
                    }else{
                        $src=$chemint."/images/validé.png";
                    }
                    $dP=$app->urlFor('panierDetail',['id'=>$panier->id]);
                    $liste=$liste.<<<end
                     <div>
                        <img src="$src">
                        <h4 class="title"><strong>Panier du $panier->date</strong></h4>
                        <p>$panier->etat</p>
                        <a href="$dP">detail</a>
                    </div>
end;

            }
        }
        $admin="";
        if($client->role_id==2){
            $A=$app->urlFor('adminMenu');
            $admin="<a href='$A' class='adminButton'><h4>admin</h4></a>";
        }
        $cont=<<<end
        
        <div id="Compte">
            <h1 class="title">mon Compte</h1>
            <div class="listePanier">
                <h4 class="title"> Mes <strong>Commandes</strong></h4>
                <div class="liste">$liste</div>
            </div>
            <div class="Compteoption">
                <div>
                    <h4 class="title"><strong>information</strong></h4>
                    <p>rue: $client->rue</p>
                    <p>ville: $client->ville</p>
                    <p>Code Postal: $client->codePostal </p>
                    <p>departement: $client->departement</p>
                </div>
                $admin
                <a href="$mC"><h4>Modifier coordonnée</h4></a>
                <a href="$mMP"><h4>Modifier mot de passe</h4></a>
                <a href="$sav"><h4>Sav</h4></a>
                <a href="$deco"><h4>Deconnection</h4></a>
            </div>
             <h4 class="title"><strong><a href=''> </a></strong></h4>
        </div>
end;
        return $cont;

    }
    function payer(){
        $app=\Slim\Slim::getInstance();
        $acc=$app->urlFor('accueil');
        $cont=<<<end
        
        <div id="Compte">
           <h1>merci de votre achat</h1>
                <h4><a href="$acc">retourner a l'accueil</a></h4>
        </div>
end;
        return $cont;
    }

    function Pdetail($chemin,$pa){
        $cont='';
        $total=0;
        foreach ($this->content as $item){
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
        return <<<end
                     <h4 class="title" style="text-align: center"><span class="text"><strong>Votre</strong> Panier</span></h4>
                     <div class="Trans">
                        <p>Transporteur : $pa->Transporteur </p>
                        <p>code :</p>
                        <a href='$pa->code'> $pa->code</a>
                     </div>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Image</th>
									<th>nom du produit</th>
									<th>qunatité</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody class="cart">
								$cont		  
							</tbody>
						</table>
                    <h4 class="title" style="text-align: right">total: $total €</h4>
end;
    }
    function saisirEmail(){
        $erreur="";
        if($this->content!=null){
            $erreur="<p class='erreur'>$this->content </p>";
        }
        $app=\Slim\Slim::getInstance();
        $url=$app->urlFor('verifEmail');
        $cont=<<<end
                    <div class="inscription">					
						<h4 class="title"><span class="text"><strong>modifier</strong> mot de passe</span></h4>
						$erreur
						<form action="$url" method="post" class="form-stacked">
							<fieldset>
								<div class="control-group">
									<label class="control-label">email</label>
									<div class="controls">
										<input type="email" name="email" placeholder="Enter your mail" class="input-xlarge">
									</div>
								</div>		
								<div class="actions"><input tabindex="9" class="btn btn-inverse large" type="submit" value="envoyé email"></div>
							</fieldset>
						</form>					
					</div>				
				
end;
        return $cont;
    }
    function ModMp($email){
        $erreur="";
        if($this->content!=null){
            $erreur="<p class='erreur'>$this->content </p>";
        }
        $app=\Slim\Slim::getInstance();
        $url=$app->urlFor('enrmdp');
        $cont=<<<end
                    <div class="inscription">					
						<h4 class="title"><span class="text"><strong>modifier</strong> mot de passe</span></h4>
						$erreur
						<form action="$url" method="post" class="form-stacked">
						<input type="hidden" name="email" value="$email" >
							<fieldset>
								<div class="control-group">
									<label class="control-label">nouveau  mot de passe</label>
									<div class="controls">
										<input type="password" name="password" placeholder="Enter your username" class="input-xlarge">
									</div>
								</div>		
								<div class="control-group">
									<label class="control-label">confirme</label>
									<div class="controls">
										<input type="password" name="confirm" placeholder="Enter your username" class="input-xlarge">
									</div>
								</div>
								<div class="actions"><input tabindex="9" class="btn btn-inverse large" type="submit" value="continuer"></div>
							</fieldset>
						</form>					
					</div>				
				
end;
        return $cont;

    }
}