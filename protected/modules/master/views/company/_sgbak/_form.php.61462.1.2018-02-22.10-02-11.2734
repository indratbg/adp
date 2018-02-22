<style>
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->textFieldRow($model,'nama_prsh',array('class'=>'span6','maxlength'=>50)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'kd_broker',array('class'=>'span8','maxlength'=>2)); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'other_1',array('class'=>'span8','maxlength'=>12)); ?>
		</div>
	</div>
	
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'round',array('class'=>'span8 tnumber','maxlength'=>1)); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'limit_mkbd',array('class'=>'span8 tnumber')); ?>
		</div>
	</div>
	<br />
	<div class="row-fluid">
		<div class="span6">
			<div class="well">
				Fee
			</div>
			<div class="row-fluid">
				<div class="span6">
					<?php echo $form->textFieldRow($model,'kom_fee_pct',array('class'=>'tnumber span5')); ?>
					<?php echo $form->textFieldRow($model,'vat_pct',array('class'=>'tnumber span5')); ?>
				</div>
				<div class="span6">
					<?php echo $form->textFieldRow($model,'pph_pct',array('class'=>'tnumber span5')); ?>
					<?php echo $form->textFieldRow($model,'levy_pct',array('class'=>'tnumber span5')); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="well">
				<?php echo $form->checkBox($model,'min_fee_flag',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
				Minimum Fee
			</div>
			<?php echo $form->textFieldRow($model,'min_value',array('class'=>'span6 tnumber','maxlength'=>8)); ?>
			<?php echo $form->textFieldRow($model,'min_charge',array('class'=>'span6 tnumber','maxlength'=>6)); ?>
		</div>
	</div>

	<br/>
	<div class="well">
		Address Detail
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'def_addr_1',array('class'=>'span8')); ?>
			<?php echo $form->label($model,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($model,'def_addr_2',array('class'=>'span8','label'=>false)); ?>
			<?php echo $form->label($model,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($model,'def_addr_3',array('class'=>'span8','label'=>false)); ?>
			<?php echo $form->textFieldRow($model,'post_cd',array('class'=>'span8','maxlength'=>6)); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'phone_num',array('class'=>'span8','maxlength'=>15)); ?>		
			<?php echo $form->textFieldRow($model,'hp_num',array('class'=>'span8','maxlength'=>15)); ?>
			<?php echo $form->textFieldRow($model,'fax_num',array('class'=>'span8','maxlength'=>15)); ?>
			<?php echo $form->textFieldRow($model,'e_mail1',array('class'=>'span8','maxlength'=>57)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'con_pers_title',array('class'=>'span3','maxlength'=>15)); ?>
			<?php echo $form->textFieldRow($model,'contact_pers',array('class'=>'span8','maxlength'=>40)); ?>
		</div>
	</div>
	<br/>
	<div class="well">
		Document Details
	</div>
	<div class="row-fluid">
		<div class="span4">
			<div class="well">Jenis</div>
			<?php echo $form->textFieldRow($model,'jenis_ijin1',array('id'=>'jenis1','class'=>'span12','maxlength'=>10,'label'=>false,'readonly'=>'readonly')); ?>
		</div>
		<div class="span4">
			<div class="well">No</div>
			<?php echo $form->textFieldRow($model,'no_ijin1',array('class'=>'span12','maxlength'=>25,'label'=>false)); ?>
		</div>
		<div class="span4">
			<div class="well">Tgl Ijin</div>
			<?php echo $form->datePickerRow($model,'tgl_ijin1',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<?php echo $form->textFieldRow($model,'jenis_ijin2',array('class'=>'span12','maxlength'=>10,'label'=>false)); ?>
		</div>
		<div class="span4">
			<?php echo $form->textFieldRow($model,'no_ijin2',array('class'=>'span12','maxlength'=>25,'label'=>false)); ?>
		</div>
		<div class="span4">
			<?php echo $form->datePickerRow($model,'tgl_ijin2',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<?php echo $form->textFieldRow($model,'jenis_ijin3',array('class'=>'span12','maxlength'=>10,'label'=>false)); ?>
		</div>
		<div class="span4">
			<?php echo $form->textFieldRow($model,'no_ijin3',array('class'=>'span12','maxlength'=>25,'label'=>false)); ?>
		</div>
		<div class="span4">
			<?php echo $form->datePickerRow($model,'tgl_ijin3',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<?php echo $form->textFieldRow($model,'jenis_ijin4',array('class'=>'span12','maxlength'=>10,'label'=>false)); ?>
		</div>
		<div class="span4">
			<?php echo $form->textFieldRow($model,'no_ijin4',array('class'=>'span12','maxlength'=>25,'label'=>false)); ?>
		</div>
		<div class="span4">
			<?php echo $form->datePickerRow($model,'tgl_ijin4',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<?php echo $form->textFieldRow($model,'jenis_ijin5',array('class'=>'span12','maxlength'=>10,'label'=>false)); ?>
		</div>
		<div class="span4">
			<?php echo $form->textFieldRow($model,'no_ijin5',array('class'=>'span12','maxlength'=>25,'label'=>false)); ?>
		</div>
		<div class="span4">
			<?php echo $form->datePickerRow($model,'tgl_ijin5',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		</div>
	</div>
	
	<br/>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
	
<script>
	<?php if($status == 'U'){?>
		$("#jenis1").attr('readonly','readonly');
	<?php }?>
</script>

<?php $this->endWidget(); ?>
