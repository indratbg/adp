<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'stk_name',array('class'=>'span5','maxlength'=>80)); ?>
	<?php echo $form->textFieldRow($model,'jenis_penjaminan',array('class'=>'span5','maxlength'=>30)); ?>
	<div class="control-group">
		<?php echo $form->label($model,'tgl_kontrak',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'tgl_kontrak_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'tgl_kontrak_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'tgl_kontrak_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'eff_dt_fr',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'eff_dt_fr_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'eff_dt_fr_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'eff_dt_fr_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'eff_dt_to',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'eff_dt_to_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'eff_dt_to_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'eff_dt_to_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'offer_dt_fr',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'offer_dt_fr_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'offer_dt_fr_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'offer_dt_fr_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'offer_dt_to',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'offer_dt_to_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'offer_dt_to_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'offer_dt_to_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'distrib_dt_fr',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'distrib_dt_fr_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'distrib_dt_fr_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'distrib_dt_fr_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'allocate_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'allocate_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'allocate_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'allocate_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'paym_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'paym_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'paym_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'paym_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'price',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'nilai_komitment',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'bank_garansi',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'unsubscribe_qty',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'order_price',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
