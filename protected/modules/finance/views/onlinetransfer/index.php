<?php
$this->breadcrumbs=array(
	'Onlinetransfer'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Online Transfer', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>
<br />

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'onlinetransfer-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<div class="row-fluid" style="display:none">
	<label class="control-label">Channel ID</label>
	<input type="text" name="transactionData[channel_id]" value="<?php echo $transactionData->ChannelID ?>" class="span3" />
</div>
<div class="row-fluid" style="display:none">
	<label class="control-label">Requester Data 1</label>
	<input type="text" name="transactionData[request_data_1]" value="<?php echo $transactionData->RequestData1 ?>" class="span3" />
</div>
<div class="row-fluid" style="display:none">
	<label class="control-label">Requester Data 2</label>
	<input type="text" name="transactionData[request_data_2]" value="<?php echo $transactionData->RequestData2 ?>" class="span3" />
</div>	
<div class="row-fluid">
	<label class="control-label">Transaction ID</label>
	<input type="text" name="transactionData[transaction_id]" maxlength="8" value="<?php echo $transactionData->TransactionId ?>" class="span3" readonly="readonly" />
</div>
<div class="row-fluid">
	<!-- <label class="control-label">Trx Ref No</label> -->
	<label class="control-label">Reference Number</label>
	<input type="text" name="transactionData[trx_ref_no]" maxlength="30" value="<?php echo $transactionData->TrxRefNo ?>" class="span3" required="required"/>
</div>
<div class="row-fluid">
	<label class="control-label">Transaction Date</label>
	<input type="text" name="transactionData[transaction_date]" maxlength="8" value="<?php echo $transactionData->TransactionDate ?>" placeholder="yyyymmdd" class="span3" readonly="readonly"/>
</div>
<div class="row-fluid">
	<label class="control-label">Currency Symbol</label>
	<input type="text" name="transactionData[currency_symbol]" maxlength="3" value="<?php echo $transactionData->CurrencySymbol ?>" class="span3" />
</div>
<div class="row-fluid">
	<label class="control-label">Transfer Type</label>
	<!-- <input type="text" name="transactionData[transfer_type]" value="<?php echo $transactionData->TransferType ?>" class="span3" /> -->
	<select name="transactionData[transfer_type]" class="span3" id="trx_type">
		<option value="">-Select-</option>
		<option value="BCA" <?php echo $transactionData->TransferType=='BCA'?'selected':''; ?> >BCA</option>
		<option value="LLG" <?php echo $transactionData->TransferType=='LLG'?'selected':''; ?> >LLG</option>
		<option value="RTG" <?php echo $transactionData->TransferType=='RTG'?'selected':''; ?> >RTG</option>
	</select>
	
</div>
<div class="row-fluid">
	<label class="control-label">From Account Number</label>
	<input type="text" name="transactionData[from_account_number]" maxlength="10" value="<?php echo $transactionData->FromAccountNumber ?>" class="span3" />
</div>
<div class="row-fluid">
	<label class="control-label">To Account Number</label>
	<input type="text" name="transactionData[to_account_number]" maxlength="34" id="to_account_number" value="<?php echo $transactionData->ToAccountNumber ?>" class="span3" />
</div>
<div class="row-fluid">
	<label class="control-label">Amount Input</label>
	<input type="text" name="transactionData[amount_input]" id="amount_input" value="<?php echo $transactionData->AmountInput ?>" class="span3" style="text-align: right" />
</div>
<div class="row-fluid">
	<label class="control-label">Transaction Remark 1</label>
	<input type="text" name="transactionData[transaction_remark_1]" maxlength="18" value="<?php echo $transactionData->TransactionRemark1 ?>" class="span3" />
</div>
<div class="row-fluid">
	<label class="control-label">Transaction Remark 2</label>
	<input type="text" name="transactionData[transaction_remark_2]" maxlength="18" value="<?php echo $transactionData->TransactionRemark2 ?>" class="span3" />
</div>
<div class="row-fluid">
	<label class="control-label">Receiver Bank Code</label>
	<!-- <input type="text" name="transactionData[receiver_bank_code]" value="<?php echo $transactionData->ReceiverBankCode ?>" class="span3" /> -->
	<select name="transactionData[receiver_bank_code]" class="span3" id="receiver_bank_code" style="font-family: Courier">
		<option value="">-Select-</option>
		<?php foreach($bi_code as $row) { ?>
			<option value="<?php echo $row['bi_code'] ?>" <?php echo $transactionData->ReceiverBankCode==$row['bi_code']?'selected':''; ?> ><?php echo $row['bank_name'] ?></option>
		
		<?php } ?>
	</select>
	
</div>
<div class="row-fluid">
	<label class="control-label">Receiver Bank Name</label>
	<input type="text" name="transactionData[receiver_bank_name]" id="receiver_bank_name" maxlength="18" value="<?php echo $transactionData->ReceiverBankName ?>" class="span3" />
</div>
<div class="row-fluid">
	<label class="control-label">Receiver Name</label>
	<input type="text" name="transactionData[receiver_name]" id="receiver_name" maxlength="70" value="<?php echo $transactionData->ReceiverName ?>" class="span3" />
</div>
<div class="row-fluid">
	<label class="control-label">Receiver Bank Branch Name</label>
	<input type="text" name="transactionData[receiver_bank_branch_name]" maxlength="18" value="<?php echo $transactionData->ReceiverBankBranchName ?>" class="span3" />
</div>
<div class="row-fluid">
	<label class="control-label">Receiver Cust Type</label>
	<!-- <input type="text" name="transactionData[receiver_cust_type]" value="<?php echo $transactionData->ReceiverCustType ?>" class="span3" /> -->
	<select name="transactionData[receiver_cust_type]" class="span3" id="receiver_cust_type">
		<option value="">-Select-</option>
		<option value="1" <?php echo $transactionData->ReceiverCustType=='1'?'selected':''; ?> >Perorangan</option>
		<option value="2" <?php echo $transactionData->ReceiverCustType=='2'?'selected':''; ?> >Perusahaan</option>
		<option value="3" <?php echo $transactionData->ReceiverCustType=='3'?'selected':''; ?> >Pemerintah</option>
	</select>
	
</div>
<div class="row-fluid">
	<label class="control-label">Receiver Cust Residence</label>
	<!-- <input type="text" name="transactionData[receiver_cust_residence]" value="<?php echo $transactionData->ReceiverCustResidence ?>" class="span3" /> -->
	<select name="transactionData[receiver_cust_residence]" class="span3" id="receiver_cust_residence">
		<option value="">-Select-</option>
		<option value="R" <?php echo $transactionData->ReceiverCustResidence=='R'?'selected':''; ?> >Penduduk</option>
		<option value="N" <?php echo $transactionData->ReceiverCustResidence=='N'?'selected':''; ?> >Bukan Penduduk</option>
	</select>
</div>
<div class="row-fluid">
	<label class="control-label">Receiver Email Address</label>
	<input type="text" name="transactionData[receiver_email_address]" maxlength="100" value="<?php echo $transactionData->ReceiverEmailAddress ?>" class="span3" />
</div>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnSubmit',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Transfer',
	)); ?>
</div>

<?php $this->endWidget(); ?>

<script>
	$(document).ready(function()
	{
		$("label.control-label").css("width",200);
		bank_name();
	});
	
	$('#trx_type').change(function(){
		
		if($('#trx_type').val() =='LLG' ||$('#trx_type').val() =='RTG')
		{
			$('#receiver_bank_code').attr('required',true);
			$('#receiver_bank_name').attr('required',true);
			$('#receiver_name').attr('required',true);
			$('#receiver_cust_type').attr('required',true);
			$('#receiver_cust_residence').attr('required',true);
		}
		else
		{
			$('#receiver_bank_code').attr('required',false);
			$('#receiver_bank_name').attr('required',false);
			$('#receiver_name').attr('required',false);
			$('#receiver_cust_type').attr('required',false);
			$('#receiver_cust_residence').attr('required',false);
		}
	})
	
	$('#receiver_bank_code').change(function(){
		bank_name();
	});
	
	function bank_name()
	{
		if($('#receiver_bank_code').val() !='')
		{
			var bank_receiver = $('#receiver_bank_code option:selected').text().split('-');
			$('#receiver_bank_name').val(bank_receiver[0].trim());
		}	
	}
	$('#btnSubmit').click(function(){
		
		if(confirm('Are you sure want to transfer '+$('#to_account_number').val() +' : '+$('#amount_input').val() +' ?'))
		{
			return true;
			
		}
		else
		{
			return false;
		}	
		
	})

</script>