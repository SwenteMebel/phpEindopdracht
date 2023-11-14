<?php
include_once "../controller/functions.php";
include_once "../controller/signup.cont.php";

if (isset($_SESSION['user'])) destroySession();

if(isset($_POST['naam']) && isset($_POST['email']) && isset($_POST['wachtwoord'])){
    $naam = sanitiseString($_POST['naam']);
    $email =  sanitiseString($_POST['email']);
    $wachtwoord = sanitiseString($_POST['wachtwoord']);
    $wachtwoord_repeat = sanitiseString($_POST['wachtwoordrep']);

    validateEmail($email);

    $hashpw = password_hash($wachtwoord, PASSWORD_DEFAULT);

    if($wachtwoord === $wachtwoord_repeat){

        $stmt = $pdo->prepare('INSERT INTO gebruiker VALUES(NULL, ?,?,?)');
        $stmt->bindParam(1, $naam, PDO::PARAM_STR, 20);
        $stmt->bindParam(2, $email, PDO::PARAM_STR, 50);
        $stmt->bindParam(3, $hashpw, PDO::PARAM_STR, 255);
            
        $stmt->execute([$naam, $email, $hashpw]);
        header('Location: ../view/leden.php');
    } else {
        session_start();
        $_SESSION['message'][] = "Wachtwoorden komen niet overeen, probeer het opnieuw.";
        header('Location: ../view/signup.php');
        exit();
    }
    
    
}