<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
<div class="control-group">
		<?php echo $form->label($model,'jvch_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'jvch_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'jvch_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'jvch_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'folder_cd',array('class'=>'span2','style'=>'width:175px;'));?>
	<?php echo $form->textFieldRow($model,'jvch_num',array('class'=>'span2','style'=>'width:175px;'));?>
	<?php echo $form->textFieldRow($model,'remarks',array('class'=>'span2','style'=>'width:250px;'));?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>
<?php $this->endWidget(); ?>

<script>
<?php //$from_date=Date('d/m/Y',strtotime('-35 days'));
 	//	$to_date=Date('d/m/Y');?>

		//$('#Vgljournalindex_from_date').val('<?php //echo $from_date;?>');
	//	$('#Vgljournalindex_to_date').val('<?php //echo $to_date;?>');
		//$("#Vgljournalindex_from_date").datepicker({format : "dd/mm/yyyy"});
		//$("#Vgljournalindex_to_date").datepicker({format : "dd/mm/yyyy"});
	
	
</script>
