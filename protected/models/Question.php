<?php

/**
 * This is the model class for table "{{question}}".
 *
 * The followings are the available columns in table '{{question}}':
 * @property integer $id
 * @property string $theme
 * @property string $text
 * @property string $image
 */
class Question extends CActiveRecord
{
        public $imgfile;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Question the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{question}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('theme, text', 'required'),
			array('theme', 'length', 'max'=>255),
                        array('rate', 'numerical'),
                        array('imgfile', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, theme, text, image, rate', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'test' => array(self::BELONGS_TO, 'Test', 'test_id'),
                    //'answers' => array(self::HAS_MANY, 'Answer', 'question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Номер',
			'theme' => 'Тема',
			'text' => 'Текст вопроса',
			'image' => 'Изображение',
                        'rate' => 'Коэффициент сложности',
                        'image' => 'Графический файл',
		);
	}
        protected function beforeSave()
                {
            if(!parent::beforeSave())
                return false;
            if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/storage/questionimgs/'))
            {
                mkdir($_SERVER['DOCUMENT_ROOT'].'/storage/questionimgs/', 0777);
            };
            
            $imgfile=CUploadedFile::getInstance($this,'imgfile');
            if ($imgfile)
            {
                $this->imgfile=$imgfile;
                $id = md5(time());
                $this->imgfile->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/storage/questionimgs/'.$id.$this->imgfile);
                $this->image = $id.$this->imgfile; 
            }

            return true;
        }
        
        protected function beforeDelete(){
            if(!parent::beforeDelete())
                return false;
            
            if ($this->image)
                @unlink($_SERVER['DOCUMENT_ROOT'].'/storage/questionimgs/'.$this->image);
            
            return true;
        }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('theme',$this->theme,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('image',$this->image,true);
                $criteria->compare('rate',$this->rate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array('pageSize'=>15),
		));
	}
}