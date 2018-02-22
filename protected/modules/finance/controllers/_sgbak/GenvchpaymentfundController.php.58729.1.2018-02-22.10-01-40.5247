<?php

Class GenvchpaymentfundController extends AAdminController
{
    public $layout = '//layouts/admin_column3';
    public $menuName = 'GENERATE VOUCHER PAYMENT FUND';

    public function actionGetclient()
    {
        $i = 0;
        $src = array();
        $term = strtoupper($_REQUEST['term']);
        $custody_flg = isset($_POST['custody_flg']) ? $_POST['custody_flg'] : 'N';
        $qSearch = DAO::queryAllSql("
              select a.client_cd, b.client_name from fund_client_master a, mst_client b
              where a.client_cd=b.client_cd
                and  (b.client_cd like '" . $term . "%')
                AND rownum <= 30
                ORDER BY a.client_cd
                ");

        foreach ($qSearch as $search)
        {
            $src[$i++] = array(
                'label'=>$search['client_cd'] . ' - ' . $search['client_name'],
                'labelhtml'=>$search['client_cd'],
                'value'=>$search['client_cd']
            );
        }

        echo CJSON::encode($src);
        Yii::app()->end();
    }

    public function actionIndex()
    {
        $model = new Genvchpaymentfund();
        $modelDetail = Genvchpaymentfund::model()->findAllBySql(Genvchpaymentfund::getVoucherKBBFundSql(date('d/m/Y'),'%', '%'));
        $branch = Branch::model()->findAll(array(
            'select'=>"brch_cd||' - '||brch_name brch_name,brch_cd",
            'condition'=>"approved_stat='A'",
            'order'=>'brch_cd'
        ));
        $model->doc_date=date('d/m/Y');
        $valid = true;
        $success = true;

        if (isset($_POST['Genvchpaymentfund']) && isset($_POST['scenario']))
        {
            $model->attributes = $_POST['Genvchpaymentfund'];
            $scenario = $_POST['scenario'];
            if ($scenario == 'retrieve')
            {
                $client_cd = $model->client_cd ? $model->client_cd : '%';
                $branch_code = $model->branch_code ? $model->branch_code : '%';
                
                $modelDetail = Genvchpaymentfund::model()->findAllBySql(Genvchpaymentfund::getVoucherKBBFundSql($model->doc_date,$client_cd, $branch_code));
                if (!$modelDetail)
                {
                    Yii::app()->user->setFlash('danger', 'No data found');
                }
            }
            else
            {
                $rowCount = $_POST['rowCount'];

                for ($x = 1; $x <= $rowCount; $x++)
                {
                    $modelDetail[$x] = new Genvchpaymentfund;
                    $modelDetail[$x]->attributes = $_POST['Genvchpaymentfund'][$x];
                    if ($modelDetail[$x]->save_flg == 'Y')
                    {
                        $modelDetail[$x]->scenario = 'fund';
                        $modelDetail[$x]->doc_date = $model->doc_date;
                        $valid = $valid && $modelDetail[$x]->validate();
                    }
                }
                if ($valid)
                {
                    $connection = Yii::app()->db;
                    $transaction = $connection->beginTransaction();

                    for ($x = 1; $x <= $rowCount; $x++)
                    {
                        if ($modelDetail[$x]->save_flg == 'Y')
                        {
                            //call SP
                            $client_cd = $modelDetail[$x]->client_cd;
                            $branch_code = $modelDetail[$x]->branch_code;
                            if ($modelDetail[$x]->executeSpVchFund($client_cd, $branch_code) > 0)
                                $success = true;
                            else
                            {
                                $success = false;
                            }
                        }
                    }
                    if ($success)
                    {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'Generate Voucher Successfully');
                        $this->redirect(array('index'));
                    }
                    else
                    {
                        $transaction->rollback();
                    }
                }

            }
        }

        $this->render('index', array(
            'model'=>$model,
            'modelDetail'=>$modelDetail,
            'branch'=>$branch
        ));
    }

}
