<?php
  include('phpqrcode/qrlib.php');

  // Vérifier si l'URL est présente dans l'URL de la page
  if (isset($_GET['url'])) {
    
    $id = $_GET['id_animal'];
    $url = $_GET['url']."&id_animal=".$id;
    
    // Chemin de sauvegarde du fichier QR code
    // $qrCodeFilePath = 'page/qrcode/qrcode.png';

    // Générer le QR code
    // QRcode::png($url, $qrCodeFilePath, QR_ECLEVEL_L, 10);

    // Afficher le QR code
    // echo '<img src="'.$qrCodeFilePath.'" alt="QR Code">';
    QRcode::png(''.$url.'');
  }
?>