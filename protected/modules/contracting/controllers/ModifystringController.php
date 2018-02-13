<?php

class ModifystringController extends AAdminController
{

	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		//read the entire string
		$filename= '/opt/apache-tomcat-7.0.30/webapps/birt/lotsreport/Fund_ledger123.rptdesign';
		//var_dump($filename);die();
		$str=implode("",file($filename));
		$fp=fopen($filename,'w');
		//replace something in the file string, here i am replacing an IP address from  127.0.0.1 to 127.1.9.9
		$str=str_replace("jdbc:oracle:thin:@127.0.0.1:1521:orclbo",'jdbc:oracle:thin:@127.1.1.1:1521:orclbo',$str);
		//now, save the file
		fwrite($fp,$str,strlen($str));
		
		
	}
	
}

		