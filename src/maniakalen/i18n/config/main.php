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
        \maniakalen\i18n\Module::RULE_GROUP_BACKEND => [
            'translations/admin/index' => '{module}/admin/index',
            'translations/admin/languages' => '{module}/admin/languages',
            'translations/admin/languages-update' => '{module}/admin/languages-update',
            'translations/admin/languages-add' => '{module}/admin/languages-add',
            'translations/admin/languages-delete' => '{module}/admin/languages-delete',
        ],
        \maniakalen\i18n\Module::RULE_GROUP_FRONTEND => [
            'translations/json' => '{module}/translations/json'
        ]
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