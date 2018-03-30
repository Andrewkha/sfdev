<?php

use yii\db\Migration;

/**
 * Handles the creation of table `team_tournament_assignment`.
 */
class m180330_114950_create_team_tournament_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%team_tournament}}', [
            'team_id' => $this->integer()->notNull(),
            'tournament_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-team_tournament}}','{{%team_tournament}}', ['team_id', 'tournament_id']);

        $this->createIndex('{{%idx-team_tournament-team_id}}', '{{%team_tournament}}', 'team_id');
        $this->createIndex('{{%idx-team_tournament-tournament_id}}', '{{%team_tournament}}', 'tournament_id');

        $this->addForeignKey('{{%fk-team_tournament-team_id}}', '{{%team_tournament}}', 'team_id', '{{%teams}}', 'id');
        $this->addForeignKey('{{%fk-team_tournament-tournament_id}}', '{{%team_tournament}}', 'tournament_id', '{{%tournaments}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%team_tournament}}');
    }
}
