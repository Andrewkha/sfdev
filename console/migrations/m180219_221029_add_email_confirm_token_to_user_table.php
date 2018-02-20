<?php

use yii\db\Migration;

/**
 * Class m180219_221029_add_email_confirm_token_to_user_table
 */
class m180219_221029_add_email_confirm_token_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'email_confirm_token', $this->string()->unique()->after('email'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180219_221029_add_email_confirm_token_to_user_table cannot be reverted.\n";

        return false;
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'email_confirm_token');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180219_221029_add_email_confirm_token_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
