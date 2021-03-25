<?php
    namespace middlewares;

    use Application\Models\DB;
    use PDO;
	use Application\Auth;

    function isAdminPage(){
		if( Auth::isAdmin()  ){
            $user = DB::select('*')->from("users")->where("id = ". Auth::getUser()->id )->executeWith()->fetch();
			if( !empty($user) )  Auth::log($user);
			else route_redirect('login.home');
        }else route_redirect('login.home');
    }

    function isAuthPage(){
        if( Auth::isLogged()  ){
            $user = DB::select('*')->from("users")->where("id = ". Auth::getUser()->id )->executeWith()->fetch();
            if( !empty($user) )  Auth::log($user);
            else route_redirect('login.home');
        }else route_redirect('login.home');
    }

    function isDirectorPage(){

    }

    function isAdminDG(){

    }

    function isRegisterPage(){
        $route_params = CollectionData(router_instance()->getCurrentRoute()->params());
        $pdo = pdo_instance();
        $db = $pdo->prepare('SELECT *, password_confirmations.id AS password_confirmation_id
                                       FROM    users,password_confirmations 
                                       WHERE   users.id = :id AND  password_confirmations.user_id = :id AND  password_confirmations.token = :token   ');
        $db->bindValue('id',$route_params->get('0'),PDO::PARAM_INT);
        $db->bindValue('token',$route_params->get('1'),PDO::PARAM_STR);
        $db->execute();
        $users = $db->fetch();
        if( empty($users) ){
            header("location:".path_for('login.home'));
            exit();
        }
        return $users;
    }

    function isGuestPage(){
        $users = DB::select('id')->from("users")
            ->where('confirmed_at IS NOT NULL')
            ->where("type = 'admin' ")
            ->executeWith()->rowCount();
        if( empty($users) ){
            header("location:".path_for('config.home'));
            exit();
        }
		if( Auth::isAdmin() ){
			header("location:".path_for('admin.home'));
            exit();
		}
    }

    function isConfigPage(){
        $users = DB::select('id')->from("users")
            ->where("type = 'admin' ")
            ->where('confirmed_at IS NOT NULL')->executeWith()->rowCount();
        if( !empty($users) ){
            header("location:".path_for('login.home'));
            exit();
        }
        $admin_user = DB::select('id')->from("users")->where('confirmed_at IS NULL')->executeWith()->rowCount();
        if( !empty($admin_user) ){
            setFlash('info','Un compte admin est en attente de confirmation , vous devez en créer un nouveau si vous rencontrez des problemes avec cette emil','confirmation du compte admin');
        }
    }