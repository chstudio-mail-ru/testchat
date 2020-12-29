<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $register = $auth->createRole('register');

        $auth->add($admin);
        $auth->add($register);

        $viewAdminPage = $auth->createPermission('viewAdminPage');
        $viewAdminPage->description = 'Просмотр админки';

        $addMessage = $auth->createPermission('addMessage');
        $addMessage->description = 'Написать сообщение';

        $auth->add($viewAdminPage);
        $auth->add($addMessage);

        $auth->addChild($register,$addMessage);
        $auth->addChild($admin, $register);
        $auth->addChild($admin, $viewAdminPage);

        $auth->assign($admin, 1);
        $auth->assign($register, 2);
    }
}