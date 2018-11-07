<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 07/11/2018
 * Time: 15:44
 */

namespace maniakalen\i18n\components;


use yii\db\Query;

class TranslationsManager
{
    /**
     * @param $category
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function getCurrentMessagesForCategory($category)
    {
        $result = [];
        /** @var Query $query */
        $query = \Yii::createObject(['class' => 'yii\db\Query']);
        foreach ($query->from(['sm' => 'source_message'])
            ->innerJoin(['m' => 'message'], 'sm.id = m.id')
            ->where(['category' => $category, 'language' => \Yii::$app->language])
            ->select(['sm.category', 'sm.message', 'm.translation'])
                     ->createCommand()
                     ->queryAll(\PDO::FETCH_OBJ) as $item) {
            $result[$item->category][$item->message] = $item->translation;
        }

        return $result;
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function getCurrentMessages()
    {
        $result = [];
        /** @var Query $query */
        $query = \Yii::createObject(['class' => 'yii\db\Query']);
        foreach ($query->from(['sm' => 'source_message'])
                     ->innerJoin(['m' => 'message'], 'sm.id = m.id')
                     ->where(['language' => \Yii::$app->language])
                     ->select(['sm.category', 'sm.message', 'm.translation'])
                     ->createCommand()
                     ->queryAll(\PDO::FETCH_OBJ) as $item) {
            $result[$item->category][$item->message] = $item->translation;
        }

        return $result;
    }
}