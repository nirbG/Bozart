<?php
require 'vendor/autoload.php';
use \b\controleur\ControleurCatalogue;
use \b\controleur\ControleurCompte;
use \b\controleur\ControleurAdmin;

//conection a la base de donnée
$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

//connection a FrameWork
$app=new \Slim\Slim;

session_start();


//initialisation du coffret
if (!isset($_SESSION['panier']))
    $_SESSION['panier'] = [];

//initialisation du prix du coffret à 0
if (!isset($_SESSION['prixPanier']))
    $_SESSION['prixPanier'] = 0;


//chose utile pour la gestion du coffret
//$_SESSION['panier'][]=;
//unset($_SESSION['panier']);

$app->get('/',function(){(new ControleurCatalogue())->accueil();})->name('accueil');

$app->get('/:nomCat',function ($nomCat){(new ControleurCatalogue())->cat($nomCat);})->name('categorie');

$app->get('/:nomCat/catalogue',function ($nomCat){(new ControleurCatalogue())->catalogueBySl($nomCat);})->name('catalogueSl');

$app->get('/:nomCat/:nomMarque/catalogue',function ($nomCat,$nomMarque){(new ControleurCatalogue())->catalogueByMQ($nomCat,$nomMarque);})->name('catalogueMq');

$app->get('/:nomCat/:nomProduit/palette',function ($nomCat,$nomProduit){(new ControleurCatalogue())->palette($nomCat,$nomProduit);})->name('palette');

$app->get('/:nomCat/catalogueTrie:id',function ($nomCat,$id){(new ControleurCatalogue())->catalogueBySl($nomCat,$id);})->name('catalogueTrie');

$app->get('/:nomCat/:nomMarque/catalogueTrie:id',function ($nomCat,$nomMarque,$id){(new ControleurCatalogue())->catalogueByMQ($nomCat,$nomMarque,$id);})->name('catalogueTrieM');

$app->get('/:nomCat/Marque',function ($nomCat){(new ControleurCatalogue())->Marque($nomCat);})->name('marque');

$app->get('/MarqueD:id/:nomMarque',function ($id,$nomMarque){(new ControleurCatalogue())->MarqueD($id,$nomMarque);})->name('MarqueD');

$app->get('/:nomCat/catalogue/:id',function ($nomCat,$id){(new ControleurCatalogue())->detail($nomCat,$id);})->name('detail');

$app->post('/ajoutProd/:id',function($id){(new ControleurCatalogue())->ajProd($id);})->name('ajProd');

$app->get('/suppProd/:id/:qt/:opt',function($id,$qt,$opt){(new ControleurCatalogue())->supProd($id,$qt,$opt);})->name('supProd');

$app->post('/application/',function(){(new ControleurCatalogue())->search();})->name('search');

$app->get('/application/search:id',function($id){(new ControleurCatalogue())->afficheSearch($id);})->name('affichesearch');

$app->get('/compte/form:erreur',function($erreur){(new ControleurCompte())->form($erreur);})->name('form');

$app->post('/compte/connexion',function(){(new ControleurCompte())->connexion();})->name('co');

$app->get('/compte/inscription:erreur',function($erreur){(new ControleurCompte())->inscription($erreur);})->name('ins');

$app->post('/compte/sInscrire',function(){(new ControleurCompte())->sInscrire();})->name('Sins');

$app->get('/compte/ajoutDesCoordonne:erreur',function($erreur){(new ControleurCompte())->inscription2($erreur);})->name('ins2');

$app->post('/compte/sInscrire2',function(){(new ControleurCompte())->sInscrire2();})->name('Sins2');

$app->get('/compte/detail',function(){(new ControleurCompte())->detail();})->name('compte');

$app->get('/compte/detailpanier/:id',function($id){(new ControleurCompte())->PanierDetail($id);})->name('panierDetail');

$app->get('/compte/modifierCoor:erreur',function($erreur){(new ControleurCompte())->modifierCoor($erreur);})->name('modifierCoor');

$app->post('/compte/setinfo',function(){(new ControleurCompte())->setinfo();})->name('setinfo');

$app->get('/compte/ConfirmationMP:erreur',function($erreur){(new ControleurCompte())->ConfirmationMP($erreur);})->name('ConfirmationMP');

$app->post('/compte/confirmMP',function(){(new ControleurCompte())->confirmMP();})->name('confirmMP');

$app->get('/compte/saisiMP:erreur',function($erreur){(new ControleurCompte())->saisiMP($erreur);})->name('saisiMP');

$app->get('/compte/saisirEmail:erreur',function($erreur){(new ControleurCompte())->saisirEmail($erreur);})->name('saisirEmail');

$app->post('/compte/verifEmail',function(){(new ControleurCompte())->verifEmail();})->name('verifEmail');

$app->get('/compte/ModMp/:mail/:erreur',function($mail,$erreur){(new ControleurCompte())->ModMp($mail,$erreur);})->name('ModMp');

$app->post('/compte/enrmdp',function(){(new ControleurCompte())->enrmdp();})->name('enrmdp');

$app->post('/compte/enregistreMP',function(){(new ControleurCompte())->enregistreMP();})->name('enregistreMP');

$app->get('/panier/valider',function(){(new ControleurCompte())->valider();})->name('valider');

$app->get('/panier/payer',function(){(new ControleurCompte())->payer();})->name('payer');

$app->get('/compte/deco',function(){(new ControleurCompte())->deco();})->name('deco');

$app->get('/info/cart',function(){(new ControleurCatalogue())->cart();})->name('cart');

$app->get('/info/aboutUs',function(){(new ControleurCatalogue())->aboutUs();})->name('aboutUs');

$app->get('/info/contactUs',function(){(new ControleurCatalogue())->contactUs();})->name('contactUS');

$app->post('/info/contactUs/send',function(){(new ControleurCompte())->sendMessage();})->name('sendM');

$app->get('/info/ConditionGeneraleDeVentes',function(){(new ControleurCatalogue())->CGV();})->name('CGV');

$app->get('/info/MentionLegale',function(){(new ControleurCatalogue())->MentionLegale();})->name('MentionLegale');

$app->get('/admin/Menu',function(){(new ControleurAdmin())->adminMenu();})->name('adminMenu');

$app->post('/adminSearch/',function(){(new ControleurAdmin())->adminSearch();})->name('adminSearch');

$app->get('/adminSearch/search:id',function($id){(new ControleurAdmin())->adminafficheSearch($id);})->name('adminafficheSearch');

$app->get('/admin/listerProduit/:trie',function($trie){(new ControleurAdmin())->listerProduit($trie);})->name('AdminlisterProduit');

$app->get('/admin/ajoutProd',function(){(new ControleurAdmin())->ajoutProd();})->name('AdminajoutProd');

$app->post('/admin/saveProd',function(){(new ControleurAdmin())->saveProd();})->name('AdminSaveProd');

$app->get('/admin/modifprod/:id',function($id){(new ControleurAdmin())->modifProd($id);})->name('AdminmodifProd');

$app->get('/admin/modifPalette/:id',function($id){(new ControleurAdmin())->modifPalette($id);})->name('AdminmodifPalette');

$app->post('/admin/UpdateProd/:id/:prod/:redirect',function($id,$prod,$redirect){(new ControleurAdmin())->UpdateProd($id,$prod,$redirect);})->name('AdminUpdateProd');

$app->get('/admin/listerCat',function(){(new ControleurAdmin())->listerCat();})->name('AdminlisterCat');

$app->get('/admin/ajoutCat',function(){(new ControleurAdmin())->ajoutCat();})->name('AdminajoutCat');

$app->post('/admin/saveCat',function(){(new ControleurAdmin())->saveCat();})->name('AdminsaveCat');

$app->get('/admin/modifCat/:id',function($id){(new ControleurAdmin())->modifCat($id);})->name('AdminmodifCat');

$app->post('/admin/UpdateCat/:id/:cat',function($id,$cat){(new ControleurAdmin())->UpdateCat($id,$cat);})->name('AdminUpdateCat');

$app->get('/admin/listerSousliste',function(){(new ControleurAdmin())->listerSousliste();})->name('AdminlisterSousliste');

$app->get('/admin/ajoutSous',function(){(new ControleurAdmin())->ajoutSous();})->name('AdminajoutSous');

$app->post('/admin/saveSous',function(){(new ControleurAdmin())->saveSous();})->name('AdminSaveSous');

$app->get('/admin/modifSous/:id',function($id){(new ControleurAdmin())->modifSous($id);})->name('AdminmodifSous');

$app->post('/admin/UpdateSous/:id/:sous',function($id,$sous){(new ControleurAdmin())->UpdateSous($id,$sous);})->name('AdminUpdateSous');

$app->get('/admin/listerMarque',function(){(new ControleurAdmin())->listerMarque();})->name('AdminlisterMarque');

$app->get('/admin/ajoutMar',function(){(new ControleurAdmin())->ajoutMar();})->name('AdminajoutMar');

$app->post('/admin/saveMar',function(){(new ControleurAdmin())->saveMar();})->name('AdminSaveMar');

$app->get('/admin/modifMar/:id',function($id){(new ControleurAdmin())->modifMar($id);})->name('AdminmodifMar');

$app->post('/admin/UpdateMar/:id/:mar',function($id,$mar){(new ControleurAdmin())->UpdateMar($id,$mar);})->name('AdminUpdateMar');

$app->get('/admin/listerCol',function(){(new ControleurAdmin())->listerColor();})->name('AdminlisterCol');

$app->get('/admin/ajoutCol',function(){(new ControleurAdmin())->ajoutColor();})->name('AdminajoutCol');

$app->post('/admin/saveCol',function(){(new ControleurAdmin())->saveColor();})->name('AdminSaveCol');

$app->get('/admin/modifCol/:id',function($id){(new ControleurAdmin())->modifColor($id);})->name('AdminmodifCol');

$app->post('/admin/UpdateCol/:id/:mar',function($id,$mar){(new ControleurAdmin())->UpdateColor($id,$mar);})->name('AdminUpdateCol');

$app->get('/admin/listerCond',function(){(new ControleurAdmin())->listerCond();})->name('AdminlisterCond');

$app->get('/admin/ajoutCond',function(){(new ControleurAdmin())->ajoutCond();})->name('AdminajoutCond');

$app->post('/admin/saveCond',function(){(new ControleurAdmin())->saveCond();})->name('AdminSaveCond');

$app->get('/admin/modifCond/:id',function($id){(new ControleurAdmin())->modifCond($id);})->name('AdminmodifCond');

$app->post('/admin/UpdateCond/:id/:mar',function($id,$mar){(new ControleurAdmin())->UpdateCond($id,$mar);})->name('AdminUpdateCond');

$app->get('/admin/listerCompte',function(){(new ControleurAdmin())->listerCompte();})->name('AdminlisterCompte');

$app->get('/admin/ClientD/:id',function($id){(new ControleurAdmin())->ClientD($id);})->name('AdminClientD');

$app->get('/admin/listerPanier',function(){(new ControleurAdmin())->listerPanier();})->name('AdminlisterPanier');

$app->get('/admin/PanierD/:id',function($id){(new ControleurAdmin())->PanierD($id);})->name('AdminPanierD');

$app->post('/admin/ConfirmPanier/:id',function($id){(new ControleurAdmin())->ConfirmPanier($id);})->name('AdminConfirmPanier');

$app->get('/a/b/test',function(){(new ControleurCatalogue())->test();})->name('test');

$app->get('/admin/b/:a',function($a){(new ControleurAdmin())->Ad($a);})->name('Atest');

$app->run();
