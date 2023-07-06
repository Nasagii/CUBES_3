
<?php

$id_animal=$_GET["id_animal"];
$sql =$db_b->prepare("SELECT * FROM animaux WHERE id_animal=:id_animal");
$sql->execute(["id_animal" => $id_animal]);
$select_data = $sql->fetchAll(PDO::FETCH_ASSOC);

$photos = explode(",", $select_data[0]['photo']);

// Récupérer la liste des photos de l'animal sélectionné
if (!empty($id_animal)) {
  $sql = $db_b->prepare("SELECT photo FROM animaux WHERE id_animal=:id_selected");
  $sql->bindParam(':id_selected', $id_animal);
  $sql->execute();
  $selectData = $sql->fetch(PDO::FETCH_ASSOC);
  $images = explode(",", $selectData["photo"]);
}
?>
  

<div class="main">
  <div class="profil">
    <div class="photo">
      <div class="article-photo">
          <div class="content"> 
              <p class="date"> <?php echo $select_data[0]['date_naissance'] ." | ";
                  if($select_data[0]['sexe']== "male" ) 
                      {
                      echo  "<i class=\"fa-solid fa-mars\" style=\"color: #fff;\"></i>";
                      }
                      else echo  "<i class=\"fa-solid fa-venus\" style=\"color: #fff;\"></i>" ;?></p>
              <p class="title"> 
                  <?php echo $select_data[0]['nom']; ?>
              </p>
          </div>
          <img src="page/photos_spa/<?php  echo $photos[0] ;?>"  alt="image animal" > 
      </div>
    </div>
    <div class="bio">
        <?php echo $select_data[0]['description'] ;?>
        <br><br>
        <button onclick="openQRCodePage()">Générer le QR code</button>
    </div>

    <div class="vign">
      <section class="slider-wrapper">
        <button class="slide-arrow" id="slide-arrow-prev">&#8249;</button>

        <button class="slide-arrow" id="slide-arrow-next">&#8250;</button>

        <ul class="slides-container" id="slides-container">
          <?php 
          if (!empty($id_animal))
            {
            foreach ($images as $image)
              {
              ?>
            <li class="slide"><img src="page/photos_spa/<?php echo $image ?> "  ></li>
            <?php 
              }
            }
          ?>
        </ul>
        
      </section>

    </div>
  
  </div>
</div>



<script>

const slidesContainer = document.getElementById("slides-container");
const slide = document.querySelector(".slide");
const prevButton = document.getElementById("slide-arrow-prev");
const nextButton = document.getElementById("slide-arrow-next");

nextButton.addEventListener("click", () => {
  const slideWidth = slide.clientWidth;
  slidesContainer.scrollLeft += slideWidth;
});

prevButton.addEventListener("click", () => {
  const slideWidth = slide.clientWidth;
  slidesContainer.scrollLeft -= slideWidth;
});

function openQRCodePage() 
  {
  // Ouvrir une nouvelle fenêtre pour afficher la page du QR code
  var newWindow = window.open('page/code_profil.php?id_animal=<?php echo $id_animal ?>&url='+ window.location.href , '_blank');
  }
</script>

*