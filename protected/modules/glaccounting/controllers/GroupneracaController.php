<?php

class GroupneracaController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		$model = array();
		$modelRpt = new Rptmapneracaringkas('GROUP_NERACA', 'R_MST_MAP_NERACA_RINGKAS', 'Group_Neraca_Report.rptdesign');
		$valid = true;
		$success = false;
		$url = "";
		$url_xls = "";
		
		$selected = 2;
		$grp_1 = $modelRpt->p_grp = '%';
		$sql = "";
		$cancel_reason = '';
		
		$sqlGla = " SELECT TRIM(GL_A) GL_A, GL_A||' '||ACCT_NAME ACCT_NAME FROM MST_GL_ACCOUNT WHERE SL_A = '000000' ORDER BY GL_A " ;
		$sqlRc = " SELECT RINGKASAN_CD, RINGKASAN_CD||' '||LINE_DESC LINE_DESC FROM FORM_BALANCE_SHEET_RINGKAS WHERE RINGKASAN_CD NOT IN ('TXT','SUM2','SUM3') AND APPROVED_STAT = 'A' ORDER BY NORUT" ;
		
		$mGla = Glaccount::model()->findAllBySql($sqlGla);
		$mRingkasan_cd = Formbalancesheetringkas::model()->findAllBySql($sqlRc);
		
		$sqlDt = "select max(ver_end_dt) tanggal from mst_map_neraca_ringkas where approved_stat = 'A'";
		$mDate = Groupneraca::model()->findBySql($sqlDt);

		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'filter')
			{
				$selected = $_POST['filter'];
				
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
					SELECT r.ver_bgn_dt,
					  r.ver_end_dt,
					  r.grp_1,
					  r.gl_acct_cd,
					  g.acct_name,
					  r.ringkasan_cd,
					  f.line_desc,
					  r.norut
					FROM MST_MAP_NERACA_RINGKAS R,
					  mst_gl_account G,
					  form_balance_sheet_ringkas f
					WHERE trim(r.gl_acct_Cd) = trim(g.gl_a)
					AND r.approved_stat      = 'A'
					AND g.sl_A               = '000000'
					AND r.ringkasan_cd       = f.ringkasan_cd(+)
					AND r.grp_1				 like '$grp_1'
					ORDER BY r.norut					
				";
				$model = Groupneraca::model()->findAllBySql($sql);
			}
			else if($scenario == 'report')
			{
				$selected = $_POST['oldFilterCriteria'];
				
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
					$model[$x] = new Groupneraca;
					$model[$x]->attributes = $_POST['Groupneraca'][$x+1];
					
					// if($x==1){
					// var_dump($model[$x]->ver_bgn_dt);
					// die();
					// }
					
					if(isset($_POST['Groupneraca'][$x+1]['save_flg']) && $_POST['Groupneraca'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						if(isset($_POST['Groupneraca'][$x+1]['cancel_flg']))
						{
							if($_POST['Groupneraca'][$x+1]['cancel_flg'] == 'Y')
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
					// if($x==1){
					// var_dump($model[$x]->ver_bgn_dt);
					// die();
					// }
					
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
							// var_dump($model[$x]->ver_end_dt);
							// die();
							
							if($model[$x]->cancel_flg == 'Y')
							{
								//CANCEL
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model[$x]->old_ver_end_dt,$model[$x]->old_ver_bgn_dt,$model[$x]->old_grp_1,$model[$x]->old_gl_acct_cd,$model[$x]->old_ringkasan_cd,$model[$x]->old_norut) > 0)$success = true;
								else {
									$success = false;
								}
							}
							else if($model[$x]->old_ver_end_dt)
							{
								//UPDATE
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->old_ver_end_dt,$model[$x]->old_ver_bgn_dt,$model[$x]->old_grp_1,$model[$x]->old_gl_acct_cd,$model[$x]->old_ringkasan_cd,$model[$x]->old_norut) > 0)$success = true;
								else {
									$success = false;
								}
							}			
							else 
							{
								//INSERT
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->ver_end_dt,$model[$x]->ver_bgn_dt,$model[$x]->grp_1,$model[$x]->gl_acct_cd,$model[$x]->ringkasan_cd,$model[$x]->norut) > 0)$success = true;
								else {
									$success = false;
								}
							}
							// if(DateTime::createFromFormat('Y-m-d',$model[$x]->ver_bgn_dt))$model[$x]->ver_bgn_dt = DateTime::createFromFormat('Y-m-d', $model[$x]->ver_bgn_dt)->format('d/m/Y');
							// if(DateTime::createFromFormat('Y-m-d',$model[$x]->ver_end_dt))$model[$x]->ver_end_dt = DateTime::createFromFormat('Y-m-d', $model[$x]->ver_end_dt)->format('d/m/Y');
						}

					}

					if($success)
					{
						$transaction->commit();
							
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/glaccounting/groupneraca/index'));
					}
					else {
						$transaction->rollback();
					}	
				}
			}
		}
		else {
			
			$sql = "
				SELECT r.ver_bgn_dt,
				  r.ver_end_dt,
				  r.grp_1,
				  r.gl_acct_cd,
				  g.acct_name,
				  r.ringkasan_cd,
				  f.line_desc,
				  r.norut
				FROM MST_MAP_NERACA_RINGKAS R,
				  mst_gl_account G,
				  form_balance_sheet_ringkas f
				WHERE trim(r.gl_acct_Cd) = trim(g.gl_a)
				AND r.approved_stat      = 'A'
				AND g.sl_A               = '000000'
				AND r.ringkasan_cd       = f.ringkasan_cd(+)
				AND r.grp_1				 like '$grp_1'
				ORDER BY r.norut					
			";
			
			$model = Groupneraca::model()->findAllBySql($sql);
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
			$row->old_gl_acct_cd 	= $row->gl_acct_cd;
			$row->acct_name 		= $row->acct_name;
			$row->old_ringkasan_cd 	= $row->ringkasan_cd;
			$row->line_desc 		= $row->line_desc;
		}
		
		if (DateTime::createFromFormat('Y-m-d H:i:s', $mDate->tanggal))
			$mDate->tanggal = DateTime::createFromFormat('Y-m-d H:i:s', $mDate->tanggal)->format('d/m/Y');

		$this->render('index',array(
			'model'=>$model,
			'modelRpt'=>$modelRpt,
			'url'=>$url,
			'url_xls'=>$url_xls,
			'mGla'=>$mGla,
			'mDate'=>$mDate,
			'mRingkasan_cd'=>$mRingkasan_cd,
			'selected'=>$selected,
			'cancel_reason'=>$cancel_reason,
		));
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether a user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}

	public function actionAjxPopDelete($ver_end_dt,$ver_bgn_dt,$grp_1,$gl_acct_cd,$ringkasan_cd,$norut)
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
				
				$model1    				= $this->loadModel($ver_end_dt,$ver_bgn_dt,$grp_1,$gl_acct_cd,$ringkasan_cd,$norut);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$ver_end_dt,$ver_bgn_dt,$grp_1,$gl_acct_cd,$ringkasan_cd,$norut) > 0){
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

	public function loadModel($ver_end_dt,$ver_bgn_dt,$grp_1,$gl_acct_cd,$ringkasan_cd,$norut)
	{
		$model=Groupneraca::model()->find("ver_end_dt = '$ver_end_dt' AND ver_bgn_dt = '$ver_bgn_dt' AND grp_1 = $grp_1 AND gl_acct_cd = $gl_acct_cd AND ringkasan_cd = $ringkasan_cd AND norut = $norut");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
