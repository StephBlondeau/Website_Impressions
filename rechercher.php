<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
include ("./include/debut.inc.php");
//Ajout de la connexion à la BDD
include ("./include/dbconnect.inc.php");
//Ajout de la liste des fonctions
include ("./include/fonctions.inc.php");
//On récupére et on vérifie
include('./include/verification.inc.php');
?>
<!--Contenue du corps du tableau-->
    <tr>
    <!--Debut du formulaire-->
      <td rowspan="5">
        <img src="images/index_17.jpg" width="33" height="463" alt="" />
      </td>
      <td colspan="11">
          <div id="left_content_image"><br />
              <div class="h2"><br /></div>
              <br />
              <div class="content_statR">
              <label for='titreD'> Titre du document : </label><br /><br />
              </div>   
          </div>
      </td>
      <td colspan="8" rowspan="3">
          <div id="content"><br />
              <div class="h1">Recherche d'un document</div>
                  <br />
                  <div class="content_statL"> 
                      <form action='rechercher.php<?php echo $code;?>' method='POST'>
                        <input type='search' id='titreD' name='titre' placeholder='Veuillez entrer un titre'/>
                        <input type="submit" id="valider" value="Rechercher"/>
                      </form>
<?php                      
                  
                    if (isset ($_POST['titre']) and $Code!="" and $_POST['titre']!="" ) //On vérifie si le formulaire a été valider (envoie du titre et du code
                    {
                        //On récupére la valeur du formulaire
                        $recherche=$_POST['titre'];
                        //On doit écrire minimun 5 caractéres
                        $caracMin=5;
                        
                        //on utilise une fonction pour rechercher les documentes qui compose cette recherche avec leur dates et le nombre de pages
                        $resultat=rechercheDoc($recherche);
                        
                        //Création de 3 tableaux qui vont contenir les nom, date et pages des documents trouvés
                        $dates=array();
                        $noms=array();
                        $pages=array();
                        
                        if(strlen($recherche)<$caracMin)
                        {
                            $erreur="Veuillez saisir au minimum 5 caract&egrave;res.";
                        }
                        
                        //On créer le tableaux s'il n'y a pas d'erreur
                        if(!$erreur)
                        {
?>
                            <div class="divConteneur">
                            <table class="t1" summary="documents qui répondes à la recherche de l'user"> 
                              <!--<caption>Liste des Documents trouv&eacute;s</caption> -->
                              <thead> 
                                  <tr>
                                      <th>Nb Pages</th>
                                      <th>Titre document</th>
                                      <th>Dates Impressions</th>
                                  </tr> 
                              </thead> 
                              <tfoot> 
                                  <tr>
                                      <th colspan="4"></th>
                                  </tr> 
                              </tfoot> 
                              <tbody>
<?php
                            //Rangement des résultats dans les tableaux
                            $i=0;
                            while ($row = mysql_fetch_array($resultat))
                                {
                                    $pages[$i] = $row[2];
                                    $noms[$i] = $row[1];
                                    $dates[$i] = $row[0];

                                    echo"<tr>
                                            <th>".$pages[$i]."</th>
                                            <td>".$noms[$i]."</td>
                                            <td>".$dates[$i]."</td>
                                         </tr>";

                                    $i++;
                                }
                            
                            if ($i==0)
                            {
                                echo "<tr><th colspan='4'>Aucun Document trouv&eacute;...</th></tr> ";
                            }
                            
                            echo "</tbody> 
                                </table>
                               </div>";
                        
                            echo"<br /><div id='resultat'> R&eacute;sultat trouv&eacute;(s): ".$i.".</div>";
                            
                        }else
                        {
 ?>                           
                            <div id='affiner'> 
                                 <?php echo $erreur;?>
                           </div>
<?php                                  
                        }
                    }
?>
                 </div>
          </div>
      </td>
      <td rowspan="5">
	<img src="images/index_20.jpg" width="108" height="463" alt="" />
      </td> 
    </tr>
    <tr>
      <td rowspan="2">
        <img src="images/index_21.jpg" width="14" height="114" alt="" /></td>
	    <td height="36" colspan="2" style="background:url(images/index_22.jpg)"></td>
	    <td rowspan="2">
	        <img src="images/index_23.jpg" width="11" height="114" alt="" /></td>
	    <td style="background:url(images/index_24.jpg)"></td>
	    <td colspan="2" rowspan="2">
	        <img src="images/index_25.jpg" width="13" height="114" alt="" /></td>
	    <td colspan="3" style="background:url(images/index_22.jpg)">
	    </td>
	    <td rowspan="2">
	        <img src="images/index_33.jpg" width="35" height="114" alt="" /></td>
      </tr>

<?php
include ("./include/fin.inc.php");
?>