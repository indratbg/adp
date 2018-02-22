<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>

	<?php echo $form->datePickerRow($model,'from_dt',array('id'=>'fromDt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<?php echo $form->datePickerRow($model,'to_dt',array('id'=>'toDt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span5')); ?>
	
	<?php echo $form->dropDownListRow($model,'movement_type',array(
																	'ALL'=>'ALL',
																	'RW'=>'Receipt/Withdraw',
																	'R'=>'Receipt',
																	'W'=>'Withdraw',
																	'REPO'=>'Repo',
																	'REREPO'=>'Reverse Repo',
																	'EXERCS'=>'Exercise HMETD',
																	'EXERNP'=>'Exercise NP',
																	'SETTLE'=>'Settle Transaction Custody',
																	'TDOBUY'=>'Tender Offer Buy',
																	'TDOSEL'=>'Tender Offer Sell',
																	'BORROW'=>'Borrowing',
																	'LEND'=>'Lending',
																	'HMETD'=>'HMETD',
																	'SPLIT'=>'Split',
																	'REVERSE'=>'Reverse',
																	'BONUS'=>'Bonus',
																	'STKDIV'=>'Stock Dividen'
															),
															array('class'=>'span5')); ?>
	
	<?php echo $form->textFieldRow($model,'qty',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'price',array('class'=>'span5')); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	$("#toDt").focus(function()
	{
		if($("#fromDt").val())
		{
			$(this).val($("#fromDt").val()).datepicker('update');
		}
	});
</script>
