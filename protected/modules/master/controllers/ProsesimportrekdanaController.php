<?php

class ProsesimportrekdanaController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	
	public function actionIndex()
	{
		$model = new Trekdanaksei();
		//$model->unsetAttributes();
		$cif = new Cif('search');
		$cif->unsetAttributes();
		$modelfail=Vfailimprekdana::model()->findAll();		
		
		$modelclient=Clientflacct::model()->findAll();
		$valid = TRUE;
		$success = false;
		$cancel_reason = '';
		
		if(isset($_POST['scenario'])){
	
			if($_POST['scenario'] == 'import'){
			//	echo "<script>alert('test')</script>";
					$success=TRUE;
					
					if($model->validate()){
				/*	$query = "SELECT DFLG1  
							FROM mst_sys_param  
							WHERE  param_id = 'IMPORT_CLIENT_FLACCT' AND param_cd1 = 'UPDATE'
							AND DSTR1 = 'MST_CLIENT_FLACCT'";
							$res   = DAO::queryRowSql($query);
							
							if($res['dflg1']=='Y')
							{ */
								$ip = Yii::app()->request->userHostAddress;
								if($ip=="::1")
								$ip = '127.0.0.1';
								$model->ip_address = $ip;
								if($model->executeInsert()>0){$success=TRUE;
							
								}
								else{
									$success=false;
								}
						//	}
							
						
						if($success){
							
							Yii::app()->user->setFlash('success', 'Successfully Process Import Rekening Dana');
							$this->redirect(array('/master/prosesimportrekdana/index'));
							}
							}
							
			}//end import
			else{
				
				
				$rowCount = $_POST['rowCount'];
				$x;
				$save_flag = false; //False if no record is saved
				
				$ip = Yii::app()->request->userHostAddress;
				if($ip=="::1")
				$ip = '127.0.0.1';
			
			$modelfail[0]->ip_address = $ip;
			$modelfail[0]->upd_dt  = Yii::app()->datetime->getDateTimeNow();
			$modelfail[0]->upd_by  = Yii::app()->user->id;
			$modelfail[0]->user_id =  Yii::app()->user->id;
			$modelclient[0]->ip_address = $ip;
			$modelclient[0]->upd_dt  = Yii::app()->datetime->getDateTimeNow();
			$modelclient[0]->upd_by  = Yii::app()->user->id;
			$modelclient[0]->user_id =  Yii::app()->user->id;
			
			
			
					for($x=0;$x<$rowCount;$x++)
				{
					$modelfail[$x] = new Vfailimprekdana;
					
					$modelfail[$x]->attributes = $_POST['Vfailimprekdana'][$x+1];
					
					
					
					if(isset($_POST['Vfailimprekdana'][$x+1]['save_flg']) && $_POST['Vfailimprekdana'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						if(isset($_POST['Vfailimprekdana'][$x+1]['cancel_flg']))
						{
							if($_POST['Vfailimprekdana'][$x+1]['cancel_flg'] == 'Y')
							{
								//CANCEL
								$modelfail[$x]->scenario = 'cancel';
								$modelfail[$x]->cancel_reason = $_POST['cancel_reason'];  	
								
							}
							else 
							{
								//UPDATE
								$modelfail[$x]->scenario = 'update';
								
							}
						}
						else 
						{
							//INSERT
							
							$modelfail[$x]->scenario = 'insert';
						}
						$valid = $modelfail[$x]->validate() && $valid;		
					
					}	
						
				}
				
				$valid = $valid && $save_flag;
			
				if($valid)
				{ 
					$success = true;
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					$menuName = 'IMPORT REKENING DANA';
					$modelfail[0]->update_date=Yii::app()->datetime->getDateTimeNow();
					
					
					
					for($x=0;$success && $x<$rowCount;$x++)
					{
						
						
						if($modelfail[$x]->save_flg == 'Y')
						{
							if($modelfail[$x]->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
							
							 $modelfail[$x]->update_date=$modelfail[$x]->update_date;
						 $modelfail[$x]->update_seq=$modelfail[$x]->update_seq;
								
					
							if($modelfail[$x]->client_cd)
							{ //INSERT
								$modelfail[$x]->acct_stat='A';
								$modelfail[$x]->from_dt=date("Y-m-d");
								$modelfail[$x]->to_dt=('2030-12-31');
								if( $success  && $modelfail[$x]-> executeSp(AConstant::INBOX_STAT_INS,$modelfail[$x]->client_cd, $modelfail[$x]->new_bank_acct,1) > 0)$success = true;
								else {
									$success = false;
								}	
								$client_cd=$modelfail[$x]->client_cd;
								$bank_acct_num=$modelfail[$x]->bank_acct;
								$modelclient[$x]= Clientflacct::model()->find("client_cd='$client_cd' and bank_acct_num='$bank_acct_num' ");
								//UPDATE
								 $modelclient[$x]->update_date=$modelfail[$x]->update_date;
								 $modelclient[$x]->update_seq=$modelfail[$x]->update_seq;
								$modelclient[$x]->acct_stat='C';
								
								$sql = "select get_doc_date('1',trunc(sysdate)) as to_dt from dual";
								$date = DAO::queryRowSql($sql);
								$to_dt = $date['to_dt'];
								if(DateTime::createFromFormat('Y-m-d H:i:s',$to_dt))$to_dt= DateTime::createFromFormat('Y-m-d H:i:s',$to_dt)->format('Y-m-d');
								$modelclient[$x]->to_dt= $to_dt; //date('Y-m-d',strtotime("-1 days"));
								$modelclient[$x]->client_cd=$modelfail[$x]->client_cd;
								$modelclient[$x]->bank_acct_num=$modelfail[$x]->bank_acct;
								
								if( $success && $modelclient[$x]->executeSpImport(AConstant::INBOX_STAT_UPD,$modelfail[$x]->client_cd, $modelfail[$x]->bank_acct,2) > 0)$success = true;
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
						$this->redirect(array('index'));
					}
					else {
						$transaction->rollback();
					}
				}
			}

		}

						 $sql="SELECT count(*) as jumlah
						FROM(
							SELECT client_Cd, t.bank_cd, t.rek_dana, t.name
							FROM(
									 SELECT subrek001, MST_CLIENT.client_cd
								  FROM MST_CLIENT, v_client_subrek14
								 WHERE susp_stat = 'N'
								 AND client_type_1 <> 'B'
								 AND MST_CLIENT.client_cd = v_client_subrek14.client_cd
								 AND SUBSTR(subrek001,6,4) <> '0000'
								 AND subrek001 IS NOT NULL
								 ) m,
								T_REK_DANA_KSEI t
								WHERE t.subrek = m.subrek001 ) c,
						   ( SELECT client_Cd
						     FROM MST_CLIENT_FLACCT
							 WHERE acct_stat <> 'C'
							 AND approved_stat = 'A') f,
						   MST_FUND_BANK b
						   WHERE    c.client_Cd = f.client_cd(+)
						   AND f.client_Cd IS NULL
						   AND c.bank_Cd= b.bank_Cd";
						   
						  $unprocess=DAO::queryRowSql($sql); 
						  $jumlah=$unprocess['jumlah'];
						   
				if($jumlah>0){
					$jum_unprocess=$jumlah.' Belum diproses';
				}
				else{
					$jum_unprocess="Tidak ada data yang belum diproses";
				}		
								
	
		$this->render('index',array(
		'model'=>$model,
			'modelfail'=>$modelfail,
			'modelclient'=>$modelclient,
			'jum_unprocess'=> $jum_unprocess
		));
	}
}
