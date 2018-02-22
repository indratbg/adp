<?php

class RptlistoftcidController extends AAdminController
{

	public $layout='//layouts/admin_column2';

	public function actionIndex()
	{
		// [AR] provide Module Name, Table Name, RptDesign Name
		//      notice that no unset attributes because it will make error !!  
		$model 		= new RptListOfTcId('LIST_OF_TC_ID','R_TC_ID_LIST','List_of_TcId.rptdesign');
		$url 		= NULL;
		
		$model->tc_date = date('d/m/Y');
		$model->client_mode = 0;
		$model->tc_status = 0;
		
		if(isset($_POST['RptListOfTcId']))
		{
			$model->attributes = $_POST['RptListOfTcId'];
			
			if($model->client_mode == 0)$model->client_cd = '%';
			if($model->tc_status == 1)$tc_status = '%';
			else {
				$tc_status = 0;
			}
					   
			if($model->validate() && $model->executeReportGenSp($tc_status) > 0 )
			{
				$url = $model->showReport();
			}
		}

		$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
		));
	}
	
	public function actionAjxGetClientList()
	{
		$resp['status']  = 'error';
		
		$client_cd = array();
		
		if(isset($_POST['tc_date']))
		{
			$tc_date = $_POST['tc_date'];
			//$tc_status = $_POST['tc_status'];
			
			//if($tc_status != 0)$tc_status = '%';
			
			$model = Ttcdoc::model()->findAll(array('select'=>'DISTINCT client_cd','condition'=>"tc_date = TO_DATE('$tc_date','DD/MM/YYYY')"));
			
			foreach($model as $row)
			{
				$client_cd[] = $row->client_cd;
			}
			$resp['status'] = 'success';
		}
		
		$resp['content'] = array('client_cd'=>$client_cd);
		echo json_encode($resp);
	}
}
