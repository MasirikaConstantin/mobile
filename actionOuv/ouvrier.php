<?php
    session_start();
    if($_SESSION['ouvrier']==null){
        header('Location: ConnexionClie.php');
        die();
    }
    require("../config/Database.php");


    $req=$bdd->prepare('SELECT * FROM ville_intervention');
    $req->execute();
    $villes = $req->fetchAll();
   // $d=Utilisateur($bdd);

      
    require("../vendor/autoload.php");
    //dump($villes);
   // dump($_SESSION['ouvrier']);
   $Utilisateur= Utilisateur($bdd);
   dump($Utilisateur);
    

                if (isset($_POST['ville'])){

                    $ville = implode(";",$_POST['ville']);
                    $marequette='UPDATE ouvrier SET ville_intervention=:ville_intervention WHERE id=:id';
                    $data=[
                            'id' => $_SESSION['ouvrier']['id'],
                            'ville_intervention' => $ville
                        ];
                  
                        Modifier($bdd, $marequette,$data);
                   
                    //dump($coco);

                    

                    //UPDATE `ouvrier` SET `ville_intervention` = 'Kinshasa' WHERE `ouvrier`.`id` = 9 
                }
                $choix_utilisateur =explode(';',$Utilisateur['ville_intervention']); 
                dump($choix_utilisateur);
         
         
    
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
    <link rel="stylesheet" href="../tom-select.css">
    <script src="../tom-select.complete.min.js.js"></script>
</head>
<body>

    <div class="container mt-5">
        <label for=""></label>
   
    <a href="ConnexionClie.php">LOGINNNNN</a> <br>
    <a href="../deconnection.php">DECONNNNNN</a>

    <div class="row ">
      <div class="col-md-6">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h2>Change the background</h2>
          <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then, mix and match with additional component themes and more.</p>
          <button class="btn btn-outline-light" type="button">Example button</button>
        </div>
      </div>
      <div class="col-md-6">
        <div class="h-100 p-2 bg-light border rounded-3">
          <h2>Mettre à jours vos informations</h2>
            <p>Villes d'interventions</p>

         <form action="" method="post">
            <select  class="form-select mb-3" aria-label="Default select example" name="ville[]" multiple placeholder="Selectionne une ou plusieurs villes" >
                    <?php foreach ($villes as $key ) :?>
                        <option value="<?= $key['nom'] ?>" <?= in_array($key['nom'], $choix_utilisateur) ? 'selected' : '' ?> ><?= $key['nom'] ?></option>
                    <?php endforeach ?>
                </select>

                <button type="submit" id="myButton" class="btn btn-primary">Envoyer</button>


         </form>
         
        </div>
      </div>
    </div>
    </div>

    <script>
        new TomSelect('select[multiple]',{plugins:{remove_button:{title:"Supprimer"}}})
                        // Créez d'abord un bouton dans votre HTML
            // <button id="myButton">Actualiser la page</button>

            // Ensuite, dans votre JavaScript, vous pouvez ajouter un écouteur d'événements au bouton
            document.getElementById('myButton').addEventListener('click', function() {
                location.reload();
            });

    </script>


</body>
</html>