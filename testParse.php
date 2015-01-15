<?php
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;
ParseClient::initialize('56VTC59EJucsHP9KOgUHgJrgzLXpwaKpRVmKpLGw', 'tKqrufMPkwc9DbAJWjrDDvGA2YQr3pRVDY0f5H6p', 'b7W2YmOtRaycX8v0tmWsUQUjSy3kgfdmmjPHczTv');


function get_client_ip() {
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ip=$_SERVER['HTTP_CLIENT_IP'];
  }
  elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else{
    $ip=$_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

if(isset($_POST['message']))
{
  $ip = get_client_ip();
  $message = $_POST['message'];
  echo "Adresse IP : \"". $ip."\"<br>";
  echo $message."<br>";

  $query = new ParseQuery("Users");
  $query->equalTo("ipAdress", $ip);
  $results = $query->find();

  if(count($results) >= 1)
  {
      $object = $results[0];
      $now = strtotime("now");
      $endAuto = $object->get('endAutorisationDate');
      if($object->get('autorisationDate') == NULL OR $endAuto < $now )
      {
        echo "Adresse IP déjà présente mais elle n'a jamais eu d'autorisation ou alors celle ci est finie.<br>";
      }

      $query = new ParseQuery("Requests");
      $query->equalTo("User_id", $object->getObjectId());
      $resultsRequests = $query->find();
      for($i = 0; $i < count($resultsRequests) ; $i++)
      {
        if($resultsRequests[$i]->get('done') == false )
        {
          echo "Une requette a déjà été envoyée, elle est en attente pour le moment.<br>";
        }
      }
  }


  if(count($results) == 0)
  {
    $User = new ParseObject("Users");

    $User->set("ipAdress", $ip);

    try {
      $User->save();
      echo 'New object created with objectId: ' . $User->getObjectId();
    } catch (ParseException $ex) {
      echo 'Failed to create new object, with error message: ' + $ex->getMessage();
    }

    $Message = new ParseObject("Messages");
    $Message->set("message", $message);

    try {
      $Message->save();
      echo 'New object created with objectId: ' . $Message->getObjectId();
    } catch (ParseException $ex) {
      echo 'Failed to create new object, with error message: ' + $Message->getMessage();
    }

    $object = ["pointer" => $Message->getObjectId()];

    $Request = new ParseObject("Requests");

    //  $Request->setArray("User_id", array('User_id' => array('__type' => 'Pointer', 'className' => 'Users', 'objectId' => $User->getObjectId())));
    //  $Request->setArray("Message_id", array('Message_id' => array('__type' => 'Pointer', 'className' => 'Messages', 'objectId' => $Message->getObjectId())));
    $Request->setAssociativeArray("Message_id",  $Message->_toPointer()) ;
    $Request->setAssociativeArray("User_id",  $User->_toPointer()) ;
    //  $Request->User_id = $Request->dataType( 'pointer', array( '_Users', $User->getObjectId() ) );
    $Request->set("done", false);


    try {
      $Request->save();
      echo 'New object created with objectId: ' . $Request->getObjectId();
    } catch (ParseException $ex) {
      echo 'Failed to create new object, with error message: ' + $Request->getMessage();
    }
  }
  else
  {
    // Ip déjà présente
  }
}
?>

<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title> GamerZ </title>
  <link rel="stylesheet" media="screen" type="text/css" href="assets/css/styles.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</head>


<body style="width : 100%; text-align : center;">



<h1> Administration </h1>
<form method="post" action="<?php echo $app->urlFor('testParse'); ?>">
  <p> Laisser un message : </p>
  <textarea name="message" rows="5" cols="40"></textarea>
  <p><input type="submit" value="Demander l'autorisation"></p>
</form>

</form>
</body>
