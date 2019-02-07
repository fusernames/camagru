<?php

namespace Services;

Class Email
{
  const NL = "\n\r";

  public static function sendEmail($to, $subject, $message)
  {
    $headers  = "MIME-Version: 1.0 \n";
    $headers .= "Content-type: text/html; charset=iso-8859-1 \n";
    $headers .= "From: Camagru \n";
    mail($to, $subject, $message, $headers);
  }

  public static function sendVerification($user)
  {
    $to = $user->email;
    $subject = 'Camagru - Verifier votre compte';
    $message = 'Bienvenu sur Camagru'.self::NL;
    $message .= 'Nom d\'utilisateur : '.$user->username.self::NL;
    $message .= 'Cliquez sur le lien ci-dessous pour verifier votre compte :'.self::NL;
    $message .= 'http://localhost:8080/php/'.APP_NAME.'/index.php?action=user_activate&username='.$user->username.'&hash='.$user->hash.self::NL;
    self::sendEmail($to, $subject, $message);
  }

  public static function sendReset($user)
  {
    $to = $user->email;
    $subject = 'Camagru - Mot de passe oublié';
    $message = 'Cliquez sur ce lien pour reinitialiser votre mot de passe :'.self::NL;
    $message .= 'http://localhost:8080/php/'.APP_NAME.'/index.php?action=user_reset_password&username='.$user->username.'&hash='.$user->hash.self::NL;
    self::sendEmail($to, $subject, $message);
  }

  public static function sendCommentAlert($user, $comment)
  {
    $to = $user->email;
    $subject = 'Nouveau commentaire sur votre photo';
    $message = 'Cliquez pour le voir :'.self::NL;
    $message .= 'http://localhost:8080/php/'.APP_NAME.'/index.php?action=picture_show&id='.$comment->id_picture;
    self::sendEmail($to, $subject, $message);
  }
}
