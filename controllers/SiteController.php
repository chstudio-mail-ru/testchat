<?php

namespace app\controllers;

use app\models\Message;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $model = new Message();

        if (\Yii::$app->user->can('viewAdminPage')) {
            if ($model->load(Yii::$app->request->post())) {
                $model->author_id = Yii::$app->user->id;
                if ($model->save()) {
                    return $this->render('index_add', ['messages' => $model->getAll(true)]);
                }
            }

            return $this->render('index_delete', ['messages' => $model->getAll(true)]);
        }
        if (\Yii::$app->user->can('addMessage')) {
            if ($model->load(Yii::$app->request->post())) {
                $model->author_id = Yii::$app->user->id;
                if ($model->save()) {
                    return $this->render('index_add', ['messages' => $model->getAll()]);
                }
            }

            return $this->render('index_add', ['messages' => $model->getAll()]);
        }
        return $this->render('index_view', ['messages' => $model->getAll()]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
