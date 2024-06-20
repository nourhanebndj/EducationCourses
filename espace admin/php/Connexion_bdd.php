<?php 
define('BASE_URL', 'http://educationdz.free.nf)/');

$con=mysqli_connect("localhost","root","","admin");
if(mysqli_connect_error()){
    echo"Erreur de connexion à la base de donnée";
    exit();
}

?>