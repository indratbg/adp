<style>
	.tnumber
	{
		text-align:right
	}
	
	.help-inline.error
	{
		display: none
	}
	
	.radio.inline label
	{
		margin-left: 15px
	}
</style>

<?php
$this->menu=array(
	array('label'=>'Generate Voucher Tender Offer', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right'))
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'genvouchertenderoffer-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	echo $form->errorSummary($model); 
	if($modelHeader)echo $form->errorSummary($modelHeader);
	foreach($modelDetail as $row)
	{
		echo $form->errorSummary($row);
	}
	foreach($modelLedger as $row)
	{
		echo $form->errorSummary($row);
	}
	if($modelFolder)echo $form->errorSummary($modelFolder);
?>

<br/>

<?php echo $form->textFieldRow($model, 'stk_cd', array('id'=>'stkCd', 'class'=>'span1')) ?>

<?php echo $form->radioButtonListInlineRow($model, 'stage', array(AConstant::VOUCHER_TENDER_TYPE_PENJUALAN=>'Penjualan', AConstant::VOUCHER_TENDER_TYPE_DISTRIBUTION=>'Distribution'), array('id'=>'stage')) ?>

<?php echo $form->datePickerRow($model, 'voucher_date',array('id'=>'voucherDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

<?php echo $form->textFieldRow($model, 'remarks', array('id'=>'remarks', 'class'=>'span6', 'maxlength'=>50)) ?>

<?php echo $form->textFieldRow($model, 'folder_cd', array('id'=>'folderCd', 'class'=>'span2', 'maxlength'=>8)) ?>

<br/>

GL Account Code:

<div class="control-group">
	<?php echo $form->label($model, 'Piutang Tender Offer', array('class'=>'control-label')) ?>
	
	<div class="controls">
		<?php echo $form->textField($model, 'tender_ar_gla', array('id'=>'tenderArGla', 'class'=>'span1')) ?>
		<?php echo $form->textField($model, 'tender_ar_sla', array('id'=>'tenderArSla', 'class'=>'span2')) ?>
	</div>
</div>

<div class="control-group">
	<?php echo $form->label($model, 'Bank', array('class'=>'control-label')) ?>
	
	<div class="controls">
		<?php echo $form->textField($model, 'bank_gla', array('id'=>'bankGla', 'class'=>'span1')) ?>
		<?php echo $form->textField($model, 'bank_sla', array('id'=>'bankSla', 'class'=>'span2')) ?>
	</div>
</div>

<div class="text-center" id="retrieve">
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'id'=>'btnSubmit',
	'buttonType'=>'submit',
	'type'=>'primary',
	'label'=>'Create'
)); ?>

</div>	

<?php $this->endWidget() ?>

<script>
	$(document).ready(function()
	{
		initAutoComplete();
	});
	
	$("#tenderArGla").change(function()
	{
		filterSla($("#tenderArSla"), $(this).val());
	});
	
	$("#bankGla").change(function()
	{		
		filterSla($("#bankSla"), $(this).val());
	});
	
	$("input[type=text]").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
	function initAutoComplete()
	{
		$("#stkCd").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getStock'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				    				}
				});
		    },
		    minLength: 1
		});
		
		$("#tenderArGla, #bankGla").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getGla'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				    				}
				});
		    },
		    minLength: 1,
		    open: function(){
        		$(this).autocomplete("widget").width(400); 
        	}
		});
		
		filterSla($("#tenderArSla"), $("#tenderArGla").val());
		filterSla($("#bankSla"), $("#bankGla").val());
	}
	
	function filterSla(obj, gla)
	{
		obj.autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getSla'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						'gla' : gla
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				    				}
				});
		    },
		    minLength: 1,
		    open: function(){
        		$(this).autocomplete("widget").width(400); 
        	}
		});
	}
</script>