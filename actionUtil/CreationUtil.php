<?php
//echo(phpinfo());die();

    //header('Content-Type: application/json');
   $result = array();

    require ('../config/Database.php');
    $json = json_decode(file_get_contents('php://input'), true);
    
/*
   $json["nom"]= $_POST['nom'];
   $json['postnom'] = $_POST['postnom'] ;
   $json["prenom"] = $_POST['prenom'] ;
   $json["num"] = $_POST['num'] ;
   $json["adresse"] = $_POST['adresse'] ;
   $json["email"] = $_POST['email'];
   $json["mdp"] = $_POST['mdp'];
*/
  
    if(isset($json['nom']) AND isset($json['postnom']) AND isset($json['prenom']) AND isset($json['num']) AND isset($json['mdp']) AND isset($json['email'])){
       $nom = htmlspecialchars($json['nom']);
       $postnom = htmlspecialchars($json['postnom']);
       $prenom = htmlspecialchars($json['prenom']);
       $num = htmlspecialchars($json['num']);
       $mdp = htmlspecialchars($json['mdp']);
       $email = htmlspecialchars($json['email']);
       $adresse = htmlspecialchars($json['adresse']);
       

       $passwordHash = password_hash($mdp, PASSWORD_DEFAULT);
       $succes="";

       if($nom == "" OR $postnom == "" OR $prenom == "" OR $num == "" OR $mdp == "" OR $email == "" ){
        $result['succes']=false;
        $result["error"] = "Veillez remplirer tous les champs Obligatoires";

       }else{
        
            $verifUsernameIfExists = $bdd->prepare('SELECT id FROM utilisateur WHERE email = ?');

            $verifUsernameIfExists->execute(array($email));
            $resultat = $verifUsernameIfExists->fetchAll();
            //var_dump($result);

            if($resultat ){

                $result['succes'] =  false;
                $result['error'] = "Ce Compte mail est déjà utiliser ";
            }else{
                //postnom;
                try{

                    $createAccount = $bdd->prepare('INSERT INTO utilisateur (nom,postnom,prenom,num,Adresse,email,mdp,type) 
                    VALUES(:nom,:postnom,:prenom,:num,:Adresse,:email,:mdp,:type)');
                    $createAccount->execute(
                        [
                            "nom" => $nom,
                            "postnom" => $postnom,
                            "prenom" => $prenom,
                            "num" => $num,
                            "Adresse" => $adresse ,
                            "email" =>  $email,
                            "mdp" => $passwordHash ,
                            "type" =>"Utilisateur"
                        ]
                    );
                    //$result['mdp']=$passwordHash;
                    $result["succes"]=true;
                    $result["type"]=true;

                }catch(Exception $e){
                    echo($e->getMessage());
                        $result['succes']=false;
                        $result['error'] = 'Erreur de Création ... ';

                }
            }
       }
    }else{
        $result['succes']=false;
        $result['error'] = 'Veillez remplirer tous les champs Obligatoires f... ';
        
    }
     echo(json_encode($result));
?>

<DOCTYPE html>
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
                        <input type="text" class="form-control" id="floatingInput"  name="nom" >
                        <label for="floatingInput">Nom </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput"  name="postnom" >
                        <label for="floatingInput">Post - Nom</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput"  name="prenom" >
                        <label for="floatingInput">Prénom</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput"  name="num" >
                        <label for="floatingInput">Numero</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput"  name="adresse" >
                        <label for="floatingInput">Adresse </label>
                    </div>

                

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput"  name="email" >
                        <label for="floatingInput">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingInput"  name="mdp" >
                        <label for="floatingInput">Mot de Passe</label>
                    </div>


                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
            
        </body>
</html>