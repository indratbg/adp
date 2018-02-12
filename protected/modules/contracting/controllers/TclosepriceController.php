<?php

class TclosepriceController extends AAdminController
{
    /**
     * @var string the default layout for the views. Defaults to
     * '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/admin_column2';

    public function actionView($stk_date,$stk_cd)
    {
        $this->render('view', array('model'=>$this->loadModel($stk_date,$stk_cd), ));
    }

    public function actionCreate()
    {
        $model = new Tcloseprice;
        $model->stk_date = date('d/m/Y');

        if (isset($_POST['Tcloseprice']))
        {
            $model->attributes = $_POST['Tcloseprice'];
            if ($model->validate())
            {
                $model->user_id = Yii::app()->user->id;
                if ($model->executeSp(AConstant::INBOX_STAT_INS, $model->stk_date, $model->stk_cd) > 0)
                {
                    Yii::app()->user->setFlash('success', 'Successfully create ' . $model->stk_cd);
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('create', array('model'=>$model, ));
    }

    public function actionUpdate($stk_date, $stk_cd)
    {
        $model = $this->loadModel($stk_date, $stk_cd);

        if (isset($_POST['Tcloseprice']))
        {
            $model->attributes = $_POST['Tcloseprice'];
            if (DateTime::createFromFormat('Y-m-d H:i:s', $stk_date))
                $stk_date = DateTime::createFromFormat('Y-m-d H:i:s', $stk_date)->format('Y-m-d');
            if ($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD, $stk_date, $stk_cd) > 0)
            {
                Yii::app()->user->setFlash('success', 'Successfully update ' . $model->stk_cd);
                $this->redirect(array('index'));
            }
        }
        $this->render('update', array('model'=>$model, ));
    }

    public function actionAjxPopDelete($stk_date, $stk_cd)
    {
        $this->layout = '//layouts/main_popup';
        $is_successsave = false;

        $model = new Ttempheader();
        $model->scenario = 'cancel';
        $model1 = null;

        if (isset($_POST['Ttempheader']))
        {
            $model->attributes = $_POST['Ttempheader'];

            if ($model->validate())
            {
                $model1 = $this->loadModel($stk_date, $stk_cd);
                $model1->cancel_reason = $model->cancel_reason;
                if (DateTime::createFromFormat('Y-m-d H:i:s', $stk_date))
                    $stk_date = DateTime::createFromFormat('Y-m-d H:i:s', $stk_date)->format('Y-m-d');
                if (DateTime::createFromFormat('Y-m-d H:i:s', $model1->stk_date))
                    $model1->stk_date = DateTime::createFromFormat('Y-m-d H:i:s', $model1->stk_date)->format('Y-m-d');
                if ($model1->executeSp(AConstant::INBOX_STAT_CAN, $stk_date, $stk_cd) > 0)
                {
                    Yii::app()->user->setFlash('success', 'Successfully cancel close price ' . $model1->stk_cd);
                    $is_successsave = true;
                }
            }
        }

        $this->render('_popcancel', array(
            'model'=>$model,
            'model1'=>$model1,
            'is_successsave'=>$is_successsave
        ));
    }

    public function actionIndex()
    {
        $model = new Tcloseprice('search');
        $model->unsetAttributes();
        // clear any default values
        $model->approved_stat = 'A';
        if (isset($_GET['Tcloseprice']))
            $model->attributes = $_GET['Tcloseprice'];

        $this->render('index', array('model'=>$model, ));
    }

    public function loadModel($stk_date, $stk_cd)
    {
        if (DateTime::createFromFormat('Y-m-d H:i:s', $stk_date))
            $stk_date = DateTime::createFromFormat('Y-m-d H:i:s', $stk_date)->format('Y-m-d');
        $model = Tcloseprice::model()->find("stk_date = to_date('$stk_date','yyyy-mm-dd') and stk_cd = '$stk_cd' and approved_stat='A' ");
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
