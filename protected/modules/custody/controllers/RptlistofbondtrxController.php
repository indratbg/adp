<?php

class RptlistofbondtrxController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	/*
	
		public function actionGet_ticket_no()
		{
			$resp['status']  = 'error';
			
			$ticket_no = array();
			$ticket_no_desc = array();
			
			if(isset($_POST['bgn_date']) && isset($_POST['end_date']))
			{
				$bgn_date = $_POST['bgn_date'];
				$end_date = $_POST['end_date'];
				
				$sql = "SELECT DISTINCT trx_id||'-'||SUBSTR(trx_id_yymm,5,2)||'-'||SUBSTR(trx_id_yymm,1,4) trx_ref, trx_id_yymm			
						FROM T_BOND_TRX			
						WHERE  approved_sts <> 'C'			
						AND trx_id_yymm IS NOT NULL			
						and trx_date between to_date('$bgn_date','dd/mm/yyyy') and to_date('$end_date','dd/mm/yyyy')	
						ORDER BY 2 DESC";
				$dropdown_ticket = Tbondtrx::model()->findAllBySql($sql);		
				
				foreach($dropdown_ticket as $row)
				{
					$ticket_no[] = $row->trx_id_yymm;
					$ticket_no_desc[] = $row->trx_ref;
				}
				$resp['status'] = 'success';
			}
			
			$resp['content'] = array('ticket_no'=>$ticket_no,'ticket_no_desc'=>$ticket_no_desc);
			echo json_encode($resp);
		}
		*/
	
	public function actionIndex()
    {
    	$model = new Rptlistofbondtrx('LIST_OF_BOND_TRX','R_LIST_OF_BOND_TRX','List_of_bond_transaction.rptdesign');
		$url='';
		/*
		$sql = "SELECT DISTINCT trx_id||'-'||SUBSTR(trx_id_yymm,5,2)||'-'||SUBSTR(trx_id_yymm,1,4) trx_ref, trx_id_yymm			
				FROM T_BOND_TRX			
				WHERE  approved_sts <> 'C'			
				AND trx_id_yymm IS NOT NULL			
				and trx_date between trunc(sysdate) and trunc(sysdate)			
				ORDER BY 2 DESC";
		 * 
		 */
		//$dropdown_ticket = Tbondtrx::model()->findAllBySql($sql);	
		$model->option_date = 0;	
		$model->bgn_date = date('d/m/Y');
		$model->end_date = date('d/m/Y');
		if(isset($_POST['Rptlistofbondtrx']))
		{
			$model->attributes = $_POST['Rptlistofbondtrx'];
			if($model->validate())
			{
				/*
				if($model->ticket_no_from=='' && $model->ticket_no_to =='')
								{
									$ticket_from = '%';
									$ticket_to = '_'; 
								}
								else 
								{
									$ticket_from = $model->ticket_no_from;
									$ticket_to = $model->ticket_no_to;
								}*/
				
				$option_date = $model->option_date=='0'?'T':'V';
				if($model->executeRpt($option_date)>0)
				{
					$url = $model->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
				
			}
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->bgn_date)) $model->bgn_date = DateTime::createFromFormat('Y-m-d',$model->bgn_date)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->end_date)) $model->end_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d/m/Y');
	
		
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									//'dropdown_ticket'=>$dropdown_ticket
									));
	}
}
?>