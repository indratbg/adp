<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'rem_cd',array('class'=>'span5','maxlength'=>3)); ?>
	<?php echo $form->textFieldRow($model,'rem_name',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->dropDownListRow($model,'rem_susp_stat',array('N'=>'Active','Y'=>'Suspended'),array('class'=>'span3','prompt'=>'Active / Suspended')); ?>
	<?php echo $form->dropDownListRow($model,'branch_cd',Chtml::listData(Branch::model()->findAll(array("condition"=>"approved_stat = 'A'","order"=>"brch_cd")),'brch_cd', 'CodeAndName'),
						array('class'=>'span5','id'=>'cmb_brch_cd','prompt'=>'-Choose Branch-')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
