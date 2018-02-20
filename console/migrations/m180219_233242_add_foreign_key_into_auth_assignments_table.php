<?php

use yii\db\Migration;

/**
 * Class m180219_233242_add_foreign_key_into_auth_assignments_table
 */
class m180219_233242_add_foreign_key_into_auth_assignments_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('{{%auth_assignment}}', 'user_id', $this->integer()->notNull());
        $this->createIndex('{{%idx-auth_assignment-user_id}}', '{{%auth_assignment}}', 'user_id');
        $this->addForeignKey('{{%fk-auth_assignment-user_id}}', '{{%auth_assignment}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('{{%fk-auth_assignment-user_id}}', '{{%auth_assignment}}');
        $this->dropIndex('{{%idx-auth_assignment-user_id}}', '{{%auth_assignment}}');
        $this->alterColumn('{{%auth_assignment}}', 'user_id', $this->string(64)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180219_233242_add_foreign_key_into_auth_assignments_table cannot be reverted.\n";

        return false;
    }
    */
}
