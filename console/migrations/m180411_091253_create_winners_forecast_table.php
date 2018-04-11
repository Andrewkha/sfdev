<?php

use yii\db\Migration;

/**
 * Handles the creation of table `winners_forecast`.
 */
class m180411_091253_create_winners_forecast_table extends Migration
{
    private $table = '{{%winners_forecast}}';
    private $shortName = 'winners_forecast';

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable($this->table, [
            'user_id' => $this->integer()->notNull(),
            'tournament_id' => $this->integer()->notNull(),
            'team_id' => $this->integer()->notNull(),
            'position' => $this->integer(1)->notNull(),
            'date' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey("{{%pk-$this->shortName}}", $this->table, ['user_id', 'tournament_id', 'team_id']);

        $this->createIndex("{{%idx-$this->shortName-user_id}}", $this->table, 'user_id');
        $this->createIndex("{{%idx-$this->shortName-tournament_id}}", $this->table, 'tournament_id');
        $this->createIndex("{{%idx-$this->shortName-team_id}}", $this->table, 'team_id');

        $this->addForeignKey("{{%fk-$this->shortName-user_id}}", $this->table, 'user_id', '{{%user}}', 'id');
        $this->addForeignKey("{{%fk-$this->shortName-tournament_id}}", $this->table, 'tournament_id', '{{%tournaments}}', 'id');
        $this->addForeignKey("{{%fk-$this->shortName-team_id}}", $this->table, 'team_id', '{{%teams}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
