<?php

/* @var $this yii\web\View */
/* @var $messages array */
/* @var $model app\models\Message */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Test chat';

$js = <<< JS
function setNotCorrect(id)
{
    $.ajax({
            url: '/delete/'+id,
            type: 'post'
        }
    )
    .done(function(data) {
        location.reload();
    })
    .fail(function () {
    })

    return false;
}

function setCorrect(id)
{
    $.ajax({
            url: '/publish/'+id,
            type: 'post'
        }
    )
    .done(function(data) {
        location.reload();
    })
    .fail(function () {
    })

    return false;
}
JS;

$this->registerJs($js, yii\web\View::POS_HEAD);
?>
<div class="site-index">
    <div class="chat-area">
        <?php
            foreach ($messages as $message) {
                echo "<br />".(($message->author->username == "admin")? "<span style=\"color:red; font-weight: bold\">" : "<span style=\"color:black; font-weight: normal\">").$message->author->username."</span> ".date("Y.m.d H:i:s", $message->date_add)." (from IP ".$message->remote_addr."): ".(($message->deleted== 1)? "<del style=\"color:blue;\">".$message->message."</del>" : $message->message );
                if ($message->deleted == 0) {
                    echo " <a href=\"#\" onclick=\"setNotCorrect(".$message->id.");return false;\">Некорректное</a>";
                } else {
                    echo " <a href=\"#\" onclick=\"setCorrect(".$message->id.");return false;\">Корректное</a>";
                }
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
