<?php

/**
 * This is the model class for table "{{userloganswershelp}}".
 *
 * The followings are the available columns in table '{{userloganswershelp}}':
 * @property integer $id
 * @property integer $question_id
 * @property integer $answer_id
 * @property integer $userlog_id
 * @property integer $isright
 * @property string $question_text
 * @property string $answer_text
 * @property string $right_answer
 */
class Userloganswershelp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Userloganswershelp the static model class
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
		return '{{userloganswershelp}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question_id, answer_id, userlog_id', 'required'),
			array('question_id, answer_id, userlog_id, isright', 'numerical', 'integerOnly'=>true),
			array('question_text, answer_text, right_answer', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, question_id, answer_id, userlog_id, isright, question_text, answer_text, right_answer', 'safe', 'on'=>'search'),
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
			'question_id' => 'Question',
			'answer_id' => 'Answer',
			'userlog_id' => 'Userlog',
			'isright' => 'Верный',
			'question_text' => 'Текст вопроса',
			'answer_text' => 'Вы ответили',
			'right_answer' => 'Правильный ответ',
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
		$criteria->compare('question_id',$this->question_id);
		$criteria->compare('answer_id',$this->answer_id);
		$criteria->compare('userlog_id',$this->userlog_id);
		$criteria->compare('isright',$this->isright);
		$criteria->compare('question_text',$this->question_text,true);
		$criteria->compare('answer_text',$this->answer_text,true);
		$criteria->compare('right_answer',$this->right_answer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}