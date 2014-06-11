<?php

//include
    include('./include/dbconnect.inc.php');
    
//Connexion à la base de donné

    $resDbImp = mysql_connect(
            $_SESSION["SERVEUR_SQL"], 
            $_SESSION["COMPTE_BASE"], 
            $_SESSION["PSWD_BASE"]) 
            or die(mysql_error());
            mysql_select_db($_SESSION["NOM_BASE"], $resDbImp) or die(mysql_error()); 
            
//Fonction recherche un code user aléatoirement
function codeAléa ($Code)
{
    
    $alea=rand(0, 5);
    //echo $alea;
    //
    //On recherche tout les code user
    $requete="SELECT code FROM t_user WHERE code !='".$Code."' AND code !=''";
    //echo $requete;
    
    //Exécution de la requete
    $resultat = mysql_query($requete);
    
    //Création d'un tableau qui va contenir les codes
    $codesT=array();
    
    //Rangement des résultats dans les tableaux
    $i=0;
    while ($row = mysql_fetch_array($resultat))
        {
            $codesT[$i] = $row[0];
            $i++;
        }
    
    return $codesT[$alea];
    
}

//Fonctions qui retourne les résultats d'une requete sql dans des tableaux
//cette fonction retourne les résultats d'une requete par utilisateur et selon la periode demander
function statPerso($strCode,$periode)
{
    
    if($periode=="mois")//Fais une requete classer par mois
    {
        //Requete qui calcul la somme d'impressions effectuer par mois par un utilisateur
        $strReqSomme = "SELECT concat( DATE_FORMAT( date, '%m' ) , \"-\", DATE_FORMAT( date, '%y' ) ) as periode , sum( pages ) as somme, tu.nom\n"
        . "FROM `t_log` AS tl, `t_user` AS tu\n"
        . "\n"
        . "WHERE\n"
        . "tl.iduser = tu.id AND\n"
        . "tu.code = \"" . $strCode . "\" AND\n"
        . "tl.date > DATE_SUB(NOW(), INTERVAL 365 DAY) AND\n" // On prend seulement les dates sur 1 ans ( de maintenant à il y a 2 ans)
        . "1\n"
        . "\n"
        . "GROUP BY month( date ), year( date ) \n"
        . "ORDER BY year( date ), month( date )\n"   
        . "LIMIT 0 , 30";
        
        //Exécution de la requete
        $resultSomme = mysql_query($strReqSomme);
        if (!$resultSomme) 
            {
                die('Requête invalide : ' . mysql_error());
            }

        return $resultSomme;
        
    }
    elseif ($periode=="jour")//Calcul par jours les impressions
        {
            //Requete qui calcul la somme d'impressions effectuer par jours par un utilisateur
            $strReqSomme = "SELECT concat( day( date ) , \"-\", DATE_FORMAT( date, '%m' ) ) as periode , sum( pages ) as somme, tu.nom\n"
            . "FROM `t_log` AS tl, `t_user` AS tu\n"
            . "\n"
            . "WHERE\n"
            . "tl.iduser = tu.id AND\n"
            . "tu.code = \"" . $strCode . "\" AND\n"
            . "tl.date > DATE_SUB(NOW(), INTERVAL 45 DAY) AND\n" // On prend seulement sur un interval de 15 jours 
            . "1\n"
            . "\n"
            . "GROUP BY day( date ), month( date )\n"
            . "ORDER BY month( date ), day( date )\n"       
            . "LIMIT 0 , 30";

            //Exécution de la requete
            $resultSomme = mysql_query($strReqSomme);
            if (!$resultSomme) 
                {
                    die('Requête invalide : ' . mysql_error());
                }

            return $resultSomme;
        }
        else//calcule les impressions par ans
            {
                //Requete qui calcul la somme d'impressions effectuer par ans par un utilisateur
                $strReqSomme = "SELECT concat( 20, DATE_FORMAT( date, '%y' )) as periode , sum( pages ) as somme, tu.nom\n"
                . "FROM `t_log` AS tl, `t_user` AS tu\n"
                . "\n"
                . "WHERE\n"
                . "tl.iduser = tu.id AND\n"
                . "tu.code = \"" . $strCode . "\" AND\n"
                . "1\n"
                . "\n"
                . "GROUP BY year( date )\n"
                . "LIMIT 0 , 30";

                //Exécution de la requete
                $resultSomme = mysql_query($strReqSomme);
                if (!$resultSomme) 
                    {
                        die('Requête invalide : ' . mysql_error());
                    }

                return $resultSomme;

            } 
}
function StatMoyen($periode)
{
    
    if($periode=="mois")// moyenne par mois des impressions 
    {
        
        //Requete permettant de récupérer la nb de pages imprimées par mois
        $strReqMoyenne = "SELECT\n"
        . " concat( DATE_FORMAT( date, '%m' ) , \"-\", DATE_FORMAT( date, '%y' ) ) as periode ,\n"
        . " sum( pages ) as somme\n"
        . "FROM\n"
        . " `t_log` AS tl, `t_user` AS tu\n"
        . "WHERE \n"
        . " tl.iduser=tu.id AND\n"
        . "tl.date > DATE_SUB(NOW(), INTERVAL 365 DAY) AND\n" //seulement sur 1 ans
        . "  `date` > '1'\n"
        . "GROUP by month( date ) , year( date )\n"
        . "ORDER by year( date ) , month( date )";
        
        
        //Exécution de la requete
        $resultMoyenne = mysql_query($strReqMoyenne);
        
        if (!$resultMoyenne) 
            {
            die('Requête invalide : ' . mysql_error());
            }
            
        return $resultMoyenne;
          
    }
    elseif($periode=='jour')//moyenne des impressions par jour
        {
            //Requete permettant de récupérer la nb de pages imprimées par mois
                $strReqMoyenne = "SELECT concat( day(date) , \"-\", DATE_FORMAT( date, '%m' ) ) as periode , sum( pages ) as somme\n"
                . "FROM\n"
                . " `t_log` AS tl, `t_user` AS tu\n"
                . "WHERE \n"
                . " tl.iduser=tu.id AND\n"
                . "tl.date > DATE_SUB(NOW(), INTERVAL 45 DAY) AND\n" //seulement les 30 dernier jours
                . "  `date` > '1'\n"
                . "GROUP by day( date ),  month( date )\n"
                . "ORDER BY month(date), day( date )";

                //Exécution de la requete
            $resultMoyenne = mysql_query($strReqMoyenne);
            if (!$resultMoyenne) 
                {
                    die('Requête invalide : ' . mysql_error());
                }

            return $resultMoyenne;
        }
        else//sinon par ans
            {
                //Requete permettant de récupérer la nb de pages imprimées par mois
                $strReqMoyenne = "SELECT\n"
                . " concat( 20, DATE_FORMAT( date, '%y' )) as periode ,\n"
                . " sum( pages ) as somme\n"
                . "FROM\n"
                . " `t_log` AS tl, `t_user` AS tu\n"
                . "WHERE \n"
                . " tl.iduser=tu.id AND\n"
                . "  `date` > '1'\n"
                . "GROUP by year( date )";

                //Exécution de la requete
                $resultMoyenne = mysql_query($strReqMoyenne);
                if (!$resultMoyenne) 
                    {
                    die('Requête invalide : ' . mysql_error());
                    }

                return $resultMoyenne;

            }
    
}

//Création de graphique avec une courbe et deux tableaux (abscisse et ordonnée)
function graphiqueCourbe ($abscisse, $ordonne, $nomA, $nomO, $nomGraph )
        
    {
        //Construction du graphique
        $myData = new pData();
        /* Save the data in the pData array */
        //Creation des courbes
        $myData->addPoints($abscisse, "periode");
        $myData->addPoints($ordonne, "moyenne");

        $myData->setSerieDescription("periode", $nomA);
        $myData->setSerieOnAxis("periode", 0);

        $myData->setSerieDescription("moyenne", $nomO);//Legende de la 2eme courbe
        $myData->setSerieOnAxis("moyenne", 0);

        //On indique que représente l'axe des absices
        $myData->setAbscissa("periode");

        //On met la position des axe à gauche
        $myData->setAxisPosition(0, AXIS_POSITION_LEFT);
        $myData->setAxisName(0, "nombre");
        $myData->setAxisUnit(0, "");

        $myPicture = new pImage(924, 400, $myData);
        $myPicture->drawRectangle(0, 0, 923, 399, array("R" => 0, "G" => 0, "B" => 0));

        $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 50, "G" => 50, "B" => 50, "Alpha" => 20));

        $myPicture->setFontProperties(array("FontName" => "../pChart/fonts/Forgotte.ttf", "FontSize" => 14));
        $TextSettings = array("Align" => TEXT_ALIGN_TOPMIDDLE
            , "R" => 0, "G" => 0, "B" => 0, "DrawBox" => 1, "BoxAlpha" => 30);
        $myPicture->drawText(462, 25, "Nombre de pages imprimées", $TextSettings); //TITRE DU GRAPH

        $myPicture->setShadow(FALSE);
        $myPicture->setGraphArea(50, 50, 899, 360);
        $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pChart/fonts/pf_arma_five.ttf", "FontSize" => 8));

        $Settings = array("Pos" => SCALE_POS_LEFTRIGHT
            , "Mode" => SCALE_MODE_FLOATING
            , "LabelingMethod" => LABELING_ALL
            , "GridR" => 255, "GridG" => 255, "GridB" => 255, "GridAlpha" => 50, "TickR" => 0, "TickG" => 0, "TickB" => 0, "TickAlpha" => 50, "LabelRotation" => 0, "CycleBackground" => 1, "DrawXLines" => 1, "DrawSubTicks" => 1, "SubTickR" => 255, "SubTickG" => 0, "SubTickB" => 0, "SubTickAlpha" => 50, "DrawYLines" => ALL);
        $myPicture->drawScale($Settings);

        $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 50, "G" => 50, "B" => 50, "Alpha" => 10));

        $Config = array("DisplayValues" => 1);
        $myPicture->drawSplineChart($Config);

        $Config = array("FontR" => 0, "FontG" => 0, "FontB" => 0, "FontName" => "../pChart/fonts/pf_arma_five.ttf", "FontSize" => 8, "Margin" => 6, "Alpha" => 30, "BoxSize" => 5, "Style" => LEGEND_NOBORDER
            , "Mode" => LEGEND_HORIZONTAL
        );
        $myPicture->drawLegend(752, 16, $Config);

        $myPicture->Render("/var/www/html/ImpTest/images/".$nomGraph.".png");


    }

    //Création d'un graphique avec 2 courbes et donc 3 tableaux
function graphiqueCourbes ($abscisse, $courbe1, $courbe2, $nomA, $nomO1, $nomO2, $nomGraph )
        
    {
        //Construction du graphique
        $myData = new pData();
        /* Save the data in the pData array */
        //Creation des courbes
        $myData->addPoints($abscisse, $nomA);
        $myData->addPoints($courbe1, $nomO1);

        $myData->setSerieDescription($nomA, $nomA);
        $myData->setSerieOnAxis($nomA, 0);

        $myData->setSerieDescription($nomO1, $nomO1);//Legende de la 2eme courbe
        $myData->setSerieOnAxis($nomO1, 0);
                
        $myData->addPoints($courbe2, $nomO2);
        $myData->setSerieDescription($nomO2, $nomO2); //Legende de la 1ere courbe
        $myData->setSerieOnAxis($nomO2, 0);// on indique a combien on commance l'axe des ordonnés

        //On indique que représente l'axe des absices
        $myData->setAbscissa($nomA);

        //On met la position des axe à gauche
        $myData->setAxisPosition(0, AXIS_POSITION_LEFT);
        $myData->setAxisName(0, "nombre");
        $myData->setAxisUnit(0, "");

        $myPicture = new pImage(1024, 400, $myData);
        $myPicture->drawRectangle(0, 0, 1023, 399, array("R" => 0, "G" => 0, "B" => 0));

        $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 50, "G" => 50, "B" => 50, "Alpha" => 20));

        $myPicture->setFontProperties(array("FontName" => "../pChart/fonts/Forgotte.ttf", "FontSize" => 14));
        $TextSettings = array("Align" => TEXT_ALIGN_TOPMIDDLE
            , "R" => 0, "G" => 0, "B" => 0, "DrawBox" => 1, "BoxAlpha" => 30);
        $myPicture->drawText(512, 25, "Nombre de pages imprimées", $TextSettings); //TITRE DU GRAPH

        $myPicture->setShadow(FALSE);
        $myPicture->setGraphArea(50, 50, 999, 360);
        $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pChart/fonts/pf_arma_five.ttf", "FontSize" => 8));

        $Settings = array("Pos" => SCALE_POS_LEFTRIGHT
            , "Mode" => SCALE_MODE_FLOATING
            , "LabelingMethod" => LABELING_ALL
            , "GridR" => 255, "GridG" => 255, "GridB" => 255, "GridAlpha" => 50, "TickR" => 0, "TickG" => 0, "TickB" => 0, "TickAlpha" => 50, "LabelRotation" => 0, "CycleBackground" => 1, "DrawXLines" => 1, "DrawSubTicks" => 1, "SubTickR" => 255, "SubTickG" => 0, "SubTickB" => 0, "SubTickAlpha" => 50, "DrawYLines" => ALL);
        $myPicture->drawScale($Settings);

        $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 50, "G" => 50, "B" => 50, "Alpha" => 10));

        $Config = array("DisplayValues" => 1);
        $myPicture->drawSplineChart($Config);

        $Config = array("FontR" => 0, "FontG" => 0, "FontB" => 0, "FontName" => "../pChart/fonts/pf_arma_five.ttf", "FontSize" => 8, "Margin" => 6, "Alpha" => 30, "BoxSize" => 5, "Style" => LEGEND_NOBORDER
            , "Mode" => LEGEND_HORIZONTAL
        );
        $myPicture->drawLegend(842, 16, $Config);

        $myPicture->Render("/var/www/html/ImpTest/images/".$nomGraph.".png");


    }
    
// ---------------------------------------------------------------------
//  Générer un mot de passe aléatoire
// ---------------------------------------------------------------------
function genererMDP ($longueur = 8)
{
    // initialiser la variable $mdp
    $mdp = "";
 
    // Définir tout les caractères possibles dans le mot de passe,
    // Il est possible de rajouter des voyelles ou bien des caractères spéciaux
    $possible = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
 
    // obtenir le nombre de caractères dans la chaîne précédente
    // cette valeur sera utilisé plus tard
    $longueurMax = strlen($possible);
 
    if ($longueur > $longueurMax) 
        {
        $longueur = $longueurMax;
        }
 
    // initialiser le compteur
    $i = 0;
    // ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
    while ($i < $longueur) {
        // prendre un caractère aléatoire
        $caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);
 
        // vérifier si le caractère est déjà utilisé dans $mdp
        if (!strstr($mdp, $caractere)) {
            // Si non, ajouter le caractère à $mdp et augmenter le compteur
            $mdp .= $caractere;
            $i++;
        }
    }
    // retourner le résultat final
    return $mdp;
}

function modifBDD()
{
    //Rechercher les nom d'user qui on pas de code
    $requete="select nom from t_user where code=''";
    
    //On execute la requete
    $resultat=  mysql_query($requete);
    
    //Création d'un tableau qui va contenir les codes
    $userVide=array();
    
    //Rangement des résultats dans les tableaux
    $i=0;
    while ($row = mysql_fetch_array($resultat))
        {
            //recuperation d'un code
            $newCode=genererMDP();
            $userVide[$i] = $row[0];
            //Requete d'ajout d'un code à chaque agent qui n'on pas de code 
            mysql_query("UPDATE t_user SET code='".$newCode."' WHERE nom = '".$userVide[$i]."'");
            $i++;
        }   
}

function nbImpressions($Code,$periode)
{
    //Impressions selon la période
    if($periode=="mois")
    {
        //Requete
        $requete= 
        "SELECT sum( pages ) as total \n"
        . "FROM `t_log` AS tl, `t_user` AS tu\n"
        . "WHERE\n"
        . "tl.iduser = tu.id AND\n"
        . "tu.code = \"" . $Code . "\" AND\n"
        . "tl.date = month (NOW()) AND\n" // On prend seulement sur ce mois-ci
        . "1\n";
        
        //On execute la requete
        $resultat=  mysql_query($requete);
        
        //On extrait le résultat
        $total=mysql_fetch_array($resultat);
        
        //On retourne le résultat
        return $total;
        
    }elseif ($periode=="jour") 
        {
            //Requete
            $requete= 
            "SELECT sum( pages ) as total \n"
            . "FROM `t_log` AS tl, `t_user` AS tu\n"
            . "WHERE\n"
            . "tl.iduser = tu.id AND\n"
            . "tu.code = \"" . $Code . "\" AND\n"
            . "tl.date = NOW() AND\n" // On prend seulement sur ce mois-ci
            . "1\n";

            //On execute la requete
            $resultat=  mysql_query($requete);

            //On extrait le résultat
            $total=mysql_fetch_array($resultat);

            //On retourne le résultat
            return $total;
            
        }else
            {
            //Requete
            $requete= 
            "SELECT sum( pages ) as total \n"
            . "FROM `t_log` AS tl, `t_user` AS tu\n"
            . "WHERE\n"
            . "tl.iduser = tu.id AND\n"
            . "tu.code = \"" . $Code . "\" AND\n"
            . "tl.date = year(NOW()) AND\n" // On prend seulement sur ce mois-ci
            . "1\n";

            //On execute la requete
            $resultat=  mysql_query($requete);

            //On extrait le résultat
            $total=mysql_fetch_array($resultat);

            //On retourne le résultat
            return $total;
            
            }
    
}

function rechercheDoc($recherche)
{
    //On adapte la variable recherche pour la requete sql
    //On remplace les espace pas de %
    $rechercheSql=str_replace(' ','%',$recherche);
    //Requete sql 
    $requete="select date, nom, pages from t_log where nom like '%".$rechercheSql."%';";

    //On excute la requete
    $resultatSql=  mysql_query($requete);
    
    //On retourne le résultat
    return $resultatSql;
}
?>