<?php

use yii\db\Migration;

class m160318_134643_location extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%location}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'event' => $this->string()->notNull()->unique(),
//            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'mapLink' => $this->integer()->notNull(),
//            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('event_key', '{{%location}}', 'event', '{{%event}}', 'id');

    }

    public function down()
    {
        echo "m160318_134643_location cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
