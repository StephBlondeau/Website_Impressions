<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php

//***********Gestion des erreurs possibles*************

//setlocale(LC_TIME, "fr_FR");
//setlocale("fr_FR.UTF-8");
//error_reporting(E_ALL); # report all errors
//ini_set("display_errors", "1"); # but do not echo the errors

//*************Liste des includes*************
include ("./include/debut.inc.php"); //Debut de la page html identique à tous 
//Fichier pChart pour la créaion d'un graphique
include("../pChart/class/pData.class.php");
include("../pChart/class/pDraw.class.php");
include("../pChart/class/pImage.class.php");
include("../pChart/class/pCache.class.php");
//fichier de Connexion à la BDD Mysql
include('./include/dbconnect.inc.php');
//Fichier de fonction
include('./include/fonctions.inc.php');

//variable de base
$code="";

    if(isset ($_GET['code'])) //s'il y a un code
    {
        //*********on regarde si le code existe dans la base
        $code="?code=".$_GET['code']; //variable à inséré dans l'url
    }
?>
<!--Contenue du corps du tableau-->
    <!--Debut de la 1ere ligne du tableau en-tete-->
    <tr>
        <?php
        echo "<form action='moyenne.php".$code."' method='POST'>";
        ?>
            <td rowspan="5">
              <img src="images/index_17.jpg" width="33" height="463" alt="" />
            </td>
            <td colspan="11">
                <div id="left_content_image"><br />
                  <div class="h2"><br /></div>
                  <br />
                  <div class="content_statR">
                    P&eacute;riode:
                  </div>   
                </div>
            </td>
            <td colspan="8" rowspan="3">
                <div id="content"><br />
                  <div class="h1">Impressions Moyenne</div>
                  <br />
                  <div class="content_statL"> 
                      <input type='radio' id='pj' name='Periode' value='jour'/><label for='pj'> Jour</label> &nbsp;
                      <input type='radio' id='pm' name='Periode' value='mois' checked/><label for='pm'> Mois</label> &nbsp;
                      <input type='radio' id='pa' name='Periode' value='annee'/><label for='pa'> Ann&eacute;e</label> &nbsp;
                      <input type="submit" id="valider" value="Valider"/>
<?php                      
//*************Enregistrement du graphique*************

//Récuperation du champs radio

    if(isset($_POST['Periode']) and $code!="") //Si les variables periode et code existe on peut faire le graphique
         {
            $periode=$_POST['Periode']; //On la récupére
            
            //Création de 2 variables qui contiendra les résultats de la requete 
            $periodeT = array();
            $moyenne = array();
            
            //Fonction pour récupérer le résultat moyen selon la periode voulu
            $resultMoyenne=StatMoyen($periode);
            
            //Rangement des résultats dans les tableaux
            $i=0;
            while ($row = mysql_fetch_array($resultMoyenne, MYSQL_NUM)) {
                $periodeT[$i] = $row[0];
                $moyenne[$i] = floor($row[1]/44);
                $i++;
            }
            
            //Création du nom du fichier du graphique
            $nomGraph= $_GET['code']; //optionnellement on peut rajouter date(j-m-y)

            //Appel de la fonction pour créer le graphique
            graphiqueCourbe($periodeT,$moyenne,'Periode','Moyenne',$nomGraph);
            
            //Ce echo permet d'insérer le graph et d'en faire un zoom lorsqu'on clique dessus.
                echo "<section class='image'>
                        <figure tabindex='1' contenteditable='true'>
                            <img src='./images/".$nomGraph.".png' width='462' height='200' alt='' contenteditable='false' />
                        </figure>
                      </section>";
            
         }
?>                      
   
                  </div>
                </div>
            </td>
            <td rowspan="5">
              <img src="images/index_20.jpg" width="108" height="463" alt="" />
            </td>
      </form>
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