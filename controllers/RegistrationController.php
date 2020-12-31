<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class RegistrationController extends Controller
{
    /**
     * Registration.
     *
     * @return Response|array|string
     * @throws \Exception
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $model = new User();

            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $auth = Yii::$app->authManager;
                $register = $auth->getRole('register');
                $auth->assign($register, $model->id);

                return $this->redirect(['/registration']);
            }

            return $this->render('index', [
                'model' => $model,
            ]);
        } else {
            return $this->goHome();
        }
    }
}
