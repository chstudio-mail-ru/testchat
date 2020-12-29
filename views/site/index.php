<?php

/* @var $this yii\web\View */
/* @var $messages array */

$this->title = 'Test chat';
?>
<div class="site-index">
    <div class="chat-area">
        <?php
            foreach ($messages as $message) {
                echo $message->author." ".date("Y.m.d H:i:s", $message->date_add).": ".$message->text;
            }
        ?>
    </div>
</div>
