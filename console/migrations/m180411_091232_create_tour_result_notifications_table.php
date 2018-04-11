<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tour_result_notifications`.
 */
class m180411_091232_create_tour_result_notifications_table extends Migration
{
    private $table = '{{%tour_result_notifications}}';
    private $shortName = 'tour_result_notifications';

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable($this->table, [
            'tournament_id' => $this->integer()->notNull(),
            'tour' => $this->integer(2)->notNull(),
            'date' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey("{{%pk-$this->shortName}}", $this->table, ['tournament_id', 'tour']);

        $this->createIndex("{{%idx-$this->shortName-tournament_id}}", $this->table, 'tournament_id');

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
