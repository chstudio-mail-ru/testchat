<?php

namespace app\controllers;

use app\models\Message;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['viewAdminPage']
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays deleted messages.
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        if (Yii::$app->user->can('viewAdminPage')) {
            $model = new Message();

            return $this->render('messages', ['model' => $model, 'messages' => $model->getAllDeleted()]);
        } else {
            throw new ForbiddenHttpException();
        }
    }

    /**
     * Displays users.
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionUsers(): string
    {
        if (Yii::$app->user->can('viewAdminPage')) {
            $model = new User();

            return $this->render('users', ['model' => $model, 'users' => $model->getAll()]);
        } else {
            throw new ForbiddenHttpException();
        }
    }

    /**
     * Set users access.
     * @param int $id
     * @param int $access
     * @throws \Exception
     */
    public function actionAccess(int $id, int $access)
    {
        if(Yii::$app->user->can('viewAdminPage') && Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            User::setAccess($id, $access);
        }
    }
}
