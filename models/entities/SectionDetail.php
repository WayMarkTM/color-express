<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "section_detail".
 *
 * @property integer $id
 * @property integer $section_id
 * @property string $formatted_text
 * @property integer $order
 * @property string $image_path
 * @property string $link_to
 * @property string $link_text
 * @property string $link_icon
 *
 * @property Section $section
 */
class SectionDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'formatted_text', 'order'], 'required'],
            [['section_id', 'order'], 'integer'],
            [['formatted_text'], 'string'],
            [['image_path', 'link_to', 'link_text', 'link_icon'], 'string', 'max' => 4000],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => 'ID Секции',
            'formatted_text' => 'Форматированный текст',
            'order' => 'Порядковый номер',
            'image_path' => 'Ссылка на изображение',
            'link_to' => 'Ссылка',
            'link_text' => 'Текст ссылки',
            'link_icon' => 'Иконка ссылки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }
}
