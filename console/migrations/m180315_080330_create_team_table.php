<?php

use yii\db\Migration;

/**
 * Handles the creation of table `team`.
 */
class m180315_080330_create_team_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%teams}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'logo' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-sf_teams-slug}}', '{{%teams}}', 'slug', true);

        $this->createIndex('{{%idx-sf_teams-country_id}}', '{{%teams}}', 'country_id');
        $this->addForeignKey('{{%fk-sf_teams-country_id}}', '{{%teams}}', 'country_id', '{{%countries}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%teams}}');
    }
}
