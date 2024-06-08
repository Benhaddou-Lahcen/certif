<?php
include "../dao/daoUtilisateur.php";
$action = $_GET['action'];
$dao = new DaoUtilisateur();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};
switch( $action ) 
{
    case 'insert':
        $visible = $_POST['civi'];
        $pseudo = $_POST['pseudo'];
        $site = $_POST['website'];
        $tel = $_POST['telephone'];
        $email = $_POST['email'];
        $psw = $_POST['mdp'];
        $birth = $_POST['datenaissance'];
        $desc = $_POST['presentation'];
        if (isset($visible, $pseudo, $site, $tel, $email, $psw, $birth, $desc))
        {
            $user = new Utilisateur($email, $psw, $pseudo, $birth, $tel, $visible, $site, $desc);
            $dao->saveUser($user);
            echo 'element ajoute';
            header("Location: ../view/login.html");
        };
        break;
    case 'login':
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (isset($email, $password))
        {
            $user = $dao->findUser($email, $password);
            if ($user != null)
            {
                $_SESSION["utilisateur"] = $user;
                header("Location: ../view/conversation.php");
                $dao->logUserIn($user);
            
            }
            else
            {
                header("Location: ../view/login.html");
            };
        }
        else
        {
            echo "Please fill all required fields";
        };
        break;
    case 'logout':
        $dao->logUserOut($_SESSION["utilisateur"]->getEmail());
        session_destroy();
        header("Location: ../view/login.html");
        break;
    case 'users':
        $dao->loadUsers();
        break;
    default:
        echo 'something went wrong';
}