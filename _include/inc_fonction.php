<?php 
//affiche le menu HTML
function affiche_menu($menu) {
	foreach($menu as $cle=>$tab) {
		echo "<a href='$tab[0]'><li>$tab[1]</li></a>";
	}
}

//Fonction de callback pour array_map : htmlentities échappe les caractères spéciaux du HTML
function cb_htmlentities($x) {
	return htmlentities($x,ENT_QUOTES,"utf-8");
}

//Fonction de callback pour array_map : échappe les caractères spéciaux du SQL
function cb_mres($x) {
	global $link;
	return mysqli_real_escape_string($link,$x);
}

/**
 * fonction de génération d'une  balise <select></select>
 * $link : connection à la bdd
 * $sql : requete pour récupérer le données de la forme "select id,label from table"
 * $selection : valeur de $cle qui présélectionne un label
 */
function HTMLselect($link,string $sql,$selection) {
	$result = $link->query($sql);
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$row=array_map("cb_htmlentities",$row);
		extract($row);
		$sel = ($id==$selection) ? " selected " : "";
		echo "<option value='$id' $sel>$label</option>";
	}
}

/**
 * fonction qui exécute une requete sql
 * $link : connection à la bdd
 * $sql : de type select/insert/update/delete
 */
function requeteSQL($link,$sql) {
	$result = mysqli_query($link, $sql);
	if (!$result) {
		if (MODE_PROD) {
			echo "Désolé une erreur s'est produite";
		} else {
        	echo "<p>$sql</p>";
			echo mysqli_error($link);
		}
        exit;
	}	
	return $result;
}
?>



