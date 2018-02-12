<style>
	#retrieve > div, #retrieve2 > div
	{
		border-top: 1px solid #e5e5e5;
		padding-top:10px;
	}

	#payrecType > label
	{
		width:100px;
		margin-left:-12px;
	}
	
	#payrecType > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-10px;
	}
	
	#payrecType > label > input
	{
		float:left;
	}
	
	/*
	#type > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-30px;
	}
	
	#type > label
	{
		width:200px;
		margin-left:-32px;
	}
	*/
	
	.tabMenu ul
	{
		border-top:2px solid #ddd;
		border-bottom:2px solid #ddd;
		border-left:2px solid #ddd;
		border-radius:5px;
	}	
	.tabMenu li
	{
		border-right:1px solid #ddd;
		border-radius:5px;
	}
	.tabMenu li:not(:first-child)
	{
		border-left:1px solid #ddd;
		border-radius:5px;
	}
	
	.tnumber, .tnumberdec
	{
		text-align:right;
	}
	
	.markCancel
	{
		background-color:#BB0000;
	}
	
	#showloading
	{
		display:none;
		position:fixed;
		left:45%;
		top:30%;
	}
</style>

<?php

	$bankList = Ipbank::model()->findAll(array('condition'=>"approved_stat='A'",'order'=>'bank_cd'));
	$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHEQ' AND param_cd2 = 'RV'")->dflg1;
	//$rdiBank = Sysparam::model()->findAll("param_id = 'VOUCHER ENTRY' AND param_cd1 = 'RDI_PAY' AND param_cd2 = 'BANK'");	
	$rdiBank = DAO::queryAllSql("SELECT gl_a, sl_a, brch_cd, fund_bank_cd FROM MST_GLA_TRX WHERE jur_type = 'BANKRDI'");
	
	$bankAccNonTrx = Sysparam::model()->findAll(array('condition'=>"param_id = 'VOUCHER ENTRY' AND param_cd1 = 'DDBANK' AND param_cd2 = 'NONTRX'",'order'=>'param_cd3'));
	$bankAccTrx = Sysparam::model()->findAll(array('condition'=>"param_id = 'VOUCHER ENTRY' AND param_cd1 = 'DDBANK' AND param_cd2 = 'TRX'",'order'=>'param_cd3'));

	$glAcctType = DAO::queryAllSql("SELECT gl_a FROM MST_GLA_TRX WHERE jur_type IN ('T3','T7') ORDER BY jur_type");
?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tpayrech-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php 
		echo $form->errorSummary($model); 
		foreach($modelDetail as $row)echo $form->errorSummary($row);
		foreach($modelLedger as $row)echo $form->errorSummary($row);
		if($modelFolder)echo $form->errorSummary($modelFolder); 
		foreach($modelCheq as $row)echo $form->errorSummary($row);
		
		foreach($modelDetailLedger as $row)echo $form->errorSummary($row);
		if(isset($modelDetailLedgerNonRev))echo $form->errorSummary($modelDetailLedgerNonRev); 
		foreach($modelCheqLedger as $row)echo $form->errorSummary($row);
		
		if(isset($modelJvchh))echo $form->errorSummary($modelJvchh); 
		
		foreach($tempModel as $row)echo $form->errorSummary($row);
		
		if(isset($oldModel))echo $form->errorSummary($oldModel); 
		
		if(isset($oldModelDetail))
		{
			foreach($oldModelDetail as $row)
			{
				echo $form->errorSummary($row);
			}
		}
		
		if(isset($oldModelDetailLedger))
		{
			foreach($oldModelDetailLedger as $row)
			{
				echo $form->errorSummary($row);
			}
		}
		
		if(isset($oldModelLedger))
		{
			foreach($oldModelLedger as $row)
			{
				echo $form->errorSummary($row);
			}
		}
		
		if(isset($oldModelFolder))echo $form->errorSummary($oldModelFolder);
		
		if(isset($reverseModelLedger))
		{
			foreach($reverseModelLedger as $row)
			{
				echo $form->errorSummary($row);
			}
		}
		
		if(isset($reverseModelFolder))echo $form->errorSummary($reverseModelFolder);
	?>
	
	<div id="showloading" style="display:none;margin: auto; width: auto; text-align: center;">
		Please wait...<br />
		<img src="<?php echo Yii::app()->request->baseUrl ?>/images/loading2.gif" width="25px">	
	</div>
	
	<input type="hidden" id="authorizedBackDated" name="authorizedBackDated" value=1 />
	
	<div class="row-fluid">
		<div class="span4" style="<?php if(!$model->isNewRecord)echo 'display:none' ?>">
			<div id="type_span" class="span5">
				<?php echo $form->labelEx($model,'type',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->dropDownList($model,'type',array('D'=>'NON TRANSACTION','V'=>'TRANSACTION'),array('id'=>'type','class'=>'span7','onChange'=>'changeType()')); ?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span4">
			<div id="payrecType_div">
				<div class="span5">
					<?php echo $form->labelEx($model,'payrec_type',array('class'=>'control-label')) ?>
				</div>
				<?php if($model->isNewRecord): ?>
					<?php echo $form->radioButtonListInlineRow($model,'payrec_type',array('RD'=>'RECEIPT','PD'=>'PAYMENT'),array('id'=>'payrecType','class'=>'span5','label'=>false,'onChange'=>'changeLabel()')); ?>
				<?php else: ?>
					<?php echo $form->textField($model,'payrec_type',array('id'=>'payrecType','class'=>'span5','value'=>substr($model->payrec_type,0,1)=='R'?'RECEIPT':'PAYMENT','disabled'=>'disabled')); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<div class="span4" id="clientCd_span">
					<?php echo $form->labelEx($model,'client_cd',array('id'=>'clientLabel','class'=>'control-label')) ?>
				</div>
				<?php //echo $form->dropDownList($model,'client_cd',CHtml::listData(Client::model()->findAll(array('condition'=>"susp_stat = 'N'",'order'=>'client_cd')), 'client_cd', 'ConcatForSettlementClientCmb'),array('id'=>'clientCd','class'=>'span4','prompt'=>'-Choose-','disabled'=>!$model->isNewRecord?'disabled':'')); ?>
				<?php echo $form->textField($model,'client_cd',array('id'=>'clientCd','class'=>'span4','disabled'=>!$model->isNewRecord?'disabled':'')) ?>
				<input type="hidden" id="client_hid" name="client_hid" value="<?php echo $model->client_cd ?>" />
				<?php echo $form->textField($model,'client_type',array('id'=>'clientType','class'=>'span2','readonly'=>'readonly')); ?>
				<?php echo $form->textField($model,'branch_code',array('id'=>'branchCode','class'=>'span2','readonly'=>'readonly')); ?>
			</div>
		</div>
		<div class="span4">
			<?php echo $form->textField($model,'client_name',array('id'=>'clientName','class'=>'span12','readonly'=>'readonly')); ?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span4">
			<div class="span5">
				<?php echo $form->labelEx($model,'payrec_date',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->datePickerRow($model,'payrec_date',array('id'=>'payrecDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
			<input type="hidden" id="payrecDate_hid" name="payrecDate_hid" value="<?php if($model->payrec_date)echo DateTime::createFromFormat('Y-m-d',substr($model->payrec_date,0,10))->format('d/m/Y') ?>" />
		</div>
		<div class="span4">
			<div class="control-group">
				<div class="span4">
					
				</div>
				<?php echo $form->textField($model,'olt',array('id'=>'olt','class'=>'span2','readonly'=>'readonly')); ?>
				<?php echo $form->textField($model,'client_type_3',array('id'=>'clientType3','class'=>'span4','readonly'=>'readonly')); ?>
				<?php echo $form->textField($model,'recov_charge_flg',array('id'=>'recovChargeFlg','class'=>'span2','readonly'=>'readonly')); ?>
			</div>
		</div>
		<div class="span4">
			<div id="intAdjust_div" class="span6">
				<div class="span10">
					<?php echo $form->labelEx($model,'int_adjust',array('class'=>'')) ?>
				</div>
				<?php echo $form->checkBox($model,'int_adjust',array('id'=>'intAdjust','style'=>'float:left','value'=>'Y','uncheckValue'=>'N')); ?>
			</div>
			<div id="trfKsei_div"  class="span6">
				<div class="span7">
					<?php echo $form->labelEx($model,'trf_ksei',array('class'=>'')) ?>
				</div>
				<?php echo $form->checkBox($model,'trf_ksei',array('id'=>'trfKsei','style'=>'float:left','value'=>'Y','uncheckValue'=>'N')); ?>
			</div>
		</div>			
	</div>
	
	<div class="row-fluid">
		<div class="span4">
		</div>
		<div class="span4">
			<div class="control-group">
				<div class="span4">
					<?php echo $form->labelEx($model,'bank_cd',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'bank_cd',array('id'=>'bankCd','class'=>'span3','readonly'=>'readonly')); ?>
				<?php echo $form->textField($model,'bank_acct_fmt',array('id'=>'bankAcctFmt','class'=>'span5','readonly'=>'readonly')); ?>
			</div>
		</div>
		<div class="span4">
			<?php echo $form->textField($model,'active',array('id'=>'active','class'=>'span4','readonly'=>'readonly','style'=>'float:left')); ?>
			<div class="span3">
				<?php echo $form->labelEx($model,'rdi_pay_flg',array('class'=>'')) ?>
			</div>
			<?php if($model->isNewRecord): ?>
				<?php echo $form->checkBox($model,'rdi_pay_flg',array('id'=>'rdiPayFlg','style'=>'float:left','value'=>'Y','uncheckValue'=>'N')); ?>
			<?php else: ?>
				<?php echo $form->textField($model,'rdi_pay_flg',array('id'=>'rdiPayFlg','class'=>'span2','readonly'=>'readonly')); ?>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<div class="span5">
					<?php echo $form->labelEx($model,'gl_acct_cd',array('class'=>'control-label')) ?>
				</div>
				<div class="controls">
					<?php echo $form->dropDownList($model,'gl_acct_cd',CHtml::listData($model->type=='D'?$bankAccNonTrx:$bankAccTrx, 'dstr1', 'dstr1'),array('id'=>'glAcctCd','class'=>'span3')); ?>
					<?php echo $form->dropDownList($model,'sl_acct_cd',array()/*CHtml::listData($sl_acct_cd, 'sl_a', 'BankAccount')*/,array('id'=>'slAcctCd','class'=>'span4','prompt'=>'-Choose-')); ?>
					<input type="hidden" id="glAcctCd_hid" name="glAcctCd_hid" value="<?php echo $model->gl_acct_cd ?>" />
					<input type="hidden" id="slAcctCd_hid" name="slAcctCd_hid" value="<?php echo $model->sl_acct_cd ?>" />
				</div>
			</div>
		</div>
		<div class="span4">
			<div id="currAmt_div">
				<div id="currAmt_span" class="span4">
					<?php echo $form->labelEx($model,'curr_amt',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'curr_amt',array('id'=>'currAmt','class'=>'span8 tnumberdec')); ?>
			</div>
		</div>
		<div class="span4">
			<?php echo $form->textField($model,'acct_name',array('id'=>'acctName','class'=>'span12','readonly'=>'readonly')); ?>		
		</div>	
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div id="folderCd_span" class="span5">
				<?php echo $form->labelEx($model,'folder_cd',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'folder_cd',array('id'=>'folderCd','class'=>'span7','maxlength'=>8)); ?>
		</div>
		<div class="span8">
			<div class="control-group">
				<div id="remarks_span" class="span2">
					<?php echo $form->labelEx($model,'remarks',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'remarks',array('id'=>'remarks','class'=>'span8','maxlength'=>50)); ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<div id="payrecFrto_span" class="span2">
					<?php echo $form->labelEx($model,'payrec_frto',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'payrec_frto',array('id'=>'payrecFrto','class'=>'span8','maxlength'=>50)); ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<div class="span5">
					<?php echo $form->labelEx($model,'client_bank_acct',array('class'=>'control-label')) ?>
    			</div>
    			<?php echo $form->textField($model,'client_bank_acct',array('id'=>'clientBankAcct','class'=>'span7','maxlength'=>30)); ?>
    		</div>
    	</div>
    	<div class="span4">
    		<div id="clientBankName_span" class="span4">
    			<?php echo $form->labelEx($model,'client_bank_cd',array('class'=>'control-label')) ?>
    		</div>
    		<?php echo $form->dropDownList($model,'client_bank_cd',CHtml::listData($bankList, 'bank_cd', 'DropDownName'),array('id'=>'clientBankCd','class'=>'span8','prompt'=>'-Choose Bank-')); ?>
    	</div>
    	<div class="span4">
			<?php echo $form->textField($model,'client_bank_name',array('id'=>'clientBankName','class'=>'span12','maxlength'=>50,'placeholder'=>'Fill Bank Name Here')); ?>
		</div>
	</div>
	
	<?php if($model->isNewRecord): ?>
		<div class="text-center" id="retrieve">
			<div>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnRetrieve',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Retrieve Transaction',
					'htmlOptions'=>array('name'=>'submit','value'=>'retrieve') 
				)); ?>
			</div>
			<br/>
		</div>
	<?php else: ?>
		<br/>
	<?php endif; ?> 
	
	<!-- TRANSACTION LIST -->
	
	<?php
		if($retrieved > 0)
		{
			echo $this->renderPartial('/tpayrech/_form_ledger',array('model'=>$model,'modelLedger'=>$modelLedger,'form'=>$form));
		}
	?>
	
	<div class="text-center" id="retrieve2">
		<div>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnRetrieve2',
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Retrieve Journal',
				'htmlOptions'=>array('name'=>'submit','value'=>'retrieve2') 
			)); ?>
		</div>
	</div>
	
	<!-- END TRANSACTION LIST -->
	
	<br/>
	<?php
		$tabs = array(
			array(
	                'label'   => 'Journal',
	                'content' =>  $this->renderPartial($model->isNewRecord?'/tpayrech/_form_detail':'/tpayrech/_form_update_detail',array('model'=>$model,'modelDetail'=>$modelDetail,'cancel_reason'=>isset($cancel_reason)?$cancel_reason:'','form'=>$form),true,false),
	                'active'  => true
	            ),
             array(
	                'label'   => 'Cheque',
	                'content' =>  $this->renderPartial($model->isNewRecord?'/tpayrech/_form_cheq':'/tpayrech/_form_update_cheq',array('model'=>$model,'modelCheq'=>$modelCheq,'cancel_reason_cheq'=>isset($cancel_reason_cheq)?$cancel_reason_cheq:'','form'=>$form),true,false),
	                'active'  => false
	            ),
	    );
	
		$this->widget(
		   'bootstrap.widgets.TbTabs',
		    array(
		        'type' => 'pills', // 'tabs' or 'pills'
		        'tabs' => $tabs,
		        'htmlOptions' => array('id'=>'tabMenu','class'=>'tabMenu'),
		    )
		);
	 ?>
	 
	 <?php
	 	if($retrieved == 2)
	 	{
	 		$tabs = array(
			array(
	                'label'   => 'Journal',
	                'content' =>  $this->renderPartial($model->isNewRecord?'/tpayrech/_form_detail_ledger':($reretrieve_flg?'/tpayrech/_form_detail_ledger':'/tpayrech/_form_update_detail_ledger'),array('model'=>$model,'modelDetailLedger'=>$modelDetailLedger,'cancel_reason'=>isset($cancel_reason)?$cancel_reason:'','form'=>$form),true,false),
	                'active'  => true
	            ),
             array(
	                'label'   => 'Cheque',
	                'content' =>  $this->renderPartial($model->isNewRecord?'/tpayrech/_form_cheq_ledger':'/tpayrech/_form_update_cheq_ledger',array('model'=>$model,'modelCheqLedger'=>$modelCheqLedger,'cancel_reason_cheq'=>isset($cancel_reason_cheq)?$cancel_reason_cheq:'','form'=>$form),true,false),
	                'active'  => false
	            ),
	    );
	
		$this->widget(
		   'bootstrap.widgets.TbTabs',
		    array(
		        'type' => 'pills', // 'tabs' or 'pills'
		        'tabs' => $tabs,
		        'htmlOptions' => array('id'=>'tabMenu2','class'=>'tabMenu'),
		    )
		);
		}
	 ?>

	<div class="form-actions text-center" id="submit" style="margin-left:-150px">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnSubmit',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
			'htmlOptions'=>array('name'=>'submit','value'=>'submit')
		)); ?>
	</div>
	
	<?php if(!$model->isNewRecord): ?>
		<input type="hidden" id="reretrieve_flg" name="reretrieve_flg" value="<?php echo $reretrieve_flg ?>" />
	<?php endif; ?>

<?php $this->endWidget(); ?>

<script>
	var authorizedBackDated = true;
	var retrieved = <?php echo $retrieved ?>; // 0=>Not Retrieved, 1=>Transaction Retrieved, 2=>Transaction and Journal Retrieved
	var newRecord = <?php if($model->isNewRecord)echo 'true';else echo 'false' ?>;
	var result = [];
	var record;
	var recordIndex = 0;
	var init = true;
	var skipFlg = false;

	$(document).ready(function()
	{
		/*if(retrieved || 1) //Will be changed to IF retrieved OR non transaction
		{
			$("#submit").show();
		}
		else
		{
			$("#submit").hide();
		}*/
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateBackDated'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedBackDated = false;
					$("#authorizedBackDated").val(0);
				}
			}
		});
		
		changeType();
				
		getClientDetail();
		initAutoComplete();
		bankRowControl();
		bankRowControlNonTrx();
		
		$("#tableDetail").children('tbody').children('tr:first').children('td.glAcct').children('[type=text]').val($("#glAcctCd").children("option:selected").text());
		
		$("#balDebit_hid").val($("#balDebit").val());
		$("#balCredit_hid").val($("#balCredit").val());
		
		$("#tableCheq").children('tbody').children('tr').each(function()
		{
			$(this).children('td.chqDt').children('[type=text]').datepicker({format:'dd/mm/yyyy'});
		});
		
		$("#tableCheqLedger").children('tbody').children('tr').each(function()
		{
			$(this).children('td.chqDt').children('[type=text]').datepicker({format:'dd/mm/yyyy'});
		});
		
		if($("#rdiPayFlg").is(':checked'))
		{
			setRDIBankAccount();
		}
		
		$("#folderCd").val("<?php echo $model->folder_cd ?>").change(); // To preserve user inputted folder_cd after it's changed by function setRDIBankAccount();
		
		if(!newRecord)
		{
			$("#tableDetail<?php if(substr($model->payrec_num,5,1) =='V')echo'Ledger' ?>").children('tbody').children('tr').each(function()
			{
				<?php if(!(isset($reretrieve_flg) && $reretrieve_flg)): ?>
					rowControl($(this).children('td.edit').children('[type=checkbox]'));
				<?php endif; ?>
			});
			
			$("#tableCheq<?php if(substr($model->payrec_num,5,1) =='V')echo'Ledger' ?>").children('tbody').children('tr').each(function()
			{
				rowControlCheq($(this).children('td.edit').children('[type=checkbox]'));
			});
			
			<?php if(substr($model->payrec_num,5,1) =='V'): ?>
				<?php if($retrieved == 2): ?>
					<?php if(!(isset($reretrieve_flg) && $reretrieve_flg)): ?>
						cancel_reason_detail_ledger();
					<?php endif; ?>
				
					cancel_reason_cheq_ledger();
				<?php endif; ?>
				
			<?php else: ?>
				cancel_reason();
				cancel_reason_cheq();
			<?php endif; ?>
			
			$("#glAcctCd").children("option:not(:selected)").prop('disabled',true).css({'cursor':'not-allowed'});
		}
		
		init = false;
	});
	
	$(window).resize(function()
	{
		$("#remarks_span").css('width',$("#clientCd_span").width()+'px');
		$("#payrecFrto_span").css('width',$("#folderCd_span").width()+'px');
		$("#type_span").css('width',$("#folderCd_span").width()+'px');
		//$("#clientBankName_span").css('width',$("#folderCd_span").width()+'px');
		
		var body = $("#tableLedger").find('tbody');
		
		if(body.length)
		{
			if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
			{
				$('thead').css('width', '100%').css('width', '-=17px');	
			}
			else
			{
				$('thead').css('width', '100%');	
			}
			
			alignColumnLedger();
		}
	});
	$(window).trigger('resize');
	
	$("#rdiPayFlg").click(function()
	{
	<?php if($model->isNewRecord): ?>
		setRDIBankAccount();
	<?php endif; ?>
	});
	
	$("#remarks, td.remarks [type=text], td.slAcct [type=text]").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
	$("#payrecDate").change(function()
	{
		if(retrieved > 0)
		{
			var vchDate = $(this).val();
			var vchDateNum = vchDate.substr(6,4)+vchDate.substr(3,2)+vchDate.substr(0,2);
			
			$("#tableLedger").children('tbody').children('tr').each(function()
			{
				var dueDate = $(this).children('td.dueDate').children('[type=text]').val();
				var dueDateNum = dueDate.substr(6,4)+dueDate.substr(3,2)+dueDate.substr(0,2);
				
				if(vchDateNum < dueDateNum)
				{
					$(this).children('td.check').children('[type=checkbox]').prop('checked',false);
					$(this).children('td.buySettAmt').children('[type=text]').val(0).prop('readonly',true).blur();
					$(this).children('td.sellSettAmt').children('[type=text]').val(0).prop('readonly',true).blur();
				}
			});
			
			setTotal();
		}
		
		$("#tableCheq").children('tbody').find('tr').each(function()
		{
			$(this).children('td.chqDt').children('[type=text]').val($("#payrecDate").val()).datepicker('update');
			$(this).children('td.edit').children('[type=checkbox]').prop('checked',true).change();
		});
		
		$("#tableCheqLedger").children('tbody').find('tr').each(function()
		{
			$(this).children('td.chqDt').children('[type=text]').val($("#payrecDate").val()).datepicker('update');
			$(this).children('td.edit').children('[type=checkbox]').prop('checked',true).change();
		});
	});

	$("#clientCd").change(function()
	{
		$(this).val($(this).val().toUpperCase());
		getClientDetail();
		
		if($("#type").val() == 'D' && $("#clientCd").val() /*&& $("#Tpayrecd_2_gl_acct_cd").val() == "" && $("#Tpayrecd_2_sl_acct_cd").val() == ""*/)
		{
			if($("#Tpayrecd_2_gl_acct_cd").val() == "")
			{
				$("#Tpayrecd_2_gl_acct_cd").val($("#clientCd").val().substr(7,1)=='M'?'<?php echo trim($glAcctType[0]['gl_a']) ?>':<?php echo trim($glAcctType[1]['gl_a']) ?>).change();
			}
			
			$("#Tpayrecd_2_sl_acct_cd").val($("#clientCd").val());
		}
		
		if($("#bankCd").val())
		{
			if($("#Tpayrech_payrec_type_1").is(':checked'))$("#rdiPayFlg").prop('checked',true); 
			setRDIBankAccount(); // this includes updateCheqTransferFee();
		}
		else
			updateCheqTransferFee();
	});
	//$("#clientCd").trigger('change');
	
	$("#glAcctCd").change(function()
	{
		getBankAccount();
		
		var glText = $(this).children('option:selected').text();
		
		$("#tableDetail").children('tbody').children('tr:first').children('td.glAcct').children('[type=text]').val(glText);
		
		if(!newRecord)
		{
			$("#tableDetail").children('tbody').children('tr:first').children('td.edit').children('[type=checkbox]').prop('checked',true).change();
		}
		
		if(retrieved == 2)
		{
			$("#tableDetailLedger").children('tbody').children('tr.bankRow').children('td.glAcct').children('[type=text]').val($(this).val());
			bankRowControl();
		}
		else if($("#type").val() == 'D')
		{
			bankRowControlNonTrx();
		}
		
		if($(this).val() == 'NA')
		{
			$("#rdiPayFlg").prop('checked',false);		
			//updateCheqTransferFee();
		}
		
		$("#slAcctCd").change();
	});
	//$("#glAcctCd").change();
	
	$("#slAcctCd").change(function()
	{
		getFolderPrefix();
		
		var slValue = $(this).val();
		var acctName = $(this).children('option:selected').attr('id');
		
		$("#tableDetail").children('tbody').children('tr:first').children('td.slAcct').children('[type=text]').val(slValue);
		$("#acctName").val(acctName);
		
		if(!newRecord)
		{
			$("#tableDetail").children('tbody').children('tr:first').children('td.edit').children('[type=checkbox]').prop('checked',true).change();
		}
		
		if(retrieved == 2)
		{
			$("#tableDetailLedger").children('tbody').children('tr.bankRow').children('td.slAcct').children('[type=text]').val($(this).val());
		}
		
		updateCheqTransferFee();
	});
	
	$("#currAmt").change(function()
	{
		var amtValue = setting.func.number.addCommasDec($(this).val());
		
		$("#tableDetail").children('tbody').children('tr:first').children('td.amt').children('[type=text]').val(amtValue);
		
		if(cheqCount == 1)
		{
			$("#tableCheq").children('tbody').children('tr:first').children('td.chqAmt').children('[type=text]').val(amtValue).change().blur();
			$("#tableCheq").children('tbody').children('tr:first').children('td.edit').children('[type=checkbox]').prop('checked',true).change();
		}
		
		if(!newRecord)
		{
			$("#tableDetail").children('tbody').children('tr:first').children('td.edit').children('[type=checkbox]').prop('checked',true).change();
		}
	});
	
	$("#remarks").change(function()
	{
		var remarksValue = $(this).val();
		
		$("#tableDetail").children('tbody').find('tr').each(function()
		{
			$(this).children('td.remarks').children('[type=text]').val(remarksValue);
			$(this).children('td.edit').children('[type=checkbox]').prop('checked',true).change();
		});
		
		$("#tableDetailLedger").children('tbody').find('tr').each(function()
		{
			$(this).children('td.remarks').children('[type=text]').val(remarksValue);
			$(this).children('td.edit').children('[type=checkbox]').prop('checked',true).change();
		});
	});
	
	$("#folderCd").change(function()
	{
		$(this).val($(this).val().toUpperCase());
		
		if($("#rdiPayFlg").is(":checked"))
		{
			$("#tableCheq").find('tbody').children('tr:first').children('td.chqNum').children('[type=text]').val($(this).val());
			
			if(retrieved == 2)
			{
				$("#tableCheqLedger").find('tbody').children('tr:first').children('td.chqNum').children('[type=text]').val($(this).val());
			}
		}
	});
	
	$("#clientBankAcct").change(function()
	{
		//if($("#clientCd").val())
		//{
			findBankCd();		
		//}
	})
	//$("#clientBankAcct").trigger('change');
	
	$("#clientBankCd").change(function()
	{
		fillClientBankName('');
		
		updateCheqTransferFee();
	});
	
	$("#btnRetrieve2").click(function()
	{
		if($("#clientCd").val() != $("#client_hid").val())
			$("#clientCd").val($("#client_hid").val()).change();
			
		$("#ledgerCount").val(ledgerCount);
	});
	
	$("#btnSubmit").click(function(e)
	{
		var type = $("#type").val();
		var checkResult = {};
		var x = 0;
		var y = 0;
		
		record = [];
		
		if(!skipFlg)
		{
			if(type == 'D')
			{
				if(!checkBalance())
				{
					alert("Amount is not balanced");
					return false;
				}
				
				$("#detailCount").val(detailCount);
				$("#cheqCount").val(cheqCount);
				
				if($("#rdiPayFlg").is(':checked'))
				{
					if(cheqCount == 0)
					{
						alert('Payment via RDI require a cheque');
						return false;
					}
					
					if($("#Tpayrech_payrec_type_0").is(':checked') || $("#payrecType").val() == 'RECEIPT')
					{
						alert('Payment via RDI must only be used for payment');
						return false;
					}
				}
				
				if('<?php echo $check ?>' == 'N')
				{
					if(($("#Tpayrech_payrec_type_0").is(':checked') || $("#payrecType").val() == 'RECEIPT') && cheqCount > 0)
					{
						alert('Cheque is only used for payment');
						return false;
					}
				}
				
				if($("#Tpayrech_payrec_type_1").is(':checked') && cheqCount == 0)
				{
					if(!confirm("No Cheque. Do you want to continue?"))return false;
				}
				
				if(cheqCount > 0)
				{
					var amt = setting.func.number.removeCommas($("#currAmt").val()) * 100;
					var cheqTotalAmt = 0;
					
					$("#tableCheq").children('tbody').children('tr').each(function()
					{	
						if(newRecord || ( !$(this).hasClass('markCancel') && ($(this).children('td.edit').children('[type=checkbox]').is(':checked') || $(this).children('[type=hidden].rowid').val())))
						{
							//If UPDATE, exclude cancelled row AND 'not checked' new record				
							cheqTotalAmt += setting.func.number.removeCommas($(this).children('td.chqAmt').children('[type=text]').val()) * 100;
						}
					});
					
					if(amt != cheqTotalAmt)
					{
						alert("Cheque total amount must be equal with voucher amount");
						return false;
					}
				}
				
				//if($("#Tpayrech_payrec_type_1").is(':checked') || $("#payrecType").val() == 'PAYMENT')
				//{	
				if(newRecord)
				{
					$("#tableDetail").children('tbody').children('tr:gt(0)').each(function()
					{
						var client = $(this).children('td.slAcct').children('[type=text]').val();
						var amt = parseFloat(setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()));
						
						if(client.length == 8 && amt > 0)
						{
							record[x] = [];
							record[x]['client'] = client;
							record[x]['dbcr'] = $(this).children('td.dbcr').children(':first').val().substr(0,1);
							record[x]['amt'] = record[x]['dbcr'] == 'D' ? amt : -1 * amt;
							
							if(x > 0)
							{
								//GROUPING PER CLIENT
								y = 1;
								
								$.each(record,function()
								{
									if(record[x]['client'] == this.client)
									{
										this.amt += (record[x]['amt']);
										record.splice(x,1);
										return false;
									}
									
									y++;
									
									if(y == record.length) //To Prevent Comparing With Itself
									{
										x++;
										return false;
									}
								});
							}
							else
								x++;
						}
					});

					recordIndex = 0;
					
					while(recordIndex < record.length)
					{
						checkResult['valid'] = true;
						
						if(record[recordIndex]['amt'] > 0)
						{
							checkResult = checkCash(record[recordIndex]['client'], record[recordIndex]['amt']);
							
							if(!checkResult['valid'])
							{
								if(checkResult['block'])
								{
									alert(record[recordIndex]['client']+', '+checkResult['message']);
								}
								else
								{
									cashReason(record[recordIndex]['client']+', '+checkResult['message']);
								}
							}
						}
						
						recordIndex++;
						
						if(!checkResult['valid'])return false;
					}
				}
				//}
			}
			else
			{
				if(retrieved > 0)
				{
					if($("#clientCd").val() != $("#client_hid").val())
						$("#clientCd").val($("#client_hid").val()).change();
						
					/*if($("#glAcctCd").val() != $("#glAcctCd_hid").val())
						$("#glAcctCd").val($("#glAcctCd_hid").val()).change();
						
					if($("#slAcctCd").val() != $("#slAcctCd_hid").val())
						$("#slAcctCd").val($("#slAcctCd_hid").val()).change();*/
						
					if($("#payrecDate").val() != $("#payrecDate_hid").val())
						$("#payrecDate").val($("#payrecDate_hid").val()).datepicker('update').change();
						
					$("#tableLedger").children('tbody').children('tr').each(function()
					{
						if($(this).children('td.check').children('#check_hid').val() == 'Y')
						{
							$(this).children('td.check').children('[type=checkbox]').prop('checked',true).change();
						}
						else
						{
							$(this).children('td.check').children('[type=checkbox]').prop('checked',false).change();
						}
						
						var dbcr = $(this).children('td.buySellInd').children('[type=text]').val()
						if(dbcr == 'C' || dbcr == 'J')
							$(this).children('td.buySettAmt').children('[type=text]').val($(this).children('td.buySettAmt').children('#buySettAmt_hid').val()).blur().change();
						else
							$(this).children('td.sellSettAmt').children('[type=text]').val($(this).children('td.sellSettAmt').children('#sellSettAmt_hid').val()).blur().change();
					});
						
					$("#ledgerCount").val(ledgerCount);
					$("#detailLedgerCount").val(detailLedgerCount);
					$("#cheqLedgerCount").val(cheqLedgerCount);
				}
				
				if($("#rdiPayFlg").is(':checked'))
				{
					if(cheqLedgerCount == 0)
					{
						alert('Payment via RDI require a cheque');
						return false;
					}
					
					if($("#tableDetailLedger").children('tbody').children('tr.bankRow').children('td.dbcr').children('[type=text]').val() == 'DEBIT')
					{
						alert('Payment via RDI must only be used for payment');
						return false;
					}
				}
				
				if('<?php echo $check ?>' == 'N')
				{
					if($("#tableDetailLedger").children('tbody').children('tr.bankRow').children('td.dbcr').children('[type=text]').val() == 'DEBIT' && cheqLedgerCount > 0)
					{
						alert('Cheque is only used for payment');
						return false;
					}
				}
				
				var bankAmt = setting.func.number.removeCommas($("#tableDetailLedger").children('tbody').children('tr.bankRow').children('.amt').children('[type=text]').val());
				
				if($("#glAcctCd").val() != 'NA')
				{
					if(bankAmt == 0)
					{
						if(!confirm("Bank Amount is 0. Do you want to continue?"))return false;
					}
					else if(bankAmt != parseInt(bankAmt))
					{
						if(!confirm("Bank Amount is not a whole number. Do you want to continue?"))return false;
					}
				}
				else
				{
					if(!confirm("No Bank Entry. Do you want to continue?"))return false;
					
					if(!checkBalanceTrx())
					{
						alert("Amount is not balanced");
						return false;
					}
					
					var bankRow = $("#tableDetailLedger").children('tbody').children('tr.bankRow');
					
					bankRow.show();
					bankRow.css('visibility','hidden').children('td').css('visibility','hidden');
				}
				
				if($("#tableDetailLedger").children('tbody').children('tr.bankRow').children('td.dbcr').children('[type=text]').val() == 'CREDIT' && cheqLedgerCount == 0)
				{
					if(!confirm("No Cheque. Do you want to continue?"))return false;
				}
				
				if(cheqLedgerCount > 0)
				{
					var bankRow = $("#tableDetailLedger").children('tbody').children('tr.bankRow');
					var amt = setting.func.number.removeCommas(bankRow.children('td.amt').children('[type=text]').val()) * 100;
					var cheqTotalAmt = 0;
					
					$("#tableCheqLedger").children('tbody').children('tr').each(function()
					{	
						if(newRecord || ( !$(this).hasClass('markCancel') && ($(this).children('td.edit').children('[type=checkbox]').is(':checked') || $(this).children('[type=hidden].rowid').val())))
						{
							//If UPDATE, exclude cancelled row AND 'not checked' new record								
							cheqTotalAmt += setting.func.number.removeCommas($(this).children('td.chqAmt').children('[type=text]').val()) * 100;
						}
					});
					
					if(amt != cheqTotalAmt)
					{
						alert("Cheque total amount must be equal with voucher amount");
						return false;
					}
				}
			
				if(newRecord)
				{
					$("#tableDetailLedger").children('tbody').children('tr').each(function()
					{
						var client = $(this).children('td.slAcct').children('[type=text]').val();
						var amt = parseFloat(setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()));
						
						if(client.length == 8 && amt > 0)
						{
							record[x] = [];
							record[x]['client'] = client;
							record[x]['dbcr'] = $(this).children('td.dbcr').children(':first').val().substr(0,1);
							record[x]['amt'] = record[x]['dbcr'] == 'D' ? amt : -1 * amt;
							
							if(x > 0)
							{
								//GROUPING PER CLIENT
								y = 1;
								
								$.each(record,function()
								{
									if(record[x]['client'] == this.client)
									{
										this.amt += (record[x]['amt']);
										record.splice(x,1);
										return false;
									}
									
									y++;
									
									if(y == record.length) //To Prevent Comparing With Itself
									{
										x++;
										return false;
									}
								});
							}
							else
								x++;
						}
					});
		
					recordIndex = 0;
					
					while(recordIndex < record.length)
					{
						checkResult['valid'] = true;
						
						if(record[recordIndex]['amt'] > 0)
						{
							checkResult = checkCash(record[recordIndex]['client'], record[recordIndex]['amt']);
							
							if(!checkResult['valid'])
							{
								if(checkResult['block'])
								{
									alert(record[recordIndex]['client']+', '+checkResult['message']);
								}
								else
								{
									cashReason(record[recordIndex]['client']+', '+checkResult['message']);
								}
							}
						}
						
						recordIndex++;
						
						if(!checkResult['valid'])return false;
					}
				}
			}
		}
	});
	
	function checkCash(client, amt)
	{
		var data = {};
		var valid = false;
		var block = true;
		var ratio = 0;
		var message = '';
		
		$("#showloading").show();
		
		$.ajax({
    		'type'     : 'POST',
    		'url'      : '<?php echo $this->createUrl('ajxCheckCash'); ?>',
			'dataType' : 'json',
			'data'     : {
							'client' : client,
							'amt' : amt
						},
			'async'	   : false,
			'success'  : function(data){
				valid = data.valid;
				block = data.block;
				ratio = data.ratio;
				message = data.message;
			}
		});
		
		$("#showloading").hide();
		
		return {'valid' : valid, 'block' : block, 'ratio' : ratio, 'message' : message};
	}
	
	function cashReason(message)
	{
		var html = 	'<div style="margin-left:30px;margin-right:30px">';
			html += 	'<h5>Reason: </h5>';
			html += 	'<textarea id="popCashReason" class="span12" rows=5></textarea>';
			html += '</div>';
			
			html += '<br/>';
			
			html += '<div class="text-center">';
			html += 	'<button id="btnYes" class="btn btn-primary" onClick="cashReasonRespond(true)"> Yes </button>';
			html += 	'&emsp;';
			html += 	'<button id="btnNo" class="btn btn-primary" onClick="cashReasonRespond(false)"> No </button>';
			html += '</div>';
			
			html += '<br/>';
		
		$('.modal-header h4').html(message + ". Continue?");
		$('.modal-body').html(html);
		$('#modal-popup').modal('show');
	}
	
	function cashReasonRespond(continueFlg)
	{	
		if(continueFlg)
		{
			if($("#popCashReason").val() == '')
			{
				alert('Reason must be filled');
				return false;
			}
			else
			{
				var obj = $("#type").val()=='D'?$("#tableDetail"):$("#tableDetailLedger");
				
				obj.children('tbody').children('tr').each(function()
				{
					if($(this).children('td.slAcct').children('[type=text]').val() == record[recordIndex-1]['client'])
					{
						$(this).children('input.amount').val(record[recordIndex-1]['amt']);
						$(this).children('input.reason').val($("#popCashReason").val());
						return false;
					}	
				});
								
				$('#modal-popup').on('hidden.bs.modal',function() //Wait until the modal is completely hidden from view before continuing
				{
					$('#modal-popup').off('hidden.bs.modal');
					
					while(recordIndex < record.length)
					{
						var checkResult = {};
						checkResult['valid'] = true;
						
						if(record[recordIndex]['amt'] > 0)
						{
							checkResult = checkCash(record[recordIndex]['client'], record[recordIndex]['amt']);
							
							if(!checkResult['valid'])
							{
								if(checkResult['block'])
								{
									alert(record[recordIndex]['client']+', '+checkResult['message']);
								}
								else
								{
									cashReason(record[recordIndex]['client']+', '+checkResult['message']);
								}
							}
						}
						
						recordIndex++;
						
						if(!checkResult['valid'])return false;
					}
					
					skipFlg = true;
					$("#btnSubmit").click();
				});
				
				$('#modal-popup').modal('hide');
			}
		}
		else
		{
			$('#modal-popup').modal('hide');
		}
	}
	
	function initAutoComplete()
	{
		$("#clientCd").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getClient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				           				 result = data;
				    				}
				});
		    },
		    /*change: function(event,ui)
	        {
	        	$(this).val($(this).val().toUpperCase());
	        	
	        	if (ui.item==null)
	            {
	            	// Only accept value that matches the items in the autocomplete list
	            	
	            	var inputVal = $(this).val();
	            	var match = false;
	            	
	            	$.each(result,function()
	            	{
	            		if(this.value.toUpperCase() == inputVal)
	            		{
	            			match = true;
	            			return false;
	            		}
	            	});
	            	
		            if(!match)
		            {
		            	alert("Client code doesn't exist");
		            	$(this).val('');
		            }
		            
		            //$(this).focus();
	            }
	        },*/
		    minLength: 1,
		    open: function() { 
		        $(this).autocomplete("widget").width(400); 
		    } 
		});
		
		$("#clientBankAcct").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getBankAcctNum'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						'client_cd' : $("#clientCd").val()
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				    				}
				});
		   },
		   change: function(event,ui)
	       {
	           findBankCd();
	       },
		   minLength: 0
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });;
		
		$("#tableDetail").children('tbody').children('tr:not(:first)').each(function()
		{
			var glAcctCd = $(this).children('td.glAcct').children('select').val();
			
			$(this).children('td.slAcct').children('[type=text]').autocomplete(
			{
				source: function (request, response) 
				{
			        $.ajax({
			        	'type'		: 'POST',
			        	'url'		: '<?php echo $this->createUrl('getSlAcct'); ?>',
			        	'dataType' 	: 'json',
			        	'data'		:	{
			        						'term': request.term,
			        						'gl_acct_cd' : glAcctCd
			        					},
			        	'success'	: 	function (data) 
			        					{
					           				 response(data);
					           				 result = data;
					    				}
					});
			    },
			    /*change: function(event,ui)
		        {
		        	$(this).val($(this).val().toUpperCase());
		        	
		        	if (ui.item==null)
		            {
		            	// Only accept value that matches the items in the autocomplete list
		            	
		            	var inputVal = $(this).val();
		            	var match = false;
		            	
		            	$.each(result,function()
		            	{
		            		if(this.value.toUpperCase() == inputVal)
		            		{
		            			match = true;
		            			return false;
		            		}
		            	});
		            	
			            if(!match)
			            {
			            	alert("SL Account not found in chart of accounts");
			            	$(this).val('');
			            }
			            
			            //$(this).focus();
		            }
		        },*/
			    minLength: 1,
			    open: function() { 
			        $(this).autocomplete("widget").width(400); 
			    } 
			});
		});
		
		$("#tableDetailLedger").children('tbody').children('tr:not(:first)').each(function()
		{
			var glAcctCd = $(this).children('td.glAcct').children('select').val();
			
			$(this).children('td.slAcct').children('[type=text]').autocomplete(
			{
				source: function (request, response) 
				{
			        $.ajax({
			        	'type'		: 'POST',
			        	'url'		: '<?php echo $this->createUrl('getSlAcct'); ?>',
			        	'dataType' 	: 'json',
			        	'data'		:	{
			        						'term': request.term,
			        						'gl_acct_cd' : glAcctCd
			        					},
			        	'success'	: 	function (data) 
			        					{
					           				 response(data);
					           				 result = data;
					    				}
					});
			    },
			    /*change: function(event,ui)
		        {
		           	$(this).val($(this).val().toUpperCase());
	        	
		        	if (ui.item==null)
		            {
		            	// Only accept value that matches the items in the autocomplete list
		            	
		            	var inputVal = $(this).val();
		            	var match = false;
		            	
		            	$.each(result,function()
		            	{
		            		if(this.value.toUpperCase() == inputVal)
		            		{
		            			match = true;
		            			return false;
		            		}
		            	});
		            	
			            if(!match)
			            {
			            	alert("SL Account not found in chart of accounts");
			            	$(this).val('');
			            }
			            
			            //$(this).focus();
		            }
		        },*/
			    minLength: 1,
			    open: function() { 
			        $(this).autocomplete("widget").width(400); 
			    } 
			});
		});
	}
	
	function changeType()
	{
		var type = $("#type").val();
		
		if(type == 'V') //Transaction
		{
			$("#payrecType_div").hide();
			$("#currAmt_div").hide();
			$("#tabMenu").hide();
			$("#trfKsei_div").hide();
			$("#retrieve").show(); 
			$("#tableLedger").show();
			$("#intAdjust_div").show();

			if(retrieved > 0)
			{
				$("#retrieve2").show();
				setTotal();
			}
			else
				$("#retrieve2").hide();
				
			$("#tabMenu2").show();
			
			if(retrieved != 2)$("#submit").hide();
			else
			{
				$("#submit").show();
				
				$("#tableDetailLedger").children('tbody').children('tr').each(function()
				{
					var dbcr = $(this).children('td.dbcr').children('[type=text]').val();
					
					if(dbcr)
					{
						if(dbcr == 'D')$(this).children('td.dbcr').children('[type=text]').val('DEBIT');
						else if(dbcr == 'C')
							$(this).children('td.dbcr').children('[type=text]').val('CREDIT');
					}
				});
			}
					
			$("#tableDetail").children('tbody').children('tr:not(:first)').each(function()
			{
				$(this).children('td.dbcr').children('select').removeAttr('required');
			});
		}
		else //Non Transaction
		{
			$("#payrecType_div").show();
			$("#currAmt_div").show();
			$("#tabMenu").show();
			$("#retrieve").hide();
			$("#tableLedger").hide();
			$("#retrieve2").hide();
			$("#tabMenu2").hide();
			$("#intAdjust_div").hide();
			$("#submit").show();
			
			$("#tableDetail").children('tbody').children('tr:not(:first)').each(function()
			{
				$(this).children('td.dbcr').children('select').attr('required','required');
			});
		}
		
		changeLabel();
		
		$("#glAcctCd").empty();
		
		if($("#type").val()=='D')
		{	
			$("#glAcctCd")				
			<?php	
				$x=0;
				foreach($bankAccNonTrx as $row)
				{				
			?>	
				.append($("<option>").val('<?php echo $row->dstr1 ?>').html('<?php echo $row->dstr1 ?>'))		
			<?php		
					$x++;
				} 
			?>
		}
		else
		{
			$("#glAcctCd")				
			<?php	
				$x=0;
				foreach($bankAccTrx as $row)
				{						
			?>	
				.append($("<option>").val('<?php echo $row->dstr1 ?>').html('<?php echo $row->dstr1 ?>'))		
			<?php		
					$x++;
				} 
			?>
		}
		
		$("#glAcctCd").val("<?php echo $model->gl_acct_cd ?>");	
		
		//setRDIBankAccount();
	}
	
	function setRDIBankAccount()
	{
		var rdiBankGl;
		var rdiBankSl;
		var rdiAcctName;
		
		switch($("#bankCd").val())
		{
		<?php foreach($rdiBank as $row){ ?>
			case '<?php echo $row['fund_bank_cd'] ?>':
				if($("#branchCode").val() == '<?php echo trim($row['brch_cd']) ?>' || '%' == '<?php echo trim($row['brch_cd']) ?>')
				{
					rdiBankGl = '<?php echo $row['gl_a'] ?>';
					rdiBankSl = '<?php echo $row['sl_a'] ?>';
					break;
				}
		<?php } ?>
		}
		
		if($("#rdiPayFlg").is(':checked') || (!newRecord && $("#rdiPayFlg").val() == 'Y'))
		{
			<?php if($rdiBank): ?>
			
			//$("#glAcctCd").empty();
			//$("#glAcctCd").append($("<option>").val('<?php //echo $rdiBank->dstr1 ?>').html('<?php //echo $rdiBank->dstr1 ?>'));
			
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ajxGetRdiAcctName'); ?>',
				'dataType' : 'json',
				'data'     : {
								'glAcctCd':rdiBankGl,
								'slAcctCd':rdiBankSl
						},
				'async'	   : false,
				'success'  : function(data){
					rdiAcctName = data['acct_name'];
				}
			});
			
			$("#glAcctCd").val(rdiBankGl);
			var glText = $("#glAcctCd").children('option:selected').text();
		
			$("#tableDetail").children('tbody').children('tr:first').children('td.glAcct').children('[type=text]').val(glText);
		
			if(!newRecord)
			{
				$("#tableDetail").children('tbody').children('tr:first').children('td.edit').children('[type=checkbox]').prop('checked',true).change();
			}
			
			if(retrieved == 2)
			{
				$("#tableDetailLedger").children('tbody').children('tr.bankRow').children('td.glAcct').children('[type=text]').val($("#glAcctCd").val());
				bankRowControl();
			}
			else if($("#type").val() == 'D')
			{
				bankRowControlNonTrx();
			}
						
			$("#slAcctCd").empty();
			$("#slAcctCd").append($("<option>").val(rdiBankSl).html(rdiBankSl).attr('id',rdiAcctName));
			
			$("#slAcctCd").change();
			
			<?php endif; ?>
			
			if($("#type").val() == 'D')
			{
				if(cheqCount == 0)
				{
					addRowCheq();
					
					var chqFirstRow = $("#tableCheq").find('tbody').children('tr:first');
					
					chqFirstRow.children('td.type').children('select').val('RD');
					chqFirstRow.children('td.chqNum').children('[type=text]').val($("#folderCd").val());
					chqFirstRow.children('td.chqDt').children('[type=text]').val($("#payrecDate").val()).datepicker('update');
				}
			}
			else if(retrieved == 2)
			{
				if(cheqLedgerCount == 0)
				{
					addRowCheqLedger();
					
					var chqFirstRow = $("#tableCheqLedger").find('tbody').children('tr:first');
					
					chqFirstRow.children('td.type').children('select').val('RD');
					chqFirstRow.children('td.chqNum').children('[type=text]').val($("#folderCd").val());
					chqFirstRow.children('td.chqDt').children('[type=text]').val($("#payrecDate").val()).datepicker('update');
				}
			}
		}
		else
		{
			/*$("#glAcctCd").empty();
			
			if($("#type").val()=='D')
			{	
				$("#glAcctCd")				
				<?php	
					/*$x=0;
					foreach($bankAccNonTrx as $row)
					{			*/			
				?>	
					.append($("<option>").val('<?php //echo $row->dstr1 ?>').html('<?php //echo $row->dstr1 ?>'))		
				<?php		
			/*			$x++;
					} */
				?>
			}
			else
			{
				$("#glAcctCd")				
				<?php	
				/*	$x=0;
					foreach($bankAccTrx as $row)
					{		*/				
				?>	
					.append($("<option>").val('<?php //echo $row->dstr1 ?>').html('<?php //echo $row->dstr1 ?>'))		
				<?php		
			/*			$x++;
					} */
				?>
			}*/
			
			//$("#glAcctCd").val("<?php //echo $model->gl_acct_cd ?>");	
			
			//getBankAccount();
			
			$("#glAcctCd").change();
		}
		
		//updateCheqTransferFee();
	}
	
	function getClientDetail()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetClientDetail'); ?>',
			'dataType' : 'json',
			'data'     : {
							'client':$("#clientCd").val(),
					},
			'async'	   : false,
			'success'  : function(data){
				$("#clientName").val(data['client_name']);
				$("#clientType").val(data['client_type']);
				$("#clientType3").val(data['cl_desc']);
				$("#branchCode").val(data['branch_code']);
				$("#recovChargeFlg").val(data['recov_charge_flg']);
				$("#olt").val(data['olt']);
				$("#bankCd").val(data['bank_cd']);
				$("#bankAcctFmt").val(data['bank_acct_fmt']);
				$("#active").val(data['active']);
				$("#payrecFrto").val(data['acct_name']?data['acct_name']:data['cif_name']);
				$("#clientBankName").val(data['client_bank']);
				$("#clientBankAcct").val(data['bank_acct_num']);
				
				if(data['client_name'])
				{
					$("#payrecFrto").prop('readonly',true);
					//$("#clientBankName").prop('readonly',true);
					//$("#clientBankAcct").prop('readonly',true);
				}
				else
				{
					$("#payrecFrto").prop('readonly',false);
					//$("#clientBankName").prop('readonly',false);
					//$("#clientBankAcct").prop('readonly',false);
				}
				
				getBankAccount();
				findBankCd();
			}
		});
	}
	
	function getBankAccount()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetBankAccount'); ?>',
			'dataType' : 'json',
			'data'     : {
							'glAcctCd':$("#glAcctCd").val(),
							'branchCode':$("#clientCd").val()?$("#branchCode").val():'%'
					},
			'async'	   : false,
			'success'  : function(data){
				var txtCmb  = '<option value="">-Choose-</option>';
				
				$.each(data, function() {
				    txtCmb  += '<option value="'+this['sl_a']+'" id="'+this['acct_name']+'" name="'+this['brch_cd']+'">'+this['sl_a']+'&emsp;&emsp;&emsp;'+this['acct_name']+'</option>';
				    
				    /*if(this['brch_cd'] && this['brch_cd'] == $("#branchCode").val())
				    {
				    	 txtCmb  += 'selected';
				    	 alert(this['sl_a']);
				    }
				    	
				    txtCmb += '>'+this['sl_a']+'&emsp;&emsp;&emsp;'+this['acct_name']+'</option>';*/
				});
				
				$('#slAcctCd').html(txtCmb);
				
				if('<?php echo $model->sl_acct_cd ?>' == '' && $("#branchCode").val())
				{
					$('#slAcctCd').children('option').each(function()
					{
						if($(this).attr('name') == $("#branchCode").val())
						{
							$('#slAcctCd').val($(this).val());
							return false;
						}
					});
				}
				else
					$("#slAcctCd").val('<?php echo $model->sl_acct_cd ?>');
				
				$("#tableDetail").children('tbody').children('tr:first').children('td.slAcct').children('[type=text]').val($("#slAcctCd").val());
				$("#acctName").val($("#slAcctCd").children('option:selected').attr('id'));
			}
		});
	}
	
	function getFolderPrefix()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetFolderPrefix'); ?>',
			'dataType' : 'json',
			'data'     : {
							'glAcctCd':$("#glAcctCd").val(),
							'slAcctCd':$("#slAcctCd").val(),
					},
			'async'	   : false,
			'success'  : function(data){				
				if(data['folder_prefix'])
				{
					if($("#type").val() == 'D')
					{					
						if($("#Tpayrech_payrec_type_0").is(':checked'))
						{
							if(data['folder_prefix'] != null)data['folder_prefix'] += 'R';
						}
						else
						{
							if(data['folder_prefix'] != null)data['folder_prefix'] += 'P';
						}
					}
					
					if($("#folderCd").val().length <= data['folder_prefix'].length)
					{
						$("#folderCd").val(data['folder_prefix']);
					}
					else
					{
						$("#folderCd").val(data['folder_prefix'] + $("#folderCd").val().substr(data['folder_prefix'].length));
					}
				}
			}
		});
	}
	
	function findBankCd()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxFindBankCd'); ?>',
			'dataType' : 'json',
			'data'     : {
							'clientCd':$("#clientCd").val(),
							'bankAcctNum':$("#clientBankAcct").val(),
					},
			'async'	   : false,
			'success'  : function(data){
				if(data)
				{
					var branch = data['bank_branch'] ? ' ' + data['bank_branch'] : '';
					
					$("#clientBankCd").val(data['bank_cd']);
					$('#payrecFrto').val(data['acct_name']);
					$("#clientBankCd").children('option:not(:selected)').prop('disabled',true);
					$("#clientBankCd").children('option:selected').prop('disabled',false);
					//$("#clientBankCd").change();
					fillClientBankName(branch);
					updateCheqTransferFee();
				}
				else
				{
					$("#clientBankCd").children('option').prop('disabled',false);
				}
			}
		});
	}
	
	function fillClientBankName(branch)
	{
		if($("#clientBankCd").val())
		{
			var bankName = $("#clientBankCd").children('option:selected').text().substr(6);
			
			$("#clientBankName").val(bankName+branch);
		}
	}
	
	function changeLabel()
	{
		var x = 0;
		
		if($("#type").val() == 'D')
		{
			if($("#Tpayrech_payrec_type_0").is(':checked') || $("#payrecType").val() == 'RECEIPT') //RECEIPT
			{
				$("#clientLabel").html("Received From");
				
				/*$("#tableDetail").children('tbody').children('tr').each(function()
				{
					if(x == 0)$(this).children('td.dbcr').children('[type=text]').val('DEBIT');
					else
						$(this).children('td.dbcr').children('select').val('C');
					x++;
				});*/
				
				$("#tableDetail").children('tbody').children('tr:first').children('td.dbcr').children('[type=text]').val('DEBIT');
				
				$("#trfKsei_div").show();
			}
			else //PAYMENT
			{
				$("#clientLabel").html("Paid To");
				
				/*$("#tableDetail").children('tbody').children('tr').each(function()
				{
					if(x == 0)$(this).children('td.dbcr').children('[type=text]').val('CREDIT');
					else
						$(this).children('td.dbcr').children('select').val('D');
					x++;
				});*/
				
				$("#tableDetail").children('tbody').children('tr:first').children('td.dbcr').children('[type=text]').val('CREDIT');
				
				$("#trfKsei_div").hide();
			}
		}
		else
		{
			$("#clientLabel").html("Client");
		}
	}
	
	function checkBalance()
	{
		var balance = 0;
		var x = 0;
		
		$("#tableDetail").children('tbody').children('tr').each(function()
		{
			if($("#glAcctCd").val() != 'NA' || x > 0)
			{
				var amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val());
				amt = amt.replace('.','');
				
				if(x==0)
				{
					var dbcrFlg = $(this).children('td.dbcr').children('[type=text]').val()=='DEBIT'?'D':'C';
				}
				else
				{
					var dbcrFlg = $(this).children('td.dbcr').children('select').val();
				}
				
				if(newRecord || x==0 || ( !$(this).hasClass('markCancel') && ($(this).children('td.edit').children('[type=checkbox]').is(':checked') || $(this).children('[type=hidden].rowid').val())))
				{
					//If UPDATE, exclude cancelled row AND 'not checked' new record
					
					if(dbcrFlg == 'D')
					{
						balance += parseInt(amt);
					}
					else if(dbcrFlg == 'C')
					{
						balance -= parseInt(amt);
					}
					else
					{
						return false;
					}
				}
			}
		
			x++;
		});
		
		if(balance != 0)return false;
		else 
			return true; 
	}
	
	function checkBalanceTrx()
	{
		var balance = 0;
		var x = 0;
		
		$("#tableDetailLedger").children('tbody').children('tr').each(function()
		{
			if(!$(this).hasClass('bankRow'))
			{
				var amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val());
				amt = amt.replace('.','');
				
				if($(this).children('td.dbcr').children('[type=text]').length)
				{
					var dbcrFlg = $(this).children('td.dbcr').children('[type=text]').val()=='DEBIT'?'D':'C';
				}
				else
				{
					var dbcrFlg = $(this).children('td.dbcr').children('select').val();
				}
				
				if(newRecord || x==0 || ( !$(this).hasClass('markCancel') && ($(this).children('td.edit').children('[type=checkbox]').is(':checked') || $(this).children('[type=hidden].rowid').val())))
				{
					//If UPDATE, exclude cancelled row AND 'not checked' new record
					
					if(dbcrFlg == 'D')
					{
						balance += parseInt(amt);
					}
					else if(dbcrFlg == 'C')
					{
						balance -= parseInt(amt);
					}
					else
					{
						return false;
					}
				}
			}
			
			x++;
		});
		
		if(balance != 0)return false;
		else 
			return true; 
	}
	
	function updateCheqTransferFee()
	{
		if(!init)
		{
			$("#tableCheq").children('tbody').children('tr').each(function()
			{		
				var inputFee = $(this).children('td.deductFee').children('[type=text]');
				var amt = $(this).children('td.chqAmt').children('[type=text]');
				
				inputFee.val(getTransferFee(amt)).blur();
			});
			
			$("#tableCheqLedger").children('tbody').children('tr').each(function()
			{		
				var inputFee = $(this).children('td.deductFee').children('[type=text]');
				var amt = $(this).children('td.chqAmt').children('[type=text]');
				
				inputFee.val(getTransferFeeDetailLedger(amt)).blur();
			});
		}
	}
	
	function bankRowControl()
	{
		var glAcct = $("#glAcctCd").val();
		var bankRow = $("#tableDetailLedger").children('tbody').children('tr.bankRow');
		
		if(glAcct != 'NA')
		{
			bankRow.show();
			bankRow.css('visibility','visible').children('td').css('visibility','visible');
			//detailLedgerCount++;
		}
		else
		{
			bankRow.hide();
			bankRow.css('visibility','hidden').children('td').css('visibility','hidden');
			//detailLedgerCount--;
		}
		
		//reassignIdDetailLedger();
	}
	
	function bankRowControlNonTrx()
	{
		var glAcct = $("#glAcctCd").val();
		var bankRow = $("#tableDetail").children('tbody').children('tr:eq(0)');
		
		if(glAcct != 'NA')
		{
			bankRow.show();
			bankRow.css('visibility','visible').children('td').css('visibility','visible');
		}
		else
		{
			bankRow.hide();
			bankRow.css('visibility','hidden').children('td').css('visibility','hidden');
			
			$("#currAmt").val(0).change().blur();
		}
	}
</script>
