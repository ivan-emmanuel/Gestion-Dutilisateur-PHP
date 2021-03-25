<?php
namespace App\Controllers\auth;

use App\mails\AuthMails;
use Application\Mails\MailSender;
use function middlewares\isGuestPage;
use Application\Template\TemplateEngine;


class PasswordResetsController
{

	public function GetAction()
	{
		isGuestPage();
		TemplateEngine::Instance()->setLayout('guest');
        TemplateEngine::Instance()->render('auth/reset');
	}


	public function PostAction()
	{
		isGuestPage();
		$pdo = pdo_instance();
        $POST = CollectionData($_POST);
        $errors = [];
        if( !filter_var($POST->get('email'),FILTER_VALIDATE_EMAIL,['options'=>['max_range'=>'255']]) ){
            $errors['email'] = "format de l'email invalide";
        }
        $email_query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $email_query->execute(['email'=>$POST->get('email')]);
        if( empty( $email_query->rowCount()  ) ){
            $errors['email_uniq'] = "Aucun compte ne possede cette adresse email";
        }
        if( empty($errors) ){
        	$user = $email_query->fetch() ;
            $token = random_str(60);
            $pdo->query("DELETE FROM password_resets WHERE user_id = '{$user->id}' ");
            $pdo->query("INSERT INTO password_resets SET user_id = '{$user->id}', token = '$token' ");
            AuthMails::Instance()->sendPasswordResetMail(
                $POST->get('email'),
                $user->name,
                path_for("user.reset.confirmation",['id'=> $user->id,'token'=> $token  ])
            );
            setSuccesFlash("Les instructions de reinitialisation de compte vous on ete envoyer par mail","Reinitialisation de ot de passe");
            route_redirect('users.index');
        }else{
            session_instance()->write('_data',$_POST);
            session_instance()->write('errors',$errors);
            header('location: '.path_for('users.index'));
        }
	}

	public function confirm($id,$token)
	{
		 isGuestPage();
		 $pdo = pdo_instance();
         $db = $pdo->prepare("SELECT * FROM password_resets,users 
                                       WHERE 
                                            password_resets.user_id = :id AND 
                                            password_resets.token = :token AND 
                                            users.id = :id ");
         $db->bindValue('id',$id,\PDO::PARAM_INT);
         $db->bindValue('token',$token);
         $db->execute();
         $user = $db->fetch();
		 if( !empty($user->id) ){
             TemplateEngine::Instance()->setLayout('guest');
             TemplateEngine::Instance()->render('auth/reset_action');
		 }else{
		 	setErrorFlash("Vous venez d'etre rediriger d'une url invalide","redirection");
            route_redirect('users.index');
		 }
	}

	public function confirmAction($id,$token){
        isGuestPage();
        $pdo = pdo_instance();
        $db = $pdo->prepare("SELECT * FROM password_resets,users 
                                       WHERE 
                                            password_resets.user_id = :id AND 
                                            password_resets.token = :token AND 
                                            users.id = :id ");
        $db->bindValue('id',$id,\PDO::PARAM_INT);
        $db->bindValue('token',$token);
        $db->execute();
        $user = $db->fetch();
        if( !empty($user->id) ){
            $errors = [];
            $POST = CollectionData($_POST);
            if ( $POST->get('password') != $POST->get('password_confirmation') ){
                $errors['password_c'] = "Confirmation de mot passe invalide";
            }
            if ( !empty($errors) ){
                session_instance()->write('_data',$_POST);
                session_instance()->write('errors',$errors);
                route_redirect('user.reset.confirmation',['id'=>$id,'token'=>$token]);
            }
            $pdo->query("DELETE FROM password_resets WHERE user_id = '{$user->id}' ");
            $pdo->prepare("UPDATE users set password = ? WHERE id = {$user->id} ")->execute([ hash_password($POST->get('password')) ]);
            setSuccesFlash("Mot de passe reinitialiser avec success","Reinitialisation");
            route_redirect('users.index');
        }else{
            setErrorFlash("Vous venez d'etre rediriger d'une url invalide","redirection");
            route_redirect('users.index');
        }
    }

}