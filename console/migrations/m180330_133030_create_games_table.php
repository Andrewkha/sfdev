<?php

use yii\db\Migration;

/**
 * Handles the creation of table `games`.
 */
class m180330_133030_create_games_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%games}}';
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer()->notNull(),
            'home_team_id' => $this->integer()->notNull(),
            'guest_team_id' => $this->integer()->notNull(),
            'tour' => $this->integer(2)->notNull(),
            'homeScore' => $this->integer(2)->null(),
            'guestScore' => $this->integer(2)->null(),
            'date' => $this->integer()
        ], $tableOptions);

        $this->createIndex('{{%idx-games-tournament_id}}', $table, 'tournament_id');
        $this->createIndex('{{%idx-games-home_team_id}}', $table, 'home_team_id');
        $this->createIndex('{{%idx-games-guest_team_id}}', $table, 'guest_team_id');

        $this->addForeignKey('{{%fk-games-tournament_id}}', $table, 'tournament_id', '{{%tournaments}}', 'id');
        $this->addForeignKey('{{%fk-games-home_team_id}}', $table, 'home_team_id', '{{%teams}}', 'id');
        $this->addForeignKey('{{%fk-games-guest_team_id}}', $table, 'guest_team_id', '{{%teams}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%games}}');
    }
}
