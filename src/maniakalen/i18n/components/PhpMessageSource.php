<?php
/**
 * PHP Version 5.5
 *
 *  Messages translation source from database
 *
 * @category Translations
 * @package  maniakalen\i18n
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
 * @package  maniakalen\i18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class PhpMessageSource extends \yii\i18n\PhpMessageSource
{
    private $_translations = [];
    /**
     * @param string $category
     * @param string $language
     *
     * @return array
     */
    protected function getMessageFilePath($category, $language)
    {
        $this->_translations[] = $translationSource = [
            'category' => $category,
            'language' => $language,
            'filePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'messages.php',
            ];
        return $translationSource;
    }

    /**
     * @param array $messageFile
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
            $messages = include($messageFile);
            if (!is_array($messages)) {
                $messages = [];
            }

            return $messages;
        } else {
            return null;
        }
    }
}