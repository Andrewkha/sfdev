<?php

use yii\db\Migration;

/**
 * Handles the creation of table `forecast_reminders`.
 */
class m180411_091214_create_forecast_reminders_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    private $table = '{{%forecast_reminders}}';
    private $shortName = 'forecast_reminders';

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable($this->table, [
            'user_id' => $this->integer()->notNull(),
            'tournament_id' => $this->integer()->notNull(),
            'tour' => $this->integer(2)->notNull(),
            'reminders' => $this->integer(1)->notNull(),
            'date' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey("{{%pk-$this->shortName}}", $this->table, ['user_id', 'tournament_id', 'tour']);

        $this->createIndex("{{%idx-$this->shortName-user_id}}", $this->table, 'user_id');
        $this->createIndex("{{%idx-$this->shortName-tournament_id}}", $this->table, 'tournament_id');

        $this->addForeignKey("{{%fk-$this->shortName-user_id}}", $this->table, 'user_id', '{{%user}}', 'id');
        $this->addForeignKey("{{%fk-$this->shortName-tournament_id}}", $this->table, 'tournament_id', '{{%tournaments}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
