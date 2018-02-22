<style>
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'sales-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'rem_cd',array('class'=>'span4','maxlength'=>3)); ?>
		</div>
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'rem_type',Chtml::listData(Parameter::model()->findAll(array("condition"=>"prm_cd_1 = 'REMTYP'")),'prm_cd_2', 'prm_desc'),array('class'=>'span5')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->dropDownListRow($model,'rem_susp_stat',array('N'=>'Active','Y'=>'Suspended'),array('class'=>'span2')); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->textFieldRow($model,'rem_name',array('class'=>'span6','maxlength'=>50)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'rem_name_abbr',array('class'=>'span6','maxlength'=>20)); ?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->radioButtonListInlineRow($model, 'ic_type', Parameter::getRadioList('IDTYPE',0,3) ); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'rem_ic_num',array('class'=>'span8','maxlength'=>30)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'npwp_number',array('class'=>'span8','maxlength'=>20)); ?>
		</div>
		<div class="span3">
			<?php echo $form->dropDownListRow($model,'ptkp_type',Chtml::listData(Ptkp::model()->findAll(),'ptkp_type', 'ptkp_type'),array('class'=>'span3','prompt'=>'-Choose PTKP-')); ?>
		</div>
		<div class="span3">
			<?php echo $form->dropDownListRow($model,'warn_pph21_rate',Chtml::listData(Basepph21::model()->findAll(array('select'=>'t.pph21_rate','distinct'=>true,'order'=>'t.pph21_rate')),'pph21_rate', 'pph21_rate'),array('class'=>'span3','prompt'=>'-Choose PTKP-')); ?>
		</div>
	</div>	
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'branch_cd',Chtml::listData(Branch::model()->findAll(array("condition"=>"approved_stat = 'A'","order"=>"brch_cd")),'brch_cd', 'CodeAndName'),
						array('class'=>'span8','id'=>'cmb_brch_cd','prompt'=>'-Choose Branch-')); ?>
		</div>
		<div class="span6">
			<?php echo $form->datePickerRow($model,'join_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->dropDownListRow($model, 'lic_num', Sales::$lic_num,array('class'=>'span6','id'=>'licnum')); ?>
		</div>
		<div class="span6" id="licexpdt">
			<div class="control-group ">
				<label class="control-label required" for="Sales_lic_expry_dt">
					License Expiry Date
					<span class="required">*</span>
				</label>
			<?php echo $form->datePickerRow($model,'lic_expry_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','label'=>false,'class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'def_addr_1',array('class'=>'span8','maxlength'=>30)); ?>
			<?php echo $form->label($model,' ',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($model,'def_addr_2',array('class'=>'span8','maxlength'=>30,'label'=>false)); ?>
			<?php echo $form->label($model,' ',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($model,'def_addr_3',array('class'=>'span8','maxlength'=>30,'label'=>false)); ?>
			<?php echo $form->textFieldRow($model,'post_cd',array('class'=>'span5','maxlength'=>6)); ?>
		</div>
		<div class="span6">		
			<?php echo $form->textFieldRow($model,'phone_num',array('class'=>'span6','maxlength'=>15)); ?>
			<?php echo $form->textFieldRow($model,'handphone_num',array('class'=>'span6','maxlength'=>15)); ?>
			<?php echo $form->textFieldRow($model,'fax_num',array('class'=>'span6','maxlength'=>15)); ?>	
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->textFieldRow($model,'email',array('class'=>'span6','maxlength'=>50)); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	isLicensed();
	
	$('#licnum').change(function(){
		isLicensed();
	});
	
	function isLicensed(){
		if($('#licnum').val() == 'N' || $('#licnum').val() == ''){
			$('#licexpdt').hide();
		}else{
			$('#licexpdt').show();
		}
	}
</script>