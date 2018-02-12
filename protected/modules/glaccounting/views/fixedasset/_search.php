<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->dropDownListRow($model,'branch_cd',CHtml::listData(Branch::model()->findAll(array('condition'=>"approved_stat='A'",'order'=>'brch_cd')), 'brch_cd', 'CodeAndName'),array('class'=>'span3','prompt'=>'-Select Branch Code-')); ?>
	<?php echo $form->textFieldRow($model,'asset_cd',array('class'=>'span5','maxlength'=>7)); ?>
<?php echo $form->dropDownListRow($model,'asset_type',CHtml::listData(Parameter::model()->findAll("PRM_CD_1 = 'FASSET'"), 'prm_cd_2', 'prm_desc'),array('class'=>'span5','prompt'=>'-Select Asset Type-')); ?>
	<?php echo $form->textFieldRow($model,'asset_desc',array('class'=>'span5','maxlength'=>60)); ?>
	<div class="row-fluid">
		
	<div class=" control-group span5">
	<?php echo $form->labelEx($model,'Purchase Date From',array('class'=>'control-label'))?>
	<?php echo $form->datePickerRow($model,'purch_dt_from',array('prepend'=>'<i class="icon-calendar"></i>','label'=>false,'placeholder'=>'dd-M-yyyy','class'=>'tdate span8','id'=>'purch_dt_from','options'=>array('format' => 'dd-M-yyyy'))); ?>
	<?php echo $form->labelEx($model,'Purchase Date TO',array('class'=>'control-label'))?>
	<?php echo $form->datePickerRow($model,'purch_dt_to',array('prepend'=>'<i class="icon-calendar"></i>','label'=>false,'placeholder'=>'dd-M-yyyy','class'=>'tdate span8','id'=>'purch_dt_to','options'=>array('format' => 'dd-M-yyyy'))); ?>
	</div>
	</div>
	<?php echo $form->textFieldRow($model,'purch_price',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>
	<?php echo $form->textFieldRow($model,'asset_stat',array('class'=>'span5','maxlength'=>10)); ?>
	<?php echo $form->textFieldRow($model,'approved_stat',array('class'=>'span5','maxlength'=>10)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
