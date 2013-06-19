<?php
 
class QuestionForm extends CFormModel
{
 
    public $name;
    public $age;
    public $answers = array();
    public $answersmulti = array();
    public $answerscomp = array();
    public $test_id;
 
    public function rules()
    {
        return array(
 
               );
    }
 
    public function attributeLabels()
    {
        return array(
            'name'=>'Name',
            'age'=>'Age',
        );
    }
 
}
 
?>