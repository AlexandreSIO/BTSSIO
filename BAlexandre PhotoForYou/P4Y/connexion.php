<?php
    session_start();
    
    $yes=false;
    
    include "include/head.php";
 
    $laBd=$db->query("select * from utilisateur");
    while($data=$laBd->fetch())
    {
        if($data['pseudo']==$_POST['pseudoForm'] && $data['emailUser']==$_POST['emailForm'] && $data['mdpUser'] == sha1($_POST['pswForm']))
        {
            $yes=true;
            $_SESSION['user']=$data['pseudo'];
            $_SESSION['email']=$data['emailUser'];
			$_SESSION['type']=$data['typeUser'];
			$_SESSION['credit']=$data['credit'];
			$_SESSION['nom']=$data['nomUser'];
			$_SESSION['prenom']=$data['prenomUser'];
        }
    }
	$laBd->closeCursor();
	
    if($yes==false)
    {
        session_destroy();
    }
    
    header('Location: accueil.php');
    exit();