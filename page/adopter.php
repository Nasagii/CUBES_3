

<?php
// Tableau d'exemple des articles avec leurs catégories

$sql =$db_b->prepare("SELECT * FROM animaux");
$sql->execute();
$select_data = $sql->fetchAll(PDO::FETCH_ASSOC);

// Tableau des catégories disponibles
$categories = array('Toutes', 'Chat', 'Petit-Chien', 'Moyen-Chien', 'Grand-Chien',);


// Récupère la catégorie sélectionnée dans l'URL
$categorie_selectionnee = isset($_GET['categorie']) ? $_GET['categorie'] : 'Toutes';

// Filtrer les articles en fonction de la catégorie sélectionnée
if ($categorie_selectionnee == 'Toutes') {
    $articles_filtres = $select_data;
} else {
    $articles_filtres = array_filter($select_data, function($article) use ($categorie_selectionnee) {
        return $article['categorie'] == $categorie_selectionnee;
    });
}
?>


<div class="adopter">
    <div class="filtre">
        <!-- Affichage du menu de filtre -->
        <ul>
        <?php foreach ($categories as $categorie) { ?>
            <li>
                <?php if ($categorie == $categorie_selectionnee) { ?>
                    <strong style="color: #d4a373 ;"><?php echo $categorie; ?></strong>
                <?php } else { ?>
                    <a href="?page=adopter&categorie=<?php echo $categorie; ?>"><?php echo $categorie; ?></a>
                <?php } ?>
            </li>
        <?php } ?>
        </ul>

    </div>

    <div class="classeur">
        <?php
        foreach ($articles_filtres as $article) {
            $photos = explode(",", $article['photo']);
            ?>
            
            <a class="article-card" href="index.php?page=profil_animal&id_animal=<?php echo $article['id_animal']?> ">
                <div class="content">
                    <p class="date"> <?php echo $article['date_naissance'] ." | ";
                        if($article['sexe']== "male" ) 
                            {
                            echo  "<i class=\"fa-solid fa-mars\" style=\"color: #fff;\"></i>";
                            }
                            else echo  "<i class=\"fa-solid fa-venus\" style=\"color: #fff;\"></i>" ;?></p>
                    <p class="title"> 
                        <?php echo $article['nom']; ?>
                    </p>
                </div>
                <img src="page/photos_spa/<?php  echo $photos[0] ;?>"  alt="image animal" > 
            </a>

            <?php
            }
        ?>  
    </div>
</div>








