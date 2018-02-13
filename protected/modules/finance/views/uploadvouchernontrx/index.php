<style>
	.filter-group *
	{
		float:left;
	}
	#tableDetailLedger
	{
		background-color:#C3D9FF;
	}
	#tableDetailLedger thead, #tableDetailLedger tbody
	{
		display:block;
	}
	
	#tableDetailLedger tbody
	{
		max-height:250px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	

	.markCancel
	{
		background-color:#BB0000;
	}
.radio.inline{
	width: 130px;
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
</style>

<?php
$this->breadcrumbs=array(
	'Upload Voucher Non Transaksi',
);
?>
<?php
$this->menu=array(
	
	array('label'=>'Upload Voucher Non Transaksi', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

?>
<br/>

	<?php
	
	$bankList = Ipbank::model()->findAll(array('condition'=>"approved_stat='A'",'order'=>'bank_cd'));
	$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHEQ' AND param_cd2 = 'RV'")->dflg1;
	$rdiBank = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = 'RDI_PAY' AND param_cd2 = 'BANK'");
	
	$bankAcc = Parameter::getCombo('BNKFLG', '');
?>
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'import-form',
				'enableAjaxValidation'=>false,
				'type'=>'horizontal',
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			)); ?>
			<?php echo $form->errorSummary(array($model,$modelupload)); ?>
		
		<?php foreach($modeldetail as $row)echo $form->errorSummary($row); ?>
		<?php foreach($modelcheq as $row)echo $form->errorSummary($row); ?>
			<input type="hidden" id="scenario" name="scenario"/>
			<input type="hidden" id='rowCount' name="rowCount"/>
			<input type="hidden" id="balance" name="balance"/>
			<input type="hidden" id="credit" name="credit"/>
			<input type="hidden" id="debit" name="debit"/>
	<?php if(count($modeldetail) ==1){?> 		
		
					<?php  echo CHTML::activeFileField($modelupload,'file_upload');?>
					
			
					
				<?php 
				$this->widget('bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Upload',
			        'size' => 'medium',
			        'id' => 'btnImport',
			        'buttonType'=>'submit',
			        'htmlOptions'=>array('class'=>'btn-small btn-primary' ,'style'=>'font-weight:bold;margin-left:0px;margin-top:-5px;')
			    )
			); ?>
		<br/>	<br/>		
<pre>
<b>File yg diupload adalah text tab delimited tanpa heading :</b>
1. GL account code (eg. 1200)
2. Sub account code ( eg. 100001)
3. Description ( max : 50 chars)
4. Debit ( D) / Credit ( C  ) code 
5. Amount eg. 120000 / 120000.45
</pre>			
<?php } ?>
<?php if(count($modeldetail)>1){?> 
		<div class="row-fluid">
		<div class="span4">
			<div id="payrecType_div">
				<div class="span5">
					<?php echo $form->labelEx($model,'payrec_type',array('class'=>'control-label')) ?>
				</div>
		
					<?php echo $form->radioButtonListInlineRow($model,'payrec_type',array('RD'=>'RECEIPT','PD'=>'PAYMENT'),array('id'=>'payrecType','class'=>'span5','label'=>false,'onChange'=>'changeLabel()')); ?>
				
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<div class="span4" id="clientCd_span">
					<?php echo $form->labelEx($model,'Received From',array('id'=>'clientLabel','class'=>'control-label')) ?>
				</div>
				<?php //echo $form->dropDownList($model,'client_cd',CHtml::listData(Client::model()->findAll(array('condition'=>"susp_stat = 'N'",'order'=>'client_cd')), 'client_cd', 'ConcatForSettlementClientCmb'),array('id'=>'clientCd','class'=>'span4','prompt'=>'-Choose-','disabled'=>!$model->isNewRecord?'disabled':'')); ?>
				<?php echo $form->textField($model,'client_cd',array('id'=>'clientCd','class'=>'span4'));?>
				
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
			<div class="payRdi">
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
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<div class="span5">
					<?php echo $form->labelEx($model,'gl_acct_cd',array('class'=>'control-label')) ?>
				</div>
				<div class="controls">
					<?php //echo $form->textField($model,'gl_acct_cd',array('id'=>'glAcctCd','class'=>'span3'));?>
					<?php //echo $form->dropDownList($model,'gl_acct_cd',Parameter::getCombo('BNKFLG', ''),array('id'=>'glAcctCd','class'=>'span3')); ?>
					<?php echo $form->dropDownList($model,'gl_acct_cd',CHtml::listData(Sysparam::model()->findAll("param_id='VOUCHER ENTRY' and param_cd1='DDBANK' and param_cd2='NONTRX'"), 'dstr1', 'dstr1'),array('id'=>'glAcctCd','class'=>'span3'));?>
					<?php echo $form->dropDownList($model,'sl_acct_cd',array()/*CHtml::listData($sl_acct_cd, 'sl_a', 'BankAccount')*/,array('id'=>'slAcctCd','class'=>'span4','prompt'=>'-Choose-')); ?>
					
				</div>
			</div>
		</div>
		<div class="span4">
			<div id="currAmt_div">
				<div id="currAmt_span" class="span4">
					<?php echo $form->labelEx($model,'curr_amt',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'curr_amt',array('onchange'=>'setAmt()','required'=>true,'id'=>'currAmt','class'=>'span8 tnumberdec','style'=>'text-align:right;')); ?>
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
				<?php echo $form->textField($model,'remarks',array('onchange'=>'setRemarks()','id'=>'remarks','class'=>'span8','maxlength'=>50)); ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<div id="payrecFrto_span" class="span3" >
					<?php echo $form->labelEx($model,'payrec_frto',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'payrec_frto',array('style'=>'margin-left:-25px;','id'=>'payrecFrto','class'=>'span8','maxlength'=>50)); ?>
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
	
		<?php
		$tabs = array(
			array(
	                'label'   => 'Journal',
	                'content' =>  $this->renderPartial('_form_ledger',array('model'=>$model,'modeldetail'=>$modeldetail,'form'=>$form),TRUE,FALSE),
	                'active'  => true
	            ),
             array(
	                'label'   => 'Cheque',
	                 'content' =>  $this->renderPartial('_form_cheq',array('model'=>$model,'modelcheq'=>$modelcheq,'form'=>$form),TRUE,FALSE),
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
			
		
				<div class="form-actions text-center" id="submit" style="margin-left:-150px">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnSave',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Accept',
			'htmlOptions'=>array('name'=>'submit','value'=>'submit')
		)); ?>
	</div>
			
		
			
	<?php } ?>		
			
<?php echo $form->datePickerRow($model,'cre_dt',array('label'=>false,'disabled'=>'disabled','style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<?php $this->endWidget(); ?>
	
<script type="text/javascript" charset="utf-8">

var rowCount = <?php echo count($modeldetail);?> 

$('#btnImport').click(function(){
	$('#scenario').val('import');
});
$('#btnSave').click(function(){
	$('#scenario').val('save');
	$('#rowCount').val(rowCount);
	$('#cheqCount').val(cheqCount);
})


$('#folderCd').change(function(){
	
	var folder_cd= $('#folderCd').val();
	
	$('#folderCd').val(folder_cd.toUpperCase()); 
})

$('#remarks').change(function(){
var remarks = $('#remarks').val();
$('#remarks').val(remarks.toUpperCase());	
})

init();
getBankAccount();
$("#tableCheq").children('tbody').children('tr').each(function()
		{
			$(this).children('td.chqDt').children('[type=text]').datepicker({format:'dd/mm/yyyy'});
		});
function init(){
	$('#payrecDate').datepicker({format : "dd/mm/yyyy"});
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
       
        
}
	$("#clientCd").change(function()
	{
		getClientDetail();
	});
	$("#slAcctCd").change(function()
	{
		setAmt();
		getFolderPrefix();
		
		var slValue = $(this).val();
		var acctName = $(this).children('option:selected').attr('id');
		
		
		$("#acctName").val(acctName);
		
		
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
	});
	
	
	$("#rdiPayFlg").click(function()
	{
		if($(this).is(':checked'))
		{
			<?php if($rdiBank): ?>
			
			//$("#glAcctCd").empty();
			//$("#glAcctCd").append($("<option>").val('<?php echo $rdiBank->dstr1 ?>').html('<?php echo $rdiBank->dstr1 ?>'));
				
			$("#slAcctCd").empty();
			$("#slAcctCd").append($("<option>").val('<?php echo $rdiBank->dstr2 ?>').html('<?php echo $rdiBank->dstr2 ?>'));
			
			$("#slAcctCd").change();
			
			<?php  endif; ?>
		}
		else
		{
			//$("#glAcctCd").empty();
				
			//$("#glAcctCd")				
			<?php	
				//$x=0;
			//	foreach($bankAcc as $key=>$value)
			//	{						
			?>	
			//	.append($("<option>").val('<?php //echo $key ?>').html('<?php //echo $value ?>'))		
			<?php		
				//	$x++;
				//} 
			?>	
			
			getBankAccount();	
		}
	});
	
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
				$("#payrecFrto").val(data['cif_name']);
				$("#clientBankName").val(data['client_bank']);
				$("#clientBankAcct").val(data['bank_acct_num']).trigger('change');
				
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
			}
		});
	}
		$("#glAcctCd").change(function()
	{
		$("#glAcctCd").val($("#glAcctCd").val().toUpperCase());
		setAmt();
		getBankAccount();
	});
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
				    txtCmb  += '<option value="'+this['sl_a']+'" id="'+this['acct_name']+'">'+this['sl_a']+'&emsp;&emsp;&emsp;'+this['acct_name']+'</option>';
				});
				
				$('#slAcctCd').html(txtCmb);
				
				$("#slAcctCd").val('<?php echo $model->sl_acct_cd ?>');
				
			
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
				$("#folderCd").val(data['folder_prefix']);
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
			'success'  : function(data){
				if(data)
				{
					$("#clientBankCd").val(data['bank_cd'])
					$("#clientBankCd").children('option:not(:selected)').prop('disabled',true);
				}
				else
				{
					$("#clientBankCd").children('option').prop('disabled',false);
				}
			}
		});
	}
changeLabel();
		function changeLabel()
	{
		var x = 0;
		/*
		if($("#type").val() == 'D')
		{
			*/
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
				
				$("#tableDetailLedger").children('tbody').children('tr:first').children('td.dbcr').children('[type=text]').val('DEBIT');
				
				$("#trfKsei_div").show();
				//$('.payRdi').hide();
				
			}
			else //PAYMENT
			{
				$("#clientLabel").html("Paid To");
				//$('.payRdi').show();
				/*$("#tableDetail").children('tbody').children('tr').each(function()
				{
					if(x == 0)$(this).children('td.dbcr').children('[type=text]').val('CREDIT');
					else
						$(this).children('td.dbcr').children('select').val('D');
					x++;
				});*/
				
				$("#tableDetailLedger").children('tbody').children('tr:first').children('td.dbcr').children('[type=text]').val('CREDIT');
				
				$("#trfKsei_div").hide();
			}
			
			
			
			
		}
	/*	else
		{
			$("#clientLabel").html("Client");
		}
		*/
	//}
	setAmt();
	function setAmt(){
		
		$("#tableDetailLedger").children('tbody').children('tr:first').children('td.amt').children('[type=text]').val(setting.func.number.addCommasDec($('#currAmt').val()));
		var gl_a= $('#glAcctCd').val().toUpperCase();
	
		/*if(gl_a =='NA'){
			gl_a='N/A';
		}
		*/
		$("#tableDetailLedger").children('tbody').children('tr:first').children('td.glAcct').children('[type=text]').val(gl_a);
		
		$("#tableDetailLedger").children('tbody').children('tr:first').children('td.slAcct').children('[type=text]').val($('#slAcctCd').val());
		
		checkBalance();
	}
	function setRemarks(){
		$("#tableDetailLedger").children('tbody').children('tr:first').children('td.remarks').children('[type=text]').val($('#remarks').val().toUpperCase());
	}
	getClient();
	function getClient()
    {
        var result = [];
        $('#clientCd').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getclient'); ?>',
                    'dataType'  : 'json',
                    'data'      :   {
                                        'term': request.term,
                                        
                                    },
                    'success'   :   function (data) 
                                    {
                                         response(data);
                                         result = data;
                                    }
                });
            },
            change: function(event,ui)
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
                    
                }
            },
            minLength: 0,
             open: function() { 
                    $(this).autocomplete("widget").width(400);
                     $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
</script>