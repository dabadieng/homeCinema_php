<?php
const DB_SERVER = "localhost";
const DB_NAME = "basehomecinema";
const DB_USER = "root";
const DB_PWD="";
//création d'un object connexion 
$link = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER,DB_PWD);
//définit le charset pour les échanges de données avec le serveur de BDD
$link->exec("SET CHARACTER SET UTF8");
//Définit le mode de la méthode fetch par défaut
$link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//déclenche une exception en cas d'erreur : stop l'éxécution
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

// utilisation de la librairie
require_once '../vendor/autoload.php';
// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create("fr_FR");

//réinit BDD
$sql=file_get_contents("creation_base_sondage.sql");        
//echo "<pre>$sql</pre>";
$link->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
$link->exec($sql);  

//generation des données
$nbclient=100; //nombre de clients
$nbappareil = 50; //nombre d'appareils
$nbinstallateur = 10; //nombre d'installateurs
$nbcontrat=50; // nombre de contrats 

echo "<h3>création des clients</h3>";
$data=[];
$sql = "insert into client values ";
for($i=1;$i<=$nbclient; $i++) {
    $nom = "client n"
    $texte="sondage n°$i";
    $debut="2019-11-19";
    $fin="2019-12-19";
    $data[]="(null,'$texte','$debut','$fin')";
}
$link->query($sql . implode(",",$data));      


echo "<h3>création des question</h3>";
$data=[];
$sql = "insert into question values ";
for($i=1;$i<=$nbs; $i++) {
    for($j=1;$j<=$nbq; $j++) {
        $texte="question n°$j au sondage n°$i";    
        $data[]="(null,'$texte',$i)";
    }    
}
$link->query($sql . implode(",",$data));      

echo "<h3>création des réponses possibles</h3>";
$data=[];
//sélection des questions
$questions=$link->query("select * from question")->fetchAll();

$sql = "insert into reponse_possible values ";
foreach($questions as $question) {
    extract($question);
    for($j=1;$j<=$nbrp; $j++) {
        $texte="réponse n°$j à la question n°$que_id (sondage n°$que_sondage)";
        $data[]="(null,'$texte',$que_id)";
    }    
}
$link->query($sql . implode(",",$data)); 

echo "<h3>création des visiteurs</h3>";
$data=[];
$sql = "insert into visiteur values ";
for($i=1;$i<=$nbvisiteur; $i++) {    
    $ip=rand(0,255) . "." . rand(0,255) . "." . rand(0,255)  . "." . rand(0,255);
    $data[]="(null,'$ip')";    
}
$link->query($sql . implode(",",$data));  

//genération des réponses aux sondages
/* 
pour chaque visiteur
	pour chaque question
		choix d'une reponse
*/
$data=[];
$sql = "insert into choix values ";
for($i=1;$i<=$nbvisiteur; $i++) {  
    foreach($questions as $question) {
        extract($question);
        $reponses=$link->query("select rep_id from reponse_possible where rep_question=$que_id")->fetchAll();
        shuffle($reponses);
        $rep_id=$reponses[0]["rep_id"];
        $data[]="(null,$i,$rep_id,$que_id)";
    }
}
$link->query($sql . implode(",",$data));  

//résultat d'un sondage
$sql="select que_texte, cho_question,rep_texte, cho_reponse,count(cho_visiteur) 
from choix, question, reponse_possible 
where cho_question=que_id and cho_reponse=rep_id and que_sondage=1
group by cho_question,cho_reponse";