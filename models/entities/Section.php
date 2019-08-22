<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "section".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $title
 * @property integer $order
 *
 * @property SectionType $type
 * @property SectionDetail[] $sectionDetails
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'title', 'order'], 'required'],
            [['type_id', 'order'], 'integer'],
            [['title'], 'string', 'max' => 4000],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SectionType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Тип',
            'title' => 'Заголовок',
            'order' => 'Порядковый номер',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(SectionType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionDetails()
    {
        return $this->hasMany(SectionDetail::className(), ['section_id' => 'id']);
    }
}
