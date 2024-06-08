<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

// if(isset($_GET['get_id'])){
//    $get_id = $_GET['get_id'];
// }else{
//    $get_id = '';
//    header('location:home.php');
// }

if(isset($_POST['save_list'])){

   if($user_id != ''){
      
      $list_id = $_POST['list_id'];
      $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);

      $select_list = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
      $select_list->execute([$user_id, $list_id]);

      if($select_list->rowCount() > 0){
         $remove_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
         $remove_bookmark->execute([$user_id, $list_id]);
         $message[] = 'playlist removed!';
      }else{
         $insert_bookmark = $conn->prepare("INSERT INTO `bookmark`(user_id, playlist_id) VALUES(?,?)");
         $insert_bookmark->execute([$user_id, $list_id]);
         $message[] = 'playlist saved!';
      }

   }else{
      $message[] = 'please login first!';
   }

}

?>





<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Success !</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<?php
require('fpdf/fpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $fetch_profile['name'];

    // Créer une instance de FPDF
    $pdf = new FPDF();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->AddPage();
    

    // Ajouter l'image de fond (le design de Canva)
    $pdf->Image('Certificat.png', (210 - 200) / 2, (297 - 150) / 2, 200, 150);

    // Ajouter le nom de l'utilisateur dynamique
    $pdf->SetXY(0, 150); // Ajustez la position selon votre design
    $pdf->Cell(0, 10, utf8_decode($name), 0, 1, 'C'); // Utilisez utf8_decode pour les caractères spéciaux

    // En-têtes pour le téléchargement
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Certificate.pdf"');

    // Générer le PDF et l'envoyer au navigateur
    $pdf->Output('D', 'Certificate.pdf');
    exit;
}
?>

<!-- playlist section starts  -->


<!-- playlist section ends -->

<!-- videos container section starts  -->

<section class="videos-container">

   <h1 class="heading">Certificate passed !</h1>

   <div class="box-container" id="course-container">
   <div class="heading">Score : <?php echo $_GET["score"] ?>%</div>
    <div class="box" style="height: 100%">
        <img src="Certificat.png" alt="" style="width: 100%">
        <form method="post">
            <button type="submit" class="inline-btn">Download Certificate</button>
        </form>
    </div>

   </div>

</section>

<!-- videos container section ends -->











<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>