# yii2-translations
PHP db translations engine


The package is also available in packagist: "maniakalen/yii2-dbtranslate"

To enable the module inside the yii2 you need to define the module in the main config module part:

    'translations' => [
        'class' => 'maniakalen\i18n\Module'
    ],
    
You also need to add the module key to the bootstrap list:
    
    'bootstrap' => [..., 'translations'],

Then you will need to run the module migrations

    yii migrate/up --migrationPath="@translations/migrations/"
    
The categories are automatically registered in the translation system when module is bootstrapped.   
    
In project when you have translations in database you can retreive by using:

    Yii::t('<category>', '<label>');
    
Admin interface can be configured for Menu widget for example as:
    
    [
        'label' => function() { return Yii::t('yii', 'Translations control'); },
        'url' => ['/translations/admin/languages'],
        'visible' => function() { return Yii::$app->user->can('backend/translations/access'); },
        'active' => function(ActionEvent $event) {
            return strpos($event->action->getUniqueId(), 'translations/admin') === 0;
        },
        'items' => [
            [
                'label' => function() { return Yii::t('yii', 'Languages control'); },
                'url' => ['/translations/admin/languages'],
                'active' => function(ActionEvent $event) {
                    return strpos($event->action->getUniqueId(), 'languages') !== false;
                },
            ],
            [
                'label' => function() { return Yii::t('yii', 'Translations control'); },
                'url' => ['/translations/admin/translations'],
                'active' => function(ActionEvent $event) {
                    return strpos($event->action->getUniqueId(), 'admin/translations') !== false;
                },
            ]
        ]
    ]    
    
But you will need to provide the functionality to execute the inline callback methods. 
For example I use a class like MenuBehavior which has a beforeAction event and parses this configuration to
a correct Menu config.    
    
TODO: Include module for modal confirmation window
