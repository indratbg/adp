<?php

class ClientprofileController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionIndex()
	{
		$model = new Clientprofile();
		
		if(isset($_POST['SDIForm']))
		{
			$model->attributes = $_POST['SDIForm'];
			//show_subrek = true;
		}//end if isset
		else if(empty($model->status)) 
		{
			//supaya ada nilai default di checkbox nya
			$model->status = Clientprofile::CLIENT_PROFILE_AKTIF;
		}//end else
		
		$this->render('index',array(
			'model'=>$model,
		));
	}
}
