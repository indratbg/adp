<?php

class RptlistofpayrecvschedController extends AAdminController
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
      			AND rownum <= 11
      			ORDER BY client_cd
      			");

		foreach ($qSearch as $search)
		{
			$src[$i++] = array(
				'label' => $search['client_cd'] . ' - ' . $search['client_name'],
				'labelhtml' => $search['client_cd'],
				'value' => $search['client_cd']
			);
		}

		echo CJSON::encode($src);
		Yii::app()->end();
	}

	public function actionIndex()
	{
		$model = new Rptlistofpayrecvsched('LIST_OF_PAY_RECV_SCHED', 'R_LIST_OF_PAY_RECV_SCHED', 'List_of_Pay_Recv_Sched.rptdesign');
		$model->bgn_date = date('01/01/1996');
		$model->end_date = date('d/m/Y');
		$model->type ='0';
		$url = '';
		$url_xls = '';
		if (isset($_POST['Rptlistofpayrecvsched']))
		{
			$model->attributes = $_POST['Rptlistofpayrecvsched'];
			
			if ($model->client_cd)
			{
				$bgn_client = $model->client_cd;
				$end_client = $model->client_cd;
			}
			else
			{
				$bgn_client = '%';
				$end_client = '_';
			}
		
			if ($model->type == '0')
			{
				$type = 'TRX';
				$model->tablename = 'R_LIST_OF_PAY_RECV_SCHED_TRX';
				$model->rptname = 'List_of_pay_recv_trx.rptdesign';
			}
			else
			{
				$type = 'SETTLE';
				$model->tablename = 'R_LIST_OF_PAY_RECV_SCHED_SETT';
				$model->rptname = 'List_of_pay_recv_sett.rptdesign';
			}
			if($model->branch_cd)
			{
				$bgn_branch = $model->branch_cd;
				$end_branch = $model->branch_cd;
			}
			else 
			{
				$bgn_branch ='%';
				$end_branch = '_';
			}
			
			
			if ($model->validate() && $model->executeRpt($bgn_client, $end_client, $type, $bgn_branch, $end_branch) > 0)
			{
				$rpt_link = $model->showReport();
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}

		}
		if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
			$model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'url' => $url
		));
	}

}
