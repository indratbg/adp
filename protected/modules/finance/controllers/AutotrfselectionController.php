<?php

class AutotrfselectionController extends AAdminController
{
	public $layout='//layouts/admin_column3';

public function actionIndex()
{
		$modelReport = new Rptautotrfselection('AUTO_TRANSFER_SELECTION','R_AUTO_TRX_SELECTION','Auto_transfer_selection.rptdesign');
		$model = new Autotrfselection;
		$modelPenarikan=array();
		$modelDetail=array();
		$modelPrint=array();
		$model->doc_date = date('d/m/Y');
		$model->from_bank = Fundbank::model()->find("default_flg='Y'")->bank_cd;
		$model->trx_type='0';
		$valid = true;
		$success = false;
		$url='';
		if(isset($_POST['Autotrfselection']))
		{	$scenario = $_POST['scenario'];
			$model->attributes = $_POST['Autotrfselection'];
			if(DateTime::createFromFormat('d/m/Y',$model->doc_date))$model->doc_date = DateTime::createFromFormat('d/m/Y',$model->doc_date)->format('Y-m-d');
			if($scenario =='filter')
			{
					
				$doc_date = $model->doc_date;
				$fund_bank_cd = $model->from_bank;
				$branch_grp = $model->brch_cd;
				$reselect = $_POST['reSelect'];
				//RDI to CLient
				if($model->trx_type =='0')
				{
					$modelDetail = Autotrfselection::model()->findAllBySql(Autotrfselection::getAutotrf($doc_date, $fund_bank_cd, $branch_grp, $reselect));
					foreach($modelDetail as $row)
					{
						$row->save_flg = $row->auto_trf=='Y'?'Y':'N';
					}	
					if(count($modelDetail)==0)
					{
						Yii::app()->user->setFlash('danger', 'No Data Found');
					}
				}
				//PE to RDI Penarikan
				else if($model->trx_type=='1') 
				{
					$modelPenarikan = Autotrfselection::model()->findAllBySql(Autotrfselection::getPenarikan($doc_date, $fund_bank_cd, $branch_grp));
					foreach($modelPenarikan as $row)
					{
						if(DateTime::createFromFormat('Y-m-d',$row->trans_date))$row->trans_date = DateTime::createFromFormat('Y-m-d',$row->trans_date)->format('d/m/Y');
					}
					if(count($modelPenarikan)==0)
					{
						Yii::app()->user->setFlash('danger', 'No Data Found');
					}
				}
				
			}
			else if($scenario =='update')
			{
				$rowCount = $_POST['rowCount'];
				$rowCountPenarikan = $_POST['rowCountPenarikan'];
				$reselect = $_POST['reSelect'];
				//RDI to Client
				for($x=1;$x<=$rowCount;$x++)
				{
					$modelDetail[$x] = new Autotrfselection;
					$modelDetail[$x]->attributes = $_POST['Autotrfselection'][$x];
					if(isset($_POST['Autotrfselection'][$x]['save_flg']) && $_POST['Autotrfselection'][$x]['save_flg'] == 'Y')
					{	
						$modelDetail[$x]->scenario = 'insert';
						$modelDetail[$x]->trx_type = 'X';//tidak digunakan/untuk meloloskan validasi require
						$valid = $modelDetail[$x]->validate() && $valid;
						//$valid=true;	
					}
				}
				//PE to RDI penarikan
				for($x=1;$x<=$rowCountPenarikan;$x++)
				{
					$modelPenarikan[$x] = new Autotrfselection;
					$modelPenarikan[$x]->attributes = $_POST['Autotrfselection'][$x];
					if(isset($_POST['Autotrfselection'][$x]['save_flg']) && $_POST['Autotrfselection'][$x]['save_flg'] == 'Y')
					{	
						$modelPenarikan[$x]->scenario = 'insert';
						$modelPenarikan[$x]->trx_type = 'X';//tidak digunakan/untuk meloloskan validasi require
						//$valid = $modelPenarikan[$x]->validate() && $valid;
						$valid=true;	
					}
				}
			
			if($valid)
			{
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
				
				//RDI to Client
				for($x=1;$x<=$rowCount;$x++)
				{
						$modelDetail[$x]->auto_trf = $modelDetail[$x]->save_flg=='Y'?'Y':'N';
						$modelDetail[$x]->trf_id='NEW';
						$modelDetail[$x]->trf_type = 'RDCL';
						$modelDetail[$x]->doc_date = $model->doc_date;				
						if($modelDetail[$x]->auto_trf=='Y')
						{	
							if($modelDetail[$x]->trf_flg_ori== null )
							{
								$modelDetail[$x]->upd_mode = 'NEW';
								$modelDetail[$x]->new_trf_flg = 'N';
							}
							else if($modelDetail[$x]->trf_flg_ori=='Y')
							{ 
								$modelDetail[$x]->upd_mode = 'NEW';
								$modelDetail[$x]->new_trf_flg = 'N';
							}
							else if($modelDetail[$x]->trf_flg_ori== 'N')
							{
								$modelDetail[$x]->upd_mode = 'NO';
							}
						}
						/*
						else if($modelDetail[$x]->auto_trf=='N' && $modelDetail[$x]->trf_flg_ori =='N')
						{
							$modelDetail[$x]->upd_mode = 'DEL';
							$modelDetail[$x]->new_trf_flg = 'N';
						}
						 * 
						 */
						else 
						{
							$modelDetail[$x]->upd_mode = 'NO';
						}		
					//}
					if($modelDetail[$x]->upd_mode != 'NO')
					{
						//EXECUTE SP
						if($modelDetail[$x]->executeSpTrf()>0)$success=true;
						else{
							$success=false;
						}	
					}
				}

				//PE to RDI Penarikan
				for($x=1;$x<=$rowCountPenarikan;$x++)
				{
					if($modelPenarikan[$x]->save_flg=='Y')
					{
						$modelPenarikan[$x]->trf_id='KBB';//tidak dipake
						$modelPenarikan[$x]->trf_type = 'PERD';//tidak dipake
						$modelPenarikan[$x]->new_trf_flg = 'N';//tidak dipake
						$modelPenarikan[$x]->upd_mode = 'DELETE';//delete berdasarkan doc_num dan doc_date
						$modelPenarikan[$x]->doc_date = $model->doc_date;
						//EXECUTE SP
						if($modelPenarikan[$x]->executeSpTrf()>0)$success=true;
						else{
							$success=false;
						}	
					}
				}

			
			
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('index'));
				}
				else 
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('danger', 'No Data Processed');
				}
			}//end valid
			
			}
			else if($scenario=='print_x')
			{
				$doc_date = $model->doc_date;
				$fund_bank_cd = $model->from_bank;
				$branch_grp = $model->brch_cd;
				$modelPrint = Autotrfselection::model()->findAllBySql(Autotrfselection::getPrintX($doc_date, $fund_bank_cd, $branch_grp));
				foreach($modelPrint as $row)
				{
					$row->save_flg = 'Y';
				}
			}
			else if($scenario=='print')
			{
				$modelReport->fund_bank_cd = $model->from_bank;
				$modelReport->branch_grp = $model->brch_cd;
				$modelReport->end_date = $model->doc_date;
				$rowCountPrint = $_POST['rowCountPrint'];
				
				$doc_num=array();
				for($x=1;$x<=$rowCountPrint;$x++)
				{
					$modelPrint[$x] = new Autotrfselection;
					$modelPrint[$x]->attributes = $_POST['Autotrfselection'][$x];
					if(isset($_POST['Autotrfselection'][$x]['save_flg']) && $_POST['Autotrfselection'][$x]['save_flg'] == 'Y')
					{
						$doc_num[] = $modelPrint[$x]->doc_num;
					}	
				}
				
				if($modelReport->validate() && $modelReport->executeRpt($doc_num)>0)
				{
					$url=$modelReport->showReport();
				}
			}
			
		}
		
		
		
		$this->render('index',array('model'=>$model,
									'modelDetail'=>$modelDetail,
									'url'=>$url,
									'modelReport'=>$modelReport,
									'modelPrint'=>$modelPrint,
									'modelPenarikan'=>$modelPenarikan));
}
	
}