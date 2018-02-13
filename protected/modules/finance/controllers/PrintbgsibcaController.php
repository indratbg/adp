<?php

class PrintbgsibcaController extends AAdminController
{
	public $layout='//layouts/admin_column3';

public function actionIndex()
{
		$model = new Rptprintbgsibca('PRINT_BG_SI_BCA','R_PRINT_BG_BCA','Print_BG_BCA.rptdesign');
		//$modelPrintBGSI = new Printbgsibca;
		$modelRetrieve=array();
		$modelUpdate=array();
		$modelBg=array();
		$modelPrint=array();
		$modelReport=array();
		$folder_cd=array();
		$model->opt_vc='%';
		$model->vch_dt = date('d/m/Y');
		$model->vch_dt2 = date('d/m/Y');
		$valid = true;
		$success = false;
		$url='';
		$url_p_bg='';
		$url_p_transfer='';
		$url_p_setoran='';
		$cnt_trans='';
		$cnt_setor='';
		if(isset($_POST['Rptprintbgsibca']))
		{
			$scenario = $_POST['scenario'];
			$model->attributes = $_POST['Rptprintbgsibca'];
			
			//Retrieve
			if($scenario =='filter')
			{
				$p_date = $model->vch_dt;
				
				if($model->user_id){
					$p_user_id = $model->user_id;	
				}else{
					$p_user_id = '%';
				}
				
				if($model->bank_cd){
					$p_sl_acct_cd = $model->bank_cd;
				}else{
					$p_sl_acct_cd = '%';
				}
				
				$p_bg_cq = $model->opt_vc;
				
				$modelRetrieve = Printbgsibca::model()->findAllBySql(Printbgsibca::getBgSi($p_date, $p_user_id, $p_sl_acct_cd, $p_bg_cq));
				
				if(count($modelRetrieve)==0)
				{
					Yii::app()->user->setFlash('danger', 'No Data Found');
				}
			}
			
			//Update BG SI
			else if($scenario =='update')
			{
				$rowCount = $_POST['rowCount'];
				
				for($x=1;$x<=$rowCount;$x++)
				{
					$modelUpdate[$x] = new Printbgsibca;
					$modelUpdate[$x]->attributes = $_POST['Printbgsibca'][$x];
					if(isset($_POST['Printbgsibca'][$x]['upd_flg']) && $_POST['Printbgsibca'][$x]['upd_flg'] == 'Y')
					{
						$valid=true;	
					}
				}
				
				if($valid)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
					
					for($x=1;$x<=$rowCount;$x++)
					{
						$sys_bank_cd = $modelUpdate[$x]->system_bank_cd;				
						$sl_acct_cd = $modelUpdate[$x]->sl_acct_cd;				
						$chq_num_old = $modelUpdate[$x]->chq_old;				
						$chq_num_new = $modelUpdate[$x]->chq_num;				
						$bg_cq_flg = $modelUpdate[$x]->bg_cq_flg;				
						$rvpv_num = $modelUpdate[$x]->rvpv_number;				
						$flg = $modelUpdate[$x]->upd_flg;
						if($flg == 'Y')
						{
							//EXECUTE SP
							if($modelUpdate[$x]->executeSpUpdate($sys_bank_cd,$sl_acct_cd,$chq_num_old,$chq_num_new,$bg_cq_flg,$rvpv_num)>0){
								$success=true;
							}
							else{
								$success=false;
								break;								
							}	
						}
					}
					if($success){
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Update');
					}else{
						$transaction->rollback();
					}
				}//end valid
			
			}

			else if($scenario=='print_bg')
			{
				$rowCount = $_POST['rowCount'];
				
				for($x=1;$x<=$rowCount;$x++)
				{
					$modelBg[$x] = new Printbgsibca;
					$modelBg[$x]->attributes = $_POST['Printbgsibca'][$x];
					
					if(isset($_POST['Printbgsibca'][$x]['flg']) && $_POST['Printbgsibca'][$x]['flg'] == 'Y')
					{
						
						$folder_cd[] = $modelBg[$x]->folder_cd;
						$model->folder=implode($folder_cd);
						// var_dump($model->folder);die();
						$valid=true;	
					}
				}
				
				if($valid){
					$model->tablename = 'R_PRINT_BG_BCA';
					$model->rptname = 'Print_BG_BCA.rptdesign';
										
					if($model->validate()){
						
					   if($model->executeSpBg($folder_cd)>0){
					 	  
						  $sql_trans="select count(1) as cnt_trf from INSISTPRO_RPT.r_print_trf_bca where user_id='".$model->vp_userid."' and rand_value=".$model->vo_random_value;
					 	  $sql_trans_bca=DAO::queryRowSql($sql_trans);
						  $sql_setor="select count(1) as cnt_setor from INSISTPRO_RPT.r_print_setoran_bca where user_id='".$model->vp_userid."' and rand_value=".$model->vo_random_value;
					 	  $sql_setor_bca=DAO::queryRowSql($sql_setor);
						  $cnt_trans=$sql_trans_bca['cnt_trf'];
						  $cnt_setor=$sql_setor_bca['cnt_setor'];
						  $rpt_link = $model->showReport();
						  $url_p_bg = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						  $model->tablename = 'R_PRINT_TRF_BCA';
					      $model->rptname = 'Print_Transfer_BCA.rptdesign';
						  $model->module = 'RPT_TRF_BCA';
					   	  $rpt_link1 = $model->showReport();
						  $url_p_transfer = $rpt_link1 . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						  $model->tablename = 'R_PRINT_SETORAN_BCA';
						  $model->rptname = 'Print_Setoran_BCA.rptdesign';
						  $model->module = 'RPT_SETORAN_BCA';
						  $rpt_link2 = $model->showReport();
						  $url_p_setoran = $rpt_link2 . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
	
					    }
						
						
					}
					
				}
			}
			
			else
			{
				$connection  = Yii::app()->dbrpt;
				$transaction = $connection->beginTransaction();
				
				$model->tablename = 'R_PRINT_SI_BCA';
				$model->rptname = 'Print_SI_BCA.rptdesign';
				
				if($model->validate() && $model->executeSpSI()>0){
					$transaction->commit();	
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					//$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					
				}else{
					
					$transaction->rollback();
				}
			}
			
		}
		
		if (DateTime::createFromFormat('Y-m-d', $model->vch_dt))
			$model->vch_dt = DateTime::createFromFormat('Y-m-d', $model->vch_dt)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->vch_dt2))
			$model->vch_dt2 = DateTime::createFromFormat('Y-m-d', $model->vch_dt2)->format('d/m/Y');
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'url_p_bg'=>$url_p_bg,
									'url_p_transfer'=>$url_p_transfer,
									'url_p_setoran'=>$url_p_setoran,
									'modelRetrieve'=>$modelRetrieve,
									'modelReport'=>$modelReport,
									'modelPrint'=>$modelPrint,
									'cnt_trans'=>$cnt_trans,
									'cnt_setor'=>$cnt_setor
									));
}
	
}