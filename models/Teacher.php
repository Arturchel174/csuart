<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property integer $id
 * @property string $teacher_sur_name
 * @property string $teacher_name
 * @property string $teacher_patronymic_name
 * @property string $teacher_phone_number
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_sur_name', 'teacher_name', 'teacher_patronymic_name'], 'string', 'max' => 255],
            [['teacher_phone_number'], 'string', 'max' => 13],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teacher_sur_name' => 'Teacher Sur Name',
            'teacher_name' => 'Teacher Name',
            'teacher_patronymic_name' => 'Teacher Patronymic Name',
            'teacher_phone_number' => 'Teacher Phone Number',
        ];
    }

    public function getFio()
    {
        $name = $this->teacher_name;
        $patronymic_name = $this->teacher_patronymic_name;
        $teacher_name =  mb_substr($name,0,1).'.';
        $teacher_patronymic_name = mb_substr($patronymic_name,0,1).'.';
        return $teacher_name.$teacher_patronymic_name.' '.$this->teacher_sur_name;
    }

    public function getTeacher()
    {
        return $this->teacher_sur_name.' '.$this->teacher_name.' '.$this->teacher_patronymic_name;
    }

    public function getTotalteacher()
    {
        $count = Visit::find()
        ->where(['teacher_id' => $this->id])
        ->count();
        $success = Visit::find()
        ->where(['teacher_id' => $this->id, 'plus_id' => 1])
        ->count();
        if($count == 0) return 'Нет информации по преподавателю.';
      else return round($success / $count, 2) * 100 . '%';
    }
}
