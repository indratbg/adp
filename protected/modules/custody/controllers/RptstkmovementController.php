<?php

class RptstkmovementController extends AAdminController
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
		$model = new Rptstkmovement('LIST_OF_STOCK_MVMT', 'R_STK_MOVEMENT', 'List_of_stock_movement.rptdesign');
		$sqlStk = "select  stk_cd, stk_cd||'-'||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
		$mStk = Counter::model()->findAllBySql($sqlStk);
		$url = '';
		$url_xls = '';
		
		$model->bgn_date = date('01/m/Y');
		$model->end_date = date('t/m/Y');
		$model->option_client_cd='0';
		$model->option_stk_cd='0';
		if (isset($_POST['Rptstkmovement']))
		{
			$model->attributes = $_POST['Rptstkmovement'];
			$model->s_d_type = '%';
			
			if ($model->option_client_cd=='1'){$client_cd = $model->client_cd;}else{$client_cd = '%';}
			if ($model->option_stk_cd=='1'){$p_stk_cd = $model->stk_cd;}else{$p_stk_cd = '%';}
			
			if ($model->p_type1){$type1 = 'RECV';}else{$type1 = 'X';}
			if ($model->p_type2){$type2 = 'WHDR';}else{$type2 = 'X';}
			if ($model->p_type3){$type3 = 'REREPOC';}else{$type3 = 'X';}
			if ($model->p_type4){$type4 = 'REREPOCRTN';}else{$type4 = 'X';}
			if ($model->p_type5){$type5 = 'IPO';}else{$type5 = 'X';}
			if ($model->p_typea){$typea = 'SPLIT%'; $typeb = 'REVERSE%';}else{$typea = 'X'; $typeb = 'X';}
			if ($model->p_typeb){$typec = 'HMETD%';}else{$typec = 'X';}
			if ($model->p_typec){$typed = 'EXER%';}else{$typed = 'X';}
			if ($model->p_typed){$typee = 'STKDIV%';}else{$typee = 'X';}
			if ($model->p_typee){$typef = 'TRX__';}else{$typef = 'X';}
			if ($model->p_typef){$typeg = 'DUE%';}else{$typeg = 'X';}
			if ($model->p_typeg){$typeh = 'TRX%BOND';}else{$typeh = 'X';}
			if ($model->p_typeh){$typei = '%004';}else{$typei = 'X';}
			if ($model->p_type6){$type6 = 'MERGEN';}else{$type6 = 'X';}
			
			if ($model->validate() && $model->executeRpt($client_cd, $p_stk_cd, $type1, $type2, $type3, $type4, $type5, $type6, $typea, $typeb, $typec, $typed, $typee, $typef, $typeg, $typeh, $typei) > 0)
			{
				$rpt_link = $model->showReport();
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}

		}
		// else{
// 			
		// }
		if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
			$model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'mStk' => $mStk,
			'url' => $url
		));
	}

}
