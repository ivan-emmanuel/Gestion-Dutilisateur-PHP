<?php


namespace App\Controllers;


use Application\Auth;
use Application\Models\DB;
use Application\Template\TemplateEngine;
use function middlewares\isAuthPage;

class HomesController
{

    public function e404()
    {
        TemplateEngine::pageTitle('Erreur 404 : Page non trouvée');
        if (Auth::isLogged()) {
            TemplateEngine::Instance()->setLayout('app');
        } else {
            TemplateEngine::Instance()->setLayout('guest');
        }
        TemplateEngine::Instance()->render('e404');
    }

    public function internetError()
    {
        TemplateEngine::pageTitle('Erreur de connection a Internet');
        TemplateEngine::Instance()->setLayout('guest');
        TemplateEngine::Instance()->render('eInternet');
    }

    public function dashboard()
    {
        isAuthPage();
        TemplateEngine::pageTitle('Dashboard');
        $data = [
            [
                'title' => 'Admistrateur',
                'count' => DB::select('*')->from('users')->where("type='admin'")->pdoQuery()->rowCount(),
                'data' => DB::select('*')->from('users')->where("type='admin'")->limit(5)->pdoQuery(),
                'link' => path_for('users.index'),
            ],
            [
                'title' => 'Utilisateur',
                'data' => DB::select('*')->from('users')->where("type='user'")->limit(5)->pdoQuery(),
                'link' => path_for('users.index'),
                'count' => DB::select('*')->from('users')->where("type='user'")->pdoQuery()->rowCount(),
            ],

        ];
        TemplateEngine::Instance()->setLayout('app');
        TemplateEngine::Instance()->render('admin/dashboard', compact('data'));
    }


}