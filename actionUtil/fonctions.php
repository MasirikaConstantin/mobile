<?php

     
    /* function __construct(\PDO $pdo)
    {
        $this ->pdo=$pdo;
    }*/
    
        
    
     function user($pdo)
    {
       
        if(session_status()===PHP_SESSION_NONE){
            session_start();
        }
        $id=$_SESSION['auth']?? null;
        if($id===null){
            return null;
        }
        $query=$pdo->prepare('SELECT * FROM inscription WHERE id =?');
        $query->execute([$id]);
        $user=$query->fetch();
        
        return $user?:null;
    }
function login(string $mail, string $password,  $pdo)
    {
        #$pdo=new PDO("sqlite:../bdd/client.db");
        $query=$pdo->prepare('SELECT * FROM inscription WHERE mail = :mail');
        $query->execute(['mail' =>$mail]);
        #$query->setFetchMode(PDO::FETCH_CLASS);
        $user =$query->fetch();
        
        if($user === false){
            return null;
        }
        
        #var_dump($user['mdp']);
        #var_dump($user['mdp']); die;
        if(($password === $user['mdp'])){
            if(session_status()=== PHP_SESSION_NONE){
                session_start();
            }
            $_SESSION['auth']=$user['id'];
            #var_dump($_SESSION);
            #var_dump($user);
            return $user;
        }

    }

     function compte(){
       $som= array_sum($_SESSION['panier']);
        return $som;
    }






















    //--------------------------------------------------------------------//

    
function parametre(array $data, string $param, $value): string {
    return http_build_query(array_merge($data,[$param => $value]));
}
function parametres(array $data, array $params): string{
    return http_build_query(array_merge($data, $params));
}
function tabledir(string $sortKey, string $label, array $data):string {
    
    
    $sort=$data ['sort']?? null;
    $direction =$data ['dir']??null;
    $icon="";
    if($sort === $sortKey){
        $icon=$direction === 'asc' ? "^" : "v";
    }
    $url =parametres($data,
    [
        'sort'=> $sortKey,
        'dir' => $direction === 'asc' && $sort === $sortKey ? 'desc' : 'asc'

    ]);
    
    return <<<HTML
    <a href="?$url">$label $icon</a>
HTML;
}

function images(string $img, string $com){
    return <<<HTML
    


<img src="images/$img" class="card-img-top"   >
  <div class="card-body">
    <p class="card-text">$com</p>
 

</div>
HTML;
}
function supprimer(int $id){
    return <<<HTML

    

HTML;
                                                    }




function erreur(){
$HTML='<?php if($succes1):?> 
        <div class="alert alert-success">
        <?php echo($succes1) ?>
        </div>
        <?php else:?> 
          <div class="alert alert-alert">
        <?php echo($error) ?>
        </div>
        <?php endif?>';
    echo ($HTML);
    

}

?>