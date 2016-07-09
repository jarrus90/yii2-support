<?php

class m160707_115321_support_replies extends \yii\db\Migration {

    /**
     * Create tables.
     */
    public function up() {

        $tableOptions = null;
        if (Yii::$app->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%support_reply}}', [
            'id' => $this->primaryKey(),
            'content' => $this->text()->notNull(),
            'from_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'is_blocked' => $this->boolean()->defaultValue(false)
                ], $tableOptions);
        $this->createIndex('support_reply-from', '{{%support_reply}}', 'from_id');
        $this->createIndex('support_reply-created_at', '{{%support_reply}}', 'created_at');
        $this->createIndex('support_reply-parent', '{{%support_reply}}', 'parent_id');
        
        $this->addForeignKey('fk-support_reply-parent', '{{%support_reply}}', 'parent_id', '{{%support_reply}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-support_reply-user', '{{%support_reply}}', 'from_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * Drop tables.
     */
    public function down() {
        $this->dropForeignKey('fk-support_reply-parent', '{{%support_reply}}');
        $this->dropForeignKey('fk-support_reply-user', '{{%support_reply}}');
        $this->dropTable('{{%support_reply}}');
    }

}
