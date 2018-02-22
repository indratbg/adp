<?php

class RptlistofrepoController extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionGetclient()
    {
        $i = 0;
        $src = array();
        $term = strtoupper($_REQUEST['term']);
        $qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '" . $term . "%')
      			AND susp_stat = 'N'
      			AND rownum <= 11
      			ORDER BY client_cd
      			");

        foreach ($qSearch as $search)
        {
            $src[$i++] = array(
                'label'=>$search['client_cd'],
                'labelhtml'=>$search['client_cd'],
                'value'=>$search['client_cd']
            );
        }

        echo CJSON::encode($src);
        Yii::app()->end();
    }

    public function actionIndex()
    {
        $model = new Rptlistofrepo('LIST_OF_REPO', 'R_LIST_OF_REPO', 'List_of_repo.rptdesign');
        $sql = "select  stk_cd, stk_cd||'-'||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
        $stk_cd = Counter::model()->findAllBySql($sql);
        $url = '';
        $model->bgn_date = date('d/m/Y');
        $model->end_date = date('d/m/Y');
        $model->stk_option = '0';
        $model->broker_option = '0';
        $model->client_option = '0';
        if (isset($_POST['Rptlistofrepo']))
        {
            $model->attributes = $_POST['Rptlistofrepo'];
            $model->scenario = 'print';
            if ($model->validate())
            {
                if ($model->stk_option == '0')
                {
                    $bgn_stk = '%';
                    $end_stk = '_';
                }
                else
                {
                    $bgn_stk = $model->stk_cd_from;
                    $end_stk = $model->stk_cd_to;
                }
                if ($model->client_option == '0')
                {
                    $bgn_client = '%';
                    $end_client = '_';
                }
                else
                {
                    $bgn_client = $model->bgn_client;
                    $end_client = $model->end_client;
                }
                if ($model->broker_option == '0')
                {
                    $bgn_broker = '%';
                    $end_broker = '_';
                }
                else
                {
                    $bgn_broker = $model->broker_cd;
                    $end_broker = $model->broker_cd;
                }

                if ($model->executeRpt($bgn_stk, $end_stk, $bgn_client, $end_client, $bgn_broker, $end_broker) > 0)
                {
                    if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
                        $model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
                    if (DateTime::createFromFormat('Y-m-d', $model->end_date))
                        $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

                    $url = $model->showReport($model->bgn_date, $model->end_date) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                }

            }
        }

        if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
            $model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
        if (DateTime::createFromFormat('Y-m-d', $model->end_date))
            $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'stk_cd'=>$stk_cd
        ));
    }

}
?>