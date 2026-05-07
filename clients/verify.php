<?php
session_start();

if(!empty($_POST['answer'])){

    $n = intval($_POST['answer']);

    if($_SESSION['v'] == $n){

        // code redirected

        header('Location: ./login.php');
//        echo "Human!";
    } else{
        header("Location: index.php");
    }


} else{
    header("Location: index.php");
}

?>
