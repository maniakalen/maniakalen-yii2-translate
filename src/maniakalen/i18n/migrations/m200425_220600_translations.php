<?php


namespace maniakalen\i18n\migrations;


class m200425_220600_translations extends \yii\db\Migration
{
    public function saveUp()
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
        } catch (\Exception $e) {
            \Yii::error($e->getMessage(), 'mi18n');
        }
    }

    public function saveDown()
    {
        try {
            $this->delete('source_message', ['category' => 'mi18n']);
        } catch (\Exception $e) {
            \Yii::error($e->getMessage(), 'mi18n');
        }
    }
}