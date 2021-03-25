<?php


namespace App\Controllers\resources;


use App\mails\AuthMails;
use Application\Auth;
use Application\Mails\MailSender;
use Application\Models\DB;
use Application\Template\TemplateEngine;
use function middlewares\isAdminPage;
use function middlewares\isAuthPage;
use function middlewares\isGuestPage;
use PDO;

class UsersController
{

    public function __construct()
    {
        TemplateEngine::pageTitle("Utilisateurs");
    }

    public function index()
    {
        isAuthPage();
        $pdo = pdo_instance();
        $users = $pdo->query("SELECT * FROM users ")->fetchAll();
        TemplateEngine::Instance()->setLayout('app');
        TemplateEngine::Instance()->render('resources/users/index',compact('users'));
    }

    public function store(){
        isAuthPage();
        $pdo = pdo_instance();
        $POST = CollectionData($_POST);
        $errors = [];
        if( !filter_var($POST->get('login'),FILTER_SANITIZE_STRING,['options'=>['max_range'=>'255']]) ){
            $errors['login'] = "format du login invalide";
        }
        if( !filter_var($POST->get('name'),FILTER_SANITIZE_STRING,['options'=>['max_range'=>'255']]) ){
            $errors['name'] = "format du nom invalide";
        }
        if( !filter_var($POST->get('email'),FILTER_VALIDATE_EMAIL,['options'=>['max_range'=>'255']]) ){
            $errors['email'] = "format de l'email invalide";
        }
        if($POST->get('password') != $POST->get('password_confirmation')){
            $errors['password'] = "Confirmation de mot de passe invalide";
        }
        if($POST->get('password') != $POST->get('password_confirmation')){
            $errors['password'] = "Confirmation de mot de passe invalide";
        }
        $email_query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $email_query->execute(['email'=>$POST->get('email')]);
        if( $email_query->rowCount() ){
            $errors['email_uniq'] = "Email déjà existant en base de donnée";
        }
        $login_query = $pdo->prepare("SELECT * FROM users WHERE login = :login ");
        $login_query->execute(['login'=>$POST->get('login')]);
        if( $login_query->rowCount() ){
            $errors['login_uniq'] = "login déjà existant en base de donnée";
        }
        if( empty($errors) ){
            if ( app_config('ENABLE_MAILS') ) {
                $db = $pdo->prepare("INSERT INTO users    
                            SET  
                            login = :login , name= :name , type= :type ,  email= :email,password = :password");
            }else {
                $db = $pdo->prepare("INSERT INTO users    
                            SET  
                            confirmed_at = now(), login = :login , name= :name , type= :type ,  email= :email,password = :password");
            }
            $db->bindValue("login",$POST->get('login'),PDO::PARAM_STR);
            $db->bindValue("name",$POST->get('name'),PDO::PARAM_STR);
            $db->bindValue("type",$POST->get('type'),PDO::PARAM_STR);
            $db->bindValue("email",$POST->get('email'),PDO::PARAM_STR);
            $db->bindValue("password",hash_password($POST->get('password')),PDO::PARAM_STR);
            $db->execute();
            if ( app_config('ENABLE_MAILS') ) {
                $user_id = DB::Instance()->getPdo()->lastInsertId();
                $token = random_str(60);
                $db = $pdo->prepare("INSERT INTO password_confirmations SET user_id = :user_id, token = :token");
                $db->bindValue("user_id",$user_id,PDO::PARAM_INT);
                $db->bindValue("token",$token,PDO::PARAM_STR);
                $db->execute();
                AuthMails::Instance()->sendUserCreationMail(
                    $POST->get('email'),
                    $POST->get('name'),
                    path_for("users.confirmation",['id'=> $user_id,'token'=> $token  ])
                );
                setSuccesFlash("Compte créer .un mail a ete envoyé a l'email utilisateur pour confirmation","Inscription utilisateur");
            }else {
                setSuccesFlash("Compte créer","Inscription utilisateur");
            }
            route_redirect('users.index');
        }else{
            session_instance()->write('_data',$_POST);
            session_instance()->write('errors',$errors);
            header('location: '.path_for('users.index'));
        }
    }


    public function update($id){
         isAuthPage();
        $pdo = pdo_instance();
        $POST = CollectionData($_POST);
        $errors = [];
        if( !filter_var($POST->get('name'),FILTER_SANITIZE_STRING,['options'=>['max_range'=>'255']]) ){
            $errors['name'] = "format du nom invalide";
        }
        if ( !in_array($POST->get('type'),[ 'admin','user' ]) ){
            $errors['type'] = "Le type quee vous avew envoyer est invalide";
        }
        if ( !empty($errors) ){
            session_instance()->write('_data',$_POST);
            session_instance()->write('errors',$errors);
            header('location: '.path_for('users.index'));
        }
        $user = $pdo->prepare("UPDATE users 
                    SET name = :name, type = :type 
                    WHERE id = :id ");
        $user->bindValue('name',$POST->get('name'),PDO::PARAM_STR);
        $user->bindValue('type',$POST->get('type'),PDO::PARAM_STR);
        $user->bindValue('id',$id,PDO::PARAM_INT);
        $user->execute();
        setSuccesFlash("L'utilisateur a bien ete mise a jour","Modification d'utilisateur");
        route_redirect('users.index');
    }

    public function delete($id){
        isAuthPage();
        $pdo = pdo_instance();
        $user = $pdo->prepare("DELETE FROM users WHERE id = :id ");
        $user->bindValue('id',$id,PDO::PARAM_INT);
        $user->execute();
        setSuccesFlash("L'utilisateur a bien ete supprimer","Suppression d'utilisateur");
        route_redirect('users.index');
    }


    public function confirmation($id,$token)
    {
        isGuestPage();
        $pdo = pdo_instance();
        $db = $pdo->prepare('SELECT *, password_confirmations.id AS password_confirmation_id
                                       FROM    users,password_confirmations 
                                       WHERE   users.id = :id AND  password_confirmations.user_id = :id AND  password_confirmations.token = :token AND users.confirmed_at IS NULL   ');
        $db->bindValue('id', $id, PDO::PARAM_INT);
        $db->bindValue('token', $token, PDO::PARAM_STR);
        $db->execute();
        if ( !empty($db->fetch()) ) {
            TemplateEngine::Instance()->setLayout('guest');
            TemplateEngine::Instance()->render('auth/confirm');
        } else{
            setErrorFlash("Vous venez d'être rediriger d'un url invalide", "redirection");
            route_redirect('login.home');
        }
    }

    public function confirmationAction($id,$token)
    {
        isGuestPage();
        $pdo = pdo_instance();
        $db = $pdo->prepare('SELECT *, password_confirmations.id AS password_confirmation_id
                                       FROM    users,password_confirmations 
                                       WHERE   users.id = :id AND  password_confirmations.user_id = :id AND  password_confirmations.token = :token AND users.confirmed_at IS NULL   ');
        $db->bindValue('id', $id, PDO::PARAM_INT);
        $db->bindValue('token', $token, PDO::PARAM_STR);
        $db->execute();
        $user = $db->fetch();
        if ( empty($user) ) {
            setErrorFlash("Vous venez d'être rediriger d'un url invalide", "redirection");
            route_redirect('login.home');
        }
        $errors = [];
        $POST = CollectionData($_POST);
        if ( !check_password($POST->get('password_creation'),$user->password) ){
            $errors['password'] = "Mot de passe de creation invalide";
        }
        if ( $POST->get('password') != $POST->get('password_confirmation') ){
            $errors['password_c'] = "Confirmation de mot passe invalide";
        }
        if ( !empty($errors) ){
            session_instance()->write('_data',$_POST);
            session_instance()->write('errors',$errors);
            route_redirect('users.confirmation',['id'=>$id,'token'=>$token]);
        }
        $pdo->prepare("UPDATE users set confirmed_at = NOW(),password = ? WHERE id = {$user->user_id} ")
            ->execute([ hash_password($POST->get('password')) ]);
        setSuccesFlash("Compte confirmer avec success", "Confiration de compte");
        route_redirect('login.home');
    }


}