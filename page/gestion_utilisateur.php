
<?php
// Vérifier si le formulaire a été soumis
if(isset($_POST["nom"])) $nom=$_POST["nom"];
else $nom="";

// Check if image file is a actual image or fake image
if(isset($_POST["ajouter"])) 
    {
    $sql = $db_b ->prepare("INSERT INTO auth (nom) VALUES (:nom)");
    $sql->execute(["nom"=> $nom]);
    }

// DELETE //
if(isset($_GET["delete_id"]))
    {
	if(is_numeric($_GET["delete_id"]))
        {
        $delete_id=$_GET["delete_id"];
        $sql =$db_b->prepare("DELETE FROM auth WHERE id=:delete_id");
        $sql->execute(["delete_id" => $delete_id]);
        }
    }
?>


<div class="main">
    <a class="retour" href="index.php?page=tech"> > tech </a>
    <div class="gestion_page">
        <h1>Ajouter un admin</h1>
        
        <form method="post" enctype="multipart/form-data" action="index.php?page=gestion_utilisateur">
            
            <select name="nom" id="nom-select"> 
                <option value="">Choisir un utilisateur</option>
                <?php
                    $sql =$db_b->prepare("SELECT nom FROM utilisateur");
                    $sql->execute();
                    $sql_results = $sql->fetchAll(PDO::FETCH_ASSOC);
                    for($i=0;$i<count($sql_results);$i++){
                        echo"<option value=".$sql_results[$i]['nom'].">".$sql_results[$i]['nom']."</option>";
                    }	
                ?>
            </select>
            <input type="submit" name="ajouter" value="Ajouter" id="form" class="button"><br>
        </form>

        <table class="content" >
            <thead>
                <tr>
                    <th >Nom</th>
                    <th >Action</th>
                </tr>
            </thead>
            <tbody id="content">

            <?php
            // SELECT nom,photo,sexe,date_naissance FROM animaux
            $sql =$db_b->prepare("SELECT * FROM auth");
            $sql->execute();
            $select_data = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            for($u=0;$u<count($select_data);$u++)
            {
            ?>
            <tr>
                <td ><?php echo $select_data[$u]['nom'];?></td>
                <td ><a href="index.php?page=gestion_utilisateur&delete_id=<?php echo $select_data[$u]['id'] ?>"><img src="style/delete.png" alt="Supprimer" style="max-width: 50px; max-height: 50px;"></a></td>
            </tr>

            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>