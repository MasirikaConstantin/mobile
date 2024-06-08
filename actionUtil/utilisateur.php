<?php
    session_start();
    require("../vendor/autoload.php");
    //dump($_SESSION);
    require("../config/Database.php");
    require('fonctions.php');
    
    define('PAR_PAGE',3);


 
    //$query="SELECT ouvrier.nom,ouvrier.postnom, ouvrier.prenom FROM ouvrier";
    $query="SELECT ouvrier.*, expertise.nom AS expertise_nom FROM ouvrier INNER JOIN expertise ON ouvrier.id_expertise = expertise.id";
    

    $queryCount = "SELECT COUNT(id) as count FROM ouvrier ";
    $params=[];
    $sortable=['id', 'nom', 'postnom', 'prenom', 'num'];

    if(!empty($_GET['q'])){
        $query .= " WHERE description LIKE :description";
        $queryCount .= " WHERE description LIKE :description";
        $params['description']='%' . $_GET['q'] . '%';
        #$login=$_GET['login'];
    }



    $page =(int)($_GET['p'] ?? 1);
    $offset = ($page-1)* PAR_PAGE;

    $query .= " LIMIT " . PAR_PAGE . " OFFSET $offset";

    $statement = $bdd->prepare($query);
    $statement->execute($params);
    $donnes=$statement->fetchAll();

    $statement = $bdd-> prepare($queryCount);
    $statement -> execute($params);
    $count = (int)$statement->fetch()['count'];
    $pages=(int)(ceil($count / PAR_PAGE)); //arrondir

    $query1 =$bdd->query('SELECT * FROM ouvrier');
    $tables=$query1->fetchAll(PDO::FETCH_OBJ);

   dump($donnes);

       
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
</head>
<body>

    <div class="container mt-5">
        <label for=""></label>
    <a href="ConnexionClie.php">LOGINNNNN</a> <br>
    <a href="../deconnection.php">DECONNNNNN</a>



          <?php foreach ($donnes as $i ): ?>
                        
                        
            <div class="col shadow-lg p-3 mb-5  ">
            
              <div class="card shadow-sm ">
                <img src="<?= $ll?>" alt="" srcset="" width="100%" height="100%">
                    <!--svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg-->
                   
                    <hr>
                        <div class="card-body  ">
                            
                            
                                
                            <div class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                                <p class="col-md-4 mb-0 card-text"> <?= $i['nom'].'   '.$i['postnom']."    ".$i['prenom'] ?> <br> EST <strong><?= $i['expertise_nom'] ?></strong></p>

                                <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
                                </a>

                                <ul class="nav col-md-4 justify-content-end">
                                    <li class="nav-item me-4">Dans</li>
                                    <li class="nav-item me-4"><strong><?= $i['ville_intervention'] ?></strong></li>
                                    
                                </ul>
                            </div>
                                
                        </div>
                        
                </div>
                   
                
            </div>
            <?php endforeach ?> 
 
           
        </div>
        <div class="container">
            
       

                <div class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                    <div class="col-md-4 d-flex align-items-center">
                    <?php if($pages > 1 && $page > 1): ?>
                                <a href="?<?= parametre($_GET,"p", $page - 1)?>" class="btn btn-primary">Page précédente</a>

                                <?php endif?>
                    </div>

                    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                        <li class="ms-3">
                        <?php if($pages > 1 && $page < $pages): ?>
                                <li>
                                <a  href="?<?= parametre($_GET,"p", $page + 1)?>" class="btn btn-primary  justify-content-md-start">Page Suivante</a>
                                </li>
                                <?php endif?>
                        </li>
                    </ul>
                </div>
        </div>
    
    </main>
    </div>
 
   




    


   




    
    
</body>
</html>