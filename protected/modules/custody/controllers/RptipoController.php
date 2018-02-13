<?php

class RptipoController extends AAdminController
{

	public $layout='//layouts/admin_column3';
	
	public function actionAjxGetPaymentDt()
	{
		$paymentDt = '';
		
		if(isset($_POST['stk_cd']))
		{
			$stk_cd = $_POST['stk_cd'];
			
			$sql = "SELECT TO_CHAR(paym_dt,'DD/MM/YYYY') paym_dt FROM T_PEE WHERE stk_cd = '$stk_cd'";
			
			$result = DAO::queryRowSql($sql);
			$paymentDt = $result['paym_dt'];
		}
		
		echo json_encode($paymentDt);
	}
	
	public function actionGetClient()
	{
		$i = 0;
	    $src=array();
	    $term = strtoupper($_POST['term']);
		$stk_cd = $_POST['stk_cd'];
		
	    $qSearch = DAO::queryAllSql("
					SELECT a.client_cd, client_name
					FROM T_IPO_CLIENT a 
					JOIN MST_CLIENT b ON a.client_cd = b.client_cd
					WHERE (a.client_cd like '".$term."%')
					AND stk_cd = '$stk_cd'
					AND susp_stat = 'N'
					AND a.approved_stat = 'A'
	      			AND rownum <= 15
	      			ORDER BY client_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$src[$i++] = array('label'=>$search['client_cd']. ' - '.$search['client_name']
	      			, 'labelhtml'=>$search['client_cd']. ' - '.$search['client_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['client_cd']);
	    }
	      
	    echo CJSON::encode($src);
	    Yii::app()->end();
	}

	public function actionIndex()
	{
		// [AR] provide Module Name, Table Name, RptDesign Name
		//      notice that no unset attributes because it will make error !!  
		$model 		= new Rptipo('LIST_OF_IPO','R_IPO_LIST','');
		$url 		= NULL;
		$url_xls	= '';
		$model->hiddenbuttonxls=0;
		$model->qty_flg='0';
		if(isset($_POST['Rptipo']))
		{
			$model->attributes = $_POST['Rptipo'];
			
			if($model->report_type == 1)
			{
				$model->rptname = 'List_of_IPO_Invoice.rptdesign';
			}
			else
			{
				$model->rptname = 'List_of_IPO.rptdesign';
			}
			
			if($model->brch_opt == 1)$model->brch_cd = '%';
			if($model->client_from == '')$model->client_from = '%';
			if($model->client_to == '')$model->client_to = '_';
            $model->qty_flg=$model->qty_flg?$model->qty_flg:'0';
			if($model->validate() && $model->executeReportGenSp() > 0 )
			{
				$url = $model->showReport();
				$url_xls = $url.'&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url .= "&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100";
			}
			
			if($model->client_from == '%')$model->client_from = '';
			if($model->client_to == '_')$model->client_to = '';
			$model->hiddenbuttonxls=1;
		}
		else
		{
			$model->report_type = $model->brch_opt = 1;
		}

		$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
			'url_xls'=> $url_xls,
		));
	}
}