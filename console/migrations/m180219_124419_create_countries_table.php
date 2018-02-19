<?php

use yii\db\Migration;

/**
 * Handles the creation of table `countries`.
 */
class m180219_124419_create_countries_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%countries}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-sf_countries-slug}}', '{{%countries}}', 'slug', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%countries}}');
    }
}
