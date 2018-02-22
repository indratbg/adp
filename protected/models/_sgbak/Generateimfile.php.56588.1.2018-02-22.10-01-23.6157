<?php
class Generateimfile extends ARptForm
{

    public $trx_date;
    public $im_code;
    public $tempDateCol = array();
    public $col_name = array(
        'FUNDID'=>'fundID',
        'TRANSREFNO'=>'TransRefNo',
        'TRANSACTIONDATE'=>'TransactionDate',
        'SETTLEMENTDATE'=>'SettlementDate',
        'BROKERCODE'=>'BrokerCode',
        'STOCKCODE'=>'StockCode',
        'TRANSACTIONTYPE'=>'TransactionType',
        'FLAGNETTING'=>'FlagNetting',
        'VOLUME'=>'Volume',
        'PRICE'=>'Price',
        'PROCEED'=>'Proceed',
        'LEVY'=>'Levy',
        'KPEI'=>'KPEI',
        'VAT'=>'VAT',
        'WHT'=>'WHT',
        'CAPITALGAINTAX'=>'CapitalGainTax',
        'BROKERFEE'=>'BrokerFee',
        'NETAMOUNT'=>'NetAmount'
    );

    public $col_name_lim = array(
        'TRX_STS'=>'Transaction Status',
        'TA_REF_ID'=>'TA Reference ID',
        'TA_REF_NO'=>'TA Reference No.',
        'TRX_DATE'=>'Trade Date',
        'TRX_DUE_DATE'=>'Settlement Date',
        'IM_CODE'=>'IM Code',
        'BROKER_CD'=>'BR Code',
        'FUND_CODE'=>'Fund Code',
        'STK_CD'=>'Security Code',
        'BUY_SELL'=>'Buy/Sell',
        'PRICE'=>'Price',
        'QTY'=>'Quantity',
        'CURR_VALUE'=>'Trade Amount',
        'NET_COMMISION_VALUE'=>'Commission',
        'SALES_TAX'=>'Sales Tax',
        'LEVY'=>'Levy',
        'VAT'=>'VAT',
        'OTHER_CHARGES'=>'Other Charges',
        'GROSS_SETTLEMENT_AMT'=>'Gross Settlement Amount',
        'WITHHOLDING_PPH'=>'WHT on Commission',
        'NET_VALUE'=>'Net Settlement Amount',
        'SETTLEMENT_TYPE'=>'Settlement Type',
        'REMARKS'=>'Remarks',
        'CANCEL_REASON'=>'Cancellation Reason'
    );

    public $col_name_sch = array(
        'portfolio_id'=>'Portfolio ID',
        'trans_no'=>'Trans no.',
        'b_s'=>'B/S',
        'trx_date'=>'Trade Date',
        'trx_due_date'=>'Settle Date',
        'stk_cd'=>'Security',
        'isin_code'=>'ISIN',
        'qc'=>'QC',
        'qty'=>'Quantity',
        'price'=>'Price',
        'curr_value'=>'Gross Amount',
        'net_commision_value'=>'Commission',
        'levy'=>'Trans Levy',
        'vat'=>'VAT',
        'sales_tax'=>'Sales Tax',
        'other_charges'=>'Other Charges',
        'total'=>'Total',
        'withholding_pph'=>'WHT on',
        'vat2'=>'VAT2',
        'net_value'=>'Net Settlement Amo',
        'broker_cd'=>'Broker ID',
        'nama_prsh'=>'Broker'
    );
    public $col_name_sya = array(
        'BRANCH_CODE'=>'BRANCH',
        'TRX_DATE'=>'TRANSACTION_DATE',
        'TRX_DUE_DATE'=>'DUE_DATE',
        'SL_CODE'=>'CLIENT_CODE',
        'CLIENT_NAME'=>'CLIENT_NAME',
        'DEF_ADDR_1'=>'ADDRESS_1',
        'DEF_ADDR_2'=>'ADDRESS_2',
        'DEF_ADDR_3'=>'ADDRESS_3',
        'POST_CD'=>'ZIP_CODE',
        'PHONE_NUM'=>'PHONE',
        'FAX_NUM'=>'FAX',
        'STK_CD'=>'STOCK',
        'L_F'=>'L/F',
        'LOT'=>'LOT',
        'QTY'=>'QTY',
        'PRICE'=>'PRICE',
        'B_S'=>'BUY/SELL',
        'TRX_MRKT_TYPE'=>'MARKET_TYPE',
        'TOTAL_VALUE'=>'TOTAL_VALUE',
        'COMMISSION'=>'COMMISSION',
        'VAT'=>'VAT',
        'LEVY'=>'LEVY',
        'SALES_TAX'=>'SALES_TAX',
        'WITHHOLDING_PPH'=>'WITHHOLDING_PPH',
        'TOTAL_NET'=>'TOTAL_NET',
        'NPWP_NO'=>'NPWP',
        'PKP'=>'PKP',
        'REM_NAME'=>'SALES'
    );
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array(
                'trx_date',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),
            array(
                'im_code,trx_date',
                'required'
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'trx_date'=>'Transaction Date',
            'im_code'=>'IM Name'
        );
    }

    public static function getDataCSV($trx_date)
    {
        $sql = "SELECT NULL fundID , NULL TransRefNo ,TRX_DATE AS TransactionDate ,TRX_DUE_DATE SettlementDate ,BROKER_CD BrokerCode ,STK_CD StockCode ,DECODE(GL_CODE,'TBE','B','S') TransactionType ,DECODE(TRX_MRKT_TYPE,'RG',0,1) FlagNetting ,QTY Volume ,PRICE Price ,CURR_VALUE Proceed ,LEVY ,NULL KPEI ,VAT ,WITHHOLDING_PPH WHT ,NULL CapitalGainTax ,COMMISION_VALUE BrokerFee ,NET_VALUE NetAmount
            FROM stock_transaction
            where trx_date='$trx_date'";
        return $sql;
    }

    public function executeSp()
    {
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try
        {
            $query = "CALL  SP_GEN_CSV_IM(TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
                                            :P_IM_CODE,
                                            :P_USER_ID,
                                          :P_RAND_VALUE,
                                            :P_vo_errcd,
                                            :P_vo_errmsg)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_TRX_DATE", $this->trx_date, PDO::PARAM_STR);
            $command->bindValue(":P_IM_CODE", $this->im_code, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
            $command->bindParam(":P_RAND_VALUE", $this->vo_random_value, PDO::PARAM_INT, 10);
            $command->bindParam(":P_vo_errcd", $this->vo_errcd, PDO::PARAM_INT, 10);
            $command->bindParam(":P_vo_errmsg", $this->vo_errmsg, PDO::PARAM_STR, 200);
            $command->execute();
            $transaction->commit();
        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            if ($this->vo_errcd = -999)
                $this->vo_errmsg = $ex->getMessage();
        }

        if ($this->vo_errcd < 0)
            $this->addError('vo_errmsg', 'Error ' . $this->vo_errcd . ' ' . $this->vo_errmsg);

        return $this->vo_errcd;
    }

}
?>