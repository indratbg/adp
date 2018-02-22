<?php

if(!$model->isNewRecord)              		// AR: update condition
    $urlAction = $this->createUrl('updatedetail',array('client_cd'=>$model->client_cd,'cifs'=>$model->cifs,'bank_cd'=>$model->bank_cd,'bank_acct_num'=>$model->bank_acct_num));
else                                        // AR: create condition
    $urlAction = $this->createUrl('createdetail',array('client_cd'=>$model->client_cd,'cifs'=>$model->cifs));

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'client-bank-form',
	'enableAjaxValidation'=>false,
	'action'=>$urlAction,
	'type'=>'horizontal'
));
 
?>

<fieldset>
	<legend> <h5>[<?php echo ($model->isNewRecord ? 'Create' : 'Save'); ?>] Client Bank </h5> </legend>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid">
		<div class="span6">
			<b><?php echo $model->client_name; ?></b>
		</div>
		<div class="span6">
			<b><?php echo $model->cifs; ?></b>
		</div>
	</div>
	 
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->dropDownListRow($model, 'bank_cd', Parameter::getCombo('BANKCD','-Choose Bank-'),array('class'=>'span8')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'bank_acct_num',array('class'=>'span8','maxlength'=>20)); ?>		
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php //echo $form->checkBoxRow($model,'default_flg',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php //echo $form->textFieldRow($model,'bank_branch',array('class'=>'span8','maxlength'=>40)); ?>
		</div>
		<div class="span6">
			<?php //echo $form->textFieldRow($model,'acct_name',array('class'=>'span8','maxlength'=>50)); ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'secondary',
			'id'=>'btnAddDetail',
			'label'=>$model->isNewRecord ? 'Create Bank Account' : 'Update Bank Account',
		)); ?>
	</div>
	
</fieldset>
	
<?php $this->endWidget(); ?>
	
<?php 	
	// DIHAPUS
    // echo $form->textFieldRow($model,'bank_brch_cd',array('class'=>'span5','maxlength'=>6));  		
?>

	



    
    
    
                       