<?php

use yii\db\Migration;

/**
 * Class m180522_130534_forecast_reminders_drop_reminders_column
 */
class m180522_130534_forecast_reminders_drop_reminders_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%forecast_reminders}}', 'reminders');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{forecast_reminders}}', 'reminders', $this->integer(1)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180522_130534_forecast_reminders_drop_reminders_column cannot be reverted.\n";

        return false;
    }
    */
}
