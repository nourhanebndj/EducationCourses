<?php 

$con=mysqli_connect("localhost","root","","education");
if(mysqli_connect_error()){
    echo"Erreur de connexion à la base de donnée";
    exit();
}

?>