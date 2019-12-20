<?php
//$sql="insert into moniteur values (null,'moniteur 1'),(null,'moniteur 2'), (null,'moniteur 3')"

//composer require fzaninotto/faker
require "../_include/inc_config.php";
require_once '../vendor/autoload.php';
// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create("fr_FR");

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
        <h1>Génération du jeu de données</h1>        
        <?php       
        //création des clients
        $nbclient = 100;
        $nbinstallateur=10;
        $nbappareil=50;
        $nbcontrat=200;

        echo "<h1>Création des clients</h1>";
        $sql = "insert into client values ";
        $data=[];        
        for ($i = 1; $i <= $nbclient; $i++) {
            $nom=$faker->name;
            $adress=$faker->address;
            $data[]="(null,'$nom','$adress')";
        }
        $link->query($sql . implode(",",$data));

        //création des installateur
        echo "<h1>Création des installateur</h1>";
        $sql = "insert into installateur values ";
        $data=[];        
        for ($i = 1; $i <= $nbinstallateur; $i++) {
            $nom=$faker->name;
            $data[]="(null,'$nom')";
        }
        $link->query($sql . implode(",",$data));

        //création des appareil
        echo "<h1>Création des appareil</h1>";
        $sql = "insert into appareil values ";
        $data=[];        
        for ($i = 1; $i <= $nbappareil; $i++) {
            $marque=$faker->company;
            $data[]="(null,'$marque')";
        }
        $link->query($sql . implode(",",$data));

        //création des contrats
        echo "<h1>Création des contrat</h1>";
        $sql = "insert into contrat values ";
        $data=[];        
        for ($i = 1; $i <= $nbcontrat; $i++) {
            $debut=mktime(0,0,0,rand(1,12),rand(1,30),2019);
            $fin=$debut + rand(15,60)*24*60*60;
            $debut=date("Y-m-d",$debut);
            $fin=date("Y-m-d",$fin);
            $client=rand(1,$nbclient);
            $app=rand(1,$nbappareil);
            $data[]="(null,'$debut','$fin',$client,$app)";
        }
        $link->query($sql . implode(",",$data));
        
        //les interventions
        $contrats= $link->query("select * from contrat")->fetchAll();
        $data=[];
        $sql = "insert into intervention values ";
        foreach($contrats as $contrat) {
            $statut="OK";
            $idcontrat=$contrat["con_id"];
            $inst=rand(1,$nbinstallateur);
            $itype="livraison";
            $idate=$contrat["con_date_debut"];
            $data[]="(null,'$statut','$idcontrat',$inst,'$itype','$idate')";
            $inst=rand(1,$nbinstallateur);
            $itype="retrait";
            $idate=$contrat["con_date_fin"];
            $data[]="(null,'$statut','$idcontrat',$inst,'$itype','$idate')";
        }
        $link->query($sql . implode(",",$data));
               
        ?>
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>

</html>