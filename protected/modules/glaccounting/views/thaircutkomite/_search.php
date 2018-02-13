<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<div class="control-group">
		<?php echo $form->label($model,'Status Date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'status_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'status_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'status_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	
	
	
	<?php echo $form->dropDownListRow($model,'stk_cd',CHtml::listData(Counter::model()->findAllBySql('SELECT STK_CD FROM MST_COUNTER ORDER BY STK_CD'),'stk_cd','stk_cd'),array('class'=>'span3','prompt'=>'-Select Stock Code-')); ?>
	<?php echo $form->textFieldRow($model,'haircut',array('class'=>'span3','maxlength'=>50,'rows'=>3)); ?>
	<div class="control-group">
		<?php echo $form->label($model,'Effective Date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'eff_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'eff_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'eff_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
