<?php

class ClientinstitutionalController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';
	
	public function actionCreateDetail($cifs,$seqno)
    {
        $model  = new Clientautho;
        $resp   = NULL;
        
        if(isset($_POST['Clientautho'])){
           	$model->attributes = $_POST['Clientautho']; 
     	   	$model->cifs = $cifs;
		   	$model->seqno = $seqno;
		   	$model->search_cifs = $model->cifs;
			$model->search_seqno = $model->seqno;
		   
           	if($model->validate() && $model->executeSP(AConstant::INBOX_STAT_INS) > 0)
           	{
			  	 //reset the form value	           	
               	$model = new Clientautho;
			   	$model->unsetAttributes();
               	$resp['status']  = 'success';
           	}//end if model->validate() && executesp
           	else
           	{
           		//jangan ada echo, klo ada echo gk kluar pesan errornya, karena format dah bukan json lage
           	 	//echo $model->error_code.' '.$model->error_msg; 
             	$resp['status']  = 'failed';
           	}//end else
		   
		  
        }//end if isset
		  
		$resp['content'] = $this->renderPartial('_formdetail',array('model'=>$model),true,true);
    
        // AR: make into json , will parse on javascript 
        echo CJSON::encode($resp);
    }
    
      // AR: updating detail from ajax when user pressing btnAddDetail
    public function actionUpdateDetail($cifs,$seqno)
    {
        $model   = $this->loadModelClientautho($cifs, $seqno);
		$model->search_cifs = $model->cifs;
		$model->search_seqno = $model->seqno;
		//$item_cd = $model->item_cd;
        $resp    = NULL;
		
        if(isset($_POST['Clientautho']))
        {
           $model->attributes = $_POST['Clientautho'];
		   
           if($model->validate() && $model->executeSP(AConstant::INBOX_STAT_UPD) > 0)
           {
           		//reset the form value
           		$model = new Clientautho;
           		$model->unsetAttributes();
           		$resp['status']  = 'success';
           }//end if model->validate() && $model->executeSp
           else
           { 
               $resp['status']  = 'failed';
           }//end else
        }//end if isset
        echo "$model->ktp_expiry_date";
        $resp['content'] = $this->renderPartial('_formdetail',array('model'=>$model),true,true);
    
        // AR: make into json , will parse on javascript 
        echo CJSON::encode($resp);
    }
    
    public function actionDeleteDetail($cifs,$seqno)
    {
    	if(Yii::app()->request->isPostRequest):
	        $this->loadModelClientautho($cifs,$seqno)->delete();
	        if(!isset($_GET['ajax']))
	            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		endif;
    }
	
	public function actionIndex2()
	{
		$modelHeader= new Cif;
		$modelDetail= new Clientautho;
		
		$cifs = "asdf";
		$seqno = 4;
		
		if(isset($_POST['Cif']))
		{
			$modelHeader->attributes = $_POST['Cif'];
		}
		
		$this->render('detail',array(
			'modelHeader'=>$modelHeader,
			'modelDetail'=>$modelDetail,
			'cifs'=>$cifs,
			'seqno'=>$seqno
		));
	}
	
	public function actionIndex()
	{
		$model=new Cif('search'); 
        $model->unsetAttributes();  // clear any default values 

        if(isset($_GET['Cif'])) 
            $model->attributes=$_GET['Cif']; 

        $this->render('index',array( 
            'model'=>$model, 
        )); 
	}
	
	public function actionCreate($client_cd)
	{
		$model = new Cif;
		$model->client_cd = $client_cd;
		$model->purpose07 = '00';
		$model->purpose08 = '00';
		$model->purpose09 = '00';
		$model->purpose10 = '00';
		$model->purpose11 = '00';
		
		if(isset($_POST['Cif']))
		{
			$model->attributes = $_POST['Cif'];
			$model->search_cifs = $model->cifs;
			if($model->validate() && $model->executeSP(AConstant::INBOX_STAT_INS) > 0)
			{
				Yii::app()->user->setFlash('success', 'Successfully create '.$model->cifs); 
                //$this->redirect(array('update','id'=>$model->cifs)); 
			}
		}
		
		$this->render('_form',array(
			'model'=>$model
		));
	}
	
	public function actionUpdate($id)
	{
		$model=$this->loadModelCif($id);

        if(isset($_POST['Cif'])) 
        { 
            $model->attributes=$_POST['Cif']; 
			$model->search_cifs = $model->cifs;
            if($model->validate()&& $model->executeSP(AConstant::INBOX_STAT_UPD) > 0)
            { 
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->cifs); 
                //$this->redirect(array('update','id'=>$model->cifs)); 
            } 
        } 

        $this->render('_form',array( 
            'model'=>$model, 
        )); 
	}
	
	public function loadModelCif($id)
	{
		$model=Cif::model()->findByPk($id); 
        if($model===null) 
            throw new CHttpException(404,'The requested page does not exist.'); 
        return $model; 
	}

	public function loadModelClientautho($cifs,$seqno)
	{
		//$model=Clientautho::model()->findByPk(array('cifs'=>$cifs,'seqno'=>$seqno));
		$model=Clientautho::model()->find("cifs='$cifs' AND seqno = '$seqno'");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
