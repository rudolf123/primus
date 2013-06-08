<?php
 
class QuestionForm extends CFormModel
{
 
    public $name;
    public $age;
 
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