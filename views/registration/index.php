<?php
/* @var $model app\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Заполните форму для регистрации:</p>

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'username', ['enableAjaxValidation' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <div class="form-group">
        <div>
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
