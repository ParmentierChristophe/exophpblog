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
   $bdd = new PDO('mysql:host=localhost;dbname=articles;charset=utf8', 'root', '');
}
catch(Exception $e)
{
   die('Erreur : '.$e->getMessage());
}
// appel de la bdd dans l'ordre decroissant
$articles = $bdd->query('SELECT * FROM articles ORDER BY id DESC');

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

<!-- Boucle d'affichage des articles -->
<?php while($a = $articles->fetch()) { ?>
  <li> <a href="article.php?id=<?php echo $a['id'] ?>"> <?php echo $a['titre']; ?></a></li>
  <?php } ?>

<!-- Bouton pour rediger un article -->
  <a href="redaction.php" class="button">Rediger un article ?</a>

       </div>
   </body>
 </html>
