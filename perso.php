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
//On récupére et on vérifie
include('./include/verification.inc.php');

?>
<!--Contenue du corps du tableau-->
    <tr>
    <!--Debut du formulaire-->
        <?php
        echo "<form action='perso.php".$code."' method='POST'>";
        ?>
      <td rowspan="5">
        <img src="images/index_17.jpg" width="33" height="463" alt="" />
      </td>
      <td colspan="11">
          <div id="left_content_image"><br />
              <div class="h2"><br /></div>
              <br />
              <div class="content_statR">
              P&eacute;riode:<br /><br />
              Comparer avec :
              </div>   
          </div>
      </td>
      <td colspan="8" rowspan="3">
          <div id="content"><br />
              <div class="h1">Impressions Personnelles</div>
                  <br />
                  <div class="content_statL"> 
                      <!--3 boutons radio, le mois est selectionné pas défaut-->
                      <input type='radio' id='pj' name='Periode' value='jour'/><label for='pj'> Jour</label> &nbsp;
                      <input type='radio' id='pm' name='Periode' value='mois' checked/><label for='pm'> Mois</label> &nbsp;
                      <input type='radio' id='pa' name='Periode' value='annee'/><label for='pa'> Ann&eacute;e</label> &nbsp;
                      <br /><br/>
                      <!--Liste déroulante pour choisir avoir quoi la courbe personnelle va être comparer-->
                      <SELECT name="comparer" size="1">
                            <OPTION selected value="">- - - 
                            <OPTION value="moyenne">La moyenne
                            <OPTION value="autre">Al&eacute;atoire
                            <!--<OPTION value="service">M&ecirc;me service
                            <OPTION value="fonction">M&ecirc;me fonction-->
                            </SELECT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="submit" id="valider" value="Valider"/>
<?php                      
//*************Enregistrement du graphique*************

//Récuperation du champs radio et celui de la liste déroulante (Periode + comparer)
    if(isset($_POST['Periode']) and $Code!="" and isset($_POST['comparer'])) //Si les variables periode, code et comparer existe on peut faire le graphique
         {
            //Variables
            $periode=$_POST['Periode']; //On récupére la période envoyer
            $Code=$_GET['code']; //On récupére le code dans l'url
            $choix=$_POST['comparer'];//On récupére le choix de comparaison de la liste déroulante
            
            $nomGraph=$Code;//On donne comme nom de graph le code utilisateur (pour l'instant
            
            //Création de 2 variables qui contiendra les résultats de la requete 
            $periodeT = array();
            $somme = array();
            
            //Fonction pour récupérer le résultat moyen selon la periode voulu
            $resultSomme=StatPerso($Code,$periode);
            
            //Rangement des résultats dans les tableaux
            $i=0;
            while ($row = mysql_fetch_array($resultSomme, MYSQL_NUM)) 
                {
                    $periodeT[$i] = $row[0];
                    $somme[$i] = floor($row[1]);
                    $i++;
                }
            
            //On regarde si on doit ajouter une autre courbe donc récupérer des résultats d'une requete
            if($choix=="moyenne")//Si l'utilisateur à choisi de comparer avec la courbe moyenne
            {
                //Creation d'un tableau qui contiendra les donnée qui serviront de comparaison avec la courbe des stat perso
                $courbe = array();
                
                //Fonction pour récupérer le résultat moyen selon la periode voulu
                $resultMoyenne=StatMoyen($periode);
                
                //Rangement des résultats dans les tableaux
                $i=0;
                while ($row = mysql_fetch_array($resultMoyenne, MYSQL_NUM)) 
                {
                    $courbe[$i] = floor($row[1]/44);
                    $i++;
                }
                
                //Appel de la fonction pour créer le graphique
                graphiqueCourbes($periodeT,$somme,$courbe,"Periode","Mes impressons","moyenne",$nomGraph);

            }elseif ($choix=="autre") //Si l'utilisateur a décider de comparer avec un agent aléatoirement (pour l'instant)
                {
                    //Creation d'un tableau qui contiendra les donnée qui serviront de comparaison avec la courbe des stat perso
                    $courbe = array();
                    $codesT=array();
                    
                    //Recherche d'un code user dans la base gérer aléatoriement par une fonction
                    $codeAutre=codeAléa($Code);
                    //echo ($codeAutre);
                    //
                    //Fonction pour récupérer le résultat somme d'un agent 
                    $resultSommeAutre=StatPerso($codeAutre,$periode);
                    
                    //Rangement des résultats dans les tableaux
                    $i=0;
                    while ($row = mysql_fetch_array($resultSommeAutre, MYSQL_NUM)) 
                        {
                            $courbe[$i] = floor($row[1]);
                            $i++;
                        }
                    //on créer le graphique 
                    graphiqueCourbes($periodeT, $somme, $courbe, "Période","Mes Impressions", "un agent", $nomGraph);
         
                }
                else//L'utilisateur à choisi ou laissé par defaut c'est à dire que sa courbe personnelle
                {
                //Appel de la fonction pour créer le graphique
                graphiqueCourbe($periodeT,$somme,'Periode','Mes impressions',$nomGraph);
                
                }
                
                //Ce echo permet d'insérer le graph et d'en faire un zoom lorsqu'on clique dessus.
                echo "<section class='image'>
                        <figure tabindex='1' contenteditable='true'>
                            <img src='./images/".$nomGraph.".png' width='462' height='200' alt='' contenteditable='false' />
                        </figure>
                      </section>";
                
                
         }

?>               
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