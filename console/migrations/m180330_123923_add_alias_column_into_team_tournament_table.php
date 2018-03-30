<?php

use yii\db\Migration;

/**
 * Class m180330_123923_add_alias_column_into_team_tournament_table
 */
class m180330_123923_add_alias_column_into_team_tournament_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%team_tournament}}', 'alias', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%team_tournament}}', 'alias');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180330_123923_add_alias_column_into_team_tournament_table cannot be reverted.\n";

        return false;
    }
    */
}
