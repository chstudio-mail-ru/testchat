<?php

/* @var $this yii\web\View */
/* @var $messages array */

$this->title = 'Test chat';
?>
<div class="site-index">
    <div class="chat-area">
        <?php
        foreach ($messages as $message) {
            echo "<br />".(($message->author->username == "admin")? "<span style=\"color:red; font-weight: bold\">" : "<span style=\"color:black; font-weight: normal\">").$message->author->username."</span>: ".$message->message;
        }
        ?>
    </div>
</div>
