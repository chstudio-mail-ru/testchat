<?php

use yii\db\Migration;

/**
 * Class m201228_224924_rbacinit
 */
class m201228_224924_rbacinit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `auth_assignment` (
              `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              `created_at` int(11) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->execute("INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
            ('admin', '1', 1609190369),
            ('register', '2', 1609190369),
            ('register', '3', 1609190369),
            ('register', '4', 1609190369);");

        $this->execute("CREATE TABLE `auth_item` (
              `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              `type` smallint(6) NOT NULL,
              `description` text COLLATE utf8_unicode_ci,
              `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
              `data` blob,
              `created_at` int(11) DEFAULT NULL,
              `updated_at` int(11) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->execute("INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
                ('addMessage', 2, 'Написать сообщение', NULL, NULL, 1609190369, 1609190369),
                ('admin', 1, NULL, NULL, NULL, 1609190369, 1609190369),
                ('register', 1, NULL, NULL, NULL, 1609190369, 1609190369),
                ('viewAdminPage', 2, 'Просмотр админки', NULL, NULL, 1609190369, 1609190369);");

        $this->execute("CREATE TABLE `auth_item_child` (
              `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->execute("INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
            ('admin', 'register'),
            ('admin', 'viewAdminPage'),
            ('register', 'addMessage');");

        $this->execute("CREATE TABLE `auth_rule` (
              `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              `data` blob,
              `created_at` int(11) DEFAULT NULL,
              `updated_at` int(11) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->execute("ALTER TABLE `auth_assignment`
              ADD PRIMARY KEY (`item_name`,`user_id`),
              ADD KEY `idx-auth_assignment-user_id` (`user_id`);");

        $this->execute("ALTER TABLE `auth_item`
              ADD PRIMARY KEY (`name`),
              ADD KEY `rule_name` (`rule_name`),
              ADD KEY `idx-auth_item-type` (`type`);
            ");

        $this->execute("ALTER TABLE `auth_rule`
              ADD PRIMARY KEY (`name`);");

        $this->execute("ALTER TABLE `auth_assignment`
              ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;");

        $this->execute("ALTER TABLE `auth_item`
              ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;");

        $this->execute("ALTER TABLE `auth_item_child`
              ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
            COMMIT;");
   }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("auth_assignment");
        $this->dropTable("auth_item");
        $this->dropTable("auth_item_child");
        $this->dropTable("auth_rule");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201228_224924_rbacinit cannot be reverted.\n";

        return false;
    }
    */
}
