<?php

/* @var $this yii\web\View */
/* @var $messages array */
/* @var $model app\models\Message */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Test chat';
?>
<div class="site-index">
    <div class="chat-area">
        Можно удалять
        <?php
            foreach ($messages as $message) {
                echo $message->author." ".date("Y.m.d H:i:s", $message->date_add).": ".$message->text;
            }
        ?>
    </div>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'message-add']); ?>

            <?= $form->field($model, 'message')->textarea(['rows' => 3]) ?>

            <div class="form-group">
                <?= Html::submitButton('Добавить сообщение', ['class' => 'btn btn-primary', 'name' => 'add-message-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
