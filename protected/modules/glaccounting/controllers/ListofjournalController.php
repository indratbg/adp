<?php

class ListofjournalController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$modeldetail = array();
		$model = new Rptlistofjournal('List_of_journal', 'R_LIST_OF_JOURNAL', 'List_of_journal.rptdesign');
		$model->jur_type_vch = 'VCH*';
		$model->jur_type_gl = 'GL*';
		$model->jur_status = 'A';
		$model->client = 0;
		$model->end_dt = date('d/m/Y');
		$model->bgn_dt = date('d/m/Y');
		//29jul2016
		$url = '';
		$url_xls = '';

		if (isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];

			if ($scenario == 'filter')
			{

				$model->attributes = $_POST['Rptlistofjournal'];

				if (DateTime::createFromFormat('d/m/Y', $model->bgn_dt))
					$model->bgn_dt = DateTime::createFromFormat('d/m/Y', $model->bgn_dt)->format('Y-m-d');
				if (DateTime::createFromFormat('d/m/Y', $model->end_dt))
					$model->end_dt = DateTime::createFromFormat('d/m/Y', $model->end_dt)->format('Y-m-d');
				$trx_id_from = '';
				$trx_id_to = '';
				if ($model->jur_type_vch == 'VCH*' || $model->jur_type_int == 'INT*' || $model->jur_type_trx == 'TRX*')
				{
					$bgn_client = '';
					$end_client = '';
				}

				if ($model->client == 0)
				{
					$bgn_client = '%';
					$end_client = '_';
				}
				else if ($model->client == 1)
				{
					$bgn_client = '';
					$end_client = '_';
				}
				else
				{
					$bgn_client = $model->client_spec_from;
					$end_client = $model->client_spec_to;
				}

				if ($model->bond_trx_from == '')
				{
					$trx_id_from = '%';
				}
				else
				{
					$trx_id_from = $model->bond_trx_from;
				}

				if ($model->bond_trx_to == '')
				{
					$trx_id_to = '_';
				}
				else
				{
					$trx_id_to = $model->bond_trx_to;
				}
				if ($model->file_no_from)
				{
					$file_no_from = $model->file_no_from;
					$file_no_to = $model->file_no_to;
				}
				else
				{
					$file_no_from = '%';
					$file_no_to = '_';
				}

				if ($model->jur_num_from)
				{
					$jur_num_from = $model->jur_num_from;
					$jur_num_to = $model->jur_num_to;
				}
				else
				{
					$jur_num_from = '%';
					$jur_num_to = '_';
				}

				if ($model->jur_status == 'A' || $model->jur_status == 'C')
				{

					if ($model->bgn_dt != '' && $model->end_dt != '')
					{

						$sql = "select x.* from (SELECT jvch_date as jur_date,  NULL client_Cd,  remarks, folder_Cd, jvch_num as doc_num		
					 FROM T_JVCHH			
					WHERE jvch_date BETWEEN '$model->bgn_dt' AND '$model->end_dt'		
					and INSTR('$model->jur_type_bond$model->jur_type_gl$model->jur_type_int$model->jur_type_trx$model->jur_type_vch','VCH') > 0	
					AND nvl(folder_cd,'%') BETWEEN '$file_no_from' AND '$file_no_to'			
					AND jvch_num BETWEEN '$jur_num_from' AND '$jur_num_to'			
					and jvch_type <> 'RE'			
					AND approved_sts = '$model->jur_status'			
					UNION ALL			
					SELECT payrec_date, client_cd,  remarks, folder_Cd, payrec_num			
					FROM T_PAYRECH			
					WHERE  INSTR('$model->jur_type_bond$model->jur_type_gl$model->jur_type_int$model->jur_type_trx$model->jur_type_vch','VCH') > 0			
					AND payrec_date BETWEEN '$model->bgn_dt' AND '$model->end_dt'			
					AND nvl(folder_cd,'%') BETWEEN '$file_no_from' AND '$file_no_to'			
					AND payrec_num BETWEEN '$jur_num_from' AND '$jur_num_to'			
						AND (client_cd BETWEEN '$bgn_client' AND '$end_client' OR ( client_Cd IS NULL AND  '$bgn_client' IS NULL) or('$bgn_client'='%')) 			
					AND approved_sts = '$model->jur_status'		
					UNION ALL			
					SELECT contr_dt, client_cd, ledger_nar, NULL, xn_doc_num			
					FROM(SELECT contr_dt, client_cd,  NULL, DECODE(SUBSTR(contr_num,6,1),'I', SUBSTR(contr_num,1,6)||'0'||SUBSTR(contr_num, 8), contr_num) AS contr_num 			
								FROM T_CONTRACTS t
								WHERE INSTR('$model->jur_type_bond$model->jur_type_gl$model->jur_type_int$model->jur_type_trx$model->jur_type_vch','TRX') > 0
								AND t.contr_dt BETWEEN '$model->bgn_dt' AND '$model->end_dt'
								AND contr_num BETWEEN '$jur_num_from' AND '$jur_num_to'
								AND client_cd BETWEEN '$bgn_client' AND '$end_client'
								AND ( contr_stat = '$model->jur_status' OR (contr_stat <> 'C'  AND '$model->jur_status' ='A'))
								AND '$model->jur_status' <> 'E') a,
					T_ACCOUNT_LEDGER b			
					WHERE a.contr_num = b.xn_doc_num			
					AND b.tal_id = 1			
					UNION ALL			
					SELECT trx_date,'id : '||TO_CHAR(trx_id) sl_acct_cd, DECODE(trx_type,'B','Buy ','Sell ')||bond_cd||DECODE(trx_type,'B','FROM ','TO ')||lawan ledger_nar, NULL, doc_num			
					FROM t_bond_trx 			
					WHERE INSTR('$model->jur_type_bond$model->jur_type_gl$model->jur_type_int$model->jur_type_trx$model->jur_type_vch','BOND') > 0			
					AND trx_date BETWEEN '$model->bgn_dt' AND '$model->end_dt'			
					and trx_id between '$trx_id_from' and '$trx_id_to'		
					AND approved_sts = '$model->jur_status'			
					AND doc_num BETWEEN '$jur_num_from' AND '$jur_num_to'			
					UNION ALL			
					SELECT dncn_date,  sl_acct_Cd,  ledger_nar, folder_Cd, dncn_num			
					FROM T_DNCNH			
					WHERE INSTR('$model->jur_type_bond$model->jur_type_gl$model->jur_type_int$model->jur_type_trx$model->jur_type_vch','INT') > 0			
					AND dncn_date BETWEEN '$model->bgn_dt' AND '$model->end_dt'			
					AND nvl(folder_cd,'%') BETWEEN '$file_no_from' AND '$file_no_to'			
					AND dncn_num BETWEEN '$jur_num_from' AND '$jur_num_to'			
					AND (sl_acct_cd BETWEEN '$bgn_client' AND '$end_client' OR ( sl_acct_Cd IS NULL AND  '$bgn_client' IS NULL)) 			
					AND approved_sts = '$model->jur_status' )X order by jur_date desc, client_cd";

						$modeldetail = Tjvchh::model()->findAllBySql($sql);
						foreach ($modeldetail as $row)
						{
							$row->save_flg = 'Y';
						}

					}
					else//jika tidak isi from to date
					{
						$sql = "select x.* from (SELECT jvch_date as jur_date,  NULL client_Cd,  remarks, folder_Cd, jvch_num as doc_num		
					 FROM T_JVCHH			
					WHERE nvl(folder_cd,'%') BETWEEN '$file_no_from' AND '$file_no_to'	
					and INSTR('$model->jur_type_bond$model->jur_type_gl$model->jur_type_int$model->jur_type_trx$model->jur_type_vch','VCH') > 0		
					AND jvch_num BETWEEN '$jur_num_from' AND '$jur_num_to'			
					and jvch_type <> 'RE'			
					AND approved_sts = '$model->jur_status'			
					UNION ALL			
					SELECT payrec_date, client_cd,  remarks, folder_Cd, payrec_num			
					FROM T_PAYRECH			
					WHERE  INSTR('$model->jur_type_bond$model->jur_type_gl$model->jur_type_int$model->jur_type_trx$model->jur_type_vch','VCH') > 0			
					AND nvl(folder_cd,'%') BETWEEN '$file_no_from' AND '$file_no_to'			
					AND payrec_num BETWEEN '$jur_num_from' AND '$jur_num_to'			
						AND (client_cd BETWEEN '$bgn_client' AND '$end_client' OR ( client_Cd IS NULL AND  '$bgn_client' IS NULL) or('$bgn_client'='%')) 			
					AND approved_sts = '$model->jur_status'		
					UNION ALL			
					SELECT contr_dt, client_cd, ledger_nar, NULL, xn_doc_num			
					FROM(SELECT contr_dt, client_cd,  NULL, DECODE(SUBSTR(contr_num,6,1),'I', SUBSTR(contr_num,1,6)||'0'||SUBSTR(contr_num, 8), contr_num) AS contr_num 			
								FROM T_CONTRACTS t
								WHERE INSTR('$model->jur_type_bond$model->jur_type_gl$model->jur_type_int$model->jur_type_trx$model->jur_type_vch','TRX') > 0
								AND contr_num BETWEEN '$jur_num_from' AND '$jur_num_to'
								AND client_cd BETWEEN '$bgn_client' AND '$end_client'
								AND ( contr_stat = '$model->jur_status' OR (contr_stat <> 'C'  AND '$model->jur_status' ='A'))
								AND '$model->jur_status' <> 'E') a,
					T_ACCOUNT_LEDGER b			
					WHERE a.contr_num = b.xn_doc_num			
					AND b.tal_id = 1			
					UNION ALL			
					SELECT trx_date,'id : '||TO_CHAR(trx_id) sl_acct_cd, DECODE(trx_type,'B','Buy ','Sell ')||bond_cd||DECODE(trx_type,'B','FROM ','TO ')||lawan ledger_nar, NULL, doc_num			
					FROM t_bond_trx 			
					WHERE INSTR('$model->jur_type_bond$model->jur_type_gl$model->jur_type_int$model->jur_type_trx$model->jur_type_vch','BOND') > 0			
					and trx_id between '$trx_id_from' and '$trx_id_to'		
					AND approved_sts = '$model->jur_status'			
					AND doc_num BETWEEN '$jur_num_from' AND '$jur_num_to'			
					UNION ALL			
					SELECT dncn_date,  sl_acct_Cd,  ledger_nar, folder_Cd, dncn_num			
					FROM T_DNCNH			
					WHERE INSTR('$model->jur_type_bond$model->jur_type_gl$model->jur_type_int$model->jur_type_trx$model->jur_type_vch','INT') > 0			
					AND nvl(folder_cd,'%') BETWEEN '$file_no_from' AND '$file_no_to'			
					AND dncn_num BETWEEN '$jur_num_from' AND '$jur_num_to'			
					AND (sl_acct_cd BETWEEN '$bgn_client' AND '$end_client' OR ( sl_acct_Cd IS NULL AND  '$bgn_client' IS NULL)) 			
					AND approved_sts = '$model->jur_status' )X order by jur_date desc, client_cd";

						$modeldetail = Tjvchh::model()->findAllBySql($sql);
						foreach ($modeldetail as $row)
						{
							$row->save_flg = 'Y';
						}
					}

				}

				else
				{
					
					$sql = " SELECT * FROM (
				SELECT NULL CLIENT_CD, 'Y' SAVE_FLG,
					(SELECT TO_DATE(FIELD_VALUE,'YYYY/MM/DD HH24:MI:SS') FROM T_MANY_DETAIL DA 
					        WHERE DA.TABLE_NAME = 'T_JVCHH' 
					        AND DA.UPDATE_DATE = DD.UPDATE_DATE
					        AND DA.UPDATE_SEQ = DD.UPDATE_SEQ
					        AND DA.FIELD_NAME = 'JVCH_DATE'
					        AND DA.RECORD_SEQ = DD.RECORD_SEQ) JUR_DATE, 
					(SELECT FIELD_VALUE FROM T_MANY_DETAIL DA 
					        WHERE DA.TABLE_NAME = 'T_JVCHH' 
					        AND DA.UPDATE_DATE = DD.UPDATE_DATE
					        AND DA.UPDATE_SEQ = DD.UPDATE_SEQ
					        AND DA.FIELD_NAME = 'FOLDER_CD'
					        AND DA.RECORD_SEQ = DD.RECORD_SEQ) FOLDER_CD,
					(SELECT FIELD_VALUE FROM T_MANY_DETAIL DA 
					        WHERE DA.TABLE_NAME = 'T_JVCHH' 
					        AND DA.UPDATE_DATE = DD.UPDATE_DATE
					        AND DA.UPDATE_SEQ = DD.UPDATE_SEQ
					        AND DA.FIELD_NAME = 'JVCH_NUM'
					        AND DA.RECORD_SEQ = DD.RECORD_SEQ) DOC_NUM,
					(SELECT FIELD_VALUE FROM T_MANY_DETAIL DA 
					        WHERE DA.TABLE_NAME = 'T_JVCHH' 
					        AND DA.UPDATE_DATE = DD.UPDATE_DATE
					        AND DA.UPDATE_SEQ = DD.UPDATE_SEQ
					        AND DA.FIELD_NAME = 'REMARKS'
					        AND DA.RECORD_SEQ = DD.RECORD_SEQ) REMARKS
					FROM T_MANY_DETAIL DD, T_MANY_HEADER HH WHERE DD.TABLE_NAME = 'T_JVCHH' AND DD.UPDATE_DATE = HH.UPDATE_DATE
					                      AND DD.UPDATE_SEQ = HH.UPDATE_SEQ AND  DD.RECORD_SEQ =1
					                     AND DD.FIELD_NAME = 'JVCH_DATE' AND HH.APPROVED_STATUS = 'E' ORDER BY HH.UPDATE_SEQ) A
					WHERE A.JUR_DATE BETWEEN  DECODE('$model->bgn_dt','','1000-01-01','$model->bgn_dt')
						 and DECODE('$model->end_dt','','2050-12-31','$model->end_dt')     
						 AND DOC_NUM BETWEEN '$jur_num_from' AND '$jur_num_to'	
						 AND folder_Cd BETWEEN '$file_no_from' and '$file_no_to' 			                  
					order by A.jur_date desc";

					$modeldetail = Tjvchh::model()->findAllBySql($sql);

				}
			}// end filter
			else if ($scenario == 'print')
			{

				$rowCount = $_POST['rowCount'];
				$success = false;
				$connection = Yii::app()->dbrpt;
				$connection->enableParamLogging = false;
				//WT disable save data to log
				$transaction = $connection->beginTransaction();
				//$rand_value=abs(mt_rand());
				$doc_num = array();
				for ($x = 0; $x < $rowCount; $x++)
				{
					$modeldetail[$x] = new Tjvchh;
					$model->attributes = $_POST['Rptlistofjournal'];
					$modeldetail[$x]->attributes = $_POST['Tjvchh'][$x + 1];

					if (isset($_POST['Tjvchh'][$x + 1]['save_flg']) && $_POST['Tjvchh'][$x + 1]['save_flg'] == 'Y')
					{
						$doc_num[] = $modeldetail[$x]->doc_num;
					}

				}
				if (DateTime::createFromFormat('d/m/Y', $model->bgn_dt))
					$model->bgn_dt = DateTime::createFromFormat('d/m/Y', $model->bgn_dt)->format('Y-m-d');
				if (DateTime::createFromFormat('d/m/Y', $model->end_dt))
					$model->end_dt = DateTime::createFromFormat('d/m/Y', $model->end_dt)->format('Y-m-d');

				$file_no_from = $model->file_no_from == '' ? '%' : $model->file_no_from;
				$file_no_to = $model->file_no_to == '' ? '_' : $model->file_no_to;

				if ($model->validate() && $model->executeReportGenSp($doc_num, $file_no_from, $file_no_to) > 0)
				{
					$success = true;
				}
				else
				{
					$success = false;
				}

				if ($success)
				{
					$transaction->commit();
					//Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					//$this->redirect(array('Report','random_value'=>$model->vo_random_value, 'user_id'=>$model->vp_userid));

					//29jul2016
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';

				}
				else
				{
					$transaction->rollback();
					//Yii::app()->user->setFlash('danger', $model->vo_errmsg);
				}
			}
			//end print
		}//end scenario
		else
		{
			//load first time
		}
		if (DateTime::createFromFormat('Y-m-d', $model->bgn_dt))
			$model->bgn_dt = DateTime::createFromFormat('Y-m-d', $model->bgn_dt)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->end_dt))
			$model->end_dt = DateTime::createFromFormat('Y-m-d', $model->end_dt)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'modeldetail' => $modeldetail,
			'url' => $url,
			'url_xls' => $url_xls,
		));
	}

	/*

	 public function actionReport($random_value,$user_id){

	 $modelreport= new Rptlistofjournal('LIST_OF_JOURNAL','R_LIST_OF_JOURNAL','List_of_journal.rptdesign');
	 $modelreport->vo_random_value = $random_value;
	 $modelreport->vp_userid=$user_id;
	 $rpt_link =$modelreport->showReport();
	 $url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
	 $url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';

	 $this->render('_report',array(
	 'url'=>$url,
	 'url_xls'=>$url_xls,
	 'modelreport'=>$modelreport
	 ));
	 }
	 */

}
?>