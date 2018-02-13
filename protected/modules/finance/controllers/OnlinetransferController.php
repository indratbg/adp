<?php

require_once('ws/trxgateway.php');

Class OnlinetransferController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public $alphaNumeric = 'abcdefghijklmnopqrstuvwxyz1234567890';
	
	public function actionIndex()
	{
		$transactionData = new CTransactionData;
		$sql ="select bi_code,ip_bank_cd||' - '||bank_name bank_name  from mst_bank_bi WHERE APPROVED_STAT='A'  order by bank_name";
		$bi_code = DAO::queryAllSql($sql);
		$today = date('d/m/Y');
		$result = DAO::queryRowSql("SELECT Get_TRF_ID(to_date('$today','dd/mm/yyyy'))trf_id FROM DUAL");
		$trx_id = $result['trf_id'];
		
		
		if(isset($_POST['transactionData']))
		{
			$transactionData->ChannelID = $_POST['transactionData']['channel_id'];
			$transactionData->RequestData1 = $_POST['transactionData']['request_data_1'];
			$transactionData->RequestData2 = $_POST['transactionData']['request_data_2'];
			$transactionData->TransactionId = $_POST['transactionData']['transaction_id'];
			$transactionData->TrxRefNo = $_POST['transactionData']['trx_ref_no'];
			$transactionData->TransactionDate = $_POST['transactionData']['transaction_date'];
			$transactionData->CurrencySymbol = $_POST['transactionData']['currency_symbol'];
			$transactionData->TransferType = $_POST['transactionData']['transfer_type'];
			$transactionData->FromAccountNumber = $_POST['transactionData']['from_account_number'];
			$transactionData->ToAccountNumber = $_POST['transactionData']['to_account_number'];
			$transactionData->AmountInput = $_POST['transactionData']['amount_input'];
			$transactionData->TransactionRemark1 = $_POST['transactionData']['transaction_remark_1'];
			$transactionData->TransactionRemark2 = $_POST['transactionData']['transaction_remark_2'];
			$transactionData->ReceiverBankCode = $_POST['transactionData']['receiver_bank_code'];
			$transactionData->ReceiverBankName = $_POST['transactionData']['receiver_bank_name'];
			$transactionData->ReceiverName = $_POST['transactionData']['receiver_name'];
			$transactionData->ReceiverBankBranchName = $_POST['transactionData']['receiver_bank_branch_name'];
			$transactionData->ReceiverCustType = $_POST['transactionData']['receiver_cust_type'];
			$transactionData->ReceiverCustResidence = $_POST['transactionData']['receiver_cust_residence'];
			$transactionData->ReceiverEmailAddress = $_POST['transactionData']['receiver_email_address'];

			$trxGatewayClient = new CTrxGatewayClient;
			//$trxGatewayClient->SoapUrl = "http://192.168.8.33:7001/TrxGateway/TrxBCA.svc?wsdl";//PROD
			$trxGatewayClient->SoapUrl = "http://192.168.8.35:5021/TrxGateway/TrxBCA.svc?wsdl";
			
			$trfHeader['trf_id'] = $transactionData->TransactionId;
			$trfHeader['file_name'] = null;
			$trfHeader['trx_type'] = 'OT';
			$trfHeader['kbb_type1'] = 9;
			$trfHeader['kbb_type2'] = null;
			$trfHeader['branch_group'] = null;
			$trfHeader['trf_date'] = substr($transactionData->TransactionDate,6,2). '/' . substr($transactionData->TransactionDate,4,2). '/' . substr($transactionData->TransactionDate,0,4);
			$trfHeader['save_date'] = date('d/m/Y H:i:s');
			$trfHeader['total_record'] = 1;
			
			$trfDetail[0]['row_id'] = 1;
			$trfDetail[0]['trx_ref'] = $transactionData->TrxRefNo;
			$trfDetail[0]['trf_id'] = $trfHeader['trf_id'];
			$trfDetail[0]['acct_name'] = $transactionData->ReceiverName;
			$trfDetail[0]['rdi_acct'] = $transactionData->FromAccountNumber;
			$trfDetail[0]['client_bank_acct'] = $transactionData->ToAccountNumber;
			$trfDetail[0]['bank_name'] = $transactionData->ReceiverBankName;
			$trfDetail[0]['trf_amt'] = $transactionData->AmountInput;
			
			$insertMessage = null;
			
			$connection  = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			
			$insertMessage = GenKBB::insertH2HRef($trfHeader, $trfDetail);

			if($insertMessage === 1)
			{
				$transaction->commit();
				$success = true;
			}
			else 
			{
				$transaction->rollback();
				$success = false;
			}
			
			if($success)  
			{
				$trxGatewayClient->Open();
				
				$success = $trxGatewayClient->SendTransaction($transactionData);
				
				$trxGatewayClient->Close();
				
				if($success)
				{
					$updateHeaderSql = "UPDATE T_H2H_REF_HEADER
										SET response_date = SYSDATE,
											success_cnt = 1,
											fail_cnt = 0,  
											description = '$trxGatewayClient->TrxMessage' 
										WHERE trf_id = '{$trfHeader['trf_id']}'";
										
					$updateDetailSql = "UPDATE T_H2H_REF_DETAIL
										SET status = '00',  
											description = '$trxGatewayClient->TrxMessage'
										WHERE trf_id = '{$trfHeader['trf_id']}'";
					
					DAO::executeSql($updateHeaderSql);
					DAO::executeSql($updateDetailSql);
					
					Yii::app()->user->setFlash('success',"Success");
					$this->redirect(array('index'));
				}
				else 
				{
					$updateHeaderSql = "UPDATE T_H2H_REF_HEADER
										SET response_date = SYSDATE,
											success_cnt = 0,
											fail_cnt = 1, 
											description = '$trxGatewayClient->ErrMessage' 
										WHERE trf_id = '{$trfHeader['trf_id']}'";
										
					$updateDetailSql = "UPDATE T_H2H_REF_DETAIL
										SET status = '01', 
											description = '$trxGatewayClient->ErrMessage' 
										WHERE trf_id = '{$trfHeader['trf_id']}'";
					
					DAO::executeSql($updateHeaderSql);
					DAO::executeSql($updateDetailSql);
					
					Yii::app()->user->setFlash('error',"Error while using SOAP Client: " . $trxGatewayClient->ErrMessage);
				}
			}
			else 
			{
				Yii::app()->user->setFlash('error',"Error while inserting record to the database: " . $insertMessage);
			}
		}
		else 
		{			
			$transactionData->ChannelID = '01';
			//$transactionData->RequestData1 = 'lautandana';//dev
			$transactionData->RequestData1 = 'KBCLAUTAND';//prod
			
			$transactionData->RequestData2 = '';
			
			for($x=0;$x<30;$x++)
			{
				$transactionData->RequestData2 .= substr($this->alphaNumeric,rand(0,35),1);
			}	
			
			$transactionData->TransactionDate = date('Ymd');
			$transactionData->CurrencySymbol = 'IDR';
			$transactionData->ReceiverCustType = 1;
			$transactionData->ReceiverCustResidence = 'R';
			//$transactionData->ReceiverName = 'Name';
			$transactionData->ReceiverBankName = 'Bank Name';
			//$transactionData->ReceiverBankCode = 'BCA';
			$transactionData->ReceiverBankCode = '0140397';
			$transactionData->ReceiverBankBranchName = 'JAKARTA';
			//$transactionData->FromAccountNumber = '0611107446';
			//$transactionData->ToAccountNumber = '0611117506';
			//$transactionData->TrxRefNo = 'ReF00001';
			$transactionData->TransferType = 'BCA';
			//$transactionData->TransactionId= '00000077';
			$transactionData->TransactionId= $trx_id;
			//$transactionData->AmountInput= '100500.00';
			$transactionData->AmountInput= '.00';
		}
		
		$this->render('index',array(
			'transactionData' => $transactionData,
			'bi_code'=>$bi_code
		));
	}	
}
