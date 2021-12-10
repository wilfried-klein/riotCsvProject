<?php

/* AVANT TOUT
        Il faut aller dans les paramètres de la boite de reception sender et autoriser "Accès moins sécurisé à des applications"

        Sur GMAIL :
        ->  Gérer votre compte Google
        ->  Sécurité (sur la gauche)
        ->  Accès moins sécurisé à des applications
        ->  Activer

*/

//Include required PHPMailer files
	require 'includes/PHPMailer.php';
	require 'includes/SMTP.php';
	require 'includes/Exception.php';
//Define name spaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

//Create instance of PHPMailer
	$mail = new PHPMailer();
//Set mailer to use smtp
	$mail->isSMTP();
//Define smtp host
	$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
	$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
	$mail->SMTPSecure = "tls";
//Port to connect smtp
	$mail->Port = "587";
//Set gmail username
	$mail->Username = ""; // email sender
//Set gmail password
	$mail->Password = ""; // mdp email
//Email subject
	$mail->Subject = "Test email using PHPMailer";
//Set sender email
	$mail->setFrom('osef@gmail.com'); // inutile, je n'ai pas trouvé où ça apparaissait dans le mail
//Enable HTML
	$mail->isHTML(true);
//Attachment
	//$mail->addAttachment(''); // pièce jointe si besoin
//Email body
	$mail->Body = "Vous avez bien reçu le mail";
//Add recipient
	$mail->addAddress('kleinwilfried3@gmail.com'); // email destination
//Finally send email
	if ( $mail->send() ) {
		echo "Email Envoyé";
	}else{
		echo "Le message ne peut pas être envoyé";
	}
//Closing smtp connection
	$mail->smtpClose();
