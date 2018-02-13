<?php

class IpbankController extends AAdminController
{
    /**
     * @var string the default layout for the views. Defaults to
     * '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/admin_column2';

    public function actionView($id)
    {
        $this->render('view', array('model'=>$this->loadModel($id), ));
    }

    public function actionCreate()
    {
        $model = new Ipbank;
        if (isset($_POST['Ipbank']))
        {
            $model->attributes = $_POST['Ipbank'];
            if ($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS, $model->bank_cd) > 0)
            {
                Yii::app()->user->setFlash('success', 'Successfully create ' . $model->bank_cd);
                $this->redirect(array('index'));

            }
        }

        $this->render('create', array('model'=>$model, ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['Ipbank']))
        {
            $model->attributes = $_POST['Ipbank'];
            if ($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD, $id) > 0)
            {
                Yii::app()->user->setFlash('success', 'Successfully update ' . $model->bank_cd);
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array('model'=>$model,));
    }

    public function actionIndex()
    {
        $model = new Ipbank('search');
        $model->unsetAttributes();
        // clear any default values
        $model->approved_stat = 'A';
        if (isset($_GET['Ipbank']))
            $model->attributes = $_GET['Ipbank'];

        $this->render('index', array('model'=>$model, ));
    }

    public function actionAjxPopDelete($id)
    {
        $this->layout = '//layouts/main_popup';
        $is_successsave = false;

        $model1 = NULL;
        $model = new Ttempheader();
        $model->scenario = 'cancel';

        if (isset($_POST['Ttempheader']))
        {
            $model->attributes = $_POST['Ttempheader'];

            if ($model->validate())
            {

                $model1 = $this->loadModel($id);
                $model1->cancel_reason = $model->cancel_reason;

                if ($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN, $id) > 0)
                {
                    Yii::app()->user->setFlash('success', 'Successfully cancel ' . $id);
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

    public function loadModel($id)
    {
        $model = Ipbank::model()->find("bank_cd='$id'");
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
