<?php

class ClientclosingController extends AAdminController
{
	public $layout='//layouts/admin_column2';

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionGetclient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '".$term."%')
      			AND susp_stat = 'N' AND client_type_1 <> 'B' AND client_type_1 <> 'H'
      			AND rownum <= 11
      			ORDER BY client_cd
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd'].' - '.$search['client_name']
      			, 'labelhtml'=>$search['client_cd'].' - '.$search['client_name'] //WT: Display di auto completenya
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }

	public function actionCreate()
	{
		$isvalid = false;
		$model = new TClientclosing;
		$modelVClientmember = new VClientmember;
		$modelVClientmember->unsetAttributes();
		
		if(isset($_POST['TClientclosing']))
		{
			$submitsts 			= $_POST['submit'];
			$model->attributes	= $_POST['TClientclosing'];
			$model->scenario   = $submitsts;
			
			if($submitsts == 'validate')
			{	
				if($model->validate() )
				{			
					if($model->executeSpValidate() > 0)
					{
						$isvalid = true;
						$modelVClientmember->client_cd = $model->client_cd;
						$listCifs = Client::model()->find('client_cd = :client_cd',array(':client_cd'=>$model->client_cd));
						if($listCifs){
							$cifs = $listCifs->cifs;
							//$modelVClientmember = VClientmember::model()->findAll('client_cd = :client_cd and cifs = :cifs',array(':client_cd'=>$model->client_cd,':cifs'=>$cifs));
							$modelVClientmember->cifs = $cifs;
						}
						//var_dump($model->shw_btn_conf);
						
					}
	            }
			}
			else if($submitsts == 'conftochg')
			{
				$model->new_stat = 'C';
				$model->iscloserdi = $_POST['iscloserdi'];
				//$model->client_cd = $_POST['client_cd'];
				//var_dump($model->client_cd);
				//die();
				
				$isvalid 					   = true;
				$modelVClientmember->client_cd = $model->client_cd;
				
				$listCifs = Client::model()->find('client_cd = :client_cd',array(':client_cd'=>$model->client_cd));
				if($listCifs){
					$cifs = $listCifs->cifs;
					//$modelVClientmember = VClientmember::model()->findAll('client_cd = :client_cd and cifs = :cifs',array(':client_cd'=>$model->client_cd,':cifs'=>$cifs));
					$modelVClientmember->cifs = $cifs;
				}
				
				$qClientmaster = DAO::queryAllSql("SELECT susp_stat FROM MST_CLIENT WHERE client_cd = '$model->client_cd'");
				$suspstat = $qClientmaster[0]['susp_stat'];
				
				$qClientflacct = DAO::queryAllSql("SELECT bank_acct_num FROM MST_CLIENT_FLACCT WHERE client_cd = '$model->client_cd' AND approved_stat = 'A'");
				$bankacctnum = array();
				
				$qGlAccount = DAO::queryAllSql("SELECT gl_a FROM MST_GL_ACCOUNT WHERE sl_a = '$model->client_cd' AND approved_stat = 'A'");
				$gla = array();
				
				$qClientname = DAO::queryRowSql("SELECT client_name FROM MST_CLIENT WHERE client_cd = '$model->client_cd'");
				$clientname = $qClientname['client_name'];
				
				$model->client_name = $clientname;

				if($qGlAccount){
					foreach($qGlAccount as $glaccount){
						$gla[] = $glaccount['gl_a'];
					}
				}
				
				//var_dump($gla);
				//die();
				
				if($model->validate()){
					$success = false;
					$transaction;
					$menuName = 'CLIENT CLOSING';
					$model->cancel_reason = 'Input by '.$model->user_id;
					
					if($model->executeSpManyHeader(AConstant::INBOX_STAT_INS,$menuName,$transaction) > 0){
						$success = true;
					}else{
						$success = false;
						$transaction->rollback();
					}
					
					
					if($success && $model->executeSp(AConstant::INBOX_STAT_INS,1,$transaction) > 0){
						$success = true;
					}else{
						$success = false;
						$transaction->rollback();
					}
					
					if($success && $model->executeSp('Z',1,$transaction) > 0){
						$success = true;
					}else{
						$success = false;
						$transaction->rollback();
					}
					/*
					if($success && $model->iscloserdi){
						if($model->iscloserdi[0] == 'Y'){
							if($success && $model->executeSp('Y',1,$transaction) > 0){
								$success = true;
							}else{
								$success = false;
								$transaction->rollback();
							}
						}
					}
					 */
					//var_dump($model->error_msg);
					//die();
					
					if($success && $qGlAccount){
						$n = 1;
						foreach($qGlAccount as $glaccount){
							
							if($success == true){
								$model->client_name = $glaccount['gl_a'];
								if($model->executeSp('X',$n,$transaction) > 0){
									$success = true;
								}else{
									$success = false;
								}
							}else{
								$success = false;
							}
							if($success){
								$n++;
							}else{
								$transaction->rollback();
								//var_dump($model->error_code.' '.$model->error_msg);
								//die();
								break;
							}
						}
					}else{
						$success = false;
						$model->addError('','GL Account not found');
					}
					
					if($model->iscloserdi){
						if($success && $qClientflacct){
							$n = 1;
							foreach($qClientflacct as $clientflacct){
								
								if($success == true){
									$model->client_name = $clientflacct['bank_acct_num'];
									if($model->executeSp('Y',$n,$transaction) > 0){
										$success = true;
									}else{
										$success = false;
									}
								}else{
									$success = false;
								}
								if($success){
									$n++;
								}else{
									$transaction->rollback();
									//var_dump($model->error_code.' '.$model->error_msg);
									//die();
									break;
								}
							}
						}else{
							$success = false;
							$model->addError('','Rekening dana not found');
						}
					}
					//var_dump($qClientflacct);
					//die();
					
					if($success){
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Successfully close client '.$model->client_cd);
						$this->redirect(array('/master/clientclosing/index'));
					}	
					
						
				// if($model->executeSpValidate() > 0 && $model->executeSp() > 0){
					// Yii::app()->user->setFlash('success', 'Successfully close client '.$model->client_cd);
					// $this->redirect(array('/inbox/clientclosing/index'));
				// }
	            }else{
	            	$model->executeSpValidate();
	            }
			}
		}
		
		//var_dump('aa');
		//die();

		$this->render('create',array(
			'model'=>$model,
			'modelVClientmember'=>$modelVClientmember,
			'isvalid'=>$isvalid
		));
	}
	
	/*
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['TClientclosing']))
		{
			$model->attributes=$_POST['TClientclosing'];
			if($model->validate()){	
				if($model->executeSpValidate() > 0 && $model->executeSp() > 0){
					Yii::app()->user->setFlash('success', 'Successfully update closed client '.$model->client_cd);
					$this->redirect(array('/inbox/clientclosing/index'));
				}
            }else{
            	$model->executeSpValidate();
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	 * 
	 */

	public function actionIndex()
	{
		$model=new TClientclosing('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['TClientclosing']))
			$model->attributes=$_GET['TClientclosing'];
		
		$model->approved_stat = 'A';
		
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=TClientclosing::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
