<div id="header">
    	<h1><a href="accueil.php">Photo for you</a></h1>
        <h2>Artisan de la photographie depuis 1969</h2>
        <h2><?= 'Utilisateur: '.$_SESSION['user'].'<br/> Type: '.$_SESSION['type']?>
			<?php 
				if(isset($_SESSION['type']) && $_SESSION['type']=="client")
				{
					echo '<br/> <a href="voirPanier.php">Panier: '.$_SESSION['nbPanier'].'</a>';
				}
			?>
		</h2>
        <div class="clear"></div>
    </div>
    <div id="nav">
    	<ul>
            <?php
				//Le menu est differant en fonction de la connexion
				//L'utilisateur n'est pas connecté, il n'a pas besoin de lien vers son compte ou pour se déconnecter
                if(!isset($_SESSION['user']))
                {
                    $req=$db->query('Select * from menu where nomMenu!="Deconnexion" and nomMenu!="Compte"');
                    while($data=$req->fetch())
                    {
                        if($data['idMenu']==$_SESSION["idPage"])
                        {
                           echo '<li class="start selected"><a href="'.$data['lien'].'">'.$data["nomMenu"].'</a></li>' ;
                        }
                        else
                        {
                            echo ' <li><a href="'.$data['lien'].'">'.$data['nomMenu'].'</a></li>';
                        }
                    }
                    $req->closeCursor();
                }
				//L'utilisateur est connecté, il n'a pas besoin de lien de connexion et d'inscription
                elseif(isset($_SESSION['user']))
				{
					$req=$db->query('Select * from menu where idMenu!=4 and idMenu!=5');
					while($data=$req->fetch())
					{
						if($data['idMenu']==$_SESSION["idPage"])
						{
						   echo '<li class="start selected"><a href="'.$data['lien'].'">'.$data["nomMenu"].'</a></li>' ;
						}
						else
						{
							echo ' <li><a href="'.$data['lien'].'">'.$data['nomMenu'].'</a></li>';
						}
					}
					$req->closeCursor();
				}
                
                    
            ?>
            
        </ul>
    </div>