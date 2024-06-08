<?php
//echo(phpinfo());die();

    //header('Content-Type: application/json');
    require ('../config/Database.php');
   $json = json_decode(file_get_contents('php://input'), true);


   $json["nom"]= $_POST['nom'];
   $json['postnom'] = $_POST['postnom'] ;
   $json["prenom"] = $_POST['prenom'] ;
   $json["num"] = $_POST['num'] ;
   $json["adresse_physique"] = $_POST['adresse_physique'] ;
   $json["adresse_postale"] = $_POST['adresse_postale'] ;
   $json["email"] = $_POST['email'];
   $json["mdp"] = $_POST['mdp'];
   $json["expertise"] = $_POST['expertise'] ;

   
   $ex = $bdd->prepare('SELECT * FROM expertise');
   $ex->execute();
   $expertise = $ex->fetchAll();

  
    if(isset($json['nom']) AND isset($json['postnom']) AND isset($json['prenom']) AND isset($json['num']) AND isset($json['mdp']) AND isset($json['email'])){
       $nom = htmlspecialchars($json['nom']);
       $postnom = htmlspecialchars($json['postnom']);
       $prenom = htmlspecialchars($json['prenom']);
       $num = htmlspecialchars($json['num']);
       $mdp = htmlspecialchars($json['mdp']);
       $email = htmlspecialchars($json['email']);
       $expertise = htmlspecialchars($json['expertise']);
       $adressephysique = htmlspecialchars($json['adressephysique']);
        $adressepostale =  htmlspecialchars($json['adressepostale']);


       $passwordHash = password_hash($mdp, PASSWORD_DEFAULT);
       $succes="";

       if($nom == "" OR $postnom = "" OR $prenom == "" OR $num == "" OR $mdp == "" OR $email == "" ){
        
        $result['succes']=false;
        $result["error"] = "Veillez remplirer tous les champs Obligatoires";

       }else{
        
            $verifUsernameIfExists = $bdd->prepare('SELECT id FROM ouvrier WHERE email = ?');

            $verifUsernameIfExists->execute(array($email));
            $resultat = $verifUsernameIfExists->fetchAll();
            //var_dump($result);

            if($resultat ){

                $result['succes'] =  false;
                $result['error'] = "Ce Compte mail est déjà utiliser ";
            }else{

                try{

                    $createAccount = $bdd->prepare('INSERT INTO ouvrier (nom,postnom,prenom,num,adressephysique,adressepostale,mdp,email,id_expertise) 
                    VALUES(:nom,:postnom,:prenom,:num,:adressephysique,:adressepostale,:mdp,:email,:id_expertise)');
                    $createAccount->execute(
                        [
                            "nom" => $nom,
                            "postnom" => $postnom,
                            "prenom" => $prenom,
                            "num" => $num,
                            "adressephysique" => $adressephysique ,
                            "adressepostale" => $adressepostale ,
                            "mdp" => $passwordHash ,
                            "email" =>  $email,
                            "id_expertise" => $expertise
                        ]
                    );
                    $result['mdp']=$passwordHash;
                    $result["succes"]=true;
                }catch(Exception $e){
                    echo($e->getMessage());
                        $result['succes']=false;
                        $result['error'] = 'Erreur de Création ... ';

                }
            }
       }
    }else{
        $result['succes']=false;
        $result['error'] = 'Veillez remplirer tous les champs Obligatoires ... ';
        
    }
     echo(json_encode($result));
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
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="nom" >
                        <label for="floatingInput">Nom </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="postnom" >
                        <label for="floatingInput">Post - Nom</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="prenom" >
                        <label for="floatingInput">Prénom</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="name@example.com" name="num" >
                        <label for="floatingInput">Numero</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="adresse_physique" >
                        <label for="floatingInput">Adresse Physique</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="adresse_postale" >
                        <label for="floatingInput">Adresse Postale</label>
                    </div>

                    <select class="form-select mb-3" aria-label="Default select example" name="expertise" >
                        <?php foreach ($expertise as $key ) :?>
                            <option value="<?= $key['id'] ?>"><?= $key['nom'] ?></option>
                        <?php endforeach ?>
                    </select>


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