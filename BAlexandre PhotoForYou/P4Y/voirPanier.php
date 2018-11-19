<?php
    session_start();
    $_SESSION['idPage']=0;
	//la personne ne s'est pas encore connectée
     if(!isset($_SESSION['total']) && !isset($_SESSION['nbPanier']) && !isset($_SESSION['user']) && !isset($_SESSION['email']) && !isset($_SESSION['panier']) && !isset($_SESSION['type']) && !isset($_SESSION['credit']) && !isset($_SESSION['nom']) && !isset($_SESSION['prenom']))
    {
        $_SESSION['user']=null;
        $_SESSION['email']=null;
		$_SESSION['type']=null;
		$_SESSION['credit']=null;
		$_SESSION['nom']=null;
		$_SESSION['prenom']=null;
		$_SESSION['panier']=null;
		$_SESSION['nbPanier']=0;
		$_SESSION['total']=0;
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include "include/head.php";?>
<body>
<div id="container">
    <?php include "include/leMenu.php";?>
    <div id="body">
		<?php 
		
			$tabPanier;
		
			if(isset($_GET['del']))
			{
				$i=0;
				
				foreach($_SESSION['panier'] as $item)
				{
					if($item==$_GET['del'])
					{
						
						
						$uneReq=$db->query('select prix from image where idImg='.$_GET['del'].';');
						while($info=$uneReq->fetch())
						{
							$_SESSION['total']=$_SESSION['total']-$info['prix'];
						}
						$uneReq->closeCursor();
						
						
					}
					else
					{
						$tabPanier[]=$_SESSION['panier'][$i];
					}
					
					unset($_SESSION['panier'][$i]);
					$i++;
				}
				$o=0;
				
				$_SESSION['panier']=null;
				$_SESSION['nbPanier']=0;
				foreach($tabPanier as $neoPanierVar)
				{
					$_SESSION['panier'][$o]=$neoPanierVar;
					$_SESSION['nbPanier']++;
					$o++;
				}
			}
			
			if($_SESSION['user']==null)
			{
				include "include/coteDroit.php";
			}
			
			if(isset($_SESSION['panier']))
			{
				foreach($_SESSION['panier'] as $item)
				{
					$laBd=$db->query('select * from image where idImg='.$item.';');
					while($data=$laBd->fetch())
					{
						if($item==$data['idImg'])
						{
							$id=$data['idImg'];
							$leLien="uploads/".$data['idImg']."_Protec.jpeg";
							$lePseudo=$data['photographePseudo'];
							$lePrix=$data['prix'];
							$titre=$data['nomImage'];
						}
					}
					$laBd->closeCursor();
					
					echo 	"<p>Nom de l'image:".$titre.'</p>
							<img src="'.$leLien.'" height="50%" width="50%">
							<p>Pseudonyme du photographe: '.$lePseudo.'</p>
							<p>Prix: '.$lePrix.'</p>';
					echo '<form method="POST" action="voirPanier.php?del='.$id.'">';
					echo '<input type="submit" value="Retirer du panier">';
					echo '</form><br/>';
				}
				
				echo "Total à payer: ".$_SESSION['total'];
				echo '<form method="POST" action="acheterPhoto.php">';
				echo '<input type="submit" value="Acheter les photographies">';
				echo '</form>';
			}
			
		?>
			
    	<div class="clear"></div>
    </div>
    <?php include "include/footer.html";?> 
</div>
</body>
</html>
