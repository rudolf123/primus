<?php

/**
 * This is the model class for table "{{helptree}}".
 *
 * The followings are the available columns in table '{{helptree}}':
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
class Helptree extends CActiveRecord
{
        public $image;
        public $image1;
        public $htmlfile;
        public $docfile;
        public $pdffile;
        public $imgfile;
        public $videofile;
        public $etype;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Helptree the static model class
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
		return '{{helptree}}';
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
			array('parent_id, test_id, type', 'numerical', 'integerOnly'=>true),
			array('title, url, doc, img, video, pdf', 'length', 'max'=>255),
			array('tooltip', 'length', 'max'=>100),
			array('icon', 'length', 'max'=>50),
			array('htmlfield', 'safe'),
                        array('imgfile', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
                        array('docfile', 'file', 'types'=>'doc, docx', 'allowEmpty'=>true),
                        array('pdffile', 'file', 'types'=>'pdf', 'allowEmpty'=>true),
                        array('videofile', 'file', 'types'=>'mp4', 'allowEmpty'=>true),
                        array('video', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, test_id, title, tooltip, url, icon, type, doc, img, video, pdf, htmlfield', 'safe', 'on'=>'search'),
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
			'title' => 'Название',
			'tooltip' => 'Tooltip',
			'url' => 'Url',
			'icon' => 'Icon',
                        'doc' => 'Документ Word',
			'img' => 'Графический файл',
			'video' => 'Видео файл',
			'pdf' => 'Документ PDF',
                        'type' => 'Тип',
			'htmlfield' => 'Содержание страницы(HTML)',
		);
	}
        
        protected function beforeSave(){
            if(!parent::beforeSave())
                return false;
            if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/storage/'))
            {
                mkdir($_SERVER['DOCUMENT_ROOT'].'/storage/', 0777);
            };
            
            $imgfile=CUploadedFile::getInstance($this,'imgfile');
            $docfile=CUploadedFile::getInstance($this,'docfile');
            $pdffile=CUploadedFile::getInstance($this,'pdffile');
            $videofile=CUploadedFile::getInstance($this,'videofile');
            if ($imgfile)
            {
                $this->imgfile=$imgfile;
                $this->imgfile->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/storage/'.$this->imgfile);
                $this->img = $this->imgfile; 
            }
            if ($docfile)
            {
                $this->docfile=$docfile;
                $this->docfile->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/storage/'.$this->docfile);
                $this->doc = $this->docfile;
            }
            if ($pdffile)
            {
                $this->pdffile=$pdffile;
                $this->pdffile->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/storage/'.$this->pdffile);
                $this->pdf = $this->pdffile;
            }
            if ($videofile)
            {
                $this->videofile=$videofile;
                $this->videofile->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/storage/'.$this->videofile);
                $this->video = $this->videofile;
            }
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