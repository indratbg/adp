<?php

Class GenKBBController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model = new GenKBB('header');
		$modelDetailList = array();
		$branchGroupList = array();
		$bankList = Fundbank::model()->findAll();
		$retrieved = false;
		$valid = false;
		$success = false;
		$scenario = '';
        //21MAR2017
        $method_flg = Sysparam::model()->find("PARAM_ID='GEN KBB' AND PARAM_CD1='METHOD'")->dflg1;
				
		if(isset($_POST['GenKBB']))
		{
			$model->attributes = $_POST['GenKBB'];
			$scenario = $_POST['submit'];
			
			if($scenario != 'download')
			{	
				if($model->branch_all_flg == 'Y')
				{
					$branchGroupList = DAO::queryAllSql("SELECT prm_desc branch_group FROM MST_PARAMETER WHERE prm_cd_1 = 'KBBGRP' AND prm_desc <> 'XX'");
					
					/*foreach($result as $row)
					{
						$branchGroupList = array_merge($branchGroupList, explode(',', $row['prm_desc']));
					}*/
				}
				else 
				{
					//$branchGroupList = explode(',', $model->branch_code);
					$branchGroupList = array(0 => array('branch_group'=>$model->branch_code));
				}
				
				$totalBranch = count($branchGroupList);
				
				if($model->validate())
				{
					$retrieved = true;
					
					$x = 0;
					$end_date = $model->due_date;
					
					switch($model->payrec_type)
					{
						case AConstant::KBB_TYPE_AP:
							
							//$end_date = date('Y-m-d');
							//$end_date = $model->due_date;
							
							switch($model->bank_cd) 
							{
								case 'BCA02':
									$success = true;
									
									$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
									$trfId = $result['trf_id'];
									
									$connection  = Yii::app()->db;
									$transaction = $connection->beginTransaction();
									
									foreach($branchGroupList as $row)
									{
										$modelDetailList[$x][0] = GenKBB::model()->findAllBySql(GenKBB::getKbbApSql($end_date, $row['branch_group']));
										
										foreach($modelDetailList[$x][0] as $row)
										{
											$row->trf_id = $trfId;
											
											if($row['upd_flg'] == 'Y')
											{
												if( !($success = $success && $row->executeSpFundTrf('KBB','PERD','UPD','Y') > 0) )
												{
													$model->addError('error_msg', 'Error '.$row->error_code.' '.$row->error_msg);
													break 2;
												}
											}
										}
											
										if(count($modelDetailList[$x][0]))
										{
											if($success = $success && $model->executeSpFundTrf($trfId, 'AP', 'NEW', 'Y') > 0)
											{
												//25jan2017 pake seq untuk ambil trf id	
												//$trfId++;
												$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
												$trfId = $result['trf_id'];
											}
											else 
											{
												$model->addError('error_msg', 'Error '.$model->error_code.' '.$model->error_msg);
												break;
											}
										}
									
										$x++;
										
									}
									
									if($success)
									{
										$transaction->commit();
									}
									else 
									{
										$transaction->rollback();
										
										$modelDetailList = array();
									}
									
									break;
									
								case 'BNGA3':
									foreach($branchGroupList as $row)
									{
										// To handle the differences in MST_PARAMETER.prm_desc WHERE prm_cd_1 = 'KBBGRP'
										$branch = strpos($row['branch_group'],',') !== false ? $row['branch_group'] : substr($row['branch_group'],0,2);
										
										$modelDetailList[$x][0] = GenKBB::model()->findAllBySql(GenKBB::getCimbApSql($end_date, $branch));
										
										$x++;
									}
									
									break;
							}
							
						
							break;
							
						case AConstant::KBB_TYPE_AR:
							
							//$end_date = $model->due_date;
							
							switch($model->bank_cd)
							{
								case 'BCA02':
									$success = true;
									
									$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
									$trfId = $result['trf_id'];
									
									$connection  = Yii::app()->db;
									$transaction = $connection->beginTransaction();
									
									foreach($branchGroupList as $row)
									{
										$modelDetailList[$x][0] = GenKBB::model()->findAllBySql(GenKBB::getKbbArSql($end_date, $row['branch_group']));
										
										foreach($modelDetailList[$x][0] as $row)
										{
											$row->trf_id = $trfId;
											
											if($row['upd_flg'] == 'Y')
											{
												if( !($success = $success && $row->executeSpFundTrf('KBB','RDPE','UPD','Y') > 0) )
												{
													$model->addError('error_msg', 'Error '.$row->error_code.' '.$row->error_msg);
													break 2;
												}
											}
										}
										
										if(count($modelDetailList[$x][0]))
										{
											if($success = $success && $model->executeSpFundTrf($trfId, 'AR', 'NEW', 'Y') > 0)
											{
												//25jan2017 pake seq untuk ambil trf id	
												//$trfId++;
												$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
												$trfId = $result['trf_id'];
											}
											else 
											{
												$model->addError('error_msg', 'Error '.$model->error_code.' '.$model->error_msg);
												break;
											}
										}
										
										$x++;

									}
									
									if($success)
									{
										$transaction->commit();
									}
									else 
									{
										$transaction->rollback();
										
										$modelDetailList = array();
									}
									
								break;
								
								case 'BNGA3':
									foreach($branchGroupList as $row)
									{
										// To handle the differences in MST_PARAMETER.prm_desc WHERE prm_cd_1 = 'KBBGRP'
										$branch = strpos($row['branch_group'],',') !== false ? $row['branch_group'] : substr($row['branch_group'],0,2);
										
										$modelDetailList[$x][0] = GenKBB::model()->findAllBySql(GenKBB::getCimbArSql($end_date, $branch));
										
										$x++;
									}
									
									break;
							}
							
							break;
							
						case AConstant::KBB_TYPE_TO_RDI:
							
							//$end_date = $model->due_date;
							$success = true;
							
							$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
							$trfId = $result['trf_id'];
							
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction();
							
							foreach($branchGroupList as $row)
							{
								$modelDetailList[$x]['Fee'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToRdiSql($end_date, 'FEE', $row['branch_group']));
								$modelDetailList[$x]['Payment'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToRdiSql($end_date, 'PAYM', $row['branch_group']));
								
								foreach($modelDetailList[$x]['Fee'] as $feeRow)
								{
									$feeRow->trf_id = $trfId;
									
									if( !($success = $success && $feeRow->executeSpFundTrf('FEE','PERD','NEW','Y') > 0) )
									{
										$model->addError('error_msg', 'Error '.$feeRow->error_code.' '.$feeRow->error_msg);
										break 2;
									}
								}

								
								if(count($modelDetailList[$x]['Fee']))
								{
									if($success = $success && $model->executeSpFundTrf($trfId, 'AP', 'NEW', 'Y') > 0)
									{
										//25jan2017 pake seq untuk ambil trf id	
										//$trfId++;
										$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
										$trfId = $result['trf_id'];
									}
									else 
									{
										$model->addError('error_msg', 'Error '.$model->error_code.' '.$model->error_msg);
										break;
									}
								}
								
								foreach($modelDetailList[$x]['Payment'] as $paymentRow)
								{
									$paymentRow->trf_id = $trfId;
									
									if( !($success = $success && $paymentRow->executeSpFundTrf('KBB','PERD','NEW','Y') > 0) )
									{
										$model->addError('error_msg', 'Error '.$paymentRow->error_code.' '.$paymentRow->error_msg);
										break 2;
									}
								}
																	
								if(count($modelDetailList[$x]['Payment']))
								{
									if($success = $success && $model->executeSpFundTrf($trfId, 'AP', 'NEW', 'Y') > 0)
									{
										//25jan2017 pake seq untuk ambil trf id	
										//$trfId++;
										$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
										$trfId = $result['trf_id'];
									}
									else 
									{
										$model->addError('error_msg', 'Error '.$model->error_code.' '.$model->error_msg);
										break;
									}
								}
																	
								$x++;	
							}
							
							
							if($success)
							{
								$transaction->commit();
							}
							else 
							{
								$transaction->rollback();
								
								$modelDetailList = array();
							}

							break;
							
						case AConstant::KBB_TYPE_TO_CLIENT:
							
							$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
							//26jan2017
							//$trfId = $result['trf_id'] - 1;
							$trfId = $result['trf_id'];
							
							$success = true;
									
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction();
							
							foreach($branchGroupList as $row)
							{
								if($model->payrec_type == AConstant::KBB_TYPE_TO_CLIENT)
								{
									$modelDetailList[$x]['BCA'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToClientSql($end_date, 'BCA', $row['branch_group']));
									$modelDetailList[$x]['LLG'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToClientSql($end_date, 'LLG', $row['branch_group']));
									$modelDetailList[$x]['RTGS'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToClientSql($end_date, 'RTG', $row['branch_group']));
								}
								else
								{
									$modelDetailList[$x]['BCA'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToClientIPOSql($end_date, 'BCA', $row['branch_group']));
									$modelDetailList[$x]['LLG'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToClientIPOSql($end_date, 'LLG', $row['branch_group']));
									$modelDetailList[$x]['RTGS'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToClientIPOSql($end_date, 'RTG', $row['branch_group']));
								}
								
								if(count($modelDetailList[$x]['BCA']))
								{
									//26jan2017	
									//$trfId++;
									$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
									$trfId = $result['trf_id'];
								}
					
								foreach($modelDetailList[$x]['BCA'] as $bcaRow)
								{
									$bcaRow->trf_id = $trfId;
									
									if( !($success = $success && $bcaRow->executeSpFundTrf($trfId,'RDCL','UPD','Y') > 0) )
									{
										$model->addError('error_msg', 'Error '.$bcaRow->error_code.' '.$bcaRow->error_msg);
										break 2;
									}
								}
		
								$valid = true;
								
								foreach($modelDetailList[$x]['LLG'] as $llgRow)
								{
									if($llgRow->bank_cd == '')
									{
										$success = $valid = false;
										$model->addError('error_msg', 'Error '.$llgRow->client_cd.'. Bank name cannot be blank if destination bank is not BCA.');
										break 2;
									}
								}	
								
								if($valid)
								{
									if(count($modelDetailList[$x]['LLG']))
									{
										//26jan2017	
										//$trfId++;
										$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
										$trfId = $result['trf_id'];
									}
																		
									foreach($modelDetailList[$x]['LLG'] as $llgRow)
									{
										$llgRow->trf_id = $trfId;
																		
										if( !($success = $success && $llgRow->executeSpFundTrf($trfId,'RDCL','UPD','Y') > 0) )
										{
											$model->addError('error_msg', 'Error '.$llgRow->error_code.' '.$llgRow->error_msg);
											break 2;
										}
									}
								}
										
								$valid = true;
								
								foreach($modelDetailList[$x]['RTGS'] as $rtgsRow)
								{
									if($rtgsRow->bank_cd == '')
									{
										$success = $valid = false;
										$model->addError('error_msg', 'Error '.$rtgsRow->client_cd.'. Bank name cannot be blank if destination bank is not BCA.');
										break 2;
									}
								}
								
								if($valid)
								{
									if(count($modelDetailList[$x]['RTGS']))
									{
										//26jan2017	
										//$trfId++;
										$result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
										$trfId = $result['trf_id'];
									}
																		
									foreach($modelDetailList[$x]['RTGS'] as $rtgsRow)
									{
										$rtgsRow->trf_id = $trfId;
										
										if( !($success = $success && $rtgsRow->executeSpFundTrf($trfId,'RDCL','UPD','Y') > 0) )
										{
											$model->addError('error_msg', 'Error '.$rtgsRow->error_code.' '.$rtgsRow->error_msg);
											break 2;
										}
									}
								}
								
								$x++;
							}
		
							if($success)
							{
								$transaction->commit();
							}
							else 
							{
								$transaction->rollback();
								
								$modelDetailList = array();
							}
							
							break;
                            
                            //16 JUN2017 TRANSFER PE KE RDN UNTUK APPSFUND
                            case AConstant::KBB_TYPE_TO_RDI_FUND:
                            
                            $success = true;
                            
                            $result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
                            $trfId = $result['trf_id'];
                            
                            $connection  = Yii::app()->db;
                            $transaction = $connection->beginTransaction();
                            
                            foreach($branchGroupList as $row)
                            {
                                $modelDetailList[$x]['Fee'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToRdiFundSql($end_date, 'FEE', $row['branch_group']));
                                $modelDetailList[$x]['Payment'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToRdiFundSql($end_date, 'PAYM', $row['branch_group']));
                                
                                foreach($modelDetailList[$x]['Fee'] as $feeRow)
                                {
                                    $feeRow->trf_id = $trfId;
                                    
                                    if( !($success = $success && $feeRow->executeSpFundTrf('FEE','PERD','NEW','Y') > 0) )
                                    {
                                        $model->addError('error_msg', 'Error '.$feeRow->error_code.' '.$feeRow->error_msg);
                                        break 2;
                                    }
                                }

                                
                                if(count($modelDetailList[$x]['Fee']))
                                {
                                    if($success = $success && $model->executeSpFundTrf($trfId, 'AP', 'NEW', 'Y') > 0)
                                    {
                                        //25jan2017 pake seq untuk ambil trf id 
                                        //$trfId++;
                                        $result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
                                        $trfId = $result['trf_id'];
                                    }
                                    else 
                                    {
                                        $model->addError('error_msg', 'Error '.$model->error_code.' '.$model->error_msg);
                                        break;
                                    }
                                }
                                
                                foreach($modelDetailList[$x]['Payment'] as $paymentRow)
                                {
                                    $paymentRow->trf_id = $trfId;
                                    
                                    if( !($success = $success && $paymentRow->executeSpFundTrf('KBB','PERD','NEW','Y') > 0) )
                                    {
                                        $model->addError('error_msg', 'Error '.$paymentRow->error_code.' '.$paymentRow->error_msg);
                                        break 2;
                                    }
                                }
                                                                    
                                if(count($modelDetailList[$x]['Payment']))
                                {
                                    if($success = $success && $model->executeSpFundTrf($trfId, 'AP', 'NEW', 'Y') > 0)
                                    {
                                        //25jan2017 pake seq untuk ambil trf id 
                                        //$trfId++;
                                        $result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
                                        $trfId = $result['trf_id'];
                                    }
                                    else 
                                    {
                                        $model->addError('error_msg', 'Error '.$model->error_code.' '.$model->error_msg);
                                        break;
                                    }
                                }
                                                                    
                                $x++;   
                            }
                            
                            
                            if($success)
                            {
                                $transaction->commit();
                            }
                            else 
                            {
                                $transaction->rollback();
                                
                                $modelDetailList = array();
                            }

                            break;
                            //16 JUN 2017 TRANSFER DARI RDN KE REK CLIENT UNTUK APPSFUND
                            case AConstant::KBB_TYPE_TO_CLIENT_FUND:
                            
                            $result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
                            //26jan2017
                            //$trfId = $result['trf_id'] - 1;
                            $trfId = $result['trf_id'];
                            
                            $success = true;
                                    
                            $connection  = Yii::app()->db;
                            $transaction = $connection->beginTransaction();
                            
                            foreach($branchGroupList as $row)
                            {
                                    $modelDetailList[$x]['BCA'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToClientFundSql($end_date, 'BCA', $row['branch_group']));
                                    $modelDetailList[$x]['LLG'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToClientFundSql($end_date, 'LLG', $row['branch_group']));
                                    $modelDetailList[$x]['RTGS'] = GenKBB::model()->findAllBySql(GenKBB::getKbbToClientFundSql($end_date, 'RTG', $row['branch_group']));
                                
                                if(count($modelDetailList[$x]['BCA']))
                                {
                                    //26jan2017 
                                    //$trfId++;
                                    $result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
                                    $trfId = $result['trf_id'];
                                }
                    
                                foreach($modelDetailList[$x]['BCA'] as $bcaRow)
                                {
                                    $bcaRow->trf_id = $trfId;
                                    
                                    if( !($success = $success && $bcaRow->executeSpFundTrf($trfId,'RDCL','UPD','Y') > 0) )
                                    {
                                        $model->addError('error_msg', 'Error '.$bcaRow->error_code.' '.$bcaRow->error_msg);
                                        break 2;
                                    }
                                }
        
                                $valid = true;
                                
                                foreach($modelDetailList[$x]['LLG'] as $llgRow)
                                {
                                    if($llgRow->bank_cd == '')
                                    {
                                        $success = $valid = false;
                                        $model->addError('error_msg', 'Error '.$llgRow->client_cd.'. Bank name cannot be blank if destination bank is not BCA.');
                                        break 2;
                                    }
                                }   
                                
                                if($valid)
                                {
                                    if(count($modelDetailList[$x]['LLG']))
                                    {
                                        //26jan2017 
                                        //$trfId++;
                                        $result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
                                        $trfId = $result['trf_id'];
                                    }
                                                                        
                                    foreach($modelDetailList[$x]['LLG'] as $llgRow)
                                    {
                                        $llgRow->trf_id = $trfId;
                                                                        
                                        if( !($success = $success && $llgRow->executeSpFundTrf($trfId,'RDCL','UPD','Y') > 0) )
                                        {
                                            $model->addError('error_msg', 'Error '.$llgRow->error_code.' '.$llgRow->error_msg);
                                            break 2;
                                        }
                                    }
                                }
                                        
                                $valid = true;
                                
                                foreach($modelDetailList[$x]['RTGS'] as $rtgsRow)
                                {
                                    if($rtgsRow->bank_cd == '')
                                    {
                                        $success = $valid = false;
                                        $model->addError('error_msg', 'Error '.$rtgsRow->client_cd.'. Bank name cannot be blank if destination bank is not BCA.');
                                        break 2;
                                    }
                                }
                                
                                if($valid)
                                {
                                    if(count($modelDetailList[$x]['RTGS']))
                                    {
                                        //26jan2017 
                                        //$trfId++;
                                        $result = DAO::queryRowSql("SELECT get_trf_id(TO_DATE('$end_date','YYYY-MM-DD')) trf_id FROM dual");
                                        $trfId = $result['trf_id'];
                                    }
                                                                        
                                    foreach($modelDetailList[$x]['RTGS'] as $rtgsRow)
                                    {
                                        $rtgsRow->trf_id = $trfId;
                                        
                                        if( !($success = $success && $rtgsRow->executeSpFundTrf($trfId,'RDCL','UPD','Y') > 0) )
                                        {
                                            $model->addError('error_msg', 'Error '.$rtgsRow->error_code.' '.$rtgsRow->error_msg);
                                            break 2;
                                        }
                                    }
                                }
                                
                                $x++;
                            }
        
                            if($success)
                            {
                                $transaction->commit();
                            }
                            else 
                            {
                                $transaction->rollback();
                                
                                $modelDetailList = array();
                            }
                            
                            break;
					}
				} 
			}
			else
			{
				//DOWNLOAD
				
				$fileType = $_POST['fileType'];
				$activeTab = strtoupper($_POST['activeTab']);
				$fileName = $fileDownloadName = '';
				
				switch($model->payrec_type)
				{
					case AConstant::KBB_TYPE_AP:
						
						if($model->bank_cd == 'BCA02')
						{
							$fileDownloadName = 'Kbb AP'.$_POST['downloadSeq'].' '.DateTime::createFromFormat('d/m/Y',$model->due_date)->format('dMy');
						}
						else
						{
							$branch = isset($_POST['detailBranchGroupTxt'])?$_POST['detailBranchGroupTxt']:$model->branch_code;
							
							// To handle the differences in MST_PARAMETER.prm_desc WHERE prm_cd_1 = 'KBBGRP'
							$downloadSeq = strpos($branch,',') !== false ? $_POST['downloadSeq'] : substr($branch,0,2);
							
							$fileDownloadName = $model->bank_cd.' AP '.$downloadSeq.' '.DateTime::createFromFormat('d/m/Y',$model->due_date)->format('dMy');
						}
						
						break;
											
					case AConstant::KBB_TYPE_AR:
						if($model->bank_cd == 'BCA02')
						{
							$fileDownloadName = 'Kbb AR'.$_POST['downloadSeq'].' '.DateTime::createFromFormat('d/m/Y',$model->due_date)->format('dMy');
						}
						else
						{
							$branch = isset($_POST['detailBranchGroupTxt'])?$_POST['detailBranchGroupTxt']:$model->branch_code;
							
							// To handle the differences in MST_PARAMETER.prm_desc WHERE prm_cd_1 = 'KBBGRP'
							$downloadSeq = strpos($branch,',') !== false ? $_POST['downloadSeq'] : substr($branch,0,2);
							
							$fileDownloadName = $model->bank_cd.' AR '.$downloadSeq.' '.DateTime::createFromFormat('d/m/Y',$model->due_date)->format('dMy');
						}
						
						break;
						
					case AConstant::KBB_TYPE_TO_RDI:
						$activeTab = $activeTab == 'FEE'?'BIAYA':'PENARIKAN';
						$fileDownloadName = 'Kbb '.$activeTab.' '.DateTime::createFromFormat('d/m/Y',$model->due_date)->format('dMy');
									
						break;
						
					case AConstant::KBB_TYPE_TO_CLIENT:
						$activeTab = substr($activeTab,0,3);
						$fileDownloadName = 'Trf_'.DateTime::createFromFormat('d/m/Y',$model->due_date)->format('Ymd').'_07PAYM_'.$activeTab;
						
						break;
                       //16 JUN2017 UNTUK APPSFUND 
                    case AConstant::KBB_TYPE_TO_RDI_FUND:
                        $activeTab = $activeTab == 'FEE'?'BIAYA':'PENARIKAN';
                        $fileDownloadName = 'Kbb '.$activeTab.' '.DateTime::createFromFormat('d/m/Y',$model->due_date)->format('dMy');
                                    
                        break;
                    case AConstant::KBB_TYPE_TO_CLIENT_FUND:
                        $activeTab = substr($activeTab,0,3);
                        $fileDownloadName = 'Trf_'.DateTime::createFromFormat('d/m/Y',$model->due_date)->format('Ymd').'_07PAYM_'.$activeTab;
                        
                        break;  
				}
				
				if($fileType == 'txt')
				{
					$fileName = $_POST['textFileName'];
			
					if(file_exists($fileName))
					{
					    header('Content-Description: File Transfer');
					    header('Content-Type: text/txt');
					    //header('Content-Disposition: attachment; filename='.basename($textFile));
					    header('Content-Disposition: attachment; filename="'.$fileDownloadName.'.txt"');
					    header('Expires: 0');
					    header('Cache-Control: must-revalidate');
					    header('Pragma: public');
					    header('Content-Length: ' . filesize($fileName));
						ob_clean();
						flush();
					    readfile($fileName);
						unlink($fileName);
					}
				}
				else if($fileType == 'xls')
				{
					$fileName = $_POST['excelFileName'];
					
					if(file_exists($fileName))
					{
						header('Content-Description: File Transfer');
					    header('Content-Type: application/vnd.ms-excel');
					    header('Content-Disposition: attachment; filename="'.$fileDownloadName.'.xls"');
					    header('Expires: 0');
					    header('Cache-Control: must-revalidate');
					    header('Pragma: public');
					    header('Content-Length: ' . filesize($fileName));
						ob_clean();
						flush();
					    readfile($fileName);
						unlink($fileName);
					} 
				}
				else 
				{
					// CSV
					
					$fileName = $_POST['csvFileName'];

					if(file_exists($fileName))
					{
						header('Content-Description: File Transfer');
					    header('Content-Type: application/vnd.ms-excel');
					    header('Content-Disposition: attachment; filename="'.$fileDownloadName.'.csv"');
					    header('Expires: 0');
					    header('Cache-Control: must-revalidate');
					    header('Pragma: public');
					    header('Content-Length: ' . filesize($fileName));
						ob_clean();
						flush();
					    readfile($fileName);
						unlink($fileName);
					} 
				}
			}
		}
		else 
		{
			$model->due_date = date('d/m/Y');
			$model->branch_all_flg = 'Y';
			//$model->save_text_flg = 'Y';
			$model->method = 1;

			foreach($bankList as $row)
			{
				if($row->default_flg == 'Y')$model->bank_cd = $row->bank_cd;
			}

			switch($model->bank_cd)
			{
				case 'BCA02':
					$model->save_text_flg = 'Y';
					break;
				
				case 'BNGA3':
					$model->save_csv_flg = 'Y';
					break;
					
				default:
					$model->save_text_flg = 'Y';
					break;
			}
		}
		
		$this->render('index',array(
			'model'=>$model,
			'modelDetailList'=>$modelDetailList,
			'branchGroupList'=>$branchGroupList,
			'bankList'=>$bankList,
			'retrieved'=>$retrieved,
			'scenario'=>$scenario,
			'method_flg'=>$method_flg
		));
	}

	public function actionAjxPrepareFile()
	{
		$result = FALSE;
		
		if(isset($_POST['record']))
		{
			$data = $_POST['record'];
			$totalAmount = $_POST['totalAmount'];
			$totalRecord = $_POST['totalRecord'];	
			$payrec_type = $_POST['payrecType'];
			$active_tab = $_POST['activeTab'];
			$bank = $_POST['bank'];
			$method = $_POST['method'];
			$fileType = $_POST['fileType'];
			$branchGroupIndex = $_POST['branchGroupIndex'];
			$branchGroup = $_POST['branchGroup'];
			
			$trfHeader = $trfDetail = array();
			//08feb2017cek trf_id if existing from t_h2h_ref_header
			$trf_id = $data[0]['trf_id'];
			$check_trf_id = Th2hrefheader::model()->find("trf_id='$trf_id' ");
            $corp_id = Sysparam::model()->find("PARAM_ID='HOST TO HOST' and param_cd1='CORP_ID' ");
			if($check_trf_id)
			{
				$result['errorMessage']='File has been sent, please wait in a few minutes';
			}
			 
			//if($fileType == 'txt' || $method == 2)
			if(($fileType == 'txt' && $method==1 )|| ($method == 2 && !$check_trf_id))
			{
				$pureFileName = 'kbb_'.date('YmdHis').substr((string)microtime(), 2, 6).'_YJ.txt';
				$textFileName = Yii::app()->basePath.'/../upload/gen_kbb/'.$pureFileName;
				$handle = fopen($textFileName,'wb');
				
				if($bank == 'BCA02')
				{
					switch($payrec_type)
					{
						case AConstant::KBB_TYPE_AP :
						case AConstant::KBB_TYPE_TO_RDI :
							
							if($method == 1)
							{
								// MANUAL
								
								$content = '0MP'.DateTime::createFromFormat('d/m/Y',$data[0]['trans_date'])->format('Ymd').'4583010541'.' '.$corp_id->dstr1.str_repeat(' ',15);
								$content .= str_pad($totalAmount,20,'0',STR_PAD_LEFT);
								$content .= str_pad($totalRecord,5,'0',STR_PAD_LEFT);
								$content .= 'BCA';
								$content .= str_repeat(' ',183);
								
								foreach($data as $row)
								{
									$content .= "\r\n";
									$content .= "1";
									$content .= str_pad($row['bank_acct_num'],34,' ',STR_PAD_RIGHT);
									$content .= str_repeat(' ',18);
									$content .= str_pad($row['trans_amount'],20,'0',STR_PAD_LEFT);
									$content .= str_pad($row['client_name'],70,' ',STR_PAD_RIGHT);
									$content .= str_pad($row['bank_cd'],7,' ',STR_PAD_RIGHT);
									$content .= str_pad($row['bi_code'],11,' ',STR_PAD_RIGHT);
									$content .= str_pad($row['bank_cd'],18,' ',STR_PAD_RIGHT);
									$content .= str_pad($row['bank_branch_name'],18,' ',STR_PAD_RIGHT);
									$content .= str_pad($row['remark1'],18,' ',STR_PAD_RIGHT);
									$content .= str_pad($row['remark2'],36,' ',STR_PAD_RIGHT);
									//$content .= str_repeat(' ',18);
									$content .= $row['customer_type'];
									$content .= $row['customer_residence'];
									$content .= $row['bank_cd']=='BCA'?'014':'888';
								}
							}
							else 
							{
								// HOST TO HOST
								
								$content = '0'.'|';
								$content .= 'CR'.'|';
								$content .= 'MP'.'|';
								$content .= $data[0]['trf_id'].'|';
								$content .= '|';
								$content .= '|';
								$content .= DateTime::createFromFormat('d/m/Y',$data[0]['trans_date'])->format('Ymd').'|';
								$content .= '4583010541'.'|';
								//$content .= '04580606'.'|';//AMBIL DARI SYSPARAM
								$content .= $corp_id->dstr1.'|';
								//$content .= 'KBCLAUTAND'.'|';//uncomment jika taro live, ambil dari sys param
								//$content .= 'lautandana'.'|';//comment jika taro di live
								$content .= $corp_id->dstr2.'|';
								$content .= $totalAmount.'|';
								$content .= $totalRecord.'|';
								$content .= 'BCA'.'|';
								$content .= 'IDR'.'|';
								$content .= 'N'.'|';
								$content .= '|';
								
								$trfHeader['trf_id'] = $data[0]['trf_id'];
								$trfHeader['file_name'] = $pureFileName;
								$trfHeader['trx_type'] = 'CR';
								$trfHeader['kbb_type1'] = $payrec_type;
								$trfHeader['kbb_type2'] = $active_tab;
								$trfHeader['branch_group'] = $branchGroup;
								$trfHeader['trf_date'] = $data[0]['trans_date'];
								$trfHeader['save_date'] = date('d/m/Y H:i:s');
								$trfHeader['total_record'] = $totalRecord;
								
								$x = 0;
								
								foreach($data as $row)
								{
									$content .= "\r\n";
									$content .= '1'.'|';
									$content .= ($x+1).'|';
									//$content .= date('my').'ZZ1234567'.'|';
									$content .= $row['payrec_num'].'|';
									$content .= $row['bank_acct_num'].'|';
									$content .= $row['trans_amount'].'|';
									$content .= substr($row['client_name'],0,35).'|';
									$content .= $row['bi_code'].'|';
									$content .= $row['bank_cd'].'|';
									$content .= $row['bank_branch_name'].'|';
									$content .= substr($row['remark1'],0,18).'|';
									$content .= substr($row['remark2'],0,18).'|';
									
									$trfDetail[$x]['row_id'] = $x+1;
									$trfDetail[$x]['trx_ref'] = $row['payrec_num'];
									$trfDetail[$x]['trf_id'] = $trfHeader['trf_id'];
									$trfDetail[$x]['acct_name'] = $row['client_name'];
									$trfDetail[$x]['rdi_acct'] = $row['bank_acct_num'];
									$trfDetail[$x]['trf_amt'] = $row['trans_amount'];
									
									$x++;
								}
							}
							
							break;
							//16 jun2017 untuk appsfund
						case AConstant::KBB_TYPE_TO_RDI_FUND :
                            
                            if($method == 1)
                            {
                                // MANUAL
                                
                                $content = '0MP'.DateTime::createFromFormat('d/m/Y',$data[0]['trans_date'])->format('Ymd').'4583010541'.' '.$corp_id->dstr1.str_repeat(' ',15);
                                $content .= str_pad($totalAmount,20,'0',STR_PAD_LEFT);
                                $content .= str_pad($totalRecord,5,'0',STR_PAD_LEFT);
                                $content .= 'BCA';
                                $content .= str_repeat(' ',183);
                                
                                foreach($data as $row)
                                {
                                    $content .= "\r\n";
                                    $content .= "1";
                                    $content .= str_pad($row['bank_acct_num'],34,' ',STR_PAD_RIGHT);
                                    $content .= str_repeat(' ',18);
                                    $content .= str_pad($row['trans_amount'],20,'0',STR_PAD_LEFT);
                                    $content .= str_pad($row['client_name'],70,' ',STR_PAD_RIGHT);
                                    $content .= str_pad($row['bank_cd'],7,' ',STR_PAD_RIGHT);
                                    $content .= str_pad($row['bi_code'],11,' ',STR_PAD_RIGHT);
                                    $content .= str_pad($row['bank_cd'],18,' ',STR_PAD_RIGHT);
                                    $content .= str_pad($row['bank_branch_name'],18,' ',STR_PAD_RIGHT);
                                    $content .= str_pad($row['remark1'],18,' ',STR_PAD_RIGHT);
                                    $content .= str_pad($row['remark2'],36,' ',STR_PAD_RIGHT);
                                    //$content .= str_repeat(' ',18);
                                    $content .= $row['customer_type'];
                                    $content .= $row['customer_residence'];
                                    $content .= $row['bank_cd']=='BCA'?'014':'888';
                                }
                            }
                            else 
                            {
                                // HOST TO HOST
                                
                                $content = '0'.'|';
                                $content .= 'CR'.'|';
                                $content .= 'MP'.'|';
                                $content .= $data[0]['trf_id'].'|';
                                $content .= '|';
                                $content .= '|';
                                $content .= DateTime::createFromFormat('d/m/Y',$data[0]['trans_date'])->format('Ymd').'|';
                                $content .= '4583010541'.'|';
                                //$content .= '04580606'.'|';//ambil dari sysparam
                                $content .= $corp_id->dstr1.'|';
                                //$content .= 'KBCLAUTAND'.'|';//uncomment jika taro live, ambil dari sys param
                                //$content .= 'lautandana'.'|';//comment jika taro di live
                                $content .= $corp_id->dstr2.'|';
                                $content .= $totalAmount.'|';
                                $content .= $totalRecord.'|';
                                $content .= 'BCA'.'|';
                                $content .= 'IDR'.'|';
                                $content .= 'N'.'|';
                                $content .= '|';
                                
                                $trfHeader['trf_id'] = $data[0]['trf_id'];
                                $trfHeader['file_name'] = $pureFileName;
                                $trfHeader['trx_type'] = 'CR';
                                $trfHeader['kbb_type1'] = $payrec_type;
                                $trfHeader['kbb_type2'] = $active_tab;
                                $trfHeader['branch_group'] = $branchGroup;
                                $trfHeader['trf_date'] = $data[0]['trans_date'];
                                $trfHeader['save_date'] = date('d/m/Y H:i:s');
                                $trfHeader['total_record'] = $totalRecord;
                                
                                $x = 0;
                                
                                foreach($data as $row)
                                {
                                    $content .= "\r\n";
                                    $content .= '1'.'|';
                                    $content .= ($x+1).'|';
                                    //$content .= date('my').'ZZ1234567'.'|';
                                    $content .= $row['payrec_num'].'|';
                                    $content .= $row['bank_acct_num'].'|';
                                    $content .= $row['trans_amount'].'|';
                                    $content .= substr($row['client_name'],0,35).'|';
                                    $content .= $row['bi_code'].'|';
                                    $content .= $row['bank_cd'].'|';
                                    $content .= $row['bank_branch_name'].'|';
                                    $content .= substr($row['remark1'],0,18).'|';
                                    $content .= substr($row['remark2'],0,18).'|';
                                    
                                    $trfDetail[$x]['row_id'] = $x+1;
                                    $trfDetail[$x]['trx_ref'] = $row['payrec_num'];
                                    $trfDetail[$x]['trf_id'] = $trfHeader['trf_id'];
                                    $trfDetail[$x]['acct_name'] = $row['client_name'];
                                    $trfDetail[$x]['rdi_acct'] = $row['bank_acct_num'];
                                    $trfDetail[$x]['trf_amt'] = $row['trans_amount'];
                                    
                                    $x++;
                                }
                            }
                            
                            break;	
						case AConstant::KBB_TYPE_AR :
							
							if($method == 1)
							{
								// MANUAL
								
								$content = '0CO'.DateTime::createFromFormat('d/m/Y',$data[0]['trans_date'])->format('Ymd').'4583010541'.' '.'04580510'.str_repeat(' ',15);
								$content .= str_pad($totalAmount,20,'0',STR_PAD_LEFT);
								$content .= str_pad($totalRecord,5,'0',STR_PAD_LEFT);
								$content .= str_pad('AR'.$branchGroupIndex,18,' ',STR_PAD_RIGHT);
								$content .= str_pad(date('dmy'),18,' ',STR_PAD_RIGHT);
								$content .= str_repeat(' ',95);
								
								foreach($data as $row)
								{
									$content .= "\r\n";
									$content .= "1";
									$content .= str_pad($row['bank_acct_num'],34,' ',STR_PAD_RIGHT);
									$content .= str_pad($row['trans_amount'],20,'0',STR_PAD_LEFT);
									$content .= str_pad($row['client_name'],35,' ',STR_PAD_RIGHT);
									$content .= str_pad($row['remark1'],18,' ',STR_PAD_RIGHT);
									$content .= str_pad($row['remark2'],18,' ',STR_PAD_RIGHT);
									$content .= str_repeat(' ',72).'014';
								}
							}
							else 
							{
								// HOST TO HOST
								
								$content = '0'.'|';
								$content .= 'CO'.'|';
								$content .= $data[0]['trf_id'].'|';
								$content .= '|';
								$content .= '|';
								$content .= DateTime::createFromFormat('d/m/Y',$data[0]['trans_date'])->format('Ymd').'|';
								$content .= '4583010541'.'|';
								$content .= '04580510'.'|';//ambil dari sysparam
                                //$content .= $corp_id->dstr1.'|';//beda untuk acuto collect
								//$content .= 'KBCLAUTAND'.'|';//uncomment jika taro live, ambil dari sysparam
								//$content .= 'lautandana'.'|';//comment jika taro di live
								$content .= $corp_id->dstr2.'|';
								$content .= $totalAmount.'|';
								$content .= $totalRecord.'|';
								$content .= 'IDR'.'|';
								$content .= 'N'.'|';
								$content .= '|';
								
								$trfHeader['trf_id'] = $data[0]['trf_id'];
								$trfHeader['file_name'] = $pureFileName;
								$trfHeader['trx_type'] = 'CO';
								$trfHeader['kbb_type1'] = $payrec_type;
								$trfHeader['kbb_type2'] = $active_tab;
								$trfHeader['branch_group'] = $branchGroup;
								$trfHeader['trf_date'] = $data[0]['trans_date'];
								$trfHeader['save_date'] = date('d/m/Y H:i:s');
								$trfHeader['total_record'] = $totalRecord;
								
								$x = 0;
								
								foreach($data as $row)
								{
									$content .= "\r\n";
									$content .= '1'.'|';
									$content .= ($x+1).'|';
									//$content .= date('my').'ZZ1234567'.'|';
									$content .= $row['payrec_num'].'|';
									$content .= $row['bank_acct_num'].'|';
									$content .= $row['trans_amount'].'|';
									$content .= substr($row['client_name'],0,35).'|';
									$content .= substr($row['remark1'],0,18).'|';
									$content .= substr($row['remark2'],0,18).'|';
									
									$trfDetail[$x]['row_id'] = $x+1;
									$trfDetail[$x]['trx_ref'] = $row['payrec_num'];
									$trfDetail[$x]['trf_id'] = $trfHeader['trf_id'];
									$trfDetail[$x]['acct_name'] = $row['client_name'];
									$trfDetail[$x]['rdi_acct'] = $row['bank_acct_num'];
									$trfDetail[$x]['trf_amt'] = $row['trans_amount'];
									
									$x++;
								}
							}

							break;
							
						case AConstant::KBB_TYPE_TO_CLIENT :
							
							$content = '0'.'|';
							$content .= 'FT'.'|';
							$content .= $data[0]['trf_id'].'|';
							$content .= '|';
							$content .= '|';
							$content .= DateTime::createFromFormat('d/m/Y',$data[0]['trans_date'])->format('Ymd').'|';
							//$content .= 'KBCLAUTAND'.'|'; //uncomment jika taro live, ambil dari sysparam
							//$content .= 'lautandana'.'|';//comment jika taro di live
							$content .= $corp_id->dstr2.'|';
							$content .= $totalAmount.'|';
							$content .= $totalRecord.'|';
							$content .= substr($data[0]['trf_type'],0,3).'|';
							$content .= 'IDR'.'|';
							
							$trfHeader['trf_id'] = $data[0]['trf_id'];
							$trfHeader['file_name'] = $pureFileName;
							$trfHeader['trx_type'] = 'FT';
							$trfHeader['kbb_type1'] = $payrec_type;
							$trfHeader['kbb_type2'] = $active_tab;
							$trfHeader['branch_group'] = $branchGroup;
							$trfHeader['trf_date'] = $data[0]['trans_date'];
							$trfHeader['save_date'] = date('d/m/Y H:i:s');
							$trfHeader['total_record'] = $totalRecord;
							
							$x = 0;
							
							foreach($data as $row)
							{
								$content .= "\r\n";
								$content .= '1'.'|';
								$content .= ($x+1).'|';
								$content .= $row['doc_num'].'|';
								$content .= $row['from_acct'].'|';
								$content .= $row['to_acct'].'|';
								$content .= $row['trans_amount'].'|';
								$content .= substr($row['remark1'],0,18).'|';
								$content .= substr($row['remark2'],0,18).'|';
								$content .= $row['bi_code'].'|';
								$content .= $row['bank_cd'].'|';
								$content .= $row['bank_branch_name'].'|';
								$content .= substr($row['receiver_name'],0,35).'|';
								$content .= '|';
								$content .= '|';
								$content .= '|';
								$content .= '|';
								$content .= $row['customer_type'].'|';
								$content .= $row['customer_residence'].'|';

								$trfDetail[$x]['row_id'] = $x+1;
								$trfDetail[$x]['trx_ref'] = $row['doc_num'];
								$trfDetail[$x]['trf_id'] = $trfHeader['trf_id'];
								$trfDetail[$x]['acct_name'] = $row['receiver_name'];
								$trfDetail[$x]['rdi_acct'] = $row['from_acct'];
								$trfDetail[$x]['client_bank_acct'] = $row['to_acct'];
								$trfDetail[$x]['bank_name'] = $row['bank_cd'];
								$trfDetail[$x]['trf_amt'] = $row['trans_amount'];
								
								$x++;
							}
							
							break;
                            case AConstant::KBB_TYPE_TO_CLIENT_FUND :
                            
                            $content = '0'.'|';
                            $content .= 'FT'.'|';
                            $content .= $data[0]['trf_id'].'|';
                            $content .= '|';
                            $content .= '|';
                            $content .= DateTime::createFromFormat('d/m/Y',$data[0]['trans_date'])->format('Ymd').'|';
                            //$content .= 'KBCLAUTAND'.'|'; //uncomment jika taro live ambil dari sys param
                            //$content .= 'lautandana'.'|';//comment jika taro di live
                            $content .= $corp_id->dstr2.'|';
                            $content .= $totalAmount.'|';
                            $content .= $totalRecord.'|';
                            $content .= substr($data[0]['trf_type'],0,3).'|';
                            $content .= 'IDR'.'|';
                            
                            $trfHeader['trf_id'] = $data[0]['trf_id'];
                            $trfHeader['file_name'] = $pureFileName;
                            $trfHeader['trx_type'] = 'FT';
                            $trfHeader['kbb_type1'] = $payrec_type;
                            $trfHeader['kbb_type2'] = $active_tab;
                            $trfHeader['branch_group'] = $branchGroup;
                            $trfHeader['trf_date'] = $data[0]['trans_date'];
                            $trfHeader['save_date'] = date('d/m/Y H:i:s');
                            $trfHeader['total_record'] = $totalRecord;
                            
                            $x = 0;
                            
                            foreach($data as $row)
                            {
                                $content .= "\r\n";
                                $content .= '1'.'|';
                                $content .= ($x+1).'|';
                                $content .= $row['doc_num'].'|';
                                $content .= $row['from_acct'].'|';
                                $content .= $row['to_acct'].'|';
                                $content .= $row['trans_amount'].'|';
                                $content .= substr($row['remark1'],0,18).'|';
                                $content .= substr($row['remark2'],0,18).'|';
                                $content .= $row['bi_code'].'|';
                                $content .= $row['bank_cd'].'|';
                                $content .= $row['bank_branch_name'].'|';
                                $content .= substr($row['receiver_name'],0,35).'|';
                                $content .= '|';
                                $content .= '|';
                                $content .= '|';
                                $content .= '|';
                                $content .= $row['customer_type'].'|';
                                $content .= $row['customer_residence'].'|';

                                $trfDetail[$x]['row_id'] = $x+1;
                                $trfDetail[$x]['trx_ref'] = $row['doc_num'];
                                $trfDetail[$x]['trf_id'] = $trfHeader['trf_id'];
                                $trfDetail[$x]['acct_name'] = $row['receiver_name'];
                                $trfDetail[$x]['rdi_acct'] = $row['from_acct'];
                                $trfDetail[$x]['client_bank_acct'] = $row['to_acct'];
                                $trfDetail[$x]['bank_name'] = $row['bank_cd'];
                                $trfDetail[$x]['trf_amt'] = $row['trans_amount'];
                                
                                $x++;
                            }
                            
                            break;
					}
				}
				else if($bank == 'BNGA3')
				{
					switch($payrec_type)
					{
						case AConstant::KBB_TYPE_AP :
							
							$content = 'Bank Account Code';
							$content .= '|Bank Name';
							$content .= '|Currency';
							$content .= '|Amount';
							$content .= '|Description';
							$content .= '|Count';
							$content .= '|Tanggal';
							$content .= '|E-Mail';
							
							foreach($data as $row)
							{
								$content .= "\r\n";
								$content .= $row['bank_acct_cd'];
								$content .= '|'.$row['bank_name'];
								$content .= '|'.$row['currency'];
								$content .= '|'.$row['curr_amt'];
								$content .= '|'.$row['descrip'];
								$content .= '|'.$row['cnt'];
								$content .= '|'.$row['tanggal'];
								$content .= '|'.$row['e_mail'];
							}
							
							break;
							
						case AConstant::KBB_TYPE_AR :
							
							$content = 'Bank Account Code';
							$content .= '|Bank Account Number';
							$content .= '|Account Name';
							$content .= '|Amount';
							$content .= '|Description';
							$content .= '|Type';
							$content .= '|E-Mail';
							
							foreach($data as $row)
							{
								$content .= "\r\n";
								$content .= $row['bank_acct_cd'];
								$content .= '|'.$row['bank_acct_fmt'];
								$content .= '|'.$row['acct_name'];
								$content .= '|'.$row['curr_amt'];
								$content .= '|'.$row['descrip'];
								$content .= '|'.$row['trx_type'];
								$content .= '|'.$row['e_mail'];
							}
							
							break;
					}
				}
				
				fwrite($handle,$content);				
				fclose($handle);
				
				if($bank == 'BCA02' && $method == 2)
				{
					//BCA HOST TO HOST
					
					$uploadFileName = str_replace('gen_kbb', 'trxgateway/out', $textFileName);
					
					$result['errorMessage'] = '';
					
					//if($result['successUpload'] = copy($textFileName, $uploadFileName))
					//{
						$connection  = Yii::app()->db;
						$transaction = $connection->beginTransaction();
						
						$result['errorMessage'] = GenKBB::insertH2HRef($trfHeader, $trfDetail);

						if($result['errorMessage'] === 1)
						{
						    if($result['successUpload'] = copy($textFileName, $uploadFileName))
                            {
							     $transaction->commit();
                            }
                            else 
                            {
                                $transaction->rollback();
                                unlink($uploadFileName);
                                $result['successUpload'] = false;
                            }
						}
						else 
						{
							$transaction->rollback();
							unlink($uploadFileName);
							$result['successUpload'] = false;
						}
					//}
				}
				
				$result['textFileName'] = $textFileName;
				$result['fileType'] = 'txt';
			}
			else if($fileType == 'xls')
			{
				$excelFileName = Yii::app()->basePath.'/../upload/gen_kbb/kbb_'.date('YmdHis').substr((string)microtime(), 2, 6).'.xls';
							 
				$objPHPExcel= XPHPExcel::createPHPExcel();	
				
				if($bank == 'BCA02')
				{
					switch($payrec_type)
					{
						case AConstant::KBB_TYPE_AP :
						case AConstant::KBB_TYPE_TO_RDI :
							
							$objPHPExcel->setActiveSheetIndex(0);
							
							$objPHPExcel->getActiveSheet()
										->setCellValue('A1', 'Name')
										->setCellValue('B1', 'Trans Date')
										->setCellValue('C1', 'Trans Amount')
										->setCellValue('D1', 'Acc No')
										->setCellValue('E1', 'Bank')
										->setCellValue('F1', 'Bi Code')
										->setCellValue('G1', 'Bank Branch')
										->setCellValue('H1', 'Remark 1')
										->setCellValue('I1', 'Remark 2')
										->setCellValue('J1', 'Jenis')
										->setCellValue('K1', 'Receiver Customer Type')
										->setCellValue('L1', 'Receiver Customer Residence');
							
							$fileRow = 2;
							
							foreach($data as $row)
							{
								$objPHPExcel->getActiveSheet()
											->setCellValue('A'.$fileRow,$row['client_name'])
											->setCellValue('B'.$fileRow,$row['trans_date'])
											->setCellValue('C'.$fileRow,$row['trans_amount'])
											->setCellValue('D'.$fileRow,$row['bank_acct_num'])
											->setCellValue('E'.$fileRow,$row['bank_cd'])
											->setCellValue('F'.$fileRow,$row['bi_code'])
											->setCellValue('G'.$fileRow,$row['bank_branch_name'])
											->setCellValue('H'.$fileRow,$row['remark1'])
											->setCellValue('I'.$fileRow,$row['remark2'])
											->setCellValue('J'.$fileRow,$row['jenis'])
											->setCellValue('K'.$fileRow,$row['customer_type'])
											->setCellValue('L'.$fileRow,$row['customer_residence']);
											
								$objPHPExcel->getActiveSheet()->getStyle('C'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
								$objPHPExcel->getActiveSheet()->getStyle('D'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								$objPHPExcel->getActiveSheet()->getStyle('F'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								$objPHPExcel->getActiveSheet()->getStyle('H'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								$objPHPExcel->getActiveSheet()->getStyle('I'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								$objPHPExcel->getActiveSheet()->getStyle('K'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								
											
								$fileRow++;
							}
							
							break;
							
						case AConstant::KBB_TYPE_AR :
							
							$objPHPExcel->setActiveSheetIndex(0);
							
							$objPHPExcel->getActiveSheet()
										->setCellValue('A1', 'Acc No')
										->setCellValue('B1', 'Trans Amount')
										->setCellValue('C1', 'Name')
										->setCellValue('D1', 'Remark 1')
										->setCellValue('E1', 'Remark 2')
										->setCellValue('F1', 'Trans Date');
							
							$fileRow = 2;
							
							foreach($data as $row)
							{
								$objPHPExcel->getActiveSheet()
											->setCellValue('A'.$fileRow,$row['bank_acct_num'])
											->setCellValue('B'.$fileRow,$row['trans_amount'])
											->setCellValue('C'.$fileRow,$row['client_name'])
											->setCellValue('D'.$fileRow,$row['remark1'])
											->setCellValue('E'.$fileRow,$row['remark2'])
											->setCellValue('F'.$fileRow,$row['trans_date']);
								
								$objPHPExcel->getActiveSheet()->getStyle('A'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);			
								$objPHPExcel->getActiveSheet()->getStyle('B'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
								$objPHPExcel->getActiveSheet()->getStyle('D'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								$objPHPExcel->getActiveSheet()->getStyle('E'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
	
								$fileRow++;
							}
							
							break;
							
						case AConstant::KBB_TYPE_TO_CLIENT :
							
							$objPHPExcel->setActiveSheetIndex(0);
							
							$objPHPExcel->getActiveSheet()
										->setCellValue('A1', 'Doc Num')
										->setCellValue('B1', 'From')
										->setCellValue('C1', 'To')
										->setCellValue('D1', 'Amount')
										->setCellValue('E1', 'Remark1')
										->setCellValue('F1', 'Remark2')
										->setCellValue('G1', 'Bi Code')
										->setCellValue('H1', 'Bank')
										->setCellValue('I1', 'Bank Branch')
										->setCellValue('J1', 'Name')
										->setCellValue('K1', 'Trans Date')
										->setCellValue('L1', 'Jenis')
										->setCellValue('M1', 'Receiver Customer Type')
										->setCellValue('N1', 'Receiver Customer Residence');
							
							$fileRow = 2;
							
							foreach($data as $row)
							{
								$objPHPExcel->getActiveSheet()
											->setCellValue('A'.$fileRow,$row['doc_num'])
											->setCellValue('B'.$fileRow,$row['from_acct'])
											->setCellValue('C'.$fileRow,$row['to_acct'])
											->setCellValue('D'.$fileRow,$row['trans_amount'])
											->setCellValue('E'.$fileRow,$row['remark1'])
											->setCellValue('F'.$fileRow,$row['remark2'])
											->setCellValue('G'.$fileRow,$row['bi_code'])
											->setCellValue('H'.$fileRow,$row['bank_cd'])
											->setCellValue('I'.$fileRow,$row['bank_branch_name'])
											->setCellValue('J'.$fileRow,$row['receiver_name'])
											->setCellValue('K'.$fileRow,$row['trans_date'])
											->setCellValue('L'.$fileRow,$row['jenis'])
											->setCellValue('M'.$fileRow,$row['customer_type'])
											->setCellValue('N'.$fileRow,$row['customer_residence']);
								
								$objPHPExcel->getActiveSheet()->getStyle('B'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								$objPHPExcel->getActiveSheet()->getStyle('C'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);			
								$objPHPExcel->getActiveSheet()->getStyle('D'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
								$objPHPExcel->getActiveSheet()->getStyle('E'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								$objPHPExcel->getActiveSheet()->getStyle('F'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								$objPHPExcel->getActiveSheet()->getStyle('G'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								$objPHPExcel->getActiveSheet()->getStyle('M'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
											
								$fileRow++;
							}
							
							break;	
                            //16 jun2017 untuk appsfund
                            case AConstant::KBB_TYPE_TO_RDI_FUND :
                            
                            $objPHPExcel->setActiveSheetIndex(0);
                            
                            $objPHPExcel->getActiveSheet()
                                        ->setCellValue('A1', 'Name')
                                        ->setCellValue('B1', 'Trans Date')
                                        ->setCellValue('C1', 'Trans Amount')
                                        ->setCellValue('D1', 'Acc No')
                                        ->setCellValue('E1', 'Bank')
                                        ->setCellValue('F1', 'Bi Code')
                                        ->setCellValue('G1', 'Bank Branch')
                                        ->setCellValue('H1', 'Remark 1')
                                        ->setCellValue('I1', 'Remark 2')
                                        ->setCellValue('J1', 'Jenis')
                                        ->setCellValue('K1', 'Receiver Customer Type')
                                        ->setCellValue('L1', 'Receiver Customer Residence');
                            
                            $fileRow = 2;
                            
                            foreach($data as $row)
                            {
                                $objPHPExcel->getActiveSheet()
                                            ->setCellValue('A'.$fileRow,$row['client_name'])
                                            ->setCellValue('B'.$fileRow,$row['trans_date'])
                                            ->setCellValue('C'.$fileRow,$row['trans_amount'])
                                            ->setCellValue('D'.$fileRow,$row['bank_acct_num'])
                                            ->setCellValue('E'.$fileRow,$row['bank_cd'])
                                            ->setCellValue('F'.$fileRow,$row['bi_code'])
                                            ->setCellValue('G'.$fileRow,$row['bank_branch_name'])
                                            ->setCellValue('H'.$fileRow,$row['remark1'])
                                            ->setCellValue('I'.$fileRow,$row['remark2'])
                                            ->setCellValue('J'.$fileRow,$row['jenis'])
                                            ->setCellValue('K'.$fileRow,$row['customer_type'])
                                            ->setCellValue('L'.$fileRow,$row['customer_residence']);
                                            
                                $objPHPExcel->getActiveSheet()->getStyle('C'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                                $objPHPExcel->getActiveSheet()->getStyle('D'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                                $objPHPExcel->getActiveSheet()->getStyle('F'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                                $objPHPExcel->getActiveSheet()->getStyle('H'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                                $objPHPExcel->getActiveSheet()->getStyle('I'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                                $objPHPExcel->getActiveSheet()->getStyle('K'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                                
                                            
                                $fileRow++;
                            }
                            
                            break;
                            //16 jun2017 untuk appsfund
                            case AConstant::KBB_TYPE_TO_CLIENT_FUND :
                            
                            $objPHPExcel->setActiveSheetIndex(0);
                            
                            $objPHPExcel->getActiveSheet()
                                        ->setCellValue('A1', 'Doc Num')
                                        ->setCellValue('B1', 'From')
                                        ->setCellValue('C1', 'To')
                                        ->setCellValue('D1', 'Amount')
                                        ->setCellValue('E1', 'Remark1')
                                        ->setCellValue('F1', 'Remark2')
                                        ->setCellValue('G1', 'Bi Code')
                                        ->setCellValue('H1', 'Bank')
                                        ->setCellValue('I1', 'Bank Branch')
                                        ->setCellValue('J1', 'Name')
                                        ->setCellValue('K1', 'Trans Date')
                                        ->setCellValue('L1', 'Jenis')
                                        ->setCellValue('M1', 'Receiver Customer Type')
                                        ->setCellValue('N1', 'Receiver Customer Residence');
                            
                            $fileRow = 2;
                            
                            foreach($data as $row)
                            {
                                $objPHPExcel->getActiveSheet()
                                            ->setCellValue('A'.$fileRow,$row['doc_num'])
                                            ->setCellValue('B'.$fileRow,$row['from_acct'])
                                            ->setCellValue('C'.$fileRow,$row['to_acct'])
                                            ->setCellValue('D'.$fileRow,$row['trans_amount'])
                                            ->setCellValue('E'.$fileRow,$row['remark1'])
                                            ->setCellValue('F'.$fileRow,$row['remark2'])
                                            ->setCellValue('G'.$fileRow,$row['bi_code'])
                                            ->setCellValue('H'.$fileRow,$row['bank_cd'])
                                            ->setCellValue('I'.$fileRow,$row['bank_branch_name'])
                                            ->setCellValue('J'.$fileRow,$row['receiver_name'])
                                            ->setCellValue('K'.$fileRow,$row['trans_date'])
                                            ->setCellValue('L'.$fileRow,$row['jenis'])
                                            ->setCellValue('M'.$fileRow,$row['customer_type'])
                                            ->setCellValue('N'.$fileRow,$row['customer_residence']);
                                
                                $objPHPExcel->getActiveSheet()->getStyle('B'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                                $objPHPExcel->getActiveSheet()->getStyle('C'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);         
                                $objPHPExcel->getActiveSheet()->getStyle('D'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                                $objPHPExcel->getActiveSheet()->getStyle('E'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                                $objPHPExcel->getActiveSheet()->getStyle('F'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                                $objPHPExcel->getActiveSheet()->getStyle('G'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                                $objPHPExcel->getActiveSheet()->getStyle('M'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                                            
                                $fileRow++;
                            }
                            
                            break;		
					}
				}
				else if($bank == 'BNGA3')
				{
					switch($payrec_type)
					{
						case AConstant::KBB_TYPE_AP :
							
							$objPHPExcel->setActiveSheetIndex(0);
							
							$objPHPExcel->getActiveSheet()
										->setCellValue('A1', 'Bank Account Code')
										->setCellValue('B1', 'Bank Name')
										->setCellValue('C1', 'Currency')
										->setCellValue('D1', 'Amount')
										->setCellValue('E1', 'Description')
										->setCellValue('F1', 'Count')
										->setCellValue('G1', 'Tanggal')
										->setCellValue('H1', 'E-Mail');
							
							$fileRow = 2;
							
							foreach($data as $row)
							{
								$objPHPExcel->getActiveSheet()
											->setCellValue('A'.$fileRow,$row['bank_acct_cd'])
											->setCellValue('B'.$fileRow,$row['bank_name'])
											->setCellValue('C'.$fileRow,$row['currency'])
											->setCellValue('D'.$fileRow,$row['curr_amt'])
											->setCellValue('E'.$fileRow,$row['descrip'])
											->setCellValue('F'.$fileRow,$row['cnt'])
											->setCellValue('G'.$fileRow,$row['tanggal'])
											->setCellValue('H'.$fileRow,$row['e_mail']);
								
								$objPHPExcel->getActiveSheet()->getStyle('A'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);		
								$objPHPExcel->getActiveSheet()->getStyle('D'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
											
								$fileRow++;
							}
							
							break;
							
						case AConstant::KBB_TYPE_AR :
							
							$objPHPExcel->setActiveSheetIndex(0);
							
							$objPHPExcel->getActiveSheet()
										->setCellValue('A1', 'Bank Account Code')
										->setCellValue('B1', 'Bank Account Number')
										->setCellValue('C1', 'Account Name')
										->setCellValue('D1', 'Amount')
										->setCellValue('E1', 'Description')
										->setCellValue('F1', 'Type')
										->setCellValue('G1', 'E-Mail');
							
							$fileRow = 2;
							
							foreach($data as $row)
							{
								$objPHPExcel->getActiveSheet()
											->setCellValue('A'.$fileRow,$row['bank_acct_cd'])
											->setCellValue('B'.$fileRow,$row['bank_acct_fmt'])
											->setCellValue('C'.$fileRow,$row['acct_name'])
											->setCellValue('D'.$fileRow,$row['curr_amt'])
											->setCellValue('E'.$fileRow,$row['descrip'])
											->setCellValue('F'.$fileRow,$row['trx_type'])
											->setCellValue('G'.$fileRow,$row['e_mail']);
								
								$objPHPExcel->getActiveSheet()->getStyle('B'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);		
								$objPHPExcel->getActiveSheet()->getStyle('D'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
											
								$fileRow++;
							}
							
							break;
					}
				}
						
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save($excelFileName);
				
				$result['excelFileName'] = $excelFileName;
				$result['fileType'] = 'xls';
			}
			else if($fileType == 'csv')
			{
				$csvFileName = Yii::app()->basePath.'/../upload/gen_kbb/kbb_'.date('YmdHis').substr((string)microtime(), 2, 6).'.csv';
				$handle = fopen($csvFileName,'wb');
				
				if($bank == 'BCA02')
				{
					switch($payrec_type)
					{
						case AConstant::KBB_TYPE_AP :
						case AConstant::KBB_TYPE_TO_RDI :
							
							fputcsv($handle, array(
								'Name',
								'Trans Date',
								'Trans Amount',
								'Acc No',
								'Bank',
								'Bi Code',
								'Bank Branch',
								'Remark 1',
								'Remark 2',
								'Jenis',
								'Receiver Customer Type',
								'Receiver Customer Residence'
							));
							
							foreach($data as $row)
							{
								fputcsv($handle, $row);
							}
							
							break;
							
						case AConstant::KBB_TYPE_AR :
							
							fputcsv($handle, array(
								'Acc No',
								'Trans Amount',
								'Name',
								'Remark 1',
								'Remark 2',
								'Trans Date',
							));
							
							foreach($data as $row)
							{
								fputcsv($handle, array(
									$row['bank_acct_num'],
									$row['trans_amount'],
									$row['client_name'],
									$row['remark1'],
									$row['remark2'],
									$row['trans_date']
								));
							}
							
							break;
							
						case AConstant::KBB_TYPE_TO_CLIENT :
							
							fputcsv($handle, array(
								'Doc Num',
								'From',
								'To',
								'Amount',
								'Remark 1',
								'Remark 2',
								'Bi Code',
								'Bank',
								'Bank Branch',
								'Name',
								'Trans Date',
								'Jenis',
								'Receiver Customer Type',
								'Receiver Customer Residence',
							));
							
							foreach($data as $row)
							{
								unset($row['trf_id']);
								if(isset($row['trf_type']))unset($row['trf_type']);
								
								fputcsv($handle, $row);
							}
							
							break;
					}
				}
				else if($bank == 'BNGA3')
				{
					switch($payrec_type)
					{
						case AConstant::KBB_TYPE_AP :
							
							/*fputcsv($handle, array(
								'bank_acct',
								'bank_name',
								'currency',
								'sum_amt',
								'head_descrip',
								'cnt',
								'tanggal',
							));
							
							foreach($data as $row)
							{
								fputcsv($handle, array(
									$row['bank_acct_cd_csv'],
									$row['bank_name_csv'],
									$row['currency'],
									$row['curr_amt'],
									$row['descrip'],
									$row['cnt'],
									$row['tanggal']
								));
							}*/
							
							foreach($data as $row)
							{
								$detail = array(
									$row['bank_acct_cd_csv'],
									$row['bank_name_csv'],
									$row['currency'],
									$row['curr_amt'],
									$row['descrip'],
									$row['cnt'],
									$row['tanggal']
								);
								
								fwrite($handle, implode(',',$detail)."\r\n");
							}
							
							break;
						
						case AConstant::KBB_TYPE_AR :
							
							/*fputcsv($handle, array(
								'bank_acct_num',
								'bank_acct_broker',
								'acct_name',
								'curr_amt',
								'descrip',
								'trx_type',
							));
							
							foreach($data as $row)
							{
								fputcsv($handle, array(
									$row['bank_acct_fmt_csv'],
									$row['bank_acct_cd_csv'],
									$row['acct_name_csv'],
									$row['curr_amt'],
									$row['descrip'],
									$row['trx_type']
								));
							}*/
							
							foreach($data as $row)
							{
								$detail = array(
									$row['bank_acct_fmt_csv'],
									$row['bank_acct_cd_csv'],
									$row['acct_name_csv'],
									$row['curr_amt'],
									$row['descrip'],
									$row['trx_type']
								);
								
								fwrite($handle, implode(',',$detail)."\r\n");
							}
							
							break;
					}
				}
				
				fclose($handle);
				
				$result['csvFileName'] = $csvFileName;
				$result['fileType'] = 'csv';
			}
			else
			{
				$result['fileType'] = '';
			}
		}
		
		echo json_encode($result);
	}
}
