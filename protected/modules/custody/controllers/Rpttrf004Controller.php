<?php

class Rpttrf004Controller extends AAdminController
{

	public $layout='//layouts/admin_column3';
	
	public function actionAjxGetTrxDate()
	{
		$trxDate = '';
		
		if(isset($_POST['due_date']))
		{
			$due_date = $_POST['due_date'];
			
			$sql = "SELECT TO_CHAR(GET_DOC_DATE(3,TO_DATE('$due_date','DD/MM/YYYY')),'DD/MM/YYYY') trx_date FROM dual";
			
			$result = DAO::queryRowSql($sql);
			$trxDate = $result['trx_date'];
		}
		
		echo json_encode($trxDate);
	}
	
	public function actionGetClient()
	{
		$i = 0;
	    $src=array();
	    $term = strtoupper($_POST['term']);
		
	    $qSearch = DAO::queryAllSql("
					SELECT client_cd, client_name
					FROM MST_CLIENT
					WHERE (client_cd like '".$term."%')
					AND susp_stat = 'N'
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
	
	public function actionGetStock()
	{
		$i = 0;
	    $src=array();
	    $term = strtoupper($_POST['term']);
		
	    $qSearch = DAO::queryAllSql("
					SELECT stk_cd
					FROM MST_COUNTER
					WHERE (stk_cd like '".$term."%')
					AND approved_stat = 'A'
	      			AND rownum <= 15
	      			ORDER BY stk_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$src[$i++] = array('label'=>$search['stk_cd']
	      			, 'labelhtml'=>$search['stk_cd'] //WT: Display di auto completenya
	      			, 'value'=>$search['stk_cd']);
	    }
	      
	    echo CJSON::encode($src);
	    Yii::app()->end();
	}

	public function actionIndex()
	{
		// [AR] provide Module Name, Table Name, RptDesign Name
		//      notice that no unset attributes because it will make error !!  
		$model 		= new Rpttrf004('LIST_OF_TRF_004','R_TRF_004','List_of_Trf_004.rptdesign');
		$url 		= NULL;
		
		if(isset($_POST['Rpttrf004']))
		{
			$model->attributes = $_POST['Rpttrf004'];
								   
			if($model->validate() && $model->executeReportGenSp() > 0 )
			{
				$url = $model->showReport();
				
				$format = DAO::queryRowSql("SELECT dstr1 FROM MST_SYS_PARAM WHERE param_id = 'SYSTEM' AND param_cd1 = 'DECPOINT'");
				
				if($format['dstr1'] == ',')
				{
					$url .= '&__locale=in_ID';
				}
				else 
				{
					$url .= '&__locale=en_US';
				}
				
				$url .= "&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100";
			}
		}
		else
		{
			$model->due_date = date('d/m/Y');
			
			$sql = "SELECT TO_CHAR(GET_DOC_DATE(3,TO_DATE('$model->due_date','DD/MM/YYYY')),'DD/MM/YYYY') trx_date FROM dual";
			
			$result = DAO::queryRowSql($sql);
			$model->trx_date = $result['trx_date'];
			$model->all_client_flg = $model->all_stk_flg = 'Y';
			
			$sql = "SELECT dstr1
					FROM MST_SYS_PARAM
					WHERE param_id = 'W_GEN_XML_TRX'
					AND param_cd1 = 'MODE'
					AND param_cd2 = 'JUN16'";
					
			$result = DAO::queryRowSql($sql);
			
			$model->trf_mode = $result['dstr1'];
		}

		$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
		));
	}
}