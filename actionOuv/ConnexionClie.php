<?php
session_start();

if($_SESSION['ouvrier']!=null){
    header('Location: ouvrier.php');
}
//header('Content-Type: application/json');
   // include_once ('../config/Database.php');
    $json = json_decode(file_get_contents('php://input'), true); // Correction ici : 'php:/input' -> 'php://input'
    $result = array();

    //$json["email"] = $_POST['email'];
    //$json["mdp"] = $_POST['mdp'];
    include_once ('../config/Database.php');
   

   // $json = json_decode(file_get_contents('php://input'), true);
    /*$json['username']="COCO";
    $json['password']="coco";*/
    if(isset($json['email']) AND isset($json['mdp'])){
       $email = htmlspecialchars($json['email']);
       $mdp = htmlspecialchars($json['mdp']);
       $getUser=$bdd->prepare('SELECT * FROM ouvrier WHERE email = ?');
       $getUser->execute(array($email));
       $resultat = $getUser->fetch();

     
            if($resultat ){
               // var_dump($resultat);die;
                $user= $resultat;
               if(password_verify($mdp, $user['mdp'])){
                    $result['succes'] = true; 
                    $_SESSION['ouvrier'] = $user;
                    $result['identite']=$user['nom'].' '.$user['postnom'].' ' .$user['prenom'];
                    //header('Location: ouvrier.php');

                } else {
                    $result['identite']="erreur";
                    $result['succes']=false;
                    $result['error'] = ' Mot de passe incorect';
                }
            }else{
                $result['identite']="erreur";

                $result['succes']=false;
                    $result['error'] = "Mot de passe ou nom d'utilisateur incorect";
            }
    } else{
        $result['identite']="erreur";

        $result['succes']=false;
        $result['error'] = 'Veillez Completez tous les champs ... ';

    }
    echo json_encode($result);
?>


<!--!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../bootstrap.min.css">
    </head>
    <body>

        <div class="container mt-5">
            <form action="" method="post" class="" >


                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" >
                    <label for="floatingInput">Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingInput" placeholder="name@example.com" name="mdp" >
                    <label for="floatingInput">Mot de Passe</label>
                </div>


                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
        
    </body>
</html-->