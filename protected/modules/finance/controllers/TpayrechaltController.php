<?php

class TpayrechaltController extends AAdminController
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
		require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'TpayrechController.php');
		
		$this->origControllerId = 'tpayrech';
		$this->origClass = new Tpayrechcontroller($this->origControllerId, $this->getModule());	
	}

	public function actionAjxGetClientDetail()
	{
		$this->origClass->actionAjxGetClientDetail();
	}
	
	public function actionAjxGetBankAccount()
	{
		$this->origClass->actionAjxGetBankAccount();
	}
	
	public function actionAjxGetFolderPrefix()
	{
		$this->origClass->actionAjxGetFolderPrefix();
	}
	
	public function actionAjxFindBankCd()
	{
		$this->origClass->actionAjxFindBankCd();
	}
	
	public function actionAjxGetTransferFee()
	{
		$this->origClass->actionAjxGetTransferFee();
	}
	
	public function actionAjxGetRdiAcctName()
	{
		$this->origClass->actionAjxGetRdiAcctName();
	}
	
	public function actionAjxCheckCash()
	{
		$this->origClass->actionAjxCheckCash();
	}

	public function actionAjxValidateBackDated()
	{
		$this->origClass->actionAjxValidateBackDated();
	}
	
	public function actionGetClient()
	{
		$this->origClass->actionGetClient();
	}
	
	public function actionGetSlAcct()
	{
		$this->origClass->actionGetSlAcct();
	}
	
	public function actionGetBankAcctNum()
	{
		$this->origClass->actionGetBankAcctNum();
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
