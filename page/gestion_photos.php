<?php
function deletePhoto($photoName, $idSelected, $db_b)
{
    // Supprimer la photo du dossier "photos_spa"
    unlink("page/photos_spa/" . $photoName);

    // Extraire la liste de photos actuelle
    $sql = $db_b->prepare("SELECT photo FROM animaux WHERE id_animal=:id_selected");
    $sql->bindParam(':id_selected', $idSelected);
    $sql->execute();
    $selectData = $sql->fetch(PDO::FETCH_ASSOC);
    $images = explode(",", $selectData["photo"]);

    // Supprimer la photo sélectionnée de la liste
    $index = array_search($photoName, $images);
    if ($index !== false) {
        array_splice($images, $index, 1);
    }

    // Mettre à jour la base de données avec la nouvelle liste de photos
    $newPhotoList = implode(",", $images);
    $sql = $db_b->prepare("UPDATE animaux SET photo=:photo WHERE id_animal=:id_selected");
    $sql->bindParam(':photo', $newPhotoList);
    $sql->bindParam(':id_selected', $idSelected);
    $sql->execute();

    header("Refresh:0");
}

function uploadPhoto($idSelected, $db_b)
{
    // Récupération du nom de la photo
    $photoName = basename($_FILES["fileToUpload"]["name"]);

    // Upload de la photo dans le dossier "photos_spa"
    $targetDir = "page/photos_spa/";
    $targetFile = $targetDir . $photoName;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        // Si l'upload s'est bien passé, on ajoute le nom de la nouvelle photo à la chaîne de caractères de la base de données
        $sql = $db_b->prepare("SELECT photo FROM animaux WHERE id_animal=:id_selected");
        $sql->bindParam(':id_selected', $idSelected);
        $sql->execute();
        $selectData = $sql->fetch(PDO::FETCH_ASSOC);
        $newPhotoList = $selectData["photo"] . "," . $photoName;

        // Mettre à jour la base de données avec la nouvelle liste de photos
        $sql = $db_b->prepare("UPDATE animaux SET photo=:photo WHERE id_animal=:id_selected");
        $sql->bindParam(':photo', $newPhotoList);
        $sql->bindParam(':id_selected', $idSelected);
        $sql->execute();

        header("Refresh:0");
    }
}

// Vérifier si un animal est sélectionné
$idSelected = '';

if (isset($_POST['id_animal'])) {
    $idSelected = $_POST['id_animal'];
} elseif (isset($_GET['id_animal'])) {
    $idSelected = $_GET['id_animal'];
}

// Récupérer la liste des photos de l'animal sélectionné
if (!empty($idSelected)) {
    $sql = $db_b->prepare("SELECT photo FROM animaux WHERE id_animal=:id_selected");
    $sql->bindParam(':id_selected', $idSelected);
    $sql->execute();
    $selectData = $sql->fetch(PDO::FETCH_ASSOC);
    $images = explode(",", $selectData["photo"]);
}

// Traiter les soumissions de formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_photo'])) {
        $photoName = $_POST['photo_name'];
        deletePhoto($photoName, $idSelected, $db_b);
    }

    if (isset($_POST['submit'])) {
        uploadPhoto($idSelected, $db_b);
    }
}

// Sélectionner l'animal dans la liste déroulante
$sql = $db_b->prepare("SELECT id_animal FROM animaux");
$sql->execute();
$sqlResults = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="main">
    
    <a class="retour" href="index.php?page=tech"> > tech </a>
    <div class="gestion_page">
        <div class="main_photos">
            <form method="post">
                <div class="select_id_animal">
                    <select name="id_animal" id="animal-select">
                        <option value="" disabled selected>Sélectionnez un animal</option>
                        <?php foreach ($sqlResults as $row): ?>
                            <?php $selected = ($row['id_animal'] == $idSelected) ? 'selected' : ''; ?>
                            <option value="<?php echo $row['id_animal']; ?>" <?php echo $selected; ?>><?php echo $row['id_animal']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Sélectionner</button>
                </div>
            </form>

            <?php if (!empty($idSelected)): ?>
                <?php foreach ($images as $image): ?>
                    <div class="image_wrapper">
                    <img src="page/photos_spa/<?php echo $image ?>" width="300" height="auto">
                    <form method="post">
                        <input type="hidden" name="photo_name" value="<?php echo $image ?>">
                        <input type="hidden" name="id_animal" value="<?php echo $idSelected ?>">
                        <?php $selectedAnimal = $idSelected; ?>
                        <button type="submit" name="delete_photo">Supprimer</button>
                    </form>
                    </div>
                <?php endforeach; ?>

                <?php
                // Supprimer la photo sélectionnée si le formulaire est soumis
                if (isset($_POST['delete_photo'])) {
                    $photoName = $_POST['photo_name'];
                    deletePhoto($photoName, $idSelected, $db_b);
                }
                ?>
                <form action="index.php?page=gestion_photos" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_animal" value="<?php echo $idSelected ?>">
                    <input type="file" name="fileToUpload" id="fileToUpload" class="button">
                    <input type="submit" value="Upload Image" name="submit" class="button">
                </form>
            <?php endif; ?>
        </div>
   </div>
</div> 




