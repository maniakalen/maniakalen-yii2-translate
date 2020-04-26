<?php


namespace maniakalen\i18n\migrations;


class m200425_220600_translations extends \yii\db\Migration
{
    public function safeUp()
    {
        try {
            $this->batchInsert('source_message', ['category', 'message'], [
                ['mi18n', 'Category'],
                ['mi18n', 'Label'],
                ['mi18n', 'Language'],
                ['mi18n', 'Translation'],
                ['mi18n', 'Language Code'],
                ['mi18n', 'Language'],
                ['mi18n', 'Status'],
            ]);
            return true;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage(), 'mi18n');
        }
        return false;
    }

    public function safeDown()
    {
        try {
            $this->delete('source_message', ['category' => 'mi18n']);
            return true;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage(), 'mi18n');
        }
        return false;
    }
}