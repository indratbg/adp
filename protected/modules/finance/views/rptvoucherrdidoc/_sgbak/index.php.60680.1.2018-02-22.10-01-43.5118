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
	
	.tnumber, .tnumberdec
	{
		text-align:right
	}
</style>

<?php AHelper::applyFormatting() ?>

<h3>Print Voucher RDI</h3>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'voucherdoc-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid"> 
		<div class="span6">
			<div class="control-group">
				<div class="span2">
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
			<input type="checkbox" id="voucherType1" name="Rptvoucherrdidoc[voucher_type][]" value="R" <?php if(array_search('R',$model->voucher_type) !== false )echo 'checked' ?> /> 
			&nbsp;
			Receipt 
			&emsp;
			<input type="checkbox" id="voucherType2" name="Rptvoucherrdidoc[voucher_type][]" value="W" <?php if(array_search('W',$model->voucher_type) !== false )echo 'checked' ?> /> 
			&nbsp; 
			Payment
		</div>
	</div>
	
	
	<div class="row-fluid">
		<div id="clientSpecified_span" class="span6">
			<div class="span2">
				<?php echo $form->label($model,'client',array('class'=>'control-label')) ?>
			</div>
			From &nbsp;
			<?php echo $form->textField($model,'client_from',array('id'=>'clientFrom','class'=>'span3')); ?>
			&emsp;
			To &nbsp;
			<?php echo $form->textField($model,'client_to',array('id'=>'clientTo','class'=>'span3')); ?>
		</div>
		
		<div class="span6">
			<div class="span3">
				<?php echo $form->label($model,'voucher_status',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->radioButtonListInlineRow($model,'voucher_status',array('A'=>'Approved','E'=>'Unapproved','C'=>'Cancel'),array('class'=>'voucherStatus','label'=>false)) ?>
			<input type="hidden" id="voucherStatus_hid" name="voucherStatus_hid" value="<?php echo $model->voucher_status ?>" />
		</div>
	</div>	
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span2">
				<?php echo $form->label($model,'branch',array('class'=>'control-label')) ?>
			</div>
			From &nbsp;
			<?php echo $form->textField($model,'branch_from',array('id'=>'branchFrom','class'=>'span3')); ?>
			&emsp;
			To &nbsp;
			<?php echo $form->textField($model,'branch_to',array('id'=>'branchTo','class'=>'span3')); ?>
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

<script>
	var retrieved = <?php if($retrieved)echo 'true';else echo 'false' ?>;

	$(document).ready(function()
	{
		$("#dateFrom").datepicker({'format':'dd/mm/yyyy'});
		$("#dateTo").datepicker({'format':'dd/mm/yyyy'});
		
		checkAll();
		initAutoComplete();
		
		if('<?php echo $url ?>')window.open('<?php echo $url;?>','_blank');
	});
	
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
	
	$("#clientFrom").on('change blur',function()
	{
		if($("#clientFrom").val())
			$("#clientTo").val($("#clientFrom").val());
	});
	
	$("#branchFrom").on('change blur',function()
	{
		if($("#branchFrom").val())
			$("#branchTo").val($("#branchFrom").val());
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
	
	function initAutoComplete()
	{
		$("#clientFrom, #clientTo").autocomplete(
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
		   minLength: 0,
		   open: function()
		   {
        		$(this).autocomplete("widget").width(500); 
           },
           /*position: 
           {
           	    offset: '-150 0' // Shift 150px to the left, 0px vertically.
    	   }*/
        
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
       	});
       
       	$("#branchFrom, #branchTo").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getBranch'); ?>',
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
		   minLength: 0,
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
       	});
	}
</script>
