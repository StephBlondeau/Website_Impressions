
<?php
//variable de base
$code="";

    if(isset ($_GET['code'])) //s'il y a un code dans l'url
    {
        
        //On récupere le code
        $Code=$_GET['code'];
        
        //creation d'une variable pour l'url
        $code="?code=".$Code;
        //*********on regarde si le code existe dans la base******
        $verif=verifCode($Code);
        
        //On regarde la valeur du resultat
        if (!$verif or $Code=="")
        {
            header('Location: index.php');
        }
        
    }
    else
    {
        header('Location: index.php');
    }
    
?>