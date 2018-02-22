<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->datePickerRow($model,'cre_dt_from',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<?php echo $form->datePickerRow($model,'cre_dt_to',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<?php echo $form->dropDownListRow($model,'vch_type',array(
															'%' => 'ALL',
															'TRX' => 'REGULAR TRANSACTION',
															'CUSTO' => 'CUSTODY TRANSACTION',
															'NET' => 'NETTING',
															'KBB' => 'RDI',
															'KSEI' => 'KSEI',
														),
														array('class'=>'span3')); ?>
	
	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span3','maxlength'=>10)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
