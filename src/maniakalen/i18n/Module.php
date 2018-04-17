<?php
/**
 * PHP Version 5.5
 *
 *  Yii2 Database translation module
 *
 * @category I18n
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */

namespace maniakalen\i18n;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Module as BaseModule;
use yii\helpers\ArrayHelper;

/**
 * Class Module
 *
 *  Yii2 Database translation module definition.
 *
 * @category I18n
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class Module extends BaseModule implements BootstrapInterface
{

    const RULE_GROUP_FRONTEND = 'frontend';
    const RULE_GROUP_BACKEND = 'backend';

    public $controllerNamespace;
    public $urlRules;
    public $events;
    public $container;
    public $components;
    public $group;

    /**
     * Module initialisation
     *
     * @return null
     * @throws \ErrorException
     */
    public function init()
    {
        if (defined('MANIAKALEN_I18N_TRANSLATE')) {
            throw new \ErrorException("Trying to redefine translation module");
        }
        define('MANIAKALEN_I18N_TRANSLATE', 1);
        Yii::setAlias('@translations', dirname(__FILE__));
        $config = include Yii::getAlias('@translations/config/main.php');
        Yii::configure($this, $config);
        if (!$this->controllerNamespace) {
            $this->controllerNamespace = 'maniakalen\i18n\controllers';
        }
        parent::init();

        $this->prepareEvents();
        $this->prepareContainer();


        if (isset($config['aliases']) && !empty($config['aliases'])) {
            Yii::$app->setAliases($config['aliases']);
        }
        return null;
    }

    /**
     * Overrides the default method in order to use the correct alias
     *
     * @return bool|string
     */
    public function getControllerPath()
    {
        return Yii::getAlias('@translations/controllers');
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
            if ($this->group && isset($this->urlRules[$this->group]) && is_array($this->urlRules[$this->group]) && !empty($this->urlRules[$this->group])) {
                $app->getUrlManager()->addRules($this->urlRules[$this->group], true);
            }
        }
        if (is_array($this->components) && !empty($this->components)) {
            $app->setComponents($this->components);
        }
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'maniakalen\i18n\console\controllers';
        }

        $this->registerTranslations();

        return null;
    }

    /**
     * Registers the translation file for the module
     *
     * @return null
     */
    protected function registerTranslations()
    {
        foreach (Yii::$app->translationsAdmin->getTranslationCategories() as $category) {
            Yii::$app->i18n->translations[$category] = [
                'class' => 'yii\i18n\DbMessageSource',
            ];
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
                $definitions = ArrayHelper::merge(Yii::$container->getDefinitions(), $this->container['definitions']);
                Yii::$container->setDefinitions($definitions);
            }
        }

        return null;
    }
    /**
     * @param \yii\web\Application $app
     *
     * @return null
     * @throws \InvalidArgumentException
     */
    public function registerRoutes(\yii\web\Application $app)
    {
        if (!$this->group) {
            throw new \InvalidArgumentException("Missing route group config");
        }
        if (is_array($this->group)) {
            foreach ($this->group as $group) {
                $this->registerRoutesByGroup($app, $group);
            }
        } else if (is_string($this->group)) {
            $this->registerRoutesByGroup($app, $this->group);
        }
        return true;
    }

    private function registerRoutesByGroup(\yii\web\Application $app, $groupLabel)
    {
        if (isset($this->urlRules[$groupLabel]) && !empty($this->urlRules[$groupLabel])) {
            $group = $this->urlRules[$groupLabel];
            $id = $this->id;
            foreach ($group as $url => $route) {
                $group[$url] = str_replace('{module}', $id, $route);
            }
            $app->getUrlManager()->addRules($group, true);
        }
    }
}