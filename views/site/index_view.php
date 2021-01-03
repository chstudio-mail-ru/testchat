<?php

/* @var $this yii\web\View */
/* @var $messages array */

$this->title = 'Test chat';
?>
<div class="site-index">
    <div class="chat-area">
        Можно смотреть
        <?php
            foreach ($messages as $message) {
                echo $message->author.": ".$message->text;
            }
        ?>
    </div>
</div>
