<?php
	require File::build_path(array("mail","includes","Exception.php"));
	require File::build_path(array("mail","includes","PHPMailer.php"));
	require File::build_path(array("mail","includes","SMTP.php"));
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	file_put_contents("gameData.csv",$csvContent);
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
	$mail->Username = "getstatlol.csv@gmail.com"; // email sender
	//Set gmail password
	$mail->Password = "projetS3"; // mdp email
	//Email subject
	$mail->Subject = "Notification telechargement CSV";
	//Set sender email
	$mail->setFrom("getstatlol.csv@gmail.com"); // inutile, je n'ai pas trouvé où ça apparaissait dans le mail
	//Enable HTML
	$mail->isHTML(true);
	//Attachment
	$mail->addAttachment('gameData.csv'); // pièce jointe si besoin
	//Email body
	$d = getdate(time());
	$body = "Un utilisateur vient de telecharger un fichier CSV sur votre site !<br>
				   Horodatage : ". $d['mday']."/".$d['mon']."/".$d['year']."-".$d['hours'].":".$d['minutes'];
	$mail->Body = $body;
	//Add recipient
	$mail->addAddress("receptionstatlol@yopmail.com"); // email destination
	//Finally send email
	$mail->send();
	//Closing smtp connection
	$mail->smtpClose();
?>