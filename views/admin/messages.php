<?php

/* @var $this yii\web\View */
/* @var $messages array */
/* @var $model app\models\Message */

use yii\bootstrap\Html;

$this->title = 'Удаленные сообщения';

$js = <<< JS
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

$this->registerJs($js, yii\web\View::POS_HEAD);?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <a href="/admin/users">Пользователи</a>
    <div class="messages-area">
        <?php
        foreach ($messages as $message) {
            echo "<br />".(($message->author->username == "admin")? "<span style=\"color:red; font-weight: bold\">" : "<span style=\"color:black; font-weight: normal\">").$message->author->username."</span> ".date("Y.m.d H:i:s", $message->date_add)." (from IP ".$message->remote_addr."): ".(($message->deleted== 1)? "<del style=\"color:blue;\">".$message->message."</del>" : $message->message );
            echo " <a href=\"#\" onclick=\"setCorrect(".$message->id.");return false;\">Восстановить</a>";
        }
        ?>
    </div>
</div>
