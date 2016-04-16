<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller{

    public function actionInit(){
        $auth = Yii::$app->authManager;

        //add "Create Notification" permission
        $createNotification = $auth->createPermission("createNotification");
        $createNotification->description = "Create notification";
        $auth->add($createNotification);

        //add "Create article" permission
        $createArticle = $auth->createPermission("createArticle");
        $createArticle->description = "Create article";
        $auth->add($createArticle);

        //add "View article" permission
        $viewArticle = $auth->createPermission("viewArticle");
        $viewArticle->description = "View article";
        $auth->add($viewArticle);

        //add "admin" role and give "createNotification", "createArticle", "viewArticle" permission
        $admin = $auth->createRole("admin");
        $auth->add($admin);
        $auth->addChild($admin, $createNotification);
        $auth->addChild($admin, $createArticle);
        $auth->addChild($admin, $viewArticle);

        //add "user" role and give "viewArticle" permission
        $user = $auth->createRole("user");
        $auth->add($user);
        $auth->addChild($user, $viewArticle);

        //Assign roles to users. 
        $auth->assign($admin, 1);
        $auth->assign($user, 2);
    }
}