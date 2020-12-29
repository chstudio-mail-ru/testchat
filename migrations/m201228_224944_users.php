<?php

use yii\db\Migration;

/**
 * Class m201228_224944_users
 */
class m201228_224944_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `users` (
            `id` int(11) NOT NULL,
            `username` varchar(255) NOT NULL,
            `password` varchar(32) NOT NULL,
            `deleted` enum('0','1') NOT NULL DEFAULT '0',
            `role_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->execute("ALTER TABLE `users`
            ADD PRIMARY KEY (`id`);");

        $this->execute("ALTER TABLE `users`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
            COMMIT;");

        $this->execute("INSERT INTO `users` (`id`, `username`, `password`, `deleted`, `role_id`, `created_at`) VALUES
                (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '0', 1, '2020-12-28 21:00:00'),
                (2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', '0', 2, '2020-12-28 21:00:00'),
                (3, 'user1', 'ee11cbb19052e40b07aac0ca060c23ee', '0', 2, '2020-12-28 21:00:00'),
                (4, 'user2', 'ee11cbb19052e40b07aac0ca060c23ee', '0', 2, '2020-12-28 21:00:00');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("users");
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
