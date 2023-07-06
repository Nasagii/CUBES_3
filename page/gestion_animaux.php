
<?php
// Vérifier si le formulaire a été soumis
if(isset($_POST["espece"])) $espece=$_POST["espece"];
else $espece="";
if(isset($_POST["sexe"])) $sexe=$_POST["sexe"];
else $sexe="";
if(isset($_POST["nom"])) $nom=$_POST["nom"];
else $nom="";
if(isset($_POST["categorie"])) $categorie=$_POST["categorie"];
else $categorie="";
if(isset($_POST["description"])) $description=$_POST["description"];
else $description="";
if(isset($_POST["sauve"])) $sauve=$_POST["sauve"];
else $sauve=0;
if(isset($_POST["date_naissance"])) $date_naissance=$_POST["date_naissance"];
else $date_naissance="";
if(isset($_POST["id_animal"])) $id_animal=$_POST["id_animal"];
else $id_animal="";
        
if(isset($_POST["edit"])) $edit=$_POST["edit"];
else $edit="";

// Check if image file is a actual image or fake image
if(isset($_POST["ajouter"])) 
    {
    $target_dir = "page/photos_spa/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if($check !== false) 
        {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
        } 
    else 
        {
        echo "File is not an image.";
        $uploadOk = 0;
        }

    // Check if file already exists
    if (file_exists($target_file)) 
        {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        }

    // Check file size
    if ($_FILES["photo"]["size"] > 500000) 
        {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) 
        {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) 
        {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } 
    else 
        {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) 
            {
            echo "The file ". htmlspecialchars( basename( $_FILES["photo"]["name"])). " has been uploaded.";
            $photo=htmlspecialchars( basename( $_FILES["photo"]["name"]));
            $sql = $db_b  ->prepare("INSERT INTO animaux (id_animal, espece, sexe, nom, categorie, description, sauve, photo, date_naissance) VALUES (:id_animal, :espece, :sexe, :nom, :categorie, :description, :sauve, :photo, :date_naissance)");
            $sql->execute(["id_animal"=> $id_animal,"espece"=> $espece,"sexe"=> $sexe,"nom"=> $nom,"categorie"=> $categorie,"description"=> $description,"sauve"=> $sauve,"photo"=> $photo,"date_naissance"=> $date_naissance]);
            }     
        else 
            {
            echo "Sorry, there was an error uploading your file.";
            }
        }
    }

// DELETE //
if(isset($_GET["delete_id"]))
{
	if(is_numeric($_GET["delete_id"]))
	{
	$delete_img=$_GET["delete_img"];
	unlink("photos_spa/".$delete_img);
	$delete_id=$_GET["delete_id"];
	$sql =$db_b->prepare("DELETE FROM animaux WHERE id_animal=:delete_id");
	$sql->execute(["delete_id" => $delete_id]);

	}
}
if(isset($_GET["edit_id"]))
    {
    if(is_numeric($_GET["edit_id"]))
        {
        $edit_id=$_GET["edit_id"];
        $sql =$db_b->prepare("SELECT * FROM animaux WHERE id_animal=:edit_id");
        $sql->execute(["edit_id" => $edit_id]);
        $select_update = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        }
    }

if(isset($_POST["maj"]))
    {
    // 	echo "UPDATE plante SET plante_id=$plante_id, plante_nom=$plante_nom, plante_desc=$plante_desc WHERE plante_id=$edit";
    $sql =$db_b->prepare("UPDATE animaux SET id_animal=:id_animal, espece=:espece, sexe=:sexe, nom=:nom, categorie=:categorie, description=:description, sauve=:sauve, date_naissance=:date_naissance WHERE id_animal=:edit");
    $sql->execute(["id_animal"=> $id_animal,"espece"=> $espece,"sexe"=> $sexe,"nom"=> $nom,"categorie"=> $categorie,"description"=> $description,"sauve"=> $sauve,"date_naissance"=> $date_naissance,"edit" =>$edit]);
    }

?>


<div class="main">
    <a class="retour" href="index.php?page=tech"> > tech </a>
    <div class="gestion_page">
        <h1>Ajouter un animal</h1>
        
        <form method="post" enctype="multipart/form-data" action="index.php?page=gestion_animaux">
            
            <label for="id_animal">Identifiant de l'animal :</label>
            <input type="text" id="id_animal" name="id_animal" <?php if(isset($edit_id)){?> value="<?php echo $select_update[0]['id_animal'];?>" <?php } ?> ><br><br>

            <label for="espece">Espèce :</label>
            <select id="espece" name="espece" required>
                <option value="chat" <?php if(isset($edit_id)){ if($select_update[0]['espece']== "chat" ) {echo "selected" ;} } ?>>Chat</option>
                <option value="chien" <?php if(isset($edit_id)){ if($select_update[0]['espece']== "chien" ) {echo "selected" ;} } ?>>Chien</option>
            </select><br><br>

            <label for="sexe">Sexe :</label>
            <select id="sexe" name="sexe" required>
                <option value="mâle" <?php if(isset($edit_id)){ if($select_update[0]['sexe']== "male" ) {echo "selected" ;} } ?> >Male</option>
                <option value="femelle" <?php if(isset($edit_id)){ if($select_update[0]['sexe']== "femelle" ) {echo "selected" ;} } ?> >Femelle</option>
            </select><br><br>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required <?php if(isset($edit_id)){?> value="<?php echo $select_update[0]['nom'];?>" <?php } ?> ><br><br>

            <label for="categorie">Catégorie :</label>
            <select id="categorie" name="categorie" required>
                <option value="chat" <?php if(isset($edit_id)){ if($select_update[0]['categorie']== "chat" ) {echo "selected" ;} } ?>>Chat</option>
                <option value="petit-chien" <?php if(isset($edit_id)){ if($select_update[0]['categorie']== "petit_chien" ) {echo "selected" ;} } ?>>Petit Chien</option>
                <option value="moyen-chien" <?php if(isset($edit_id)){ if($select_update[0]['categorie']== "moyen_chien" ) {echo "selected" ;} } ?>> Moyen Chien</option>
                <option value="grand-chien" <?php if(isset($edit_id)){ if($select_update[0]['categorie']== "grand_chien" ) {echo "selected" ;} } ?>>Grand Chien</option>
            
            </select><br><br>

            <label for="description">Description :</label>
            <input id="description" name="description" required <?php if(isset($edit_id)){?> value="<?php echo $select_update[0]['description'];?>" <?php } ?> ><br><br>

            <label for="sauve">Sauvé :</label>
            <input type="checkbox" id="sauve" name="sauve" value=1 <?php if(isset($edit_id)){?> <?php echo "checked" ?> <?php } ?> ><br><br>

            <input type="file" name="photo" size=50 ><br><br>
            
            <label for="date_naissance">Date de naissance :</label>
            <input type="text" id="date_naissance" name="date_naissance" <?php if(isset($edit_id)){?> value="<?php echo $select_update[0]['date_naissance'];?>" <?php } ?> ><br><br>

            <?php if(isset($edit_id)){ ?> 
                <input name="edit" type="hidden" value=" <?php echo $edit_id ?> ">

                <input type="submit" name="maj" value="Mettre a jour" id="form" class="button"><br>
            <?php } else {?>
                <input type="submit" name="ajouter" value="Ajouter" id="form" class="button"><br>
            <?php } ?>

        </form>

        <table class="content" >
            <thead>
                <tr>
                    <th >id_animal</th>
                    <th >espece</th>
                    <th >id_animal</th>
                    <th >nom</th>
                    <th >categorie</th>
                    <th >sauve</th>
                    <th >date_naissance</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody id="content">

            <?php
            // SELECT nom,photo,sexe,date_naissance FROM animaux
            $sql =$db_b->prepare("SELECT * FROM animaux");
            $sql->execute();
            $select_data = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            for($u=0;$u<count($select_data);$u++)
            {
            ?>
            <tr>
                <td ><?php echo $select_data[$u]['id_animal'];?></td>
                <td ><?php echo $select_data[$u]['espece'];?></td>
                <td ><?php echo $select_data[$u]['nom'];?></td>
                <td ><?php echo $select_data[$u]['categorie'];?></td>
                <td ><?php echo $select_data[$u]['description'];?></td>
                <td ><?php echo $select_data[$u]['sauve'];?></td>
                <td ><?php echo $select_data[$u]['date_naissance'];?></td>
                <!-- <td ><img src="photos_spa/<?php //echo $select_data[$u]['photo'];?>" width="64"></td>  -->
                <td ><a href="index.php?page=gestion_animaux&edit_id=<?php echo $select_data[$u]['id_animal'] ?>">Edit</a></td>
                <td ><a href="index.php?page=gestion_animaux&delete_id=<?php echo $select_data[$u]['id_animal'] ?>&delete_img=<?php echo $select_data[$u]['photo'];?>">Suppr</a></td>
            </tr>

            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
       
