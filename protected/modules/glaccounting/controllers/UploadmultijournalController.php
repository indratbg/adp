<?php

ini_set('memory_limit', '256M');

class UploadmultijournalController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Tjvchh;
		$modelledger = array();
		$modelfolder = new Tfolder;
		$success = false;
		$filename = '';
		$folder = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='VCH_REF'")->dflg1;
		$sign = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='DOC_REF' ")->dflg1;
		//danasakti
		$cek_branch = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='CHECK' AND PARAM_CD2='ACCTBRCH'")->dflg1;

		if (isset($_POST['Tjvchh']))
		{
			$model->attributes = $_POST['Tjvchh'];
			$back_date_jur = $_POST['sign'];

			$model->scenario = 'upload';
			if ($model->validate())
			{
				//buat ambil file yang di upload tanpa $_FILES
				$model->file_upload = CUploadedFile::getInstance($model, 'file_upload');
				$path = FileUpload::getFilePath(FileUpload::T_JVCH, 'jurnal.txt');
				$model->file_upload->saveAs($path);
				$filename = $model->file_upload;
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				//Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
				$menuName = 'UPLOAD MULTI JOURNAL';
				$lines = file($path);
				$date = date('Y-m-d', strtotime(' -1 month'));

				$x = 0;
				$recordSeq = 1;
				$amount = 0;
				$debit = 0;
				$credit = 0;
				$amount_credit = 0;
				foreach ($lines as $line_num => $line)
				{
					$rowNum = count($lines);
					$pieces = explode("\t", $line);
					if (count($pieces) < 7)
					{
						Yii::app()->user->setFlash('danger', 'Failed upload file, delete blank space below text file');
						$this->redirect(array('index'));
						break;
					}
					$modelledger[$x] = new Taccountledger;

					$doc_date = $pieces[0];
					// DateTime::createFromFormat('d/m/Y',$pieces[0])->format('Y-m-d');
					if (DateTime::createFromFormat('d/m/Y', $doc_date))
						$doc_date = DateTime::createFromFormat('d/m/Y', $doc_date)->format('Y-m-d');
					//if(DateTime::createFromFormat('d//Y',$doc_date)) $doc_date = DateTime::createFromFormat('d/m/Y',$doc_date)->format('Y-m-d');

					$modelledger[$x]->xn_doc_num = 'x';
					if ($sign == 'Y')
					{
						$modelledger[$x]->doc_ref_num = 'x';
					}
					$modelledger[$x]->tal_id = $pieces[2];
					$modelledger[$x]->doc_date = $doc_date;
					$modelledger[$x]->due_date = $doc_date;
					$modelledger[$x]->sl_acct_cd = trim($pieces[4]);
					$modelledger[$x]->gl_acct_cd = trim($pieces[3]);
					$client = trim($modelledger[$x]->sl_acct_cd);
					$gl_a = trim($modelledger[$x]->gl_acct_cd);
					$sql_client = "SELECT acct_type FROM MST_CLIENT c,mst_gl_account m WHERE client_cd = sl_a and sl_a='$client' and trim(gl_a)='$gl_a' and m.acct_stat='A' and m.prt_type <> 'S' and m.approved_stat='A' ";
					$client_cd = DAO::queryRowSql($sql_client);
					$acct_type = $client_cd['acct_type'];
					if ($acct_type != '' || $acct_type != null)
					{
						$modelledger[$x]->acct_type = trim($acct_type);
					}
					$modelledger[$x]->curr_cd = 'IDR';
					$modelledger[$x]->curr_val = str_replace(',', '.', str_replace('.', '', $pieces[6]));
					$modelledger[$x]->xn_val = str_replace(',', '.', str_replace('.', '', $pieces[6]));
					$modelledger[$x]->reversal_jur = 'N';
					$modelledger[$x]->budget_cd = 'GL';
					$modelledger[$x]->record_source = 'GL';
					$modelledger[$x]->manual = 'Y';
					$modelledger[$x]->user_id = Yii::app()->user->id;
					$modelledger[$x]->cre_dt = date('Y-m-d H:i:s');
					$modelledger[$x]->db_cr_flg = $pieces[5];
					$modelledger[$x]->ledger_nar = trim($pieces[7]);
					$modelledger[$x]->folder_cd = $pieces[1];

					//VALIDASI JURNAL
					if ($back_date_jur == 'N')
					{
						if ($doc_date < date('Y-m-d'))
						{
							$model->addError('jvch_date', 'Tidak boleh membuat jurnal bulan lalu');
							break;
						}
					}

					//cek sl account
					$sl_account = $modelledger[$x]->sl_acct_cd;
					$gl_account = $modelledger[$x]->gl_acct_cd;
					$cek = Glaccount::model()->find("trim(gl_a) ='$gl_account' and sl_a='$sl_account' and acct_stat='A' and prt_type <> 'S' and approved_stat='A' ");
					if (!$cek)
					{
						$modelledger[$x]->addError($modelledger[$x]->sl_acct_cd, 'Not found in chart of Account ' .$modelledger[$x]->gl_acct_cd.' '. $modelledger[$x]->sl_acct_cd);
						$success = FALSE;
						break;
					}
				
					if ($x > 0)
					{
						if (trim($modelledger[$x - 1]->folder_cd) == trim($modelledger[$x]->folder_cd))
						{
							//execute sp header
							if ($x == 1)
							{
								if ($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName) > 0)
									$success = true;
								else
								{
									$success = false;
								}
							}
							//jumlahkan amount
							if ($modelledger[$x - 1]->db_cr_flg == 'D')
							{
								$amount = $amount + $modelledger[$x - 1]->curr_val;
								$debit = $debit + $modelledger[$x - 1]->curr_val;
							}
							else
							{
								$credit = $credit + $modelledger[$x - 1]->curr_val;
								$amount_credit = $amount_credit + $modelledger[$x - 1]->curr_val;
							}

							//cek branch untuk broker PF
							if ($cek_branch == 'Y')
							{
								$gl = trim($modelledger[$x - 1]->gl_acct_cd);
								$sl = trim($modelledger[$x - 1]->sl_acct_cd);
								$gl_2 = trim($modelledger[$x]->gl_acct_cd);
								$sl_2 = trim($modelledger[$x]->sl_acct_cd);
								$branch1 = Glaccount::model()->find(" sl_a= '$sl' and trim(gl_a) = trim('$gl') ")->brch_cd;
								$branch2 = Glaccount::model()->find(" sl_a= '$sl_2' and trim(gl_a) = trim('$gl_2') ")->brch_cd;
								//var_dump($branch2);die();
								if (trim($branch1) != trim($branch2))
								{
									$modelledger[$x]->addError('gl_acct_cd', 'SL Account / GL Account harus dari branch yang sama');
									$success = false;
									break;
								}
							}

							//save ke t account ledger
							$modelledger[$x - 1]->update_date = $model->update_date;
							$modelledger[$x - 1]->update_seq = $model->update_seq;
							if ($success && $modelledger[$x - 1]->executeSp(AConstant::INBOX_STAT_INS, $modelledger[$x - 1]->xn_doc_num, $modelledger[$x - 1]->tal_id, $model->update_date, $model->update_seq, $recordSeq) > 0)
								$success = true;
							else
							{
								$success = false;
							}
							$recordSeq++;

							//SAVE KE T ACCOUNT LEDGER UNTUK JURNAL BARIS TERAKHIR
							if (($x + 1) == $rowNum)
							{
								$modelledger[$x]->update_date = $model->update_date;
								$modelledger[$x]->update_seq = $model->update_seq;
								if ($success && $modelledger[$x]->executeSp(AConstant::INBOX_STAT_INS, $modelledger[$x]->xn_doc_num, $modelledger[$x]->tal_id, $model->update_date, $model->update_seq, $recordSeq) > 0)
									$success = true;
								else
								{
									$success = false;
								}

								//jumlahkan amount
								if ($modelledger[$x]->db_cr_flg == 'D')
								{
									$debit = $debit + $modelledger[$x]->curr_val;
								}
								else
								{
									$credit = $credit + $modelledger[$x]->curr_val;
								}

								//save ke t jvchh
								$doc_num = $this->get_doc_num($modelledger[$x]->doc_date);
								$model->jvch_date = $modelledger[$x]->doc_date;
								$model->jvch_num = $doc_num;
								$model->jvch_type = 'GL';
								$model->reversal_jur = 'N';
								$model->curr_cd = 'IDR';
								$model->user_id = Yii::app()->user->id;
								$model->remarks = $modelledger[$x]->ledger_nar;
								$model->curr_amt = $amount==0?$amount_credit:$amount;
								$model->folder_cd = $modelledger[$x]->folder_cd;
								$amount = 0;
								$amount_credit=0;
								//reset amount jika beda jurnal

								if (number_format((float)$debit, 2, '.', ',') != number_format((float)$credit, 2, '.', ','))
								{
									$model->addError('curr_amt', 'Amount tidak balance , Credit : ' . $credit . ' Debit : ' . $debit);
									$success = FALSE;
									break;
								}

								if ($success && $model->executeSp(AConstant::INBOX_STAT_INS, $model->jvch_num, 1) > 0)
									$success = true;
								else
								{
									$success = false;
								}
								//update xn_doc_num jurnal sebelumnya
								$sql = "UPDATE T_MANY_DETAIL SET field_value='$doc_num' where update_seq='$model->update_seq' and update_date='$model->update_date'
					and table_name='T_ACCOUNT_LEDGER' and field_name='XN_DOC_NUM'";
								$exec = DAO::executeSql($sql);

								if ($sign == 'Y')
								{
									$sql = "UPDATE T_MANY_DETAIL SET field_value='$doc_num' where update_seq='$model->update_seq' and update_date='$model->update_date'
					and table_name='T_ACCOUNT_LEDGER' and field_name='DOC_REF_NUM'";
									$exec = DAO::executeSql($sql);
								}

								//insert ke t folder
								if ($folder == 'Y')
								{
									//cek folder_cd
									$cek_folder_cd = $this->checkFolderCd($modelledger[$x - 1]->folder_cd, $modelledger[$x - 1]->doc_date);
									if ($cek_folder_cd)
									{
										$model->addError('folder_cd', "File Code " . $model->folder_cd . " is already used by $cek_folder_cd[0] $cek_folder_cd[1] $cek_folder_cd[2]");
										$success = FALSE;
										break;
									}
									$modelfolder->fld_mon = DateTime::createFromFormat('Y-m-d', $modelledger[$x - 1]->doc_date)->format('my');
									$modelfolder->folder_cd = $modelledger[$x - 1]->folder_cd;
									$modelfolder->doc_date = $modelledger[$x - 1]->doc_date;
									$modelfolder->doc_num = $doc_num;
									$modelfolder->user_id = Yii::app()->user->id;
									$modelfolder->cre_dt = date('Y-m-d H:i:s');
									if ($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_INS, $modelfolder->doc_num, $model->update_date, $model->update_seq, 1) > 0)
										$success = true;
									else
									{
										$success = false;
									}
								}

							}//END BARIS TERAKHIR FILE JOURNAL

						}
						else//beda jurnal
						{
							//save ke t account ledger baris terakhir
							$modelledger[$x - 1]->update_date = $model->update_date;
							$modelledger[$x - 1]->update_seq = $model->update_seq;
							if ($success && $modelledger[$x - 1]->executeSp(AConstant::INBOX_STAT_INS, $modelledger[$x - 1]->xn_doc_num, $modelledger[$x - 1]->tal_id, $model->update_date, $model->update_seq, $recordSeq) > 0)
								$success = true;
							else
							{
								$success = false;
							}
							$recordSeq++;
							$recordSeq = 1;
							//reset recorseq kalau beda jurnal

							//jumlahkan amount
							if ($modelledger[$x - 1]->db_cr_flg == 'D')
							{
								$amount = $amount + $modelledger[$x - 1]->curr_val;
								$debit = $debit + $modelledger[$x - 1]->curr_val;
							}
							else
							{
								$credit = $credit + $modelledger[$x - 1]->curr_val;
								$amount_credit = $amount_credit + $modelledger[$x - 1]->curr_val;
							}

							//save ke t jvchh
							$doc_num = $this->get_doc_num($modelledger[$x - 1]->doc_date);
							$model->jvch_date = $modelledger[$x - 1]->doc_date;
							$model->jvch_num = $doc_num;
							$model->jvch_type = 'GL';
							$model->curr_cd = 'IDR';
							$model->user_id = Yii::app()->user->id;
							$model->remarks = $modelledger[$x - 1]->ledger_nar;
							$model->curr_amt = $amount==0?$amount_credit:$amount;
							$model->folder_cd = $modelledger[$x - 1]->folder_cd;
							$amount = 0;
							$amount_credit=0;
							//reset amount jika beda jurnal

							if (number_format((float)$debit, 2, '.', ',') != number_format((float)$credit, 2, '.', ','))
							{
								$model->addError('curr_amt', 'Amount tidak balance , Credit : ' . $credit . ' Debit : ' . $debit);
								$success = FALSE;
								break;
							}
							$credit = 0;
							$debit = 0;
							if ($success && $model->executeSp(AConstant::INBOX_STAT_INS, $model->jvch_num, 1) > 0)
								$success = true;
							else
							{
								$success = false;
							}
							//update xn_doc_num jurnal sebelumnya
							$sql = "UPDATE T_MANY_DETAIL SET field_value='$doc_num' where update_seq='$model->update_seq' and update_date='$model->update_date'
					and table_name='T_ACCOUNT_LEDGER' and field_name='XN_DOC_NUM'";
							$exec = DAO::executeSql($sql);

							if ($sign == 'Y')
							{
								$sql = "UPDATE T_MANY_DETAIL SET field_value='$doc_num' where update_seq='$model->update_seq' and update_date='$model->update_date'
					and table_name='T_ACCOUNT_LEDGER' and field_name='DOC_REF_NUM'";
								$exec = DAO::executeSql($sql);
							}

							//insert ke t folder
							if ($folder == 'Y')
							{
								//cek folder_cd
								$cek_folder_cd = $this->checkFolderCd($modelledger[$x - 1]->folder_cd, $modelledger[$x - 1]->doc_date);
								if ($cek_folder_cd)
								{
									$model->addError('folder_cd', "File Code " . $model->folder_cd . " is already used by $cek_folder_cd[0] $cek_folder_cd[1] $cek_folder_cd[2]");
									$success = FALSE;
									break;
								}

								$modelfolder->fld_mon = DateTime::createFromFormat('Y-m-d', $modelledger[$x - 1]->doc_date)->format('my');
								$modelfolder->folder_cd = $modelledger[$x - 1]->folder_cd;
								$modelfolder->doc_date = $modelledger[$x - 1]->doc_date;
								$modelfolder->doc_num = $doc_num;
								$modelfolder->user_id = Yii::app()->user->id;
								$modelfolder->cre_dt = date('Y-m-d H:i:s');
								if ($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_INS, $modelfolder->doc_num, $model->update_date, $model->update_seq, 1) > 0)
									$success = true;
								else
								{
									$success = false;
								}
							}

							//EXECUTE SP HEADER UNTUK JURNAL SELANJUTNYA
							if ($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName) > 0)
								$success = true;
							else
							{
								$success = false;
							}

						}

					}
					$x++;

				}//end foreach

				if ($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					//$this->redirect(array('/glaccounting/uploadmultijournal/index'));
				}
				else
				{
					$transaction->rollback();
				}
			}//end validate
		}//end if isset
		$this->render('index', array(
			'model' => $model,
			'modelledger' => $modelledger,
			'modelfolder' => $modelfolder
		));
	}

	public function get_doc_num($tanggal)
	{

		$sql = "SELECT GET_DOCNUM_GL(to_date('$tanggal','yyyy-mm-dd'),'GL') as jvch_num from dual";
		$num = DAO::queryRowSql($sql);
		$jvch_num = $num['jvch_num'];
		return $jvch_num;
	}

	public function checkFolderCd($folder_cd, $jvch_date)
	{
		$model = new Tjvchh;
		$return;
		$doc_num;
		$user_id;
		$doc_date;

		$connection = Yii::app()->db;
		//$transaction = $connection->beginTransaction();

		$query = "CALL SP_CHECK_FOLDER_CD(
					:P_FOLDER_CD,
					TO_DATE(:P_DATE,'YYYY-MM-DD'),
					:P_RTN,
					:P_DOC_NUM,
					:P_USER_ID,
					:P_DOC_DATE)";

		$command = $connection->createCommand($query);
		$command->bindValue(":P_FOLDER_CD", strtoupper($folder_cd), PDO::PARAM_STR);
		$command->bindValue(":P_DATE", $jvch_date, PDO::PARAM_STR);
		$command->bindParam(":P_RTN", $return, PDO::PARAM_STR, 1);
		$command->bindParam(":P_DOC_NUM", $doc_num, PDO::PARAM_STR, 100);
		$command->bindParam(":P_USER_ID", $user_id, PDO::PARAM_STR, 10);
		$command->bindParam(":P_DOC_DATE", $doc_date, PDO::PARAM_STR, 100);

		$command->execute();

		if ($doc_date)
			$doc_date = DateTime::createFromFormat('Y-m-d G:i:s', $doc_date)->format('d/m/Y');

		if ($return == 1)
		{
			//$model->addError('folder_cd',"File Code ".$folder_cd." is already used by $user_id $doc_num $doc_date");

			return array(
				$user_id,
				$doc_date,
				$doc_num
			);
			//return $doc_date;
			//return $doc_num;
		}
	}

	public function actionAjxValidateBackDate()//LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}

}
