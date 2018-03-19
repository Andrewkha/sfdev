<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tournaments`.
 */
class m180319_134408_create_tournaments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%tournaments}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'country_id' => $this->integer(),
            'tours' => $this->integer(2),
            'status' => $this->integer(1),
            'startDate' => $this->integer(),
            'autoprocess' => $this->boolean(),
            'autoprocessUrl' => $this->string(),
            'winnersForecastDue' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%idx-sf_teams-slug}}', '{{%tournaments}}', 'slug', true);

        $this->createIndex('{{%idx-sf_tournaments-country_id}}', '{{%tournaments}}', 'country_id');
        $this->addForeignKey('{{%fk-sf_tournaments-country_id}}', '{{%tournaments}}', 'country_id', '{{%countries}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tournaments}}');
    }
}
