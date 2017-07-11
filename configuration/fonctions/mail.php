<?php
	
  /**
   * Liste des fonctions relatives à l'envoi de mail
   * @autor: Brion Sébastien
   */
  
   /**
    * Fonction qui envoi un mail via un SMTP sécurisé (SMTP de Gmail)
    * @param   Array<>     $données          Données du formulaire
    * @return  String      $erreur_envoi     Erreur en cas d'echec de l'envoi du mail
    */
   	function smtpMailer(&$donnees) {
		
		    $erreur_envoi = '';
        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";
        $mail->SetFrom(FROM, FROM_NAME);
        $mail->Subject = ($donnees['type_requete'] == 'update') ? 'Modification de votre compte' : 'Création de votre compte';
        $mail->Body = genererTemplateSmarty(PATH_VUES.'/clients/email.tpl', array('donnees' => $donnees));
        $mail->AddAddress($donnees['email']);
      
        /*$mail->IsSMTP();
          $mail->SMTPAuth = true;
          $mail->Host = HOST_SMTP;          
          $mail->Port = PORT_SMTP;
          $mail->Username = GMAIL_USER;                         
          $mail->Password = GMAIL_PWD;
          $mail->SMTPSecure = MODE_SECURITE;*/

        if(!$mail->Send()) {
           $erreur_envoi = 'L\'envoi du mail a échoué !';
        }

        return $erreur_envoi;
    }

?>