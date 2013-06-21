<?php

/**
 * This is the model class for table "{{testtree}}".
 *
 * The followings are the available columns in table '{{testtree}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $test_id
 * @property string $title
 * @property string $tooltip
 * @property string $url
 * @property string $icon
 */
class Testtree extends CActiveRecord
{
        public $etype;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Testtree the static model class
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
		return '{{testtree}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
                        array('time', 'required'),
			array('time', 'numerical', 'integerOnly'=>true),
			array('parent_id, test_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>250),
			array('tooltip', 'length', 'max'=>100),
			array('url', 'length', 'max'=>255),
			array('icon', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, test_id, title, type, tooltip, url, icon', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'test_id' => 'Test',
			'title' => 'Название',
                        'time'=>'Время на выполнение',
			'tooltip' => 'Tooltip',
			'url' => 'Url',
			'icon' => 'Icon',
		);
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('test_id',$this->test_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('tooltip',$this->tooltip,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('icon',$this->icon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}