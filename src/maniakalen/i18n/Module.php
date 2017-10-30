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

namespace maniakalen\i18n;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Module as BaseModule;

/**
 * Class Module
 *
 *  CLASSDESCRIPTION
 *
 * @category CATEGORY
 * @package  PACKAGE
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class Module extends BaseModule implements BootstrapInterface
{
    public $controllerNamespace;
    public $urlRules;
    public $events;
    public $container;
    public $components;

    /**
     * Module initialisation
     *
     * @return null
     */
    public function init()
    {
        parent::init();
        Yii::setAlias('@translations', dirname(__FILE__));
        $config = include Yii::getAlias('@translations/config/main.php');
        Yii::configure($this, $config);
        if (!$this->controllerNamespace) {
            $this->controllerNamespace = Yii::getAlias('@translations\controllers');
        }

        $this->prepareEvents();
        $this->prepareContainer();


        if (isset($config['aliases']) && !empty($config['aliases'])) {
            Yii::$app->setAliases($config['aliases']);
        }
        return null;
    }

    /**
     * Protected method to register events defined in config
     *
     * @return null
     */
    protected function prepareEvents()
    {
        if (!empty($this->events)) {
            foreach ($this->events as $event) {
                if (isset($event['class']) && isset($event['event'])
                    && isset($event['callback']) && is_callable($event['callback'])
                ) {
                    Event::on($event['class'], $event['event'], $event['callback']);
                }
            }
        }

        return null;
    }

    /**
     * Protected method to add container definition from the config file
     *
     * @return null
     */
    protected function prepareContainer()
    {
        if (!empty($this->container)) {
            if (isset($this->container['definitions'])) {
                $definitions = array_merge(Yii::$container->getDefinitions(), $this->container['definitions']);
                Yii::$container->setDefinitions($definitions);
            }
        }

        return null;
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     *
     * @return null
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            if (is_array($this->urlRules) && !empty($this->urlRules)) {
                $app->getUrlManager()->addRules($this->urlRules, true);
            }
        }
        if (is_array($this->components) && !empty($this->components)) {
            $app->setComponents($this->components);
        }
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = '@translations\console\controllers';
        }

        return null;
    }
}