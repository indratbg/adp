<?php

class Th2hrefheaderController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/admin_column3';

	public function actionView($id)
	{
		$model = $this->loadModel($id);

		switch($model->trx_type)
		{
			case 'CR' :
				$model->trx_type = 'AUTO CREDIT';
				break;

			case 'CO' :
				$model->trx_type = 'AUTO COLLECTION';
				break;

			case 'FT' :
				$model->trx_type = 'AUTO TRANSFER';
				break;

			case 'OT' :
				$model->trx_type = 'ONLINE TRANSFER';
				break;
		}

		switch($model->kbb_type1)
		{
			case AConstant::KBB_TYPE_AP :
				$model->kbb_type1 = 'AP';
				break;

			case AConstant::KBB_TYPE_AR :
				$model->kbb_type1 = 'AR';
				break;

			case AConstant::KBB_TYPE_TO_RDI :
				$model->kbb_type1 = 'PE TO RDI PENARIKAN (' . $model->kbb_type2 . ')';
				break;

			case AConstant::KBB_TYPE_TO_CLIENT :
				$model->kbb_type1 = 'RDI TO CLIENT (' . $model->kbb_type2 . ')';
				break;

			case 9 :
				$model->kbb_type1 = 'RDI TO CLIENT';
				break;
		}

		$model->trf_status = $model->response_date ? 'SENT' : 'WAITING';
		if (isset($_GET['success_stat']))
		{
			$model->success_stat = $_GET['success_stat'];
		}
		else
		{
			$model->success_stat = '%';
		}
		$sql = "select sum(trf_amt)total_trf_amt from t_h2h_ref_detail where trf_id='$id' ";
		$exec = DAO::queryRowSql($sql);
		$total_trf_amt = $exec['total_trf_amt'];

		$detailProvider = new CActiveDataProvider(Th2hrefdetail::model(), array(
			'criteria' => array('condition' => "trf_id = '$id' AND (status LIKE '$model->success_stat' OR '$model->success_stat' = '%')"),
			'sort' => array('defaultOrder' => 'row_id')
		));

		$this->render('view', array(
			'model' => $model,
			'detailProvider' => $detailProvider,
			'total_trf_amt' => $total_trf_amt
		));
	}

	public function actionIndex()
	{
		$model = new Th2hrefheader('search');
		$model->unsetAttributes();
		// clear any default values

		if (isset($_GET['Th2hrefheader']))
			$model->attributes = $_GET['Th2hrefheader'];
		else
		{
			//$model->trf_date_date = date('d');
			//$model->trf_date_month = date('m');
			$model->trf_date_year = date('Y');
		}

		$this->render('index', array('model' => $model, ));
	}

	public function loadModel($id)
	{
		$model = Th2hrefheader::model()->find("trf_id='$id' ");
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

}
