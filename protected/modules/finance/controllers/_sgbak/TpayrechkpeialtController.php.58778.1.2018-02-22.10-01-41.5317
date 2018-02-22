<?php

class TpayrechkpeialtController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	private $origControllerId;
	private $origClass;
	
	public function init()
	{
		require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'TpayrechkpeiController.php');
		
		$this->origControllerId = 'tpayrechkpei';
		$this->origClass = new Tpayrechkpeicontroller($this->origControllerId, $this->getModule());	
	}
	
	public function actionAjxGetBankAccount()
	{
		$this->origClass->actionAjxGetBankAccount();
	}
	
	public function actionAjxGetFolderPrefix()
	{
		$this->origClass->actionAjxGetFolderPrefix();
	}
	
	public function actionAjxGetTransferFee()
	{
		$this->origClass->actionAjxGetTransferFee();
	}
	
	public function actionAjxGetDueTrxDate()
	{
		$this->origClass->actionAjxGetDueTrxDate();
	}

	public function actionAjxValidateBackDated()
	{
		$this->origClass->actionAjxValidateBackDated();
	}
	
	public function actionGetSlAcct()
	{
		$this->origClass->actionGetSlAcct();
	}
	
	public function actionView($id)
	{	
		$this->origClass->actionView($id, $this);
	}
	
	public function actionCreate()
	{	
		$this->origClass->actionCreate($this);
	}

	public function actionUpdate($id)
	{	
		$this->origClass->actionUpdate($id, $this, true);
	}
	
	public function actionUpdateRemark($id)
	{	
		$this->origClass->actionUpdateRemark($id, $this);
	}

	public function actionAjxPopDelete($id)
	{
		$this->origClass->actionAjxPopDelete($id, $this, true);
	}

	public function actionIndex()
	{		
		$this->origClass->actionIndex($this);
	}
}
