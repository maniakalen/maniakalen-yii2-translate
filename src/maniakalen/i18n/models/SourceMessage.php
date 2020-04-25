<?php

/**
 * PHP Version 5.5
 *
 *  This is the model class for table "source_message".
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     LINK
 */

namespace maniakalen\i18n\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\AfterSaveEvent;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "source_message".
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Message[] $translationsTexts
 */
class SourceMessage extends \yii\db\ActiveRecord
{
    /**
     * Returns table name of the table associated
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%source_message}}';
    }

    /**
     * Returns an array of property rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['category'], 'string', 'max' => 255],
            [['message'], 'safe'],
        ];
    }

    /**
     * Returns an array of property labels
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => \Yii::t('mi18n', 'Category'),
            'message' => \Yii::t('mi18n', 'Label'),
        ];
    }

    /**
     * Returns related translation texts. Returs ActiveQuery if called as method and TranslationsTexts[] if called as
     * property
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslationsTexts()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }

    /**
     * Returns a query union to get listing with message data for all languages
     *
     * @return Query
     */
    public function getAllMessages()
    {
        $unionQuery = \Yii::createObject(Query::className());
        $unionQuery
            ->select(
                [
                    'id' => new Expression('NULL'),
                    'language' => 'language_code',
                    'translation' => new Expression('NULL')
                ]
            )
            ->from(['l' => Languages::tableName()]);
        /** @var Query $query */
        $query = \Yii::createObject(Query::className());
        $query
            ->select(['id', 'language', 'translation'])
            ->from(['m' => 'message'])
            ->where(['id' => $this->id])
            ->union($unionQuery, true);

        /** @var Query $finalQuery */
        $finalQuery = \Yii::createObject(ActiveQuery::className(), [Message::className()]);
        $finalQuery
            ->select(['sub.id', 'sub.language', 'sub.translation'])->from(['sub' => $query])->groupBy(['language'])
            ->leftJoin(['ll' => Languages::tableName()], 'sub.language = ll.language_code')
            ->orderBy(['ll.id' => SORT_ASC])->multiple = true;

        return $finalQuery;
    }

    public function getMessageForLanguage($language_code)
    {
        static $messages = null;
        if ($messages === null) {
            $messages = $this->allMessages;
        }

        foreach ($messages as $msg) {
            if ($msg->language == $language_code) {
                if (!$msg->id) {
                    $msg->isNewRecord = true;
                    $msg->id = $this->id;
                }
                return $msg;
            }
        }

        return null;
    }

    /**
     * This method is used when the object is provided as filter for GridView
     *
     * @param array $params an array of input params to filter by
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find()->groupBy(['category', 'message']);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'category' => $this->category?:null,
                'message' => $this->message?:null,
            ]
        );

        return $dataProvider;
    }
}
