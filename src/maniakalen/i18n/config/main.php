<?php
/**
 * PHP Version 5.5
 *
 *  Module configuration
 *
 * @category Configuration
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */

return [
    'components' => [
        'translationsManager' => [
            'class' => 'maniakalen\i18n\components\TranslationsManager',
        ],
        'langsAdmin' => [
            'class' => 'maniakalen\i18n\components\LanguagesAdminManager',
        ],
        'translationsAdmin' => [
            'class' => 'maniakalen\i18n\components\TranslationsAdminManager',
        ]
    ],
    'urlRules' => [
        'translations/admin/index' => 'translations/admin/index',
        'translations/admin/languages' => 'translations/admin/languages',
        'translations/admin/languages-update' => 'translations/admin/languages-update',
        'translations/admin/languages-add' => 'translations/admin/languages-add',
        'translations/admin/languages-delete' => 'translations/admin/languages-delete',
    ],
    'container' => [
        'definitions' => [
            'yii\console\controllers\MigrateController' => [
                'class' => 'yii\console\controllers\MigrateController',
                'migrationPath' => [
                    '@yii/i18n/migrations',
                    '@translations/migrations'
                ]
            ]
        ]
    ]
];