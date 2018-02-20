<?php

use yii\db\Migration;

/**
 * Class m180219_183748_add_fields_to_user_table
 */
class m180219_183748_add_fields_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $table = '{{%user}}';
        $this->addColumn($table, 'first_name', $this->string(50)->after('username'));
        $this->addColumn($table, 'last_name', $this->string(50)->after('first_name'));
        $this->addColumn($table, 'avatar', $this->string()->after('status'));
        $this->addColumn($table, 'last_login', $this->integer()->after('updated_at'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180219_183748_add_fields_to_user_table cannot be reverted.\n";

        return false;
    }

    public function down()
    {
        $table = '{{%user}}';
        $this->dropColumn($table, 'first_name');
        $this->dropColumn($table, 'last_name');
        $this->dropColumn($table, 'avatar');
        $this->dropColumn($table, 'last_login');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180219_183748_add_fields_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
