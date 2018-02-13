<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'bank_cd',array('class'=>'span5','maxlength'=>5)); ?>
	<?php echo $form->textFieldRow($model,'bank_acct_num',array('class'=>'span5','maxlength'=>25)); ?>
	<?php echo $form->textFieldRow($model,'acct_name',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->dropDownListRow($model,'acct_stat',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1='RDISTS'",'order'=>'prm_desc')),'prm_cd_2', 'prm_desc'),array('class'=>'span3','id'=>'acctstat','maxlength'=>100)); ?>
	<?php echo $form->textFieldRow($model,'bank_short_name',array('class'=>'span5','maxlength'=>15)); ?>
	<?php echo $form->textFieldRow($model,'bank_acct_fmt',array('class'=>'span5','maxlength'=>30)); ?>
	<?php //echo $form->textFieldRow($model,'approved_stat',array('class'=>'span5','maxlength'=>1)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
