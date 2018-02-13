<?php

class InterestprocessController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	public function actionAjxCheckPostFlg()
	{
		$rest['status'] = 'error';
		if (isset($_POST['client_cd']) && isset($_POST['bgn_date']) && isset($_POST['end_date']))
		{
			$client_cd = $_POST['client_cd'];
			$bgn_date = $_POST['bgn_date'];
			$end_date = $_POST['end_date'];

			$check = Tinterest::model()->findAll("int_dt between to_date('$bgn_date','dd/mm/yyyy') and to_date('$end_date','dd/mm/yyyy') and client_cd='$client_cd' and post_flg='Y'");

			if ($check)
			{
				$resp['post_flg'] = 'Y';
			}
			else
			{
				$resp['post_flg'] = 'N';
			}

		}

		echo json_encode($resp);
	}

	public function actionGetEndDateBourse()
	{
		$resp['status'] = 'error';
		if (isset($_POST['post_flg']) && isset($_POST['journal_date']))
		{
			$post_flg = $_POST['post_flg'];
			$journal_date = $_POST['journal_date'];
			if (DateTime::createFromFormat('d/m/Y', $journal_date))
				$journal_date = DateTime::createFromFormat('d/m/Y', $journal_date)->format('Y-m-d');
			$from_date = DateTime::createFromFormat('Y-m-d',$journal_date)->format('Y-m-01');
			$to_date = '';
			$close_date = '';
			$mmYY = DateTime::createFromFormat('Y-m-d', $journal_date)->format('Ym');
			if ($post_flg == 'calc' || $post_flg == 'view')
			{
				
				$to_date = date('Y-m-t', strtotime($journal_date));
				$close_date = $to_date;

			}
			else if ($post_flg == 'post')
			
			{
				$to_date = date('Y-m-d', strtotime($journal_date . "-1 day"));
				$close_date = date('Y-m-t',strtotime($to_date));
			}
			else if ($post_flg == 'post_end')
			{
				$to_date = date('Y-m-t', strtotime($journal_date));
				$close_date = $to_date;
				$journal_date = AConstant::getEndDateBourse($journal_date);
			}
			$resp['from_date'] = DateTime::createFromFormat('Y-m-d', $from_date)->format('d/m/Y');
			$resp['to_date'] = DateTime::createFromFormat('Y-m-d', $to_date)->format('d/m/Y');
			$resp['close_date'] = DateTime::createFromFormat('Y-m-d', $close_date)->format('d/m/Y');
			if(DateTime::createFromFormat('Y-m-d', $journal_date))$journal_date=DateTime::createFromFormat('Y-m-d',$journal_date)->format('d/m/Y');
			$resp['journal_date'] = $journal_date;
		}

		echo json_encode($resp);
	}

	public function actionGetclient()
	{
		$i = 0;
		$src = array();
		$term = strtoupper($_REQUEST['term']);
		$qSearch = DAO::queryAllSql("
				Select branch_code, client_cd, client_name, client_type_1||client_type_2||client_type_3 cl_type, client_type_3, nvl(amt_int_flg,'Y') amt_int_flg FROM MST_CLIENT 
				Where ( (client_cd like '" . $term . "%') OR (client_name like '" . $term . "%') ) 
      			AND susp_stat = 'N'
      			AND rownum <= 11
      			ORDER BY client_cd
      			");

		foreach ($qSearch as $search)
		{
			$cl_type_3 = $search['client_type_3'];
			$src[$i++] = array(
				'label' => $search['client_cd'] . ' - ' . $search['client_name'],
				'labelhtml' => $search['client_cd'],
				'value' => $search['client_cd'],
				'cl_type' => $search['cl_type'],
				'client_name' => $search['client_name'],
				'cl_desc' => Lsttype3::model()->find("cl_type3 = '$cl_type_3'")->cl_desc,
				'amt_int_flg' => $search['amt_int_flg'],
				'client_type_3' => $cl_type_3,
				'branch_cd' => trim($search['branch_code']),
			);
		}

		echo CJSON::encode($src);
		Yii::app()->end();
	}

	public function actionAjxValidateSpv()
	{
		$resp = '';
		echo json_encode($resp);
	}

	public function actionAjxValidateMonthEndSpv()
	{
		$resp = '';
		echo json_encode($resp);
	}
	public function actionAjxValidateNonSpv()
    {
        $resp = '';
        echo json_encode($resp);
    }

	public function actionIndex()
	{

		$model = new Interestprocess('INTEREST WORKSHEET', 'R_INTEREST_WORKSHEET', 'Interest_worksheet.rptdesign');
		$branch_cd = Branch::model()->findAll(array(
			'select' => "brch_cd, brch_cd ||' - '|| brch_name as brch_name",
			'condition' => "approved_stat='A' ",
			'order' => 'brch_cd'
		));
		$branch_flg = Interestprocess::cekBranch();
		$model->month = date('m');
		$model->year = date('Y');
		//$model->from_due_dt = date('01/m/Y');
		$model->journal_date=date('d/m/Y');
		
		$model->process_option = '0';
		$model->client_option = '1';
		$model->branch_option = '1';
		$model->mode_rpt = '0'; //RD 3 JANUARI 2018
		
		$success = false;
		$url = '';
		if (isset($_POST['Interestprocess']))
		{

			$model->attributes = $_POST['Interestprocess'];
			$model->scenario = 'generate';
			$ip = Yii::app()->request->userHostAddress;
			if ($ip == "::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;

			if ($model->client_option == '1')
			{
				$bgn_client = $model->client_cd;
				$end_client = $model->client_cd;
			}
			else
			{
				$bgn_client = '%';
				$end_client = '_';
			}

			if ($model->branch_option == '1')
			{
				$bgn_branch = $model->brch_cd;
				$end_branch = $model->brch_cd;
			}
			else
			{
				$bgn_branch = '%';
				$end_branch = '_';
			}
			if ($branch_flg == 'N')
			{
				$bgn_branch = '%';
				$end_branch = '_';
			}
			$cancel_posted_int = $_POST['cancel_posted_int'];
			$process_type='';
			
			//RD interest worksheet type 3 januari 2018
			if ($model->mode_rpt == '0'){
				$mode_rpt = 'ALL';
			}else if($model->mode_rpt == '1'){
				$mode_rpt = '8';
			}else{
				$mode_rpt = '10';
			}

			//CALCULATE
			if ($model->process_option == '0')
			{
			    $process_type='CALCULATE';  
				if ($model->validate())
				{

					if ($model->executeSpProsesInt($bgn_client, $bgn_branch, $cancel_posted_int) > 0)
					{
						$success = true;
						Yii::app()->user->setFlash('success', 'Interest Process the month of : ' . $model->month . ' / ' . $model->year . '  successfully process: ' . $model->client_cnt . ' client(s).');

					}
					
					if ($model->client_option == '0' && $success)
					{
						//jika ada gagal di calculate
						$sql = "SELECT COUNT(1) cnt FROM T_INTEREST_FAIL";
						$check = DAO::queryAllSql($sql);
						if ($check)
						{
							$model->rptname = 'Interest_worksheet_fail.rptdesign';
							$param 		  ='&ACC_USER_ID='.$model->vp_userid;
							$url = Constanta::URL.$model->rptname. $param.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						}
					}
					
					if ($model->client_option == '1' && $success)
					{
						$as_deposit = $model->client_type_3;

						if ($model->executeSpWorksheet($bgn_client, $end_client, $as_deposit, $bgn_branch, $end_branch, $mode_rpt) > 0)
						{
							$url = $model->showReport() . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						}
					}

				}
			}
			//POSTING
			else if ($model->process_option == '1' || $model->process_option == '3')
			{
			    
				if ($model->validate())
				{
					$month_end = $model->process_option == '1' ? 'N' : 'Y';
                    $process_type=$month_end=='N'?'POSTING':'MONTH END';
					if ($model->executeSpPostingInt($bgn_client, $end_client, $bgn_branch, $month_end) > 0)
					{
						Yii::app()->user->setFlash('success', 'Successfully posting interest ' . $model->vo_errmsg);
					}
				}

			}
			//VIEW/PRINT
			else if ($model->process_option == '2')
			{
			    $process_type='VIEW';
				if ($model->validate())
				{
					$as_deposit = $model->client_type_3 ? $model->client_type_3 : '%';

					if ($model->executeSpWorksheet($bgn_client, $end_client, $as_deposit, $bgn_branch, $end_branch, $mode_rpt) > 0)
					{
						$url = $model->showReport() . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
				}

			}
            
            //insert log
            $model->executeSpLogInterestProcess($process_type, $bgn_client, $bgn_branch);

		}

		if (DateTime::createFromFormat('Y-m-d', $model->from_due_dt))
			$model->from_due_dt = DateTime::createFromFormat('Y-m-d', $model->from_due_dt)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->to_due_dt))
			$model->to_due_dt = DateTime::createFromFormat('Y-m-d', $model->to_due_dt)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->closing_dt))
			$model->closing_dt = DateTime::createFromFormat('Y-m-d', $model->closing_dt)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->journal_date))
			$model->journal_date = DateTime::createFromFormat('Y-m-d', $model->journal_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'branch_cd' => $branch_cd,
			'branch_flg' => $branch_flg,
			'url' => $url,
		));

	}

}
