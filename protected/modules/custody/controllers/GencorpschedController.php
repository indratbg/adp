<?php

class GencorpschedController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Gencorpsched;
        $model->doc_dt=date('d/m/Y');
        if(isset($_POST['Gencorpsched']))
        {
            $model->attributes = $_POST['Gencorpsched'];
            
            $stk_cd = $model->stk_cd?$model->stk_cd:'%';
            $ca_type = $model->ca_type?$model->ca_type:'%';
            if($model->validate() && $model->executeSpCaJurManual($stk_cd, $ca_type)>0)
            {
                Yii::app()->user->setFlash('success','Corporate action berhasil digenerate');
            }
        }
        $this->render('index',array('model'=>$model));
    }
}
