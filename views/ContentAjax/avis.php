<!--<div id="imagesAvis"> <img id="lol" src="../assets/img/fontAvis1.png">

  <div id="commentContent">
    <div id="commentContent1">
    <//?php include "../views/include/avis-include.php";?>

  </div></div>

  <div id="addCommentContainer">
    <form id="form1" method="post" action="">
      <p>
        <label for="name"></label>
        <input name="name" type="text" id="name" value="" placeholder="Name"/>
      </p>
      <p>
        <label for="body"></label>
        <textarea name="body" id="body" placeholder="Commentaire"></textarea>
      </p>
      <p>
        <input type="hidden" name="game_id" id="game_id" value="<//?php echo $game_id ?>" />
        <p><input type="submit" id="submit" value="Envoyer" /></p>
      </form>
  </div>
</div>
-->
<div id="contentAvis">
<div id="imagesAvis"> <img id="lol" src="../assets/img/fontAvis3.png"> <img id="lol1" src="../assets/img/test.png">

<div id="commentContent">
  <div id="commentContent1">
<?php include "./views/include/avis-include.php";?>
  </div>
</div>
<button id="unhide" type="button">+</button>
<div id="addCommentContainer"> <img id="test" src="../assets/img/fontAvisPortable.png">
<form id="form1" method="post" action="">
<p>
<label for="name"></label>
<input name="name" type="text" id="name" value="" placeholder="Name (Obligatoire)"/>
</p>
<p>
<label for="body"></label>
<textarea name="body" id="body" placeholder="Commentaire (Obligatoire)"></textarea>
</p>
<p>
<input type="hidden" name="game_id" id="game_id" value="<?php echo $game_id ?>" />
<p><input type="submit" id="submit" value="Envoyer" /></p>
<button id="hide" type="button">-</button>
</form>
</div>
</div>
</div>
