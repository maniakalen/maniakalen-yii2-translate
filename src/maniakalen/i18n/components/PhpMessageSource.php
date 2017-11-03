<?php
/**
 * PHP Version 5.5
 *
 *  Messages translation source from database
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */

namespace maniakalen\i18n\components;

/**
 * Class PhpMessageSource
 *
 *  Messages translation source from database
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class PhpMessageSource extends \yii\i18n\PhpMessageSource
{
    /**
     * Method to prepare the translation configuration to be loaded for the currently running session
     *
     * @param string $category the translation category
     * @param string $language the translation language
     *
     * @return array
     */
    protected function getMessageFilePath($category, $language)
    {
        return [
            'category' => $category,
            'language' => $language,
            'filePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages.php',
        ];
    }

    /**
     * Loads the messages for the provided translation configuration
     *
     * @param array $messageFile the configuration for the translation group
     *
     * @return array|mixed|null
     */
    protected function loadMessagesFromFile($messageFile)
    {
        $translation = $messageFile;
        $messageFile = $translation['filePath'];
        if (is_file($messageFile)) {
            unset($translation['filePath']);
            extract($translation, EXTR_OVERWRITE);
            $messages = include $messageFile;
            if (!is_array($messages)) {
                $messages = [];
            }

            return $messages;
        }

        return null;
    }
}