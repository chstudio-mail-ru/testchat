<?php

use yii\db\Migration;

/**
 * Class m201228_224944_users
 */
class m201228_224955_messages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `messages` (
              `id` int(11) NOT NULL,
              `author_id` int(11) NOT NULL,
              `date_add` int(11) NOT NULL,
              `message` varchar(1024) NOT NULL,
              `deleted` enum('0','1') NOT NULL DEFAULT '0',
              `remote_addr` varchar(15) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");

        $this->execute("ALTER TABLE `messages`
              ADD PRIMARY KEY (`id`),
              ADD KEY `author_id` (`author_id`),
              ADD KEY `date_add` (`date_add`);");

        $this->execute("ALTER TABLE `messages`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
            COMMIT;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey("id", "messages");
        $this->dropIndex("author_id","messages");
        $this->dropIndex("date_add","messages");
        $this->dropTable("messages");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201228_224944_users cannot be reverted.\n";

        return false;
    }
    */
}
