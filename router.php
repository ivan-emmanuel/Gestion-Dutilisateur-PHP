<?php

    $router = router_instance();

    /**
    Page de configuration
     */
    $router->get('/config/register/:id/:token','Config#configConfirmation','config.confirmation')
        ->with('id','[0-9]+')
        ->with('slug','[a-z\-0-9]+');

    $router->get('/config',"Config#home",'config.home');

    $router->post('/config',"Config#homeAction");

    /**
     * Authrntification page
     */
    $router->get('/',"auth\Login#home",'login.home');
    $router->post('/',"auth\Login#homeAction");
    $router->get('/logout',"auth\Login#logout",'logout');

    /**
     * User HomePage
     */
    $router->get('/dashboard',"Home#dashboard",'admin.home');

    /**
     * User CRUD routes
     */
    $router->get('/users',"resources\User#index",'users.index'); //Listes de utilisateur

    $router->post('/users',"resources\User#store"); // sauvegarde d'un utilisateur

    $router->post('/users/edit/:id',"resources\User#update",'users.edit'); //edition d'un utilisateur

    $router->get('/users/delete/:id',"resources\User#delete",'users.delete'); //Suppression d'un utilisateur

    $router->get('/users/register/:id/:token','resources\User#confirmation','users.confirmation')
        ->with('id','[0-9]+')
        ->with('slug','[a-z\-0-9]+');

    $router->post('/users/register/:id/:token','resources\User#confirmationAction')
        ->with('id','[0-9]+')
        ->with('slug','[a-z\-0-9]+');



    $router->post('/account/edit',"auth\Account#edit",'account.edit');

    $router->get('/auth/reset',"auth\PasswordReset#GetAction",'login.reset');

    $router->post('/auth/reset',"auth\PasswordReset#PostAction");

    $router->get('/auth/reset/confirmation/:id/:token',"auth\PasswordReset#Confirm",'user.reset.confirmation');

    $router->post('/auth/reset/confirmation/:id/:token',"auth\PasswordReset#ConfirmAction");

    // Dossier Controller renommer pour controller