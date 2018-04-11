<?php
/**
 * Created by PhpStorm.
 * User: Artur Khamidulin
 * Date: 02.04.2018
 * Time: 22:51
 */

namespace app\controllers;

use app\models\Students;
use yii\web\Controller;
use app\models\form\FirstForm;
use app\models\Group;
use app\models\Plus;
use app\models\Visit;
use app\models\Teacher;
use app\models\Subject;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;


class MainController extends Controller
{

    public function actionIndex()
    {

        if(Yii::$app->request->isAjax)
        {
            var_dump(Yii::$app->request->post());
            return 'index';
        }
        $model = new FirstForm;



        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()){
                Yii::$app->session->setFlash('success', 'Данные приняты');
                return $this->refresh();
            }else{
                Yii::$app->session->setFlash('error', 'Ошибка');
            }

        }


        $this->view->title = 'Форма';
        return $this->render('index', [

            'model' => $model,

        ]);

    }

    public function actionGet()
    {
     
        $items = $_POST['FirstForm'];
        $teacher = $items['teacher'];
        $group = $items['group'];
        $subject = $items['subject'];
        $date = $items['date'];
        $visits = [];
        $group_table = Group::findOne($group);
        $teacher_table = Teacher::findOne($teacher);
        $subject_table = Subject::findOne($subject);
        $student_table = $group_table->students;

		  $test = Students::find()->all();

        foreach ($student_table as $value)
        {
            $visit = new Visit();
            $visit->students_id = $value->id;
            $visit->teacher_id = $teacher;
            $visit->subject_id = $subject;
            $visit->date = $date;
            $visits[] = $visit;
        }

		  Yii::$app->session->open();
		  Yii::$app->session->set('visit', $test);
		   
        return $this->render('get', [
            'items' => $items, 'group' => $group_table, 'subject' => $subject_table, 'teacher' => $teacher_table, 'date' => $date,
            'student' => $student_table, 'visit' => $visit, 'visits' => $visits,
        ]);
    }
   public function actionCreate()
   {
   	$i = 0;
        $model = $_POST['Visit'];
        $visit = [];
        
        $test = Yii::$app->session->get('visit');
        Yii::$app->session->destroy();
        
        $data = [];
        $students = Students::find()->all();
        $pluses = Plus::find()->all();        
        foreach ($model as $value)
        {
            $visit = new Visit;
            $visit->students_id = $value['students_id'];
            $data[$i]['fio'] = Students::findOne($visit->students_id)->fio;
            $visit->teacher_id = $value['teacher_id'];
            $visit->subject_id = $value['subject_id'];
            $visit->date = $value['date'];
            $visit->plus_id = $value['plus_id'];
            $data[$i]['plus'] = Plus::findOne($visit->students_id)->operation;
            $visit->save();
            $i++;
        }
		  
        return $this->render('create', [
            'visit' => $visit,
            'data' => $data,
            'test' => $test
        ]);
    }
}
