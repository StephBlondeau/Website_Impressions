<!--Debut de page html-->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
//on regarde s'il y a qu'elle que chose dans l'url

//variable de base
$code="";

    if(isset ($_GET['code'])) //s'il y a un code
    {
        //*********on regarde si le code existe dans la base
        $code="?code=".$_GET['code']; //variable à inséré dans l'url
    }

?>
    
<title>Gestion Impressions</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body style=" leftmargin: 0px; topmargin: 0px; marginwidth: 0px; marginheight: 0px;">
<!-- Save for Web Slices (endless_blue.psd) -->
<div id="main">
  <table style=" width: 800px; height: 601px;" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
    <tr>
      <td colspan="22">
        <img src="images/index_01.jpg" width="800" height="19" alt="" />
      </td>
    </tr>
    <tr>
      <td rowspan="8">
        <img src="images/index_02.jpg" width="68" height="581" alt="" />
      </td>
      <td colspan="7">
          <div id="logo"> <a href="index.php">Impressions</a> 
          </div>
      </td>
      <td colspan="14" rowspan="2">
	<img src="images/index_04.jpg" width="591" height="82" alt="" />
      </td>
    </tr>
    <tr>
      <td colspan="7">
        <img src="images/index_05.jpg" width="141" height="29" alt="" />
      </td>
    </tr>
<!--Menu de la page html-->
    <tr>
      <td colspan="3">
        <img src="images/index_06.jpg" width="54" height="36" alt="" />
      </td>
      <td colspan="6">
          <div class="top_menu">
            <ul>
                <li>
                    <?php
                    echo "<a href='index.php".$code." '>Presentation</a>"; 
                    ?>
                </li>
            </ul>
           </div>
      </td>
      <td>
	 <img src="images/index_08.jpg" width="11" height="36" alt="" />
      </td>
      <td colspan="3">
          <div class="top_menu">
            <ul>
                <li>
                    <?php
                    echo "<a href='moyenne.php".$code." '>Global</a>"; 
                    ?>
                </li>
            </ul>
          </div>
      </td>
      <td>
	 <img src="images/index_10.jpg" width="13" height="36" alt="" />
      </td>
      <td>
	  <div class="top_menu">
            <ul>
                <li>
                    <?php
                    echo "<a href='perso.php".$code." '>Personnelle</a>"; 
                    ?>
                </li>
            </ul>
          </div>
      </td>
      <td>
	 <img src="images/index_12.jpg" width="11" height="36" alt="" />
      </td>
      <td>
	 <div class="top_menu">
            <ul>
                <li>
                    <?php
                    echo "<a href='stat.php".$code." '>Statistiques</a>"; 
                    ?>
                </li>
            </ul>
         </div>
      </td>
      <td>
	 <img src="images/index_14.jpg" width="11" height="36" alt="" />
      </td>
      <td>
	 <div class="top_menu">
            <ul>
                <li>
                    <?php
                    echo "<a href='rechercher.php".$code." '>Rechercher</a>"; 
                    ?>
                </li>
            </ul>
         </div>
      </td>
      <td colspan="2">
	 <img src="images/index_16.jpg" width="137" height="36" alt="" />
      </td>
    </tr>

