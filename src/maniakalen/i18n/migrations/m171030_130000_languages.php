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


class m171030_130000_languages extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%languages}}', [
            'id' => $this->primaryKey(),
            'language_code' => $this->string(16)->notNull(),
            'language' => $this->string(45),
            'status' => $this->boolean()
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('languages');
    }
}