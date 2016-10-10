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

// voir si tous les champs sont remplis et envoie dans la bdd
if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
  if (!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {

    $article_titre = htmlspecialchars($_POST['article_titre']);
    $article_contenu = htmlspecialchars($_POST['article_contenu']);

    $ins = $bdd->prepare('INSERT INTO articles (titre, contenu, date_time_publication) VALUES (?, ?,NOW())');
    $ins->execute(array($article_titre, $article_contenu));

    $message = '<p class="validate">Votre article a bien été posté ! </p>';

  }else {
    // message d'erreur pour remplir tous les champs
    $message = '<p class="error">veuillez remplir tous les champs !</p>' ;
  }
}
 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Redaction</title>
     <link rel="stylesheet" href="style.css" media="screen">
     <link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
   </head>
   <body>
     <div class="container">

<!-- Formulaire d'ajout d'article simple -->
       <form class="" action="" method="post">
          <input type="text" placeholder="Titre" name="article_titre" value=""><br>
          <textarea name="article_contenu" placeholder="Contenu de l'article" rows="8" cols="40"></textarea><br>
          <input type="submit" name="name" value="Envoyer l'article" class="button">

       </form>
       <br>
       <!-- Affichage des messages 'veuillez remplir tous les champs !' ou  'Votre article a bien été posté ! ' -->
       <?php if(isset($message)) { echo $message ;} ?>

       <!-- Boutton retour a l'accueil -->
       <a href="index.php" class="button">Retour a l'accueil !</a>

     </div>
   </body>
 </html>
