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
</style>

<?php
	
	$bankList = Ipbank::model()->findAll(array('condition'=>"approved_stat='A'",'order'=>'bank_cd'));
	/*$result = DAO::queryAllSql("SELECT prm_desc, prm_desc2 FROM MST_PARAMETER WHERE prm_cd_1 = 'KPEILS' ORDER BY prm_cd_2");
	
	$typeList = array();
	
	foreach($result as $row)
	{
		$typeList[$row['prm_desc']] = $row['prm_desc2'];
	}*/
	
	$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHEQ' AND param_cd2 = 'RV'")->dflg1;
	
	$bankAccTrx = Sysparam::model()->findAll(array('condition'=>"param_id = 'VOUCHER ENTRY' AND param_cd1 = 'DDBANK' AND param_cd2 = 'TRX'",'order'=>'param_cd3'));
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tpayrech-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php 
		echo $form->errorSummary($model); 
		foreach($modelLedger as $row)echo $form->errorSummary($row);
		//foreach($modelLedgerSave as $row)echo $form->errorSummary($row);
		if($modelFolder)echo $form->errorSummary($modelFolder); 
		
		foreach($modelDetailLedger as $row)echo $form->errorSummary($row);
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
	
	<input type="hidden" id="authorizedBackDated" name="authorizedBackDated" value=1 />

	<div class="row-fluid">
		<div class="span4" style="<?php if(!$model->isNewRecord)echo 'display:none' ?>">
			<div id="type_span" class="span5">
				<?php echo $form->labelEx($model,'type',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->dropDownList($model,'type',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'KPEILS'",'order'=>'prm_cd_2')), 'prm_desc', 'prm_desc2'),array('id'=>'type','class'=>'span7'));?>
			<input type="hidden" id="type_hid" name="type_hid" value="<?php echo $model->type ?>" />
		</div>
		<div class="span4">
			
		</div>
		<div class="span4">
			
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<div class="span5">
					<?php echo $form->labelEx($model,'gl_acct_cd',array('class'=>'control-label')) ?>
				</div>
				<div class="controls">
					<?php echo $form->dropDownList($model,'gl_acct_cd',CHtml::listData($bankAccTrx, 'dstr1', 'dstr1'),array('id'=>'glAcctCd','class'=>'span3')); ?>
					<?php echo $form->dropDownList($model,'sl_acct_cd',array()/*CHtml::listData($sl_acct_cd, 'sl_a', 'BankAccount')*/,array('id'=>'slAcctCd','class'=>'span4','prompt'=>'-Choose-')); ?>
					<input type="hidden" id="glAcctCd_hid" name="glAcctCd_hid" value="<?php echo $model->gl_acct_cd ?>" />
					<input type="hidden" id="slAcctCd_hid" name="slAcctCd_hid" value="<?php echo $model->sl_acct_cd ?>" />
				</div>
			</div>
		</div>
		<div class="span4">
			<?php echo $form->textField($model,'acct_name',array('id'=>'acctName','class'=>'span12','readonly'=>'readonly')); ?>		
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
	<?php if($model->isNewRecord): ?>
		<div class="span4">
			<div id="trxDate_span" class="span4">
				<?php echo $form->labelEx($model,'trx_date',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->datePickerRow($model,'trx_date',array('id'=>'trxDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
			<input type="hidden" id="trxDate_hid" name="trxDate_hid" value="<?php if($model->trx_date)echo DateTime::createFromFormat('Y-m-d',substr($model->trx_date,0,10))->format('d/m/Y') ?>" />
		</div>
		<div class="span4">
			<div class="span4">
				<?php echo $form->labelEx($model,'due_date',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->datePickerRow($model,'due_date',array('id'=>'dueDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
			<input type="hidden" id="dueDate_hid" name="dueDate_hid" value="<?php if($model->due_date)echo DateTime::createFromFormat('Y-m-d',substr($model->due_date,0,10))->format('d/m/Y') ?>" />
		</div>	
	<?php endif; ?>	
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
			echo $this->renderPartial('/tpayrechkpei/_form_ledger',array('model'=>$model,'modelLedger'=>$modelLedger,'form'=>$form));
		
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
	
	<?php
		}
	?>
	
	<!-- END TRANSACTION LIST -->
	
	<br/>
	 
	 <?php
	 	if($retrieved == 2)
	 	{
	 		$tabs = array(
			array(
	                'label'   => 'Journal',
	                'content' =>  $this->renderPartial($model->isNewRecord?'/tpayrechkpei/_form_detail_ledger':($reretrieve_flg?'/tpayrechkpei/_form_detail_ledger':'/tpayrechkpei/_form_update_detail_ledger'),array('model'=>$model,'modelDetailLedger'=>$modelDetailLedger,'cancel_reason'=>isset($cancel_reason)?$cancel_reason:'','form'=>$form),true,false),
	                'active'  => true
	            ),
             array(
	                'label'   => 'Cheque',
	                'content' =>  $this->renderPartial($model->isNewRecord?'/tpayrechkpei/_form_cheq_ledger':'/tpayrechkpei/_form_update_cheq_ledger',array('model'=>$model,'modelCheqLedger'=>$modelCheqLedger,'cancel_reason_cheq'=>isset($cancel_reason_cheq)?$cancel_reason_cheq:'','form'=>$form),true,false),
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
	
	<?php
		}
	?>
	
	<?php if(!$model->isNewRecord): ?>
		<input type="hidden" id="reretrieve_flg" name="reretrieve_flg" value="<?php echo $reretrieve_flg ?>" />
	<?php endif; ?>

<?php $this->endWidget(); ?>

<script>
	var authorizedBackDated = true;
	var retrieved = <?php echo $retrieved ?>; // 0=>Not Retrieved, 1=>Transaction Retrieved, 2=>Transaction and Journal Retrieved
	var newRecord = <?php if($model->isNewRecord)echo 'true';else echo 'false' ?>;

	$(document).ready(function()
	{
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
		
		initAutoComplete();
		
		getBankAccount();
		
		bankRowControl();
		
		if(retrieved > 0)setTotal();
		
		if(retrieved == 2)addCheq(); 
		
		$("#balDebit_hid").val($("#balDebit").val());
		$("#balCredit_hid").val($("#balCredit").val());
		
		$("#tableCheqLedger").children('tbody').children('tr').each(function()
		{
			$(this).children('td.chqDt').children('[type=text]').datepicker({format:'dd/mm/yyyy'});
		});
		
		if(retrieved == 2)
		{
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
		
		if(!newRecord)
		{
			$("#tableDetailLedger").children('tbody').children('tr').each(function()
			{
				<?php if(!(isset($reretrieve_flg) && $reretrieve_flg)): ?>
					rowControl($(this).children('td.edit').children('[type=checkbox]'));
				<?php endif; ?>
			});
			
			$("#tableCheqLedger").children('tbody').children('tr').each(function()
			{
				rowControlCheq($(this).children('td.edit').children('[type=checkbox]'));
			});
			
			<?php if($retrieved == 2): ?>
				<?php if(!(isset($reretrieve_flg) && $reretrieve_flg)): ?>
					cancel_reason_detail_ledger();
				<?php endif; ?>
				
				cancel_reason_cheq_ledger();
			<?php endif; ?>
			
			$("#glAcctCd").children("option:not(:selected)").prop('disabled',true).css({'cursor':'not-allowed'});
		}
	});
	
	$(window).resize(function()
	{
		$("#remarks_span").css('width',$("#trxDate_span").width()+'px');
		$("#payrecFrto_span").css('width',$("#folderCd_span").width()+'px');
		
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
	
	$("#remarks, td.remarks [type=text], td.slAcct [type=text]").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
	$("#payrecDate").change(function()
	{
		if($("#dueDate").length)
		{
			$("#dueDate").val($(this).val()).data('datepicker').update();
			$("#dueDate").change();
		}	
			
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
	});
	
	
	
	$("#trxDate").change(function()
	{
		//if(!$("#dueDate").val())
		//{
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ajxGetDueTrxDate'); ?>',
				'dataType' : 'json',
				'data'     : {
								'trxDate':$("#trxDate").val(),
						},
				'success'  : function(data){
					$("#dueDate").val(data);
				}
			});
		//}
	});
	
	$("#glAcctCd").change(function()
	{
		getBankAccount();
		
		if(retrieved == 2)
		{
			$("#tableDetailLedger").children('tbody').children('tr.bankRow').children('td.glAcct').children('[type=text]').val($(this).val());
			bankRowControl();
		}
		
		$("#slAcctCd").change();
	});
	
	$("#slAcctCd").change(function()
	{
		getFolderPrefix();
		
		var slValue = $(this).val();
		var acctName = $(this).children('option:selected').attr('id');
		
		$("#acctName").val(acctName);
		
		if(retrieved == 2)
		{
			$("#tableDetailLedger").children('tbody').children('tr.bankRow').children('td.slAcct').children('[type=text]').val($(this).val());
		}
		
		updateCheqTransferFee();
	});
	
	$("#folderCd").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
	$("#clientBankAcct").change(function()
	{
		if($("#clientCd").val())
		{
			findBankCd();		
		}
	})
	$("#clientBankAcct").trigger('change');
	
	$("#clientBankCd").change(function()
	{
		if($(this).val())
		{
			var bankName = $(this).children('option:selected').text().substr(6);
			
			$("#clientBankName").val(bankName);
		}

		updateCheqTransferFee();
	});
	
	$("#btnRetrieve2").click(function()
	{
		$("#type").val($("#type_hid").val());
		$("#trxDate").val($("#trxDate_hid").val()).datepicker('update');
		$("#dueDate").val($("#dueDate_hid").val()).datepicker('update');
		
		$("#ledgerCount").val(ledgerCount);
	});
	
	$("#btnSubmit").click(function()
	{
		var type = $("#type").val();	

		if(retrieved > 0)
		{
			$("#type").val($("#type_hid").val());
			
			if($("#payrecDate").val() != $("#payrecDate_hid").val())
				$("#payrecDate").val($("#payrecDate_hid").val()).datepicker('update').change();
				
			$("#trxDate").val($("#trxDate_hid").val()).datepicker('update');
			$("#dueDate").val($("#dueDate_hid").val()).datepicker('update');
				
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
				alert("Bank Amount must be a whole number");
				return false;
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
	});
	
	function initAutoComplete()
	{
		$("#tableDetailLedger").children('tbody').children('tr:not(:first)').each(function()
		{
			var glAcctCd = $(this).children('td.glAcct').children('select').val();
			var result = [];
			
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
		
	function getBankAccount()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetBankAccount'); ?>',
			'dataType' : 'json',
			'data'     : {
							'glAcctCd':$("#glAcctCd").val(),
							//'branchCode':$("#clientCd").val()?$("#branchCode").val():'%'
					},
			'async'	   : false,
			'success'  : function(data){
				var txtCmb  = '<option value="">-Choose-</option>';
				
				$.each(data, function() {
				    txtCmb  += '<option value="'+this['sl_a']+'" id="'+this['acct_name']+'">'+this['sl_a']+'&emsp;&emsp;&emsp;'+this['acct_name']+'</option>';
				});
				
				$('#slAcctCd').html(txtCmb);
				
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
				//alert(balance);			
				x++;
			}
		});
		
		if(balance != 0)return false;
		else 
			return true; 
	}
	
	function updateCheqTransferFee()
	{
		$("#tableCheqLedger").children('tbody').children('tr').each(function()
		{		
			var inputFee = $(this).children('td.deductFee').children('[type=text]');
			var amt = $(this).children('td.chqAmt').children('[type=text]');
			
			inputFee.val(getTransferFeeDetailLedger(amt)).blur();
		});
	}
	
	function bankRowControl()
	{
		var glAcct = $("#glAcctCd").val();
		var bankRow = $("#tableDetailLedger").children('tbody').children('tr.bankRow');
		
		if(glAcct != 'NA')
		{
			bankRow.show();
			bankRow.css('visibility','visible').children('td').css('visibility','visible');
		}
		else
		{
			bankRow.hide();
			bankRow.css('visibility','hidden').children('td').css('visibility','hidden');
		}
	}
	
	function addCheq()
	{
		var type = $("#type").val();
		
		if(type == 'GS1000 JK' || type == 'GS1000 SL' || (type == 'KPEI' && $("#type").children("option[value='GS1000 JK']").length))
		{
			if(cheqLedgerCount == 0 && $("#glAcctCd").val() != 'NA')
			{
				addRowCheqLedger();
				
				var chqFirstRow = $("#tableCheqLedger").find('tbody').children('tr:first');
				var chqNum = type == 'KPEI' ? 'C-BEST' : $("#slAcctCd").val();
				var descrip = type == 'KPEI' ? 'KDEI C-BEST' : (type == 'GS1000 JK' ? 'CABANG SOLO' : 'PUSAT');
					
				chqFirstRow.children('td.chqNum').children('[type=text]').val(chqNum);
				chqFirstRow.children('td.descrip').children('[type=text]').val(descrip);
			}
		}
	}
</script>
