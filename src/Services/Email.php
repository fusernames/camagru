<?php

namespace Services;

Class Email
{
  const NL = "\n\r";

  public static function sendEmail($to, $subject, $message)
  {
    mail($to, $subject, $message);
  }

  public static function sendVerification($user)
  {
    $to = $user->email;
    $subject = 'Camagru - Verifier votre compte';
    $message = 'Bienvenu sur Camagru'.self::NL;
    $message .= 'Nom d\'utilisateur : '.$user->username.self::NL;
    $message .= 'Cliquez sur le lien ci-dessous pour verifier votre compte :'.self::NL;
    $message .= 'http://localhost:8080/camagru/index.php?action=user_activate&username='.$user->username.'&hash='.$user->hash.self::NL;
    self::sendEmail($to, $subject, $message);
  }

  public static function sendReset($user)
  {
    $to = $user->email;
    $subject = 'Camagru - Mot de passe oublié';
    $message = 'Cliquez sur ce lien pour reinitialiser votre mot de passe :'.self::NL;
    $message .= 'http://localhost:8080/camagru/index.php?action=user_reset_password&username='.$user->username.'&hash='.$user->hash.self::NL;
    self::sendEmail($to, $subject, $message);
  }
}
