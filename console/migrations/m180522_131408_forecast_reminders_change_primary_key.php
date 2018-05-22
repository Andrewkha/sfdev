<?php

use yii\db\Migration;

/**
 * Class m180522_131408_forecast_reminders_change_primary_key
 */
class m180522_131408_forecast_reminders_change_primary_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropPrimaryKey('{{%pk-forecast_reminders}}', '{{%forecast_reminders}}');
        $this->addColumn('{{%forecast_reminders}}', 'id', $this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180522_131408_forecast_reminders_change_primary_key cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180522_131408_forecast_reminders_change_primary_key cannot be reverted.\n";

        return false;
    }
    */
}
