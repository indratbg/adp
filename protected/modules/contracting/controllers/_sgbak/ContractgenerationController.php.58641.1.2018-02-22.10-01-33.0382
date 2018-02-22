<?php

class ContractgenerationController extends AAdminController
{
    public function actionIndex()
    {
        $model = new Contractgeneration;
        $model->tc_date = date('d/m/Y');

        if (isset($_POST['Contractgeneration']))
        {
            $model->attributes = $_POST['Contractgeneration'];
            $valid = $model->validate(array('tc_date'));
            //	$model->cre_by = Yii::app()->user->id;
            $ip = Yii::app()->request->userHostAddress;
            if ($ip == "::1")
                $ip = '127.0.0.1';
            $model->ip_address = $ip;

            $sql = "SELECT F_APP_RUNNING_STS( 'CONGEN', 'CONGEN', NULL, NULL, NULL, NULL, NULL, NULL, 'Y') STATUS FROM DUAL";
            $check = DAO::queryRowSql($sql);
            if ($check['status'] == 'Y')
            {
                $model->addError('tc_date', 'Contract Generation sedang diproses oleh user lain');
                $valid = false;
            }

            if ($valid)
            {
                if ($model->executeSpConGen() > 0)
                {
                    if ($model->trx_cnt > 0)
                    {
                        Yii::app()->user->setFlash('success', 'Successfully create Contract Generation ' . $model->tc_date . ' with ' . $model->trx_cnt . ' transaction processed');
                    }
                    else
                    {
                        $model->addError('', 'Contract generation failed, ' . $model->trx_cnt . ' transaction processed');
                    }
                }
                $sql = "SELECT F_APP_RUNNING_STS( 'CONGEN', 'CONGEN', NULL, NULL, NULL, NULL, NULL, NULL, 'N') STATUS FROM DUAL";
                $check = DAO::queryRowSql($sql);
            }
              

        }

        $this->render('index', array(
            'model'=>$model
        ));

    }

}
