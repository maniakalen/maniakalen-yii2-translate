<?php
/**
 * PHP Version 5.5
 *
 *  $DESCRIPTION$ $END$
 *
 * @category $Category$ $END$
 * @package  $Package$ $END$
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     $LINK$ $END$
 */


class m171030_130000_translations extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('translations', [
            'id' => $this->primaryKey(),
            'language_id' => $this->integer()->notNull(),
            'category' => $this->string(45),
            'label' => $this->string(128),
            'text' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk-languages_translations',
            'translations',
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