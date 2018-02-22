<?php 


Class TstkmovexceptController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	
	public function actionGetClient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				SELECT CLIENT_CD, CLIENT_NAME 
				FROM MST_CLIENT 				
				WHERE CLIENT_CD LIKE '".$term."%'
				AND ROWNUM <= 15
				AND client_type_1 <> 'B' 
				AND susp_stat = 'N' 
				ORDER BY CLIENT_CD
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd'].' - '.$search['client_name']
      			, 'labelhtml'=>$search['client_cd'] //WT: Display di auto completenya
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	
	public function actionIndex()
	{
		$model=new Tstkmovexcept;
		
		if(isset($_POST['submit']))
		{
			$model->client_cd = $_POST['Tstkmovexcept']['client_cd'];
			$result = DAO::queryRowSql("SELECT client_cd FROM T_STKMOV_EXCEPT WHERE client_cd = '$model->client_cd'");
			
			if($_POST['submit'] == 'add')
			{	
				if($result)
				{
					$model->addError('client_cd', 'Client code is already registered');
				}
				else {
					$model->save();
					Yii::app()->user->setFlash('success','Register successful');
				}
			}
			else 
			{
				if($result)
				{
					DAO::executeSql("DELETE FROM T_STKMOV_EXCEPT WHERE client_cd = '$model->client_cd'");
					Yii::app()->user->setFlash('success','Delete successful');
				}
				else 
				{
					$model->addError('client_cd', 'Client code is not registered');
				}
			}
		}
		
		$this->render('index',array(
			'model'=>$model,
		));
	}	
}
