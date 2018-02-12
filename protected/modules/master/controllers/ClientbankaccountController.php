<?php

class ClientBankAccountController extends AAdminController
{

	// AR: creating detail from ajax when user pressing btnsubmit
    public function actionCreateDetail($client_cd, $cifs)
    {
        $model  = new Clientbank;
		$model->client_cd  = $client_cd;
		$model->cifs = $cifs;
        $resp = NULL;
        
        if(isset($_POST['Clientbank']))
        {
           $model->attributes = $_POST['Clientbank'];
           $model->old_bank_acct_num = $model->bank_acct_num;
		   
		   if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS) > 0 )
           {
               // AR: resetting model to new / empty
               $model = new Clientbank();
               $model->unsetAttributes();
           	   $model->client_cd  = $client_cd;
		   	   $model->cifs 	  = $cifs;
			   
               $resp['status']  = 'success';
           }
           else
           { 
               $resp['status']  = 'failed';
           }  
        }
		  
		$resp['content'] = $this->renderPartial('/client/_form_client_bank',array('model'=>$model),true,true);
    
        // AR: make into json , will parse on javascript 
        echo CJSON::encode($resp);
    }
    
      // AR: updating detail from ajax when user pressing btnAddDetail
    public function actionUpdateDetail($client_cd,$cifs,$bank_cd,$bank_acct_num)
    {
    	$resp['status']  = 'success';
        $model   		  = $this->loadModel($client_cd, $cifs, $bank_cd, $bank_acct_num); 
        $resp    		  = NULL;
       
        if(isset($_POST['Clientbank']))
        {
           $model->attributes = $_POST['Clientbank'];
		   $model->old_bank_acct_num = $bank_acct_num;
		   
           $client_cd = $model->client_cd;
		   $cifs      = $model->cifs; 			 
		   
           if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD) > 0 )
           {
               // AR: resetting model to new / empty
               $model = new Clientbank();
               $model->unsetAttributes();
			   
               $model->client_cd = $client_cd;
			   $model->cifs      = $cifs; 
			   
               $resp['status']  = 'success';
           }
           else
           {
           	   $model->client_cd = $client_cd;
			   $model->cifs      = $cifs; 
			   $model->bank_cd   = $bank_cd;
			   $model->bank_acct_num = $bank_acct_num;
			    
               $resp['status']  = 'failed';
           }
        }
        
        
        $resp['content'] = $this->renderPartial('/client/_form_client_bank',array('model'=>$model),true,true);
    
        // AR: make into json , will parse on javascript 
        echo CJSON::encode($resp);
    }
    
    public function actionDeleteDetail($id)
    {
        Clientbank::model()->findByPk($id)->delete();
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
	

	public function actionIndex($client_cd,$cifs)
	{
		$model = new ClientBank('search');
		$model->unsetAttributes();
		$model->client_cd = $client_cd;
		$model->cifs	  = $cifs; 
		
		if(isset($_GET['ClientBank']))
			$model->attributes=$_GET['ClientBank'];

		$this->render('/client/index_client_bank',array(
			'model'=>$model,
		));
	}

	public function loadModel($client_cd,$cifs,$bank_cd,$bank_acct_num)
	{
		$model = new Clientbank();
		$model = Clientbank::model()->find('client_cd=:client_cd AND cifs=:cifs AND bank_cd=:bank_cd AND bank_acct_num=:bank_acct_num',
						 					array(':client_cd'=>$client_cd,':cifs'=>$cifs,':bank_cd'=>$bank_cd,':bank_acct_num'=>$bank_acct_num));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
