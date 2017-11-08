<?php
/**
 * PHP Version 5.5
 *
 *  DESCRIPTION
 *
 * @category Category
 * @package  Package
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     LINK
 */
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;
use yii\rbac\Item;
/**
 * Class m171107_093100_permissions
 *
 *  CLASSDESCRIPTION
 *
 * @category CATEGORY
 * @package  PACKAGE
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class m171107_093100_permissions extends \yii\db\Migration
{
    public function up()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use 
            database before executing this migration.');
        }
        $time = time();
        $this->batchInsert(
            $authManager->itemTable,
            ['name', 'type', 'description', 'created_at', 'updated_at'],
            [
                [
                    'backend/translations/access',
                    Item::TYPE_PERMISSION,
                    'Basic access to the admin interface of translations and internacionalization',
                    $time,
                    $time
                ],
                [
                    'backend/languages/access',
                    Item::TYPE_PERMISSION,
                    'Access to the admin interface of languages section',
                    $time,
                    $time
                ],
                [
                    'backend/languages/edit',
                    Item::TYPE_PERMISSION,
                    'Access to manipulate languages registries in admin user interface',
                    $time,
                    $time
                ],
                [
                    'backend/translations/edit',
                    Item::TYPE_PERMISSION,
                    'Access to manipulate registries in translations part of admin user insterface',
                    $time,
                    $time
                ]
            ]
        );

        return parent::up();
    }

    public function down()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use 
            database before executing this migration.');
        }
        $this->delete($authManager->itemTable, ['name' => 'backend/translations/access']);
        $this->delete($authManager->itemTable, ['name' => 'backend/languages/access']);
        $this->delete($authManager->itemTable, ['name' => 'backend/languages/edit']);
        $this->delete($authManager->itemTable, ['name' => 'backend/translations/edit']);

        return parent::down();
    }
}