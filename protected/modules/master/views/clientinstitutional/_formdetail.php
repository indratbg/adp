<h3> Detail Data </h3>
<?php
if(!$model->isNewRecord)              		 // AR: update condition
    $urlAction = $this->createUrl('updatedetail',array('cifs'=>$model->cifs,'seqno'=>$model->seqno));
else                                        // AR: create condition
    $urlAction = $this->createUrl('createdetail');
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'clientinstitutionaldetail-form',
	'action'=>$urlAction,
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php echo $form->errorSummary($model); ?>

   <div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<?php echo $form->label($model,'name',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($model,'first_name',array('class'=>'span3','maxlength'=>40,'placeholder'=>'First Name')); ?>
					<?php echo $form->error($model,'first_name', array('class'=>'help-inline error')); ?>
					<?php echo $form->textField($model,'middle_name',array('class'=>'span3','maxlength'=>40,'placeholder'=>'Middle Name')); ?>
					<?php echo $form->error($model,'middle_name', array('class'=>'help-inline error')); ?>
					<?php echo $form->textField($model,'last_name',array('class'=>'span3','maxlength'=>40,'placeholder'=>'Last Name')); ?>
				</div><!-- controls -->
			</div><!-- control-group -->
		</div><!-- span8 -->
	</div><!--row fluid -->
	
	<div class="row-fluid">
		<div class = "span12">
			<div class="span6">
				<?php echo $form->textFieldRow($model,'ktp_no',array('class'=>'span5','maxlength'=>30)); ?>
			</div>
			
			<div class="span6">
				<?php echo $form->datePickerRow($model,'ktp_expiry',array('maxlength'=>8,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdetaildate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			</div>
		</div>
	</div>    
	
	
	<div class="row-fluid">
		<div class = "span12">
			<div class="span6">
				<?php echo $form->textFieldRow($model,'passport_no',array('class'=>'span5','maxlength'=>20)); ?>
			</div>
			
			<div class="span6">
				<?php echo $form->datePickerRow($model,'passport_expiry',array('maxlength'=>8,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdetaildate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			</div>
		</div>
	</div>    
	
	<div class="row-fluid">
		<div class = "span12">
			<div class="span6">
				<?php echo $form->textFieldRow($model,'kitas_no',array('class'=>'span5','maxlength'=>30)); ?>
			</div>
			
			<div class="span6">
				<?php echo $form->datePickerRow($model,'kitas_expiry',array('maxlength'=>8,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdetaildate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			</div>
		</div>
	</div> 
	
	<div class="row-fluid">
		<div class = "span12">
			<?php echo $form->textFieldRow($model,'position',array('class'=>'span4','maxlength'=>40)); ?>
		</div>
	</div> 
	
	<div class="row-fluid">
		<div class = "span12">
			<div class="span6">
				<?php echo $form->textFieldRow($model,'npwp_no',array('class'=>'span5','maxlength'=>20)); ?>
			</div>
			
			<div class="span6">
				 <?php echo $form->datePickerRow($model,'npwp_date',array('maxlength'=>8,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdetaildate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			</div>
		</div>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'id'=>'btnAddDetail',
			'type'=>'secondary',
			'label'=>$model->isNewRecord ? 'Add Detail' : 'Update Detail',
			'icon'=>'plus',
		)); ?>
	</div>
	
<?php $this->endWidget(); ?>