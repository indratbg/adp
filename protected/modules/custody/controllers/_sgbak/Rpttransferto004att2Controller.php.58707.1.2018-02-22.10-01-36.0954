<?php

class Rpttransferto004att2Controller extends AAdminController
{
    
    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rpttransferto004att2('TRANSFER_004_AT_002','R_TRANSFER_TO_004_AT_002','Transfer_to_004_at_002.rptdesign');
        $model->due_date = AConstant::getDueDate(1, date('d/m/Y'));
        $model->trx_date = AConstant::getDocDate(3, $model->due_date);
        $model->price_date = Rpttransferto004att2::getPriceDate();
  
        $url='';

        if (isset($_POST['scenario']))
        {
            $scenario = $_POST['scenario'];
            $model->attributes = $_POST['Rpttransferto004att2'];
            if ($model->validate())
            {
                if ($scenario == 'retrieve')
                {
                        if($model->executeSpRpt()>0)
                        {
                            $due_date = DateTime::createFromFormat('Y-m-d',$model->due_date)->format('d-M-Y');
                            $price_date = DateTime::createFromFormat('Y-m-d',$model->price_date)->format('d-M-Y');
                            $url = $model->showReport($due_date,$price_date) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                        }
                }
                else if ($scenario == 'process')
                {
                        if($model->executeSpTransferto004()>0)
                        {
                            Yii::app()->user->setFlash('success', 'Process successfull');
                        }
                }
            }
        }
        if(DateTime::createFromFormat('Y-m-d',$model->due_date))$model->due_date = DateTime::createFromFormat('Y-m-d',$model->due_date)->format('d/m/Y');
        if(DateTime::createFromFormat('Y-m-d',$model->trx_date))$model->trx_date = DateTime::createFromFormat('Y-m-d',$model->trx_date)->format('d/m/Y');
        if(DateTime::createFromFormat('Y-m-d',$model->price_date))$model->price_date = DateTime::createFromFormat('Y-m-d',$model->price_date)->format('d/m/Y');
        $this->render('index', array(
            'model'=>$model,
            'url'=>$url
        ));
    }

    public function actionGetAjxTrxDate()
    {
        $resp['status'] = 'error';
        if (isset($_POST['due_date']))
        {
            $due_date = $_POST['due_date'];
            $sql = "select get_doc_date(F_GET_SETTDAYS(TO_DATE('$due_date','DD/MM/YYYY')),to_date('$due_date','dd/mm/yyyy')) trx_date from dual";
            $exec = DAO::queryRowSql($sql);
            if (DateTime::createFromFormat('Y-m-d H:i:s', $exec['trx_date']))
                $exec['trx_date'] = DateTime::createFromFormat('Y-m-d H:i:s', $exec['trx_date'])->format('d/m/Y');
            $resp['trx_date'] = $exec['trx_date'];
        }

        echo json_encode($resp);
    }

}
