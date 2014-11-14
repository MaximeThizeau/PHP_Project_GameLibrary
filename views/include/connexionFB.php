<!-- connexion php:  "devra être inclus dans vos pages à chaque fois que vous souhaitez connaitre le statut de l'utilisateur" -->
<?php
require('facebook.php');
?>

<!--javascript -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : 859555177410868,
      status     : true,
      xfbml      : true
    });
  };
</script>

<!-- auhtentification du site, php -->
<?php
$facebook = new Facebook(array(
  'appId' => 859555177410868,
  'secret' => '7ef9bc3917bf86e68b711228ae29bc2a',
  'cookie' => true
));
?>

<!-- bouton connexion -->

<div class="fb-login-button" data-show-faces="false" data-width="200" data-max-rows="1"></div>
<script>
  FB.Event.subscribe("auth.login", function () {
      window.location.replace("http://adresse/de/redirection");
  });
</script>

<!-- authentification php -->
<?php
if ($user != 0) {
  echo 'Vous êtes connecté';
} else {
  echo 'Pas connecté';
}
?>