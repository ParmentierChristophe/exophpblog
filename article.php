<!--

  Info bdd
  base de données avec 2 tables : articles , commentaires
  articles 4 colonnes : id(int, AI, PRIMARY), titre(varchar(255)), contenu(text), date_time_publication(datetime)
  commentaires 4 colonnes : id (int,AI,PRIMARY), pseudo(varchar(255)), commentaire(text), id_article(int).

-->


<?php
// Connexion à la base de données
try
{
   $bdd = new PDO('mysql:host=localhost;dbname=articles;charset=utf8', 'root', 'simplon');
}
catch(Exception $e)
{
   die('Erreur : '.$e->getMessage());
}

// Recuperation de l'id de l'article
if(isset($_GET['id']) AND !empty($_GET['id'])) {
  $get_id = htmlspecialchars($_GET['id']);

  $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
  $article->execute(array($get_id));

  if($article->rowCount() == 1) {
    $article = $article->fetch();
    $titre = $article['titre'];
    $contenu = $article['contenu'];

  }else {

    die('Cet article n\'existe pas !');

  }

}else {

  die('Erreur');

}


// creations des commentaires
  if(isset($_POST['submit_commentaire'])) {
    if(isset($_POST['pseudo'], $_POST['commentaire']) AND !empty($_POST['pseudo']) AND !empty($_POST['commentaire'])) {
      $pseudo = htmlspecialchars($_POST['pseudo']);
      $commentaire = htmlspecialchars($_POST['commentaire']);
        $ins = $bdd->prepare('INSERT INTO commentaires (pseudo, commentaire, id_article) VALUES (?,?,?)');
        $ins->execute(array($pseudo,$commentaire,$get_id));
        $c_msg = '<p class="validate">Votre commentaire a bien été posté !</p>';

    }else {

      $c_msg = '<p class="error">Tous les champs doivent être complétés !</p>';

    }
  }

// appel des commentaires dans la bdd par ordre Desc
  $commentaires = $bdd->prepare('SELECT * FROM commentaires WHERE id_article = ? ORDER BY id DESC');
  $commentaires->execute(array($get_id));

 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Accueil</title>
     <link rel="stylesheet" href="style.css" media="screen">
     <link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
   </head>
   <body>
     <div class="container">

<!-- Affichage de l'article titre + contenu -->
       <h1><?php echo $titre; ?></h1>
       <p>
         <?php echo $contenu; ?>
       </p>
       <br>
       <!-- Commentaire -->
       <h2>Commentaires:</h2>
       <!-- Formulaire de commentaire -->
       <form class="" action="" method="post">
         <input type="text" name="pseudo" value="" placeholder="Votre pseudo"><br>
         <textarea name="commentaire" rows="8" cols="40" placeholder="Inserer votre commentaire ..."></textarea><br>
         <input type="submit" name="submit_commentaire" value="Poster" class="button">
       </form>

       <!-- Affichage des commentaires -->
        <?php if(isset($c_msg)) { echo $c_msg;} ?>
        <br>
        <?php while ($c = $commentaires->fetch()) { ?>
          <b><?php echo $c['pseudo'] ?>: </b><span><?php echo $c['commentaire'] ?></span><br>
        <?php } ?>

<!-- Bouton de retour a l'accueil -->
       <a href="index.php" class="button">Retour a l'accueil !</a>
     </div>

   </body>
 </html>
