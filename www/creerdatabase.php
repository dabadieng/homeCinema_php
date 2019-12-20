<?php
require "../_include/inc_config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <?php require "../_include/inc_head.php" ?>
</head>

<body>
    <header>
        <?php require "../_include/inc_entete.php" ?>
    </header>
    <nav>
        <?php require "../_include/inc_menu.php"; ?>
    </nav>
    <div id="contenu">
        <h1>Création de la BDD</h1>
		<pre>
        <?php
        $sql=file_get_contents("../creation_base_home_cinema.sql");        
		echo $sql;        
        $link->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
        $link->exec($sql);        
        ?>
		</pre>
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>

</html>