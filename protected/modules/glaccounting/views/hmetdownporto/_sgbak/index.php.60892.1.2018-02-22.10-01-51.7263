<style>
	.tnumber
	{
		text-align:right
	}
	
	.help-inline.error
	{
		display: none
	}
</style>

<?php
$this->menu=array(
	array('label'=>'HMETD Portofolio Sendiri', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/gljournalledger/index','icon'=>'list','itemOptions'=>array('style'=>'float:right'))
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'hmetdownporto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	echo $form->errorSummary($model); 
	if($modelHeader)echo $form->errorSummary($modelHeader);
	foreach($modelLedger as $row)
	{
		echo $form->errorSummary($row);
	}
	if($modelFolder)echo $form->errorSummary($modelFolder);
?>

<br/>

<div class="row-fluid">
	<div class="span4" id="stkCd_span">
		<?php echo $form->textFieldRow($model, 'stk_cd', array('class'=>'span6', 'id'=>'stkCd')) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model, 'hmetd_stk', array('class'=>'span6', 'id'=>'hmetdStk', 'readonly'=>true)) ?>
	</div>
	<div class="span4">
		<div class="span4">
			<?php echo $form->labelEx($model,'price') ?>
		</div>
		<?php echo $form->textField($model, 'hmetd_price', array('class'=>'span6 tnumber', 'id'=>'hmetdPrice')) ?>
	</div>
	<div class="span4">
		<div class="span3">
			<?php echo $form->labelEx($model,'Qty') ?>
		</div>
		<?php echo $form->textField($model, 'hmetd_qty', array('class'=>'span6 tnumber', 'id'=>'hmetdQty', 'readonly'=>true)) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model, 'distribution_dt', array('class'=>'span6 tdate', 'id'=>'distributionDt', 'readonly'=>true)) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->datePickerRow($model,'exercise_dt',array('id'=>'exerciseDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span4">
		<div class="span4">
			<?php echo $form->labelEx($model,'Price') ?>
		</div>
		<?php echo $form->textField($model, 'exercise_price', array('class'=>'span6 tnumber', 'id'=>'exercisePrice')) ?>
	</div>
	<div class="span4">
		<div class="span3">
			<?php echo $form->labelEx($model,'Qty') ?>
		</div>
		<?php echo $form->textField($model, 'exercise_qty', array('class'=>'span6 tnumber', 'id'=>'exerciseQty')) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model, 'expired_dt', array('class'=>'span6 tdate', 'id'=>'expiredDt', 'readonly'=>true)) ?>
	</div>
	<div class="span4">
		<div class="span4">
			<?php echo $form->labelEx($model,'Closing Price') ?>
		</div>
		<?php echo $form->textField($model, 'close_price', array('class'=>'span6 tnumber', 'id'=>'closePrice')) ?>
	</div>
</div>

<div class="control-group">
	<div class="span2 radioSpan">
		<?php echo $form->label($model,'Type',array('class'=>'control-label')) ?>
	</div>
	<div class="controls">
		<input id="HmetdOwnPorto_journal_type_0" class="journalType" type="radio" name="HmetdOwnPorto[journal_type]" value=<?php echo AConstant::HMETD_TYPE_DISTRIBUTION ?> style="float:left" <?php if($model->journal_type == AConstant::HMETD_TYPE_DISTRIBUTION)echo 'checked' ?>>
		<label for="HmetdOwnPorto_journal_type_0" style="float:left">&emsp;Distribution HMETD</label>
	</div>
</div>

<div class="control-group">
	<div class="span2 radioSpan">
		&nbsp;
	</div>
	<div class="controls">
		<input id="HmetdOwnPorto_journal_type_1" class="journalType" type="radio" name="HmetdOwnPorto[journal_type]" value=<?php echo AConstant::HMETD_TYPE_TEBUS ?> style="float:left" <?php if($model->journal_type == AConstant::HMETD_TYPE_TEBUS)echo 'checked' ?>>
		<label for="HmetdOwnPorto_journal_type_1" style="float:left">&emsp;Tebus HMETD</label>
	</div>
</div>

<div class="control-group">
	<div class="span2 radioSpan">
		&nbsp;
	</div>
	<div class="controls">
		<input id="HmetdOwnPorto_journal_type_2" class="journalType" type="radio" name="HmetdOwnPorto[journal_type]" value=<?php echo AConstant::HMETD_TYPE_EXPIRED ?> style="float:left" <?php if($model->journal_type == AConstant::HMETD_TYPE_EXPIRED)echo 'checked' ?>>
		<label for="HmetdOwnPorto_journal_type_2" style="float:left">&emsp;Expired HMETD</label>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model, 'folder_cd', array('class'=>'span6', 'id'=>'folderCd', 'maxlength'=>8)) ?>
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
		$(".radioSpan").css('width',$("#stkCd_span > .control-group > label").width());
		
		initAutoComplete();
	});
	
	$("#stkCd").change(function()
	{
		$(this).val($(this).val().toUpperCase());
		getDetail();
	});
	
	$("#folderCd").change(function()
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
		        	'data'		:	{'term': request.term},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				    				}
				});
		    },
		    minLength: 1
		})
	}
	
	function getDetail()
	{
		var stk_cd = $("#stkCd").val();
		
		$.ajax({
        	'type'		: 'POST',
        	'url'		: '<?php echo $this->createUrl('ajxGetDetail'); ?>',
        	'dataType' 	: 'json',
        	'data'		:	{'stk_cd': stk_cd},
        	'async'		:  false,
        	'success'	: 	function (data) 
			{
				if(data)
				{
   					$("#hmetdStk").val(data['hmetd_stk']);
   					$("#hmetdPrice").val(setting.func.number.addCommas(data['hmetd_price']));
   					$("#distributionDt").val(data['distrib_dt']);
   					$("#expiredDt").val(data['expired_dt']);
   					$("#hmetdQty").val(setting.func.number.addCommas(data['total_share_qty']));
   				}
   				else
   				{
   					$("#hmetdStk").val('');
   					$("#hmetdPrice").val('');
   					$("#distributionDt").val('');
   					$("#expiredDt").val('');
   					$("#hmetdQty").val('');
   				}
   				
			}
		});
	}
</script>