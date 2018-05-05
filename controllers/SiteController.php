<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\Group;
use app\models\Students;
use app\models\Subject;
use app\models\Teacher;
use app\models\Visit;
use app\models\Plus;
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }



    public function actionSubjectTable(){
          $subject = Subject::find()
             ->select(['subject', 'id'])
             ->indexBy('id')
             ->column();
        return $this->render('subject-table', ['subject' => $subject, 'post_id']);
    }



    public function actionSubjectTableStat($id = null,$ids=1){
      $subject = Subject::find()
             ->select(['subject', 'id'])
             ->indexBy('id')
             ->column();
      $subjectstat = Subject::findOne($ids);
      return $this -> render('subject-table-stat', compact('subjectstat','id','subject'));
    }

    public function actionTeacherTable(){
        $teacher = Teacher::find()
         ->select(["CONCAT(teacher_sur_name, ' ',teacher_name, ' ',teacher_patronymic_name)", 'id'])
         ->indexBy('id')
         ->column();
        return $this->render('teacher-table', ['teacher' => $teacher]);
    }
    public function actionTeacherTableStat($id = null,$ids=1){
      $teacher = Teacher::find()
             ->select(["CONCAT(teacher_sur_name, ' ',teacher_name, ' ',teacher_patronymic_name)", 'id'])
             ->indexby('id')
             ->column();
      $teacherstat= Teacher::findOne($ids);
      return $this -> render('teacher-table-stat', compact('teacherstat','id','teacher'));
    }



    public function actionGroupTable(){
         $group = Group::find()
             ->select(['group', 'id'])
             ->indexBy('id')
             ->column();
        return $this->render('group-table', ['group' => $group]);
    }



   public function actionGroupStudentTable($id = null,$ids=1){
     $student = Students::find()
             ->where(['group_id' => $id,])->all();
     $group = Group::find()
             ->select(['group', 'id'])
             ->indexBy('id')
             ->column();
     return $this -> render('group-student-table', compact('student','id','group'));
   }



   public function actionGroupStudentTableStat($id = null, $ids=1)
   {
     $student =  Students::find()
             ->where(['group_id' => $id,])
             ->all();
     $studentstat = Students::findOne($ids);
     $group = Group::find()
             ->select(['group','id'])
             ->indexBy('id')
             ->column();
     return $this -> render ('group-student-table-stat', compact('studentstat','student','id','group'));
   }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model,]);
    }


    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){

            return $this->render('entry-confirm', compact('model'));
        } else {
            return $this->render('entry', compact('model'));
        }
    }

}
