<?php

use yii\db\Migration;

/**
 * Class m180322_103452_add_tournament_type_column_into_tournaments_table
 */
class m180322_103452_add_tournament_type_column_into_tournaments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tournaments}}', 'type', $this->integer(1)->after('slug'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tournaments}}', 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180322_103452_add_tournament_type_column_into_tournaments_table cannot be reverted.\n";

        return false;
    }
    */
}
