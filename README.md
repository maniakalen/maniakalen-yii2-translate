# yii2-translations
PHP db translations engine


The package is also available in packagist: "maniakalen/yii2-translations"

To enable the module inside the yii2 you need to define the module in the main config module part:

    'translations' => [
        'class' => 'maniakalen\i18n\Module'
    ],
    
You also need to add the module key to the bootstrap list:
    
    'bootstrap' => [..., 'translations'],

Then you will need to run the module migrations

    yii migrate/up --migrationPath="@translations/migrations/"
    
And finally you will need to define a translation source like:

    '<category>' => ['class' => 'maniakalen\i18n\components\PhpMessageSource']
    
In project when you have translations in database you can retreive by using:

    Yii::t('<category>', '<label>');
    
    
TODO: Back-end UI for managing translations