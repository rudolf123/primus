<?php

/**
 * This is the model class for table "{{trainingtree}}".
 *
 * The followings are the available columns in table '{{trainingtree}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $test_id
 * @property string $title
 * @property string $tooltip
 * @property string $url
 * @property string $icon
 * @property integer $type
 * @property string $doc
 * @property string $img
 * @property string $video
 * @property string $pdf
 * @property string $htmlfield
 */
class Trainingtree extends CActiveRecord
{
        public $docfile;
        public $pdffile;
        public $imgfile;
        public $videofile;
        public $programfile;
        public $etype;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Trainingtree the static model class
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
		return '{{trainingtree}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id', 'required','message'=>'Кодовое обозначение раздела - необходимое для заполнения поле'),
                        array('title', 'required','message'=>'Поле "Название" обязательное для заполнения!'),    
                        //array('id', 'unique','message'=>'запись с таким наименованием уже существует'),
			array('id, parent_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>40),
			array('tooltip', 'length', 'max'=>100),
			array('url', 'length', 'max'=>255),
			array('icon', 'length', 'max'=>50),
                        array('imgfile', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
                        array('docfile', 'file', 'types'=>'doc, docx', 'allowEmpty'=>true),
                        array('pdffile', 'file', 'types'=>'pdf', 'allowEmpty'=>true),
                        array('videofile', 'file', 'types'=>'mp4, mpeg, mov', 'allowEmpty'=>true),
                        array('programfile', 'file', 'types'=>'rar, zip, exe', 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, title, tooltip, url, icon, htmlfield', 'safe', 'on'=>'search'),

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
			'parent_id' => 'Родительский раздел',
			'test_id' => 'Test',
			'title' => 'Название',
			'tooltip' => 'Tooltip',
			'url' => 'Url',
			'icon' => 'Icon',
			'type' => 'Type',
			'doc' => 'Документ Word',
			'img' => 'Графический файл',
			'video' => 'Видео файл',
			'pdf' => 'Документ PDF',
                        'program' => 'Файл программы',
			'htmlfield' => 'Содержание страницы(HTML)',
		);
	}
        
        protected function beforeSave()
        {
            if(!parent::beforeSave())
                return false;
          //  if(($this->scenario=='insert' || $this->scenario=='update') &&
             //   ($image=CUploadedFile::getInstance($this,'image'))){
               // $this->deleteDocument(); // старый документ удалим, потому что загружаем новый

            if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/storage/'))
            {
                mkdir($_SERVER['DOCUMENT_ROOT'].'/storage/', 0777);
            };
            
            if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/storage/training/'))
            {
                mkdir($_SERVER['DOCUMENT_ROOT'].'/storage/training/', 0777);
            };
            
            $imgfile=CUploadedFile::getInstance($this,'imgfile');
            $docfile=CUploadedFile::getInstance($this,'docfile');
            $pdffile=CUploadedFile::getInstance($this,'pdffile');
            $videofile=CUploadedFile::getInstance($this,'videofile');
            $programfile=CUploadedFile::getInstance($this,'programfile');
            if ($imgfile)
            {
                $this->imgfile=$imgfile;
                $this->imgfile->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/storage/training/'.$this->imgfile);
                $this->img = $this->imgfile; 
            }
            if ($docfile)
            {
                $this->docfile=$docfile;
                $this->docfile->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/storage/training/'.$this->docfile);
                $this->doc = $this->docfile;
            }
            if ($pdffile)
            {
                $this->pdffile=$pdffile;
                $this->pdffile->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/storage/training/'.$this->pdffile);
                $this->pdf = $this->pdffile;
            }
            if ($videofile)
            {
                $this->videofile=$videofile;
                $this->videofile->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/storage/training/'.$this->videofile);
                $this->video = $this->videofile;
            }
            if ($programfile)
            {
                $this->programfile=$programfile;
                $this->programfile->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/storage/training/'.$this->programfile);
                $this->program = $this->programfile;
            }
           // }
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('test_id',$this->test_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('tooltip',$this->tooltip,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('doc',$this->doc,true);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('video',$this->video,true);
		$criteria->compare('pdf',$this->pdf,true);
		$criteria->compare('htmlfield',$this->htmlfield,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}