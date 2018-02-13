<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AAdminController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/admin_column2';
    
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
    
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();
	
	public $gridTemplate;
	
	public $isPopupWindow = false;
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	//WT: 20140807
	public function accessRules()
	{
		// AH: Uncomment this code below to gave full access to anyone login
		// BEGIN FULL ACCESS
		/*
				$rules = array(
					array('allow', 'users' => array('@')),
				);
				return $rules;
	}*/
	
		// END FULL ACCESS
		
		//var_dump(Yii::app()->session);
		//die();
		
		/*******************************/
		//SESSION TIMEOUT MANAGEMENT // AS
		
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1")
			$ip = '127.0.0.1';
		
		if(Yii::app()->request->cookies['lastactivity']){
			$curractivity = new DateTime();
			$lastactivity = Yii::app()->request->cookies['lastactivity']->value;
			$qsessiontimeout = DAO::queryRowSql("SELECT prm_cd_2 FROM MST_PARAMETER WHERE prm_cd_1 = 'TIMOUT'"); //Get session timeout from db
			$sessiontimeout = $qsessiontimeout['prm_cd_2'];
			$idletime = $curractivity->getTimestamp() - $lastactivity;
			
			if($idletime > $sessiontimeout){
				//Log Out
				$modelLoginlog = new Loginlog();
				$modelLoginlog->user_id 	= Yii::app()->request->cookies['curruser']->value;
				$modelLoginlog->log_dt  	= new CDbExpression("TO_DATE( '".Yii::app()->datetime->getDateTimeNow()."', 'YYYY-MM-DD HH24:MI:SS')");
				$modelLoginlog->log_type 	= 'OUT';
				$modelLoginlog->description = 'SESSION TIMEOUT';
				$modelLoginlog->ip_address  = $ip;
				$modelLoginlog->save(FALSE);
				Yii::app()->request->cookies->clear();
				Yii::app()->user->logout(); 
				$this->redirect(Yii::app()->homeUrl);
			}else{
				//Refresh Last Activity Time
				Yii::app()->request->cookies['lastactivity'] = new CHttpCookie('lastactivity', $curractivity->getTimestamp());
			}
		}
		/*******************************/
		
		$rules = array(
			array('deny', 'users' => array('*')),
		);
		
		if(!Yii::app()->user->isGuest) {
			
			$arrUsergroupId  = Yii::app()->user->usergroup_id;
			$sUserGroupId 	 = implode(',', $arrUsergroupId);
	
			$sModule 		 = '';
			if(isset($this->module))
				$sModule	 = $this->module->getName();
	
			$sReqAction 	 = $sModule.'/'.Yii::app()->controller->id.'/'.$this->action->id;
			$sQuery			 = "SELECT menu_id, is_popup_window
								FROM mst_usergroupakses a ,mst_menuaction b
								WHERE a.menuaction_id = b.menuaction_id
								AND lower(action_url)  = lower('$sReqAction')
								AND usergroup_id IN ( $sUserGroupId )";
			
			$sQueryMenu = "SELECT is_popup_window
							FROM mst_menuaction 
							WHERE lower(action_url)  = lower('$sReqAction')";
	
	
			$result = DAO::queryRowSql($sQuery);
			$result2 = DAO::queryRowSql($sQueryMenu);
			if($result2['is_popup_window'] == '1'){
				$this->isPopupWindow = true;
				Yii::app()->errorHandler->errorAction='site/errorpopup';
			}
			//Yii::app()->end();
			
			if(!empty($result)){
				// AH : this code is to removing button from grid view and left navbar
				$query 			= "SELECT MAX(group_id) AS mx_group_id FROM mst_menuaction
							  		WHERE menu_id = ".$result['menu_id']." AND menuaction_id IN
					  				( SELECT menuaction_id FROM mst_usergroupakses
					  				WHERE usergroup_id IN ($sUserGroupId))";
  				$mx_group_id	= DAO::queryRowSql($query);
	
				// reduce from array to integer
				$mx_group_id 	= $mx_group_id['mx_group_id'];
				switch($mx_group_id)
				{
					case AConstant::MENUACTIONGROUP_READONLY :
						$this->gridTemplate = '{view}';
						break;
					case AConstant::MENUACTIONGROUP_CREATE :
						$this->gridTemplate = '{view}';
						break;
					case AConstant::MENUACTIONGROUP_MODIFY :
						$this->gridTemplate = '{view}{update}';
						//$this->leftMenuAcc  =  array( array('label'=>'Create','url'=>array('create'),'icon'=>'plus') );
						break;
					case AConstant::MENUACTIONGROUP_REMOVE :
						$this->gridTemplate = '{view}{update}{delete}';
						break;
				}
				
				// AS : Saving any user activity into database
				$modelaccesslog = new Useraccesslog;
				$modelaccesslog->action_url = strtolower($sReqAction);
				$modelaccesslog->user_id = Yii::app()->user->id;
				$modelaccesslog->access_date = new CDbExpression("TO_DATE( '".Yii::app()->datetime->getDateTimeNow()."', 'YYYY-MM-DD HH24:MI:SS')");
				$modelaccesslog->ip_address = $ip;
				//$appparam = '';
				/*if(isset($_GET)){
					ob_start();
					var_dump($_GET);
					$appparam = 'GET: '.substr(ob_get_clean(),0,4000);
				}
				
				if(isset($_POST)){
					ob_start();
					var_dump($_POST);
					$appparam = 'POST: '.substr(ob_get_clean(),0,4000);
				}
				*/
				//$modelaccesslog->app_param = $appparam;
				
				$modelaccesslog->save(FALSE);
				
				$rules = array(
							array('allow', 'users' => array('@')),
							array('deny', 'users' => array('*')),
						);
			}
		}
	
		return $rules;
	}

	/** 
	 * LO: Returns true if the record is already cancelled or reversed, false otherwise
	 * @param $model => Object of database record
	 * @param $redirectUrl => The URL to be redirected to, if $model is already cancelled or reversed. If not set, the controller won't redirect anywhere
	 */
	public function checkCancelled($model, $redirectUrl = '')
	{
		// Array of column name and its approved or non reversed value (column_name => approved_value)
		// approved_value may be an array of multiple values
		$columnNameArr = array(
			'approved_stat'=>'A',
			'approved_sts'=>'A',
			'doc_stat'=>'2',
			'reversal_jur'=>array('','N')
		);
		
		foreach($columnNameArr as $columnName=>$approvedValue)
		{
			if($model->getAttribute($columnName))
			{
				if(is_array($approvedValue))
				{
					$cancelledFlg = true;
					
					foreach($approvedValue as $value)
					{
						if($model->getAttribute($columnName) == $value)
						{
							$cancelledFlg = false;
						}
					}
					
					if($cancelledFlg)
					{
						Yii::app()->user->setFlash('error', 'Error: This data is already cancelled or reversed');
						
						if($redirectUrl)$this->redirect($redirectUrl);

						return true;
					}
				}
				else 
				{
					if($model->getAttribute($columnName) != $approvedValue)
					{
						Yii::app()->user->setFlash('error', 'Error: This data is already cancelled or reversed');
						
						if($redirectUrl)$this->redirect($redirectUrl);

						return true;
					}
				}
			}
		}
		
		return false;
	}
	
	
	/*
	// AH: will return array needed for acces control
	protected function getArrayAccessRules()
	{
		// AH: Uncomment this code below to gave full access to anyone login
		// BEGIN FULL ACCESS
// 		$rules = array(
// 				array('allow', 'users' => array('@')),
// 		);
// 		return $rules;
	
		// END FULL ACCESS
		
		if($this->action->id == 'login'){
			$rules = array(
					array('allow', 'users' => array('*'))
			);
		}else if($this->action->id == 'logout'){
			$rules = array(
					array('allow','users' => array('@'))
			);
		}else if(!Yii::app()->user->isGuest){
			$arrUsergroupId  = Yii::app()->user->usergroup_id;
			$sUserGroupId 	 = implode(',', $arrUsergroupId);
				
			$sModule 		 = '';
			if(isset($this->module))
				$sModule	 = $this->module->getName();
				
			$sReqAction 	 = $sModule.'/'.Yii::app()->controller->id.'/'.$this->action->id;
			$sQuery			 = "SELECT menu_id 
								FROM mst_usergroupakses a JOIN mst_menuaction b
								ON a.menuaction_id = b.menuaction_id
								AND action_url  = '$sReqAction'
								AND usergroup_id IN ( $sUserGroupId )";
	
				
			$result = DAO::queryRowSql($sQuery);
			if(!empty($result)){
				
				
				// AH : this code is to removing button from grid view and left navbar	
				$query 			= "SELECT MAX(group_id) AS mx_group_id FROM mst_menuaction 
							  		WHERE menu_id = ".$result['menu_id']." AND menuaction_id IN  
							  		( SELECT menuaction_id FROM mst_usergroupakses
							  		 	WHERE usergroup_id IN ($sUserGroupId))";
				$mx_group_id	= DAO::queryRowSql($query);
		
				// reduce from array to integer
				$mx_group_id 	= $mx_group_id['mx_group_id'];
				switch($mx_group_id)
				{
					case AConstant::MENUACTIONGROUP_READONLY :
						$this->gridTemplate = '{view}';
						break;  
						
					case AConstant::MENUACTIONGROUP_CREATE :
						$this->gridTemplate = '{view}';
						break;  
					case AConstant::MENUACTIONGROUP_MODIFY :
						$this->gridTemplate = '{view}{update}';
						
						$this->leftMenuAcc  =  array( array('label'=>'Create','url'=>array('create'),'icon'=>'plus') );
						break;
					case AConstant::MENUACTIONGROUP_REMOVE :
						$this->gridTemplate = '{view}{update}{delete}';
						break;
				}
				
				$rules = array(
					array('allow', 'users' => array('@')),
					array('deny', 'users' => array('*')),
				);
			}else{
				$rules = array(
					array('deny', 'users' => array('@')),
					array('deny', 'users' => array('*')),
				);
			}
		}else{
			$rules = array(
				array('deny', 'users' => array('@')),
				array('deny', 'users' => array('*')),
			);
		}
		return $rules;
	}
	*/
	
	  //[IN] 26 Juli 2017 untuk export ke EXCEL
	public function getDataXLS($model, $schema)
    {
        
          $excelFileName = Yii::app()->basePath.'/../upload/rpt_xls/'.$model->module.'.xls';
          $objPHPExcel= XPHPExcel::createPHPExcel();  
          $objPHPExcel->getProperties()->setCreator("SSS")
                                 ->setLastModifiedBy("SSS")
                                 ->setTitle($model->module)
                                 ->setSubject("Office 2007 XLS Document")
                                 ->setKeywords("office 2007 openxml php");
    
        $objPHPExcel->setActiveSheetIndex(0);        
        $col='A';
        $x=0;
        $select_query='select ';
        foreach($model->col_name as $row)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col.'1', strtoupper(str_replace('_',' ', $row)));
            if($x > 0)$select_query .= ', ';
            $select_query.=$row;
            $col++;
            $x++;
        }
        
        //build query select column
        $user_id=Yii::app()->user->id;
        $select_query.=" from $schema.$model->tablename  where user_id= '$user_id' and rand_value=$model->vo_random_value ";
        $exec_data = DAO::queryAllSql($select_query);
        //set detail     
        
        $y=2;
        foreach($exec_data as $row)
        {
            $col='A';
            foreach($model->col_name as $column)
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col.$y, $row[strtolower($column)]);
                $col++;
            }
          $y++;              
            
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($excelFileName);
        
        if(file_exists($excelFileName))
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="'.$model->module.'.xls"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($excelFileName));
            ob_clean();
            flush();
            readfile($excelFileName);
            unlink($excelFileName);
        }       
            
    }

    public function ExportToExcel($schema,$model, $condition, $fileName)
    {

        $excelFileName = Yii::app()->basePath . '/../upload/rpt_xls/' . $fileName . '.xls';
        $objPHPExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("SSS")->setLastModifiedBy("SSS")->setTitle($model->module)->setSubject("Office 2007 XLS Document")->setKeywords("office 2007 openxml php");

        $objPHPExcel->setActiveSheetIndex(0);
        $col = 'A';
        $x = 0;
        $select_query = 'select ';
        foreach ($model->col_name as $col_name=>$alias)
        {   //set header 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col . '1', $alias);
            if ($x > 0)
                $select_query .= ', ';
            $select_query .= strtolower($col_name);
            $col++;
            $x++;
        }

        //build query select column
        $user_id = Yii::app()->user->id;
        $select_query .= " from $schema.$model->tablename  $condition ";
        $exec_data = DAO::queryAllSql($select_query);
        //set detail
        
        $y = 2;
        foreach ($exec_data as $row)
        {
            $col = 'A';
            foreach ($model->col_name as $col_name=>$alias)
            {
                $value = $row[strtolower($col_name)];
                if (DateTime::createFromFormat('Y-m-d H:i:s', $value))
                {
                    $value = DateTime::createFromFormat('Y-m-d H:i:s', $value)->format('d/m/Y');
                }

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col . $y, $value);
                $col++;
            }
            $y++;

        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($excelFileName);

        if (file_exists($excelFileName))
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $fileName . '.xls"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($excelFileName));
            ob_clean();
            flush();
            readfile($excelFileName);
            unlink($excelFileName);
        }

    }
}
