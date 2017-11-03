<?php
/**
 * PHP Version 5.5
 *
 *  Yii2 migration class
 *
 * @category migrations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */


class m171030_130000_translations extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('translations', [
            'id' => $this->primaryKey(),
            'category' => $this->string(45),
            'label' => $this->string(128),
        ]);
        $this->createTable('translations_texts', [
            'id' => $this->primaryKey(),
            'translation_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'text' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk-_translations_texts_id',
            'translations_texts',
            'translation_id',
            'translations',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-languages_translations',
            'translations_texts',
            'language_id',
            'languages',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('translations');
    }
}