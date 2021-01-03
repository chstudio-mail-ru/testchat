<?php

/* @var $this yii\web\View */
/* @var $messages array */

$this->title = 'Test chat';
?>
<div class="site-index">
    <div class="chat-area">
        Можно писать
        <?php
            foreach ($messages as $message) {
                echo $message->author." ".date("Y.m.d H:i:s", $message->date_add).": ".$message->text;
            }
        ?>
    </div>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'message-add']); ?>

            <?= $form->field($model, 'author_id')->hiddenInput()
            (['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'subject') ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
