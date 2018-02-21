<?php

use yii\db\Migration;

/**
 * Class m180220_074358_add_notifications_column_into_users_table
 */
class m180220_074358_add_notifications_column_into_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'notification', $this->boolean()->after('status'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%user}}', 'notification');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180220_074358_add_notifications_column_into_users_table cannot be reverted.\n";

        return false;
    }
    */
}
