<?php

namespace app\modules\admin\models;

use app\models\entities\File;
use app\models\entities\Section;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class SectionDetailForm extends BaseImageForm {
  public $id;
  public $section_id;
  public $formatted_text;
  public $order;
  public $image_path;
  public $link_to;
  public $link_text;
  public $link_icon;
  public $isNewRecord;

  public function rules()
  {
      return [
          [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
          [['section_id', 'formatted_text', 'order'], 'required'],
          [['section_id', 'order'], 'integer'],
          [['formatted_text'], 'string'],
          [['image_path', 'link_to', 'link_text', 'link_icon'], 'string', 'max' => 4000],
          [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
          [['id'], 'number']
      ];
  }

  public function attributeLabels()
  {
      return [
          'imageFile' => 'Изображение',
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
}