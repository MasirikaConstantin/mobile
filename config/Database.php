<?php 
//header('content-type: text/html; charset=utf-8');
 // header('Content-Type: application/json');

//$bdd = new PDO ('msql:host=localhost; dbname=exercice;charset=utf8','root','');

/*
$host="192.168.107.1";
$user ="root";
$password="";
$dbname="programmationmobile";*/

   $host="sql212.infinityfree.com";
$user ="if0_36561389";
$password="QMtvDYKLNUrLRO";
$dbname="if0_36561389_programmationmobile";

//die('cdcd');
try{
                   
        /*$bdd =new PDO('mysql:host ='.$host. ';dbname='.$dbname. ';charset=utf8', $user,$password,[
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
        ]);*//*
                $bdd = new PDO('sqlite:../database.sqlite',null,null, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        */
         $dsn = 'mysql:host=sql212.infinityfree.com;dbname=if0_36561389_mob;charset=utf8mb4'; 
        $bdd =new PDO($dsn, $user,$password);
    }catch(PDOException $e){
                
        echo('<div class="container">
            <div class="alert alert-danger">
                Impossible de se connecter <h6>'.$e.'</h6>
            </div>
        </div>');

    }
/*[
    'UPDATE ouvrier SET ville_intervention=:ville_intervention WHERE id=:id'
    'id' => $id,
    'ville_intervention' => $ville
]*/

    /**
     * @param mixed $bdd Configuration de la base de données PDO
     * @param string $requette La requette à exécuter
     * @param array $data Les données à exécuter pour la requette 
     */
    function Modifier($bdd, string $requette, array $data)  {


        $req=$bdd->prepare($requette);
        $etat=$req->execute($data);
       

        //return $etat;
                    //UPDATE `ouvrier` SET `ville_intervention` = 'Kinshasa' WHERE `ouvrier`.`id` = 9 
               
    }

    function Utilisateur($pdo)
    {
       
        
        $id=$_SESSION['ouvrier']['id'];
        
        $query=$pdo->prepare('SELECT * FROM ouvrier WHERE id =:id');
        $query->execute(['id'=>$id]);
        $user=$query->fetch();
        
        return $user;
    }