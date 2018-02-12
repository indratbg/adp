<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->dropDownListRow($model,'reks_cd',CHtml::listData(Trekstrx::model()->findAll(),'reks_cd', 'reks_cd'),array('class'=>'span5','id'=>'reks_cd','maxlength'=>25,'prompt'=>'-Pilih Reks Code-')); ?>
	<?php echo $form->textFieldRow($model,'reks_name',array('class'=>'span5','maxlength'=>50,'id'=>'reks_name','rows'=>3)); ?>
	<?php echo $form->dropDownListRow($model,'reks_type',CHtml::listData(Trekstrx::model()->findAll(),'reks_type', 'reks_type'),array('class'=>'span5','maxlength'=>25,'prompt'=>'-Pilih Reks Type-')); ?>
	
	
	<div class="control-group">
		<?php echo $form->label($model,'Transaction Date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'trx_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'trx_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'trx_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	
	<?php echo $form->dropDownListRow($model,'trx_type',CHtml::listData(Trekstrx::model()->findAll(),'trx_type', 'trx_type'),array('class'=>'span5','maxlength'=>10,'prompt'=>'-Pilih Transaction Type-')); ?>
	<?php echo $form->dropDownListRow($model,'afiliasi',array('Y'=>'YES','N'=>'NO'),array('class'=>'span5','maxlength'=>10,'prompt'=>'-Select Afiliasi-')); ?>
	<?php echo $form->textFieldRow($model,'subs',array('class'=>'span5','id'=>'subs','maxlength'=>18,'rows'=>3)); ?>
	<?php echo $form->textFieldRow($model,'redm',array('class'=>'span5','id'=>'redm','maxlength'=>18,'rows'=>3)); ?>
	<?php echo $form->textFieldRow($model,'gl_a1',array('class'=>'span5','id'=>'gl_a1','maxlength'=>4,'rows'=>3)); ?>
	<?php echo $form->textFieldRow($model,'sl_a1',array('class'=>'span5','id'=>'sl_a1','maxlength'=>4,'rows'=>3)); ?>
	<?php echo $form->textFieldRow($model,'gl_a2',array('class'=>'span5','id'=>'gl_a2','maxlength'=>4,'rows'=>3)); ?>
	<?php echo $form->textFieldRow($model,'sl_a2',array('class'=>'span5','id'=>'sl_a2','maxlength'=>4,'rows'=>3)); ?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
