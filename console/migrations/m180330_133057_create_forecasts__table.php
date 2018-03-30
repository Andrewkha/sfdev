<?php

use yii\db\Migration;

/**
 * Handles the creation of table `forecasts_`.
 */
class m180330_133057_create_forecasts__table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%forecasts}}';
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            'game_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'homeFscore' => $this->integer(2)->null(),
            'guestFscore' => $this->integer(2)->null(),
            'date' => $this->integer()
        ], $tableOptions);

        $this->createIndex('{{%idx-forecasts-game_id}}', $table, 'game_id');
        $this->createIndex('{{%idx-forecasts-user_id}}', $table, 'user_id');

        $this->addForeignKey('{{%fk-forecasts-game_id}}', $table, 'game_id', '{{%games}}', 'id');
        $this->addForeignKey('{{%fk-forecasts-user_id}}', $table, 'user_id', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%forecasts}}');
    }
}
