<?php

class m160707_114319_support_init extends \yii\db\Migration {

    /**
     * Create tables.
     */
    public function up() {

        $tableOptions = null;
        if (Yii::$app->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%support_page}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255)->notNull(),
            'lang_code' => $this->string(10)->notNull(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
                ], $tableOptions);
        $this->createIndex('support_page_unique', '{{%support_page}}', ['key', 'lang_code'], true);
        $this->addForeignKey('fk-support_page_lang', '{{%support_page}}', 'lang_code', '{{%languages}}', 'code', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%support_category}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255)->notNull(),
            'lang_code' => $this->string(10)->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
                ], $tableOptions);
        $this->createIndex('support_category_unique', '{{%support_category}}', ['key', 'lang_code'], true);
        $this->addForeignKey('fk-support_category_lang', '{{%support_category}}', 'lang_code', '{{%languages}}', 'code', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%support_category_page}}', [
            'page_key' => $this->string(255)->notNull(),
            'category_key' => $this->string(255)->notNull(),
                ], $tableOptions);
        $this->addPrimaryKey('pk-support_category_page', '{{%support_category_page}}', ['page_key', 'category_key']);
    }

    /**
     * Drop tables.
     */
    public function down() {
        $this->dropForeignKey('fk-support_category_lang', '{{%support_category}}');
        $this->dropForeignKey('fk-support_page_lang', '{{%support_page}}');
        $this->dropTable('{{%support_category_page}}');
        $this->dropTable('{{%support_category}}');
        $this->dropTable('{{%support_page}}');
    }

}
