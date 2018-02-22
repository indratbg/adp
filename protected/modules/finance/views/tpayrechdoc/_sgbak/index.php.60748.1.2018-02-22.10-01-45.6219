<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
	
	label.checkbox.inline:nth-of-type(1)
	{
		margin-left:-100px;
		margin-right:-100px;
	}
</style>

<?php AHelper::applyFormatting() ?>

<h3>Print Voucher</h3>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'voucherdoc-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid"> 
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'date',array('class'=>'control-label')) ?>
				</div>
				From &nbsp;
				<?php echo $form->textField($model,'date_from',array('id'=>'dateFrom','placeholder'=>'dd/mm/yyyy','class'=>'tdate span3')); ?>
				&emsp;
				To &nbsp;
				<?php echo $form->textField($model,'date_to',array('id'=>'dateTo','placeholder'=>'dd/mm/yyyy','class'=>'tdate span3')); ?>
			</div>
		</div>
		<div class="span6">
			<div class="span3">
				<?php echo $form->label($model,'voucher_type',array('class'=>'control-label')) ?>
			</div>
			<?php //echo $form->checkBoxListInlineRow($model,'voucher_type',array('R'=>'Receipt','P'=>'Payment'),array('class'=>'voucherType','label'=>false)) ?>
			<input type="checkbox" id="voucherType1" name="Rptvoucherdoc[voucher_type][]" value="R" <?php if(array_search('R',$model->voucher_type) !== false )echo 'checked' ?> /> 
			&nbsp;
			Receipt 
			&emsp;
			<input type="checkbox" id="voucherType2" name="Rptvoucherdoc[voucher_type][]" value="P" <?php if(array_search('P',$model->voucher_type) !== false )echo 'checked' ?> /> 
			&nbsp; 
			Payment
		</div>
	</div>
	
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span3">
				<?php echo $form->label($model,'voucher_status',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->radioButtonListInlineRow($model,'voucher_status',array('A'=>'Approved','E'=>'Unapproved','C'=>'Cancel'),array('class'=>'voucherStatus','label'=>false)) ?>
			<input type="hidden" id="voucherStatus_hid" name="voucherStatus_hid" value="<?php echo $model->voucher_status ?>" />
		</div>
		<div class="span6">
			<div class="span3">
				<?php echo $form->label($model,'client_criteria',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->radioButtonListInlineRow($model,'client_criteria',array('A'=>'All','N'=>'Non Client','S'=>'Specified'),array('class'=>'clientCriteria','label'=>false)) ?>
		</div>
	</div>	
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span3">
				<?php echo $form->label($model,'file_no',array('class'=>'control-label')) ?>
			</div>
			From &nbsp;
			<?php echo $form->textField($model,'file_no_from',array('id'=>'fileFrom','class'=>'span3')); ?>
			&emsp;
			To &nbsp;
			<?php echo $form->textField($model,'file_no_to',array('id'=>'fileTo','class'=>'span3')); ?>
		</div>
		<div id="clientSpecified_span" class="span6">
			<div class="span3">
				<?php echo $form->label($model,'&nbsp',array('class'=>'control-label')) ?>
			</div>
			From &nbsp;
			<?php echo $form->textField($model,'client_from',array('id'=>'clientFrom','class'=>'span3')); ?>
			&emsp;
			To &nbsp;
			<?php echo $form->textField($model,'client_to',array('id'=>'clientTo','class'=>'span3')); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span3">
				<?php echo $form->label($model,'journal_number',array('class'=>'control-label')) ?>
			</div>
			From &nbsp;
			<?php echo $form->textField($model,'journal_number_from',array('id'=>'journalFrom','class'=>'span3')); ?>
			&emsp;
			To &nbsp;
			<?php echo $form->textField($model,'journal_number_to',array('id'=>'journalTo','class'=>'span3')); ?>
		</div>	
		<div class="span6">
			<div class="span3">
				<?php echo $form->label($model,'Bond Trx ID',array('class'=>'control-label')) ?>
			</div>
			From &nbsp;
			<?php echo $form->textField($model,'bond_trx_id_from',array('id'=>'bondTrxIdFrom','class'=>'span3')); ?>
			&emsp;
			To &nbsp;
			<?php echo $form->textField($model,'bond_trx_id_to',array('id'=>'bondTrxIdTo','class'=>'span3')); ?>
		</div>		
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnList',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Retrieve Voucher',
			'htmlOptions'=>array('name'=>'submit','value'=>'list') 
		)); ?>
	</div>
	
	<?php 
	if($retrieved)
	{
		echo $this->renderPartial('list',array('model'=>$model,'modelVoucherList'=>$modelVoucherList,'form'=>$form)) ;
	?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnPrint',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Show Report',
			'htmlOptions'=>array('name'=>'submit','value'=>'print') 
		)); ?>
	</div>
	
	<?php
		}
	?>
	
	<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'style'=>'display:none')) ?>

<?php $this->endWidget(); ?>

<!--<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>-->

<script>
	var retrieved = <?php if($retrieved)echo 'true';else echo 'false' ?>;

	$(document).ready(function()
	{
		$("#dateFrom").datepicker({'format':'dd/mm/yyyy'});
		$("#dateTo").datepicker({'format':'dd/mm/yyyy'});
		
		checkAll();
		
		if('<?php echo $url ?>')window.open('<?php echo $url;?>&__format=pdf&__pageoverflow=0&__overwrite=false','_blank');
	});
	
	$(".clientCriteria").click(function()
	{
		if($(this).val() == 'S')$("#clientSpecified_span").show();
		else
			$("#clientSpecified_span").hide();
	});
	$(".clientCriteria:checked").click();
	
	$("#btnPrint").click(function()
	{
		var oldStatus = $("#voucherStatus_hid").val();
		$(".voucherStatus[value="+oldStatus+"]").prop('checked',true);
	});
	
	$("#dateFrom").change(function()
	{
		if($("#dateFrom").val())
			$("#dateTo").val($("#dateFrom").val()).datepicker('update');
	});
	
	$("#fileFrom").change(function()
	{
		if($("#fileFrom").val())
			$("#fileTo").val($("#fileFrom").val());
	});
	
	$("#journalFrom").change(function()
	{
		if($("#journalFrom").val())
			$("#journalTo").val($("#journalFrom").val());
	});
	
	function checkAll()
	{
		var checkAll = true;
		
		$("#tableVchList").children("tbody").children('tr').each(function()
		{
			if(!$(this).children('td.print').children("[type=checkbox]").is(':checked'))
			{
				checkAll = false;
				return false;
			}
		});
		
		if(checkAll)
		{
			$("#checkAll").prop('checked',true);
		}
		else
		{
			$("#checkAll").prop('checked',false);
		}
	}
</script>
