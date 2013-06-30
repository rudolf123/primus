<?php
class User extends CActiveRecord
{        
    // для капчи
    public $verifyCode;
    // для поля "повтор пароля"
    public $passwd2;
    
    public $passwdModerator;
    
    const ROLE_ADMIN = 'administrator';
    const ROLE_MODER = 'moderator';
    const ROLE_USER = 'user';
    const ROLE_BANNED = 'banned';
     
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function tableName()
    {
        return 'tbl_users';
    }
    
    public function rules()
    {
        return array(
            // логин, пароль не должны быть больше 128-и символов, и меньше трёх
            array('login, passwd', 'length', 'max'=>128, 'min' => 3),
            // логин, пароль не должны быть пустыми
            array('login', 'required','message' => 'Поле "Имя пользователя" обязательное для заполнения'),
            array('passwd', 'required','message' => 'Поле "Пароль" обязательное для заполнения'),
            array('name, surname,secondname, block,rank', 'length', 'max'=>30),
            // для сценария registration поле passwd должно совпадать с полем passwd2
            array('passwd', 'compare', 'compareAttribute'=>'passwd2', 'on'=>'registration','message' => 'Пароль подтверждения не совпадает.'),
            // правило для проверки капчи что капча совпадает с тем что ввел пользователь
            //array('verifyCode', 'captcha', 'allowEmpty'=>!extension_loaded('gd')),
            array('passwd', 'authenticate', 'on' => 'login'),
            
            array('login', 'match', 'pattern' => '/^[A-Za-z0-9А-Яа-я\s,]+$/u','message' => 'Логин содержит недопустимые символы.'),
        );
    }
    
    public function safeAttributes()
    {
        return array('login', 'passwd', 'passwd2', 'verifyCode','passwdModerator','role');
    }
    
    public function attributeLabels()
    {
        return array(
            'login'   => 'Имя пользователя для входа в систему',
            'passwd'  => 'Пароль',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'secondname' => 'Отчество',
            'block' => 'Подразделение',
            'rank' => 'Звание',
            'passwd2' => 'Подтверждение пароля',
            'passwdModerator' => 'Пароль преподавателя',
            'section'=>'Что делает?',
            'online'=>'В сети',
            'regdate'=>'Дата регистрации',
            'role'=>'Статус',
            'learningtime'=>'Время работы',
        );
    } 
    
    public function authenticate($attribute,$params) 
    {
        // Проверяем были ли ошибки в других правилах валидации.
        // если были - нет смысла выполнять проверку
         if(!$this->hasErrors())
        {
            // Создаем экземпляр класса UserIdentity
            // и передаем в его конструктор введенный пользователем логин и пароль (с формы)
            $identity= new UserIdentity($this->login, $this->passwd);
             // Выполняем метод authenticate (о котором мы с вами говорили пару абзацев назад)
            // Он у нас проверяет существует ли такой пользователь и возвращает ошибку (если она есть)
            // в $identity->errorCode
             $identity->authenticate();
                
                // Теперь мы проверяем есть ли ошибка..    
                switch($identity->errorCode)
                {
                    // Если ошибки нету...
                     case UserIdentity::ERROR_NONE: {
                        // Данная строчка говорит что надо выдать пользователю
                        // соответствующие куки о том что он зарегистрирован, срок действий
                         // у которых указан вторым параметром. 
                        Yii::app()->user->login($identity, 0);
                        break;
                    }
                    case UserIdentity::ERROR_USERNAME_INVALID: {
                         // Если логин был указан наверно - создаем ошибку
                        $this->addError('login','Пользователь не существует!');
                        break;
                    }
                     case UserIdentity::ERROR_PASSWORD_INVALID: {
                        // Если пароль был указан наверно - создаем ошибку
                        $this->addError('passwd','Вы указали неверный пароль!');
                         break;
                    }
                }
        }
    }
    
}