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

namespace maniakalen\migrations;

class m20171030_1152_create_steps extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('languages', [
            'id' => $this->primaryKey(),
            'language_code' => $this->string(8),
            'language' => $this->string(45),
            'status' => $this->boolean()
        ]);
    }

    public function down()
    {
        $this->dropTable('languages');
    }
}