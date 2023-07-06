<?php
// CONNEXION
// variables

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

require 'vendor/autoload.php';

//sftp://admin@ftp.vincenzoo.gay/var/www/vincenzoo/PHPMailer/src/Exception.php


$erreur="";
if(isset($_POST["email"])) $email=$_POST["email"];
else $email="";
if(isset($_POST["mdp"])) $mdp=$_POST["mdp"];
else $mdp="";
if(isset($_POST["nom"])) $nom=$_POST["nom"];
else $nom="";



// on teste si le visiteur a soumis le formulaire de connexion
if (isset($_POST['connexion'])) 
    {
	if ((isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['mdp']) && !empty($_POST['mdp']))) 
        {
        try
            {
            $sql =$db_b->prepare("SELECT * FROM utilisateur WHERE email=:email");
            $sql->execute(["email" => $email]);
            }
        catch (PDOException $e)
            {
            /* Query error. */
            echo 'Email inconnue.';
            die();
            }
        $login_data = $sql->fetch(PDO::FETCH_ASSOC);
        /* If there is a result, check if the password matches using password_verify(). */
        if (is_array($login_data))
            {
            if (password_verify($mdp, $login_data['mdp']))
                {       
                    session_start();
                    $_SESSION['nom'] = $login_data['nom'];

                    header('Location: index.php?page=acceuil');
                    exit();
                }
			else $erreur = 'Mot de passe invalide.';
            }
    	else $erreur = 'email invalide.';	
    }
else $erreur = 'Au moins un des champs est vide.';
}


// INSCRIPTION
// $password = 'cassandre';
// $hash = password_hash($password, PASSWORD_DEFAULT);
// echo $hash;


$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = 'ssl0.ovh.net';               //Adresse IP ou DNS du serveur SMTP
$mail->Port = 465;                          //Port TCP du serveur SMTP
$mail->SMTPAuth = 1;                        //Utiliser l'identification
$mail->CharSet = 'UTF-8';

if($mail->SMTPAuth){
   $mail->SMTPSecure = 'ssl';               //Protocole de sécurisation des échanges avec le SMTP
   $mail->Username   =  'vincenzoo.gay@gmail.com';    //Adresse email à utiliser
   $mail->Password   =  'R4J95i:26Rf!';         //Mot de passe de l'adresse email à utiliser
}

$mail->From       = trim($email_from);                //L'email à afficher pour l'envoi
$mail->FromName   = trim($email_from_alias);          //L'alias de l'email de l'emetteur

$mail->AddAddress(trim($_POST["email"]));

$mail->Subject    =  $object;                      //Le sujet du mail
$mail->WordWrap   = 50; 			       //Nombre de caracteres pour le retour a la ligne automatique
$mail->AltBody = $body; 	       //Texte brut
$mail->IsHTML(false);                                  //Préciser qu'il faut utiliser le texte brut
$mail->MsgHTML($body);            //Forcer le contenu du body html pour ne pas avoir l'erreur "body is empty' même si on utilise l'email en contenu alternatif

$email_from="vincenzoo.gay@gmail.com";
$email_from_alias="R4J95i:26Rf!";
$object="Votre compte a etait créé avec succés.";
$body="Cher(e)".$email.",

Nous espérons que ce courriel vous trouve en bonne santé.
Nous tenons à vous remercier d'avoir choisi notre service et nous vous souhaitons la bienvenue.

Nous sommes heureux de vous informer que votre compte a été créé avec succès. 
Vous pouvez désormais vous connecter à votre compte en utilisant les informations suivantes :

Nom d'utilisateur : ".$_POST['email']."
Mot de passe : ".$_POST['mdp']."

Veuillez noter que votre nom d'utilisateur et votre mot de passe sont sensibles à la casse. 
Assurez-vous de les saisir correctement lors de la connexion.

Nous vous rappelons de garder vos informations de connexion confidentielles et de ne les partager avec personne. 
Si vous soupçonnez une activité suspecte sur votre compte, veuillez nous contacter immédiatement.

Nous sommes ravis de vous accueillir parmi nos utilisateurs et nous espérons que notre service répondra à vos attentes. 
Si vous avez des questions ou besoin d'une assistance supplémentaire, n'hésitez pas à nous contacter à l'adresse vincenzoo.gay@gmail.com.

Cordialement,

L'équipe de SPA";


if (isset($_POST['inscription'])) 
    {
	if ((!empty($_POST['email'])) && (!empty($_POST['mdp'])) && (!empty($_POST['nom']))) 
        {

		$sql = $db_b->prepare("SELECT email FROM utilisateur WHERE email=:email");
		$sql->execute(["email"=>$email]);
		$login_email = $sql->fetch(PDO::FETCH_ASSOC);
		
		if (empty($login_email)) 
			{
			$sql = $db_b->prepare("SELECT nom FROM utilisateur WHERE nom=:nom");
			$sql->execute(["nom"=>$nom]);
			$login_nom = $sql->fetch(PDO::FETCH_ASSOC);
			
			if (empty($login_nom)) 
				{
				$hash = password_hash($mdp, PASSWORD_DEFAULT);
				echo $hash;
				$sql_inser = $db_b  ->prepare("INSERT INTO utilisateur (nom, email, mdp) VALUES (:nom, :email, :mdp)");
				$sql_inser->execute(["nom"=> $nom,"email"=> $email,"mdp"=> $hash]);


                if (!$mail->send()) 
                    {
                    echo $mail->ErrorInfo;
                    } 
                else
                    {
                    echo 'Message bien envoyé';
                    }

				session_start();
				$_SESSION['nom'] = $nom;
				header('Location: index.php?page=acceuil');
				exit();
				} 
			else $erreur = 'nom de compte déja utilisé.';

			} 
		else $erreur = 'adresse mail déja utilisé.';

		}
	}
?>


<div class="main">

    <div class="log_form" id="log_form">
        <div  class="form-log_form sign-up-log_form">
			<form method="post" enctype="multipart/form-data" action="index.php?page=login">
                <h1>Créer un compte</h1>
				
				<input class="loginput" type="text" name="nom"  placeholder="Nom de compte" required />
				<input class="loginput" type="email" name="email" placeholder="Email" required/>
				<input class="loginput" type="password" name="mdp"  placeholder="Mot de passe" required />
				
				<input type="submit" class="btn" name="inscription" value="S'inscrire">
            </form>
        </div>
        <div class="form-log_form sign-in-log_form">
            <form method="post" enctype="multipart/form-data" action="index.php?page=login" >
                <h1>Se Connecter</h1>
                <input class="loginput" type="email" name="email" placeholder="Email" required />
                <input class="loginput" type="password" name="mdp" placeholder="Mot de passe" required />
                <a href="#">Mot de passe oublié ?</a>
				<a href="#"><?php echo $erreur; ?></a>
	
				<input type="submit" class="btn" name="connexion" value="Se connecter">
            </form>
        </div>

        <div class="overlay-log_form">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Content de vous revoir !</h1>
                    <p>Pour rester en contact avec nous, veuillez vous connecter avec vos informations personnelles</p>
					<button class="got"  id="signIn">Se connecter</button>
				</div>
                <div class="overlay-panel overlay-right">
                    <h1>Salut l'ami !</h1>
                    <p>Entrez vos données personnelles et commencez votre voyage avec nous</p>
					<button class="got" id="signUp">S'inscrire</button>
				</div>
            </div>
        </div>
    </div>

</div>

<script>
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const log_form = document.getElementById('log_form');

signUpButton.addEventListener('click', () => {
	log_form.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	log_form.classList.remove("right-panel-active");
});
</script>