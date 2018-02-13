<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>

	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span8','maxlength'=>12)); ?>
			<?php echo $form->textFieldRow($model,'cifs',array('class'=>'span8','maxlength'=>8)); ?>
			<?php echo $form->textFieldRow($model,'sid',array('class'=>'span8','maxlength'=>15)); ?>
			<?php echo $form->textFieldRow($model,'client_name',array('class'=>'span8','maxlength'=>50)); ?>
			<?php echo $form->dropDownListRow($model,'client_type_2',CHtml::listData(Lsttype2::model()->findAll(), 'cl_type2', 'cl_desc'),array('class'=>'span8','prompt'=>'ALL')); ?>
			<?php echo $form->dropDownListRow($model,'client_type_3',CHtml::listData(Lsttype3::model()->findAll(), 'cl_type3', 'cl_desc'),array('class'=>'span8','prompt'=>'ALL')); ?>
			<div class="control-group">
				<?php echo $form->label($model,'acct_open_dt',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($model,'acct_open_dt_date',array('maxlength'=>'2','class'=>'span2','placeholder'=>'dd')); ?>
					<?php echo $form->textField($model,'acct_open_dt_month',array('maxlength'=>'2','class'=>'span2','placeholder'=>'mm')); ?>
					<?php echo $form->textField($model,'acct_open_dt_year',array('maxlength'=>'4','class'=>'span2','placeholder'=>'yyyy')); ?>
				</div>
			</div>	
		</div>
		
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'rem_cd',Chtml::listData(Sales::model()->findAll(array('condition'=>"approved_stat <> 'C' AND rem_susp_stat = 'N'",'order'=>'rem_name')),'rem_cd', 'CodeAndName'),array('class'=>'span8','prompt'=>'ALL')); ?>	
			<?php echo $form->textFieldRow($model,'old_ic_num',array('class'=>'span8','maxlength'=>30)); ?>
			<?php echo $form->dropDownListRow($model,'branch_code',Chtml::listData(Branch::model()->findAll(array('condition'=>"approved_stat <> 'C'",'order'=>'brch_name')),'brch_cd', 'brch_name'),array('class'=>'span8','prompt'=>'ALL')); ?>		
			<?php echo $form->textFieldRow($model,'agreement_no',array('class'=>'span8','maxlength'=>20)); ?>
			<?php echo $form->textFieldRow($model,'commission_per',array('class'=>'span8')); ?>
			<?php echo $form->textFieldRow($model,'custodian_cd',array('class'=>'span8','maxlength'=>8)); ?>
			<?php echo $form->textFieldRow($model,'olt',array('class'=>'span8','maxlength'=>1)); ?>
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
