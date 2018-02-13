<?php

class FormbalancesheetringkasController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		$model = array();
		$modelRpt = new Rptformbalsheetringkas('FORM_NERACA_RINGKAS', 'R_FORM_BAL_SHEET_RINGKAS', 'Form_Bal_Sheet_Ringkas_Report.rptdesign');
		$valid = true;
		$success = false;
		$url = "";
		$url_xls = "";
		
		$selected = 2;
		$grp_1 = $modelRpt->p_grp = '%';
		$sql = "";
		$cancel_reason = '';
		$report_date = $modelRpt->rpt_date = date('t/m/Y');
		
		$sqlDt = "select max(ver_end_dt) tanggal from form_balance_sheet_ringkas where approved_stat = 'A'";
		$mDate = Formbalancesheetringkas::model()->findBySql($sqlDt);
		
		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'filter')
			{
				$selected = $_POST['filter'];
				$report_date = $modelRpt->rpt_date = $_POST['report_date'];
				
				switch($selected)
				{
					case 0:
						$grp_1 = '1';
						break;
					case 1:
						$grp_1 = '2';
						break;
					case 2:
						$grp_1 = '%';
						break;
				}
				
				$sql = "
					SELECT ver_bgn_dt,
					  ver_end_dt,
					  grp_1,
					  grp_2,
					  grp_3,
					  norut,
					  ringkasan_Cd,
					  line_desc,
					  catatan,
					  line_type,
					  spasi
					FROM form_balance_sheet_ringkas
					WHERE to_date('$report_date','dd/mm/yyyy') BETWEEN ver_bgn_dt AND ver_end_dt
					AND grp_1 like '$grp_1%'
					AND APPROVED_STAT = 'A'
					ORDER BY norut					
				";
				$model = Formbalancesheetringkas::model()->findAllBySql($sql);
				
				
			}
			else if($scenario == 'report')
			{
				$selected = $_POST['oldFilterCriteria'];
				$report_date = $modelRpt->rpt_date = $_POST['report_date'];
				
				switch($selected)
				{
					case 0:
						$modelRpt->p_grp = 1;
						$grp_1 = 1;
						break;
					case 1:
						$modelRpt->p_grp = 2;
						$grp_1 = 2;
						break;
					case 2:
						$modelRpt->p_grp = '%';
						$grp_1 = '%';
						break;
				}
				
				// var_dump($modelRpt->rpt_date);
				// die();
					
				if ($modelRpt->validate() && $modelRpt->excuteRpt() > 0)
				{
					$rpt_link = $modelRpt->showReport();
					$url = $rpt_link . '&&__dpi=100&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=100&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}	
			}
			else 
			{
				$selected = $_POST['oldFilterCriteria'];
				$report_date = $modelRpt->rpt_date = $_POST['report_date'];
				
				switch($selected)
				{
					case 0:
						$grp_1 = 1;
						break;
					case 1:
						$grp_1 = 2;
						break;
					case 2:
						$grp_1 = '%';
						break;
				}
				
				$rowCount = $_POST['rowCount'];
				
				$x;
				
				$save_flag = false; //False if no record is saved
				
				if(isset($_POST['cancel_reason']))
				{
					if(!$_POST['cancel_reason'])
					{
						$valid = false;
						Yii::app()->user->setFlash('error', 'Cancel Reason Must be Filled');
					}
					else
					{
						$cancel_reason = $_POST['cancel_reason'];
					}
				}
		
				for($x=0;$x<$rowCount;$x++)
				{
					$model[$x] = new Formbalancesheetringkas;
					$model[$x]->attributes = $_POST['Formbalancesheetringkas'][$x+1];
					
					// var_dump($model[0]->ver_end_dt);
					// die();
					
					if(isset($_POST['Formbalancesheetringkas'][$x+1]['save_flg']) && $_POST['Formbalancesheetringkas'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						if(isset($_POST['Formbalancesheetringkas'][$x+1]['cancel_flg']))
						{
							if($_POST['Formbalancesheetringkas'][$x+1]['cancel_flg'] == 'Y')
							{
								//CANCEL
								$model[$x]->scenario = 'cancel';
								$model[$x]->cancel_reason = $_POST['cancel_reason'];
							}
							else 
							{
								//UPDATE
								$model[$x]->scenario = 'update';
							}
						}
						else 
						{
							//INSERT
							$model[$x]->scenario = 'insert';
						}
						$valid = $model[$x]->validate() && $valid;
					}
				}
				
				$valid = $valid && $save_flag;
				
				if($valid)
				{
					$success = true;
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					for($x=0;$success && $x<$rowCount;$x++)
					{
						if($model[$x]->save_flg == 'Y')
						{
							if($model[$x]->ringkasan_cd == 'TXT'){
								$model[$x]->line_type = 'TXT';
							}else{
								$model[$x]->line_type = 'DAT';
							}
							
							// var_dump($model[0]->line_type);
							// die();
							
							if($model[$x]->cancel_flg == 'Y')
							{
								//CANCEL
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model[$x]->old_ver_end_dt,$model[$x]->old_ver_bgn_dt,$model[$x]->old_catatan,$model[$x]->old_grp_1,$model[$x]->old_grp_2,$model[$x]->old_grp_3,$model[$x]->old_line_desc,$model[$x]->old_line_type,$model[$x]->spasi,$model[$x]->old_ringkasan_cd,$model[$x]->old_norut) > 0)$success = true;
								else {
									$success = false;
								}
							}
							else if($model[$x]->old_ver_end_dt)
							{
								//UPDATE
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->old_ver_end_dt,$model[$x]->old_ver_bgn_dt,$model[$x]->old_catatan,$model[$x]->old_grp_1,$model[$x]->old_grp_2,$model[$x]->old_grp_3,$model[$x]->old_line_desc,$model[$x]->old_line_type,$model[$x]->spasi,$model[$x]->old_ringkasan_cd,$model[$x]->old_norut) > 0)$success = true;
								else {
									$success = false;
								}
							}			
							else 
							{
								//INSERT
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->ver_end_dt,$model[$x]->ver_bgn_dt,$model[$x]->catatan,$model[$x]->grp_1,$model[$x]->grp_2,$model[$x]->grp_3,$model[$x]->line_desc,$model[$x]->line_type,$model[$x]->spasi,$model[$x]->ringkasan_cd,$model[$x]->norut) > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
					}

					if($success)
					{
						$transaction->commit();
							
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/glaccounting/formbalancesheetringkas/index'));
					}
					else {
						$transaction->rollback();
					}
				}
				
			}
		}
		else {
			
			$sql = "
				SELECT ver_bgn_dt,
				  ver_end_dt,
				  grp_1,
				  grp_2,
				  grp_3,
				  norut,
				  ringkasan_Cd,
				  line_desc,
				  catatan,
				  line_type,
				  spasi
				FROM form_balance_sheet_ringkas
				WHERE to_date('$report_date','dd/mm/yyyy') BETWEEN ver_bgn_dt AND ver_end_dt
				AND grp_1 like '$grp_1%'
				AND APPROVED_STAT = 'A'
				ORDER BY norut					
			";
			
			$model = Formbalancesheetringkas::model()->findAllBySql($sql);
			
		}
		
		foreach($model as $row)
		{
			if (DateTime::createFromFormat('Y-m-d H:i:s', $row->ver_bgn_dt))
				$row->ver_bgn_dt = DateTime::createFromFormat('Y-m-d H:i:s', $row->ver_bgn_dt)->format('d/m/Y');
			if (DateTime::createFromFormat('Y-m-d H:i:s', $row->ver_end_dt))
				$row->ver_end_dt = DateTime::createFromFormat('Y-m-d H:i:s', $row->ver_end_dt)->format('d/m/Y');
			if (DateTime::createFromFormat('Y-m-d', $row->ver_bgn_dt))
				$row->ver_bgn_dt = DateTime::createFromFormat('Y-m-d', $row->ver_bgn_dt)->format('d/m/Y');
			if (DateTime::createFromFormat('Y-m-d', $row->ver_end_dt))
				$row->ver_end_dt = DateTime::createFromFormat('Y-m-d', $row->ver_end_dt)->format('d/m/Y');
			
			$row->old_norut 		= $row->norut;
			$row->old_ver_bgn_dt 	= $row->ver_bgn_dt;
			$row->old_ver_end_dt 	= $row->ver_end_dt;
			$row->old_grp_1 		= $row->grp_1;
			$row->old_grp_2 		= $row->grp_2;
			$row->old_grp_3 		= $row->grp_3;
			$row->old_spasi		 	= $row->spasi;
			$row->old_ringkasan_cd 	= $row->ringkasan_cd;
			$row->old_line_desc 	= $row->line_desc;
			$row->old_line_type 	= $row->line_type;
		
		}

		if (DateTime::createFromFormat('Y-m-d H:i:s', $mDate->tanggal))
			$mDate->tanggal = DateTime::createFromFormat('Y-m-d H:i:s', $mDate->tanggal)->format('d/m/Y');
		
		// var_dump($mDate->tanggal);
		// die();
		
		$this->render('index',array(
			'model'=>$model,
			'modelRpt'=>$modelRpt,
			'mDate'=>$mDate,
			'url'=>$url,
			'url_xls'=>$url_xls,
			'selected'=>$selected,
			'report_date'=>$report_date,
			'cancel_reason'=>$cancel_reason,
		));
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether a user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}

	public function actionAjxPopDelete($ver_end_dt,$ver_bgn_dt,$grp_1,$grp_2,$grp_3,$line_desc,$line_type,$spasi,$ringkasan_cd,$norut)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 = NULL;
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($ver_end_dt,$ver_bgn_dt,$grp_1,$grp_2,$grp_3,$line_desc,$line_type,$spasi,$ringkasan_cd,$norut);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$ver_end_dt,$ver_bgn_dt,$grp_1,$grp_2,$grp_3,$line_desc,$line_type,$spasi,$ringkasan_cd,$norut) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Balance Sheet & Profit Loss Account Entry');
					$is_successsave = true;
				}
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}

	public function loadModel($ver_end_dt,$ver_bgn_dt,$grp_1,$grp_2,$grp_3,$line_desc,$line_type,$spasi,$ringkasan_cd,$norut)
	{
		$model=Formbalancesheetringkas::model()->find("ver_end_dt = '$ver_end_dt' AND ver_bgn_dt = '$ver_bgn_dt' AND grp_1 = $grp_1 AND grp_2 = $grp_2 AND grp_3 = $grp_3 AND line_desc = $line_desc AND line_type = $line_type AND spasi = $spasi AND ringkasan_cd = $ringkasan_cd AND norut = $norut");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}