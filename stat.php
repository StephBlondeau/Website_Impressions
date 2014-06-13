<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
//Ajout debut de page html
include ("./include/debut.inc.php");
//fichier de Connexion à la BDD Mysql
include('./include/dbconnect.inc.php');
//On inclut la liste des fonctions
include('./include/fonctions.inc.php');
//On récupére et on vérifie
include('./include/verification.inc.php');

    if(isset($_POST['Periode']) and $Code!="") //Si la variables periode exite et code n'ai pas vide on peut faire le graphique
         {
            $periode=$_POST['Periode']; //On la récupére
            
            //recherche de la somme d'impression selon la période choisi ainsi que la date du jour
            $total=nbImpressions($Code,$periode);
            
            //On calcul les statistiques selon la période choisi et le code utilisateur
            if($periode=='mois')
            {
                //On recherche son nombre maximun d'impression et a quel mois 
                //Création de 2 variables qui contiendra les résultats de la requete 
                $periodeT = array();
                $somme = array();

                //Fonction pour récupérer le résultat moyen selon la periode voulu
                $resultSomme=StatPerso($Code,$periode);

                //Rangement des résultats dans les tableaux
                $i=0;
                $max=0;
                $min=100000;
                while ($row = mysql_fetch_array($resultSomme, MYSQL_NUM)) 
                    {
                        $periodeT[$i] = $row[0];
                        $somme[$i] = floor($row[1]);
                        if($somme[$i]>$max)
                        {
                            $max=$somme[$i];
                            $dateMax=$periodeT[$i];
                        }
                        
                        if($somme[$i]<$min)
                        {
                            $min=$somme[$i];
                            $dateMin=$periodeT[$i];
                        }
                        $i++;
                    }
                //Calcul des coûts 
                    //cout en euros
                        //En noir recto/Verso
                        $cout=($max/10)*0.15;
                        $coutMax=number_format($cout,2);
                    //cout en arbres
                        $ArbMax=$max/15000;//15 000 feuilles donne 1 arbres
                        $coutArbMax=number_format($ArbMax,2);
                    
                    //cout en euros
                        //En noir recto/Verso
                        $coutMin=($min/10)*0.15;
                        $coutMini=number_format($coutMin,2);
                    //cout en arbres
                        $ArbMin=$min/15000;//15 000 feuilles donne 1 arbres
                        $coutArbMin=number_format($ArbMin,2);
            }
            elseif ($periode=="annee") 
                {
                    //On recherche son nombre maximun d'impression et a quel année 
                    //Création de 2 variables qui contiendra les résultats de la requete 
                    $periodeT = array();
                    $somme = array();

                    //Fonction pour récupérer le résultat moyen selon la periode voulu
                    $resultSomme=StatPerso($Code,$periode);

                    //Rangement des résultats dans les tableaux
                    $i=0;
                    $max=0;
                    $min=1000000;
                    while ($row = mysql_fetch_array($resultSomme, MYSQL_NUM)) 
                        {
                            $periodeT[$i] = $row[0];
                            $somme[$i] = floor($row[1]);
                            if($somme[$i]>$max)
                            {
                                $max=$somme[$i];
                                $dateMax=$periodeT[$i];
                            }

                            if($somme[$i]<$min)
                            {
                                $min=$somme[$i];
                                $dateMin=$periodeT[$i];
                            }
                            $i++;
                        }
                    //Calcul des coûts 
                        //cout en euros
                            //En noir recto/Verso
                            $cout=($max/10)*0.15;
                            $coutMax=number_format($cout,2);
                        //cout en arbres
                            $ArbMax=$max/15000;//15 000 feuilles donne 1 arbres
                            $coutArbMax=number_format($ArbMax,2);

                        //cout en euros
                            //En noir recto/Verso
                            $coutMin=($min/10)*0.15;
                            $coutMini=number_format($coutMin,2);
                        //cout en arbres
                            $ArbMin=$min/15000;//15 000 feuilles donne 1 arbres
                            $coutArbMin=number_format($ArbMin,2);
                
                }
                else
                {
                    //On recherche son nombre maximun d'impression et a quel jour 
                    //Création de 2 variables qui contiendra les résultats de la requete 
                    $periodeT = array();
                    $somme = array();

                    //Fonction pour récupérer le résultat moyen selon la periode voulu
                    $resultSomme=StatPerso($Code,$periode);

                    //Rangement des résultats dans les tableaux
                    $i=0;
                    $max=0;
                    $min=10000;
                    while ($row = mysql_fetch_array($resultSomme, MYSQL_NUM)) 
                        {
                            $periodeT[$i] = $row[0];
                            $somme[$i] = floor($row[1]);
                            if($somme[$i]>$max)
                            {
                                $max=$somme[$i];
                                $dateMax=$periodeT[$i];
                            }

                            if($somme[$i]<$min)
                            {
                                $min=$somme[$i];
                                $dateMin=$periodeT[$i];
                            }
                            $i++;
                        }
                    //Calcul des coûts 
                        //cout en euros
                            //En noir recto/Verso
                            $cout=($max/10)*0.15;
                            $coutMax=number_format($cout,2);
                        //cout en arbres
                            $ArbMax=$max/15000;//15 000 feuilles donne 1 arbres
                            $coutArbMax=number_format($ArbMax,2);

                        //cout en euros
                            //En noir recto/Verso
                            $coutMin=($min/10)*0.15;
                            $coutMini=number_format($coutMin,2);
                        //cout en arbres
                            $ArbMin=$min/15000;//15 000 feuilles donne 1 arbres
                            $coutArbMin=number_format($ArbMin,2);
                }
            
         }
            
?>

<!--Contenue du corps du tableau-->
    <tr>
    <!--Debut du formulaire-->
        <?php
        echo "<form action='stat.php".$code."' method='POST'>";
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
                      </div> 
                </div>
            </td>
                
            <td colspan="8" rowspan="3">
                <div id="content"><br />
                      <div class="h1">Statistiques</div>
                      <br />
                      <div class="content_statL">
                          <input type='radio' id='pj' name='Periode' value='jour'/><label for='pj'> Jour</label> &nbsp;
                          <input type='radio' id='pm' name='Periode' value='mois' checked/><label for='pm'> Mois</label> &nbsp;
                          <input type='radio' id='pa' name='Periode' value='annee'/><label for='pa'> Ann&eacute;e</label> &nbsp;
                          <input type="submit" id="valider" value="Valider"/><br /><br />
                
                            <?php
                                    if($max and $periode=="mois")
                                        {
                            ?>            
                            <p>
                                Maximum : <?php echo $max?> pages imprim&eacute;es, au mois de <?php echo $dateMax?> .<br />
                                <span class="marge">Co&ucirc;tent: <?php echo $coutMax?> euros.</span><br />
                                <span class="marge">Abat: <?php echo $coutArbMax?> arbres.</span><br /><br />
                                Minimum : <?php echo $min?> pages imprim&eacute;es, au mois de <?php echo $dateMin?> .<br />
                                <span class="marge">Co&ucirc;tent: <?php echo $coutMini?> euros.</span><br />
                                <span class="marge">Abat: <?php echo $coutArbMin?> arbres.</span><br /><br /><br />
                                <!--Ce mois-ci, vous en étes à <?php echo $total?> pages imprim&eacute;es.<br />-->
                            </p>
            
                            <?php
                                        }
                                        elseif ($max and $periode=="annee") 
                                            {
                            ?> 
                            <p>
                                Maximum : <?php echo $max?> pages imprim&eacute;es, dans l'ann&eacute;e <?php echo $dateMax?> .<br />
                                <span class="marge">Co&ucirc;tent: <?php echo $coutMax?> euros.</span><br />
                                <span class="marge">Abat: <?php echo $coutArbMax?> arbres.</span><br /><br />
                                Minimum : <?php echo $min?> pages imprim&eacute;es, dans l'ann&eacute;e <?php echo $dateMin?> .<br />
                                <span class="marge">Co&ucirc;tent: <?php echo $coutMini?> euros.</span><br />
                                <span class="marge">Abat: <?php echo $coutArbMin?> arbres.</span><br /><br /><br />
                                <!--Cette année, vous en étes à <?php echo $total?> pages imprim&eacute;es.<br />-->
                            </p>    
                            
                          
                            <?php
                          
                                            }elseif ($max and $periode=="jour")
                                            {
                            ?>                    
                            <p>
                                Maximum : <?php echo $max?> pages imprim&eacute;es, le <?php echo $dateMax?> .<br />
                                <span class="marge">Co&ucirc;tent: <?php echo $coutMax?> euros.</span><br />
                                <span class="marge">Abat: <?php echo $coutArbMax?> arbres.</span><br /><br />
                                Minimum : <?php echo $min?> pages imprim&eacute;es, le <?php echo $dateMin?> .<br />
                                <span class="marge">Co&ucirc;tent: <?php echo $coutMini?> euros.</span><br />
                                <span class="marge">Abat: <?php echo $coutArbMin?> arbres.</span><br /><br /><br />
                                <!--Hier, vous avez imprim&eacute;e <?php echo $total?> page(s).<br />-->
                            </p> 
                          
                          
                            <?php                    
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