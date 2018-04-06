<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users_forecasts`.
 */
class m180406_121232_create_users_tournaments_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public $table = '{{%users_tournaments}}';
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $table = $this->table;
        $this->createTable($table, [
            'user_id' => $this->integer()->notNull(),
            'tournament_id' => $this->integer()->notNull(),
            'notification' => $this->boolean(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-users_tournaments}}', $table, ['user_id', 'tournament_id']);

        $this->createIndex('{{%idx-users_tournaments-user_id}}', $table, 'user_id');
        $this->createIndex('{{%idx-users_tournaments-tournament_id}}', $table, 'tournament_id');

        $this->addForeignKey('{{%fk-users_tournaments-user_id}}', $table, 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-users_tournaments-tournament_id}}', $table, 'tournament_id', '{{%tournaments}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
