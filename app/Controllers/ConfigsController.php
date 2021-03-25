<?php
/**
 * Created by PhpStorm.
 * User: ledev
 * Date: 12/03/2019
 * Time: 10:57
 */

namespace App\Controllers;

use App\mails\AuthMails;
use App\Session\Session;
use Application\Auth;
use Application\Models\DB;
use Application\Template\TemplateEngine;
use PDO;
use function middlewares\isConfigPage;

class ConfigsController
{

    public function __construct()
    {
        isConfigPage();
    }


    public function configConfirmation()
    {
        $route_params = CollectionData(router_instance()->getCurrentRoute()->params());
        $pdo = pdo_instance();
        $db = $pdo->prepare('SELECT *, password_confirmations.id AS password_confirmation_id
                                       FROM    users,password_confirmations 
                                       WHERE   users.id = :id AND  password_confirmations.user_id = :id AND  password_confirmations.token = :token AND users.confirmed_at IS NULL   ');
        $db->bindValue('id', $route_params->get('0'), PDO::PARAM_INT);
        $db->bindValue('token', $route_params->get('1'), PDO::PARAM_STR);
        $db->execute();
        if (empty($db->fetch())) {
            setErrorFlash("Vous venez d'être rediriger d'un url invalide", "redirection");
            header("location:" . path_for('login.home'));
            exit();
        }
        $db = $pdo->prepare("UPDATE users set confirmed_at = NOW() WHERE id = :id ");
        $db->bindValue('id', $route_params->get('0'), PDO::PARAM_INT);
        $db->execute();
        $db = $pdo->prepare("SELECT * FROM users WHERE id = :id ");
        $db->bindValue('id', $route_params->get('0'), PDO::PARAM_INT);
        $db->execute();
        Auth::log($db->fetch());
        session_instance()->deleteFlash();
        setSuccesFlash("Application configurer avec success", "configuration de l'application");
        route_redirect('admin.home');
    }


    public function home()
    {
        TemplateEngine::Instance()->setLayout('config');
        TemplateEngine::Instance()->render('config/index');
    }

    public function homeAction()
    {
        $pdo = pdo_instance();
        $POST = CollectionData($_POST);
        $errors = [];
        if (!filter_var($POST->get('login'), FILTER_SANITIZE_STRING, ['options' => ['max_range' => '255']])) {
            $errors['login'] = "format du login invalide";
        }
        if (!filter_var($POST->get('name'), FILTER_SANITIZE_STRING, ['options' => ['max_range' => '255']])) {
            $errors['name'] = "format du nom invalide";
        }
        if (!filter_var($POST->get('email'), FILTER_VALIDATE_EMAIL, ['options' => ['max_range' => '255']])) {
            $errors['email'] = "format de l'email invalide";
        }
        if ($POST->get('password') != $POST->get('password_confirmation')) {
            $errors['password'] = "Confirmation de mot de passe invalide";
        }
        if ($POST->get('password') != $POST->get('password_confirmation')) {
            $errors['password'] = "Confirmation de mot de passe invalide";
        }
        $email_query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $email_query->execute(['email' => $POST->get('email')]);
        if ($email_query->rowCount()) {
            $errors['email_uniq'] = "Email déjà existant en base de donnée";
        }
        $login_query = $pdo->prepare("SELECT * FROM users WHERE login = :login ");
        $login_query->execute(['login' => $POST->get('login')]);
        if ($login_query->rowCount()) {
            $errors['login_uniq'] = "login déjà existant en base de donnée";
        }
        if (empty($errors)) {
            if (app_config('ENABLE_MAILS')) {
                $db = $pdo->prepare("INSERT INTO users  
                        SET  login = :login , 
                            name= :name , 
                            type='admin',  
                            email= :email,
                            password = :password");
            }else {
                $db = $pdo->prepare("INSERT INTO users  
                        SET  login = :login , 
                            name= :name , 
                            type='admin',  
                            email= :email,
                            password = :password,
                            confirmed_at = now()
                            ");
            }
            $db->bindValue("login", $POST->get('login'), PDO::PARAM_STR);
            $db->bindValue("name", $POST->get('name'), PDO::PARAM_STR);
            $db->bindValue("email", $POST->get('email'), PDO::PARAM_STR);
            $db->bindValue("password", hash_password(request_post('password')), PDO::PARAM_STR);
            $db->execute();

            if (app_config('ENABLE_MAILS')) {
                $user_id = DB::Instance()->getPdo()->lastInsertId();
                $token = random_str(60);
                $db = $pdo->prepare("INSERT INTO password_confirmations SET user_id = :user_id, token = :token");
                $db->bindValue("user_id", $user_id, PDO::PARAM_INT);
                $db->bindValue("token", $token, PDO::PARAM_STR);
                $db->execute();
                AuthMails::Instance()->sendApplicationConfigMail(
                    $POST->get('email'),
                    $POST->get('name'),
                    path_for("config.confirmation", ['id' => $user_id, 'token' => $token])
                );
                setSuccesFlash("Application configurée. Consulter votre boite mail pour terminer la configuration", "configuration de l'application");

            }else {
                setSuccesFlash("Bienvennue dans votre espace. La configuration de l'application est terminé", "configuration de l'application");
            }
            route_redirect('login.home');
        } else {
            session_instance()->write('_data', $_POST);
            session_instance()->write('errors', $errors);
            route_redirect('config.home');
        }
    }


}