<?php

/* @var $this yii\web\View */
/* @var $users array */
/* @var $model app\models\User */

use yii\bootstrap\Html;

$this->title = 'Пользователи';

$js = <<< JS
function setUserAdmin(id)
{
    $.ajax({
            url: '/admin/access/'+id+'/1',
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

function setUserRegister(id)
{
    $.ajax({
            url: '/admin/access/'+id+'/2',
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

function setUserNotAccess(id)
{
    $.ajax({
            url: '/admin/access/'+id+'/0',
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
    <h1><?= Html::encode($this->title) ?></h1>
    <a href="/admin">Удаленные сообщения</a>
    <div class="messages-area">
        <?php
        foreach ($users as $user) {
            $roles = $user->userRoles;
            $rolesString = '';
            foreach ($roles as $roleName) {
                $rolesString = $roleName.", ";
            }
            $rolesString = preg_replace("/,\s$/", "", $rolesString);
            echo "<br />".(($user->username == "admin")? "<span style=\"color:red; font-weight: bold\">" : "<span style=\"color:black; font-weight: normal\">").$user->username."</span> - ".((strlen($rolesString) > 0)? $rolesString : "Нет прав");
            if (!in_array('admin', $roles)) {
                echo " <a href=\"#\" onclick=\"setUserAdmin(".$user->id.");return false;\">Назначить администратором</a>";
            }
            if (!in_array('register', $roles)) {
                echo " <a href=\"#\" onclick=\"setUserRegister(" . $user->id . ");return false;\">Назначить регистрантом</a>";
            }
            if (!empty($roles)) {
                echo " <a href=\"#\" onclick=\"setUserNotAccess(".$user->id.");return false;\">Лишить прав</a>";
            }
        }
        ?>
    </div>
</div>
