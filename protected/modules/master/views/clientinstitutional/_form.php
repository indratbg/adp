<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'clientinstitutional-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	<h4>Client Institutional</h4>
	
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->datePickerRow($model,'client_birth_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>  
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'ic_type',array('class'=>'span5','maxlength'=>1)); ?>  
		</div>
	</div>
	
	<div class="row-fluid">
	  <div class="span12">
			<?php echo $form->textFieldRow($model,'client_ic_num',array('class'=>'span5','maxlength'=>30)); ?>
			<?php echo $form->textFieldRow($model,'tempat_pendirian',array('class'=>'span5','maxlength'=>30)); ?>
			<?php echo $form->textFieldRow($model,'country',array('class'=>'span5','maxlength'=>30)); ?>
			<?php //domisili, gk ada field nya di spec ?>
			<?php echo $form->textAreaRow($model,'def_addr_1',array('class'=>'span5','maxlength'=>50,'rows'=>2)); ?>
		    <?php echo $form->textAreaRow($model,'def_addr_2',array('class'=>'span5','maxlength'=>50,'rows'=>2)); ?>
		    <?php echo $form->textAreaRow($model,'def_addr_3',array('class'=>'span5','maxlength'=>30,'rows'=>2)); ?>
		    <?php echo $form->textFieldRow($model,'post_cd',array('class'=>'span5','maxlength'=>6)); ?>
		    <?php echo $form->textFieldRow($model,'def_city',array('class'=>'span5','maxlength'=>40)); ?>
	  </div>
	</div>
	
	<div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<?php echo $form->label($model,'phone_num',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($model,'phone_num',array('class'=>'span3','maxlength'=>15)); ?>
					<?php echo $form->error($model,'phone_num', array('class'=>'help-inline error')); ?>
					<?php echo $form->textField($model,'phone2_1',array('class'=>'span3','maxlength'=>15)); ?>
					<?php echo $form->error($model,'phone2_1', array('class'=>'help-inline error')); ?>
				</div><!-- controls -->
			</div><!-- control-group -->
		</div><!-- span8 -->
	</div><!-- row-fluid -->
	
	<div class="row-fluid">
		<div class="span8">
			<?php echo $form->textFieldRow($model,'hp_num',array('class'=>'span3','maxlength'=>15)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<?php echo $form->label($model,'fax_num',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($model,'fax_num',array('class'=>'span3','maxlength'=>15)); ?>
					<?php echo $form->error($model,'fax_num', array('class'=>'help-inline error')); ?>
					<?php echo $form->textField($model,'hand_phone1',array('class'=>'span3','maxlength'=>15)); ?>
					<?php echo $form->error($model,'hand_phone1', array('class'=>'help-inline error')); ?>
				</div><!-- controls -->
			</div><!-- control-group -->
		</div><!-- span8 -->
	</div><!--row fluid -->
	
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->textFieldRow($model,'e_mail1',array('class'=>'span5','maxlength'=>50)); ?>
		</div>
	</div>
    
    <div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<?php echo $form->label($model,'inst_type',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'inst_type',Parameter::getCombo('KARAK','-Choose Institution-')); ?>
					<?php echo $form->error($model,'inst_type', array('class'=>'help-inline error')); ?>
					<?php echo $form->textField($model,'inst_type_txt', array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Institution Here')); ?>
					<?php echo $form->error($model,'inst_type_txt', array('class'=>'help-inline error')); ?>
				</div><!-- controls -->
			</div><!-- control-group -->
		</div><!-- span8 -->
	</div><!--row fluid -->
    
    <div class="row-fluid">
    	<div class="span6">
    		<?php echo $form->textFieldRow($model,'act_first', array('class'=>'span5','maxlength'=>15)); ?>
    	</div>
    	
    	<div class="span6">
    		<?php echo $form->datePickerRow($model,'act_first_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
    	</div>
    </div>
    
    <div class="row-fluid">
    	<div class="span6">
    		<?php echo $form->textFieldRow($model,'act_last',array('class'=>'span5','maxlength'=>30)); ?>
    	</div>
    	
    	<div class="span6">
    		<?php echo $form->datePickerRow($model,'act_last_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
    	</div>
    </div>
	
	<div class="row-fluid">
    	<div class="span6">
    		<?php echo $form->textFieldRow($model,'npwp_no',array('class'=>'span5','maxlength'=>15)); ?>
    	</div>
    	
    	<div class="span6">
    		<?php echo $form->datePickerRow($model,'npwp_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
    	</div>
    </div>
    
    <div class="row-fluid">
    	<div class="span12">
    		<?php echo $form->dropDownListRow($model,'tax_id',Parameter::getCombo('TAXCDC','-Choose Tax Code-')); ?>
    	</div>
    </div>
    <!--<div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<?php echo $form->label($model,'npwp_no',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($model,'npwp_no',array('class'=>'span5','maxlength'=>15)); ?>
					<?php echo $form->label($model,'npwp_date'); ?>
					<?php $this->widget('bootstrap.widgets.TbDatePicker', array(
					        'model' => $model,
					        'attribute' => 'npwp_date',
					        'options' => array(
					        	'class'=>'tdate span4',
					            'format'=>'dd/mm/yyyy',
					        	'placeholder'=>'dd/mm/yyyy',
					            'maxlength' => '10',    // textField maxlength
					            'autoclose' => true,					            
					        ),
					    )); ?>
					<?php echo $form->error($model,'npwp_date', array('class'=>'help-inline error')); ?>
					<?php echo $form->label($model,'tax_id'); ?>
					<?php echo $form->textField($model,'tax_id', array('class'=>'span5','maxlength'=>4)); ?>
					<?php echo $form->error($model,'tax_id', array('class'=>'help-inline error')); ?>
				</div>
			</div>
		</div>
	</div>-->
	
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'siup_no',array('class'=>'span5','maxlength'=>30)); ?>
		</div>
		
		<div class="span6">
			<?php echo $form->textFieldRow($model,'tdp_no',array('class'=>'span5','maxlength'=>30)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'modal_dasar',array('class'=>'span5','maxlength'=>30)); ?>
		</div>
		
		<div class="span6">
			<?php echo $form->textFieldRow($model,'modal_disetor',array('class'=>'span5','maxlength'=>30)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<?php echo $form->label($model,'industry_cd',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'industry_cd',Parameter::getCombo('INDUST','-Choose Industry-')); ?>
					<?php echo $form->error($model,'industry_cd', array('class'=>'help-inline error')); ?>
					<?php echo $form->textField($model,'addl_fund', array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Industry Here')); ?>
					<?php echo $form->error($model,'addl_fund', array('class'=>'help-inline error')); ?>
				</div><!-- controls -->
			</div><!-- control-group -->
		</div><!-- span8 -->
	</div><!--row fluid -->
	
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->textFieldRow($model,'industry',array('class'=>'span5','maxlength'=>30)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<?php echo $form->label($model,'funds_code',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'funds_code',Parameter::getCombo('FUNDC','-Choose Fund-')); ?>
					<?php echo $form->error($model,'funds_code', array('class'=>'help-inline error')); ?>
					<?php echo $form->textField($model,'source_of_funds', array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Fund Here')); ?>
					<?php echo $form->error($model,'source_of_funds', array('class'=>'help-inline error')); ?>
				</div><!-- controls -->
			</div><!-- control-group -->
		</div><!-- span8 -->
	</div><!--row fluid -->
	
	<div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<?php echo $form->label($model,'net_asset_cd',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'net_asset_cd',Parameter::getCombo('NASSET','-Choose ASSET-')); ?>
					<?php echo $form->error($model,'net_asset_cd', array('class'=>'help-inline error')); ?>
					<?php echo $form->textField($model,'net_asset', array('class'=>'span5','maxlength'=>30)); ?>
					<?php echo $form->error($model,'net_asset', array('class'=>'help-inline error')); ?>
				</div><!-- controls -->
			</div><!-- control-group -->
		</div><!-- span8 -->
	</div><!--row fluid -->
	
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->textFieldRow($model,'net_asset_yr',array('class'=>'span5','maxlength'=>4)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<?php echo $form->label($model,'profit_cd',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'profit_cd',Parameter::getCombo('PROFIT','-Choose Profit-'),array('length'=>30)); ?>
					<?php echo $form->error($model,'profit_cd', array('class'=>'help-inline error')); ?>
					<?php echo $form->textField($model,'profit', array('class'=>'span5','maxlength'=>30)); ?>
					<?php echo $form->error($model,'profit', array('class'=>'help-inline error')); ?>
				</div><!-- controls -->
			</div><!-- control-group -->
		</div><!-- span8 -->
	</div><!--row fluid -->
    
    <div class="row-fluid">
		<div class="span12">
			<div class="control-group">
				<label class="control-label">Fund Objectives</label>
				<div class="controls">
					<table style="width: 0px;">
						<tr>
							<td><?php echo $form->checkBox($model,'purpose01'); ?> Keuntungan</td>
							<td><?php echo $form->checkBox($model,'purpose02'); ?> Apresiasi Harga</td>
							<td><?php echo $form->checkBox($model,'purpose03'); ?> Investasi Jangka Panjang</td>
						</tr>
						<tr>
							<td><?php echo $form->checkBox($model,'purpose04'); ?> Spekulasi</td>
							<td><?php echo $form->checkBox($model,'purpose05'); ?> Pendapatan</td>
							<td><?php echo $form->checkBox($model,'purpose06'); ?> Pendapatan Tambahan</td>
						</tr>
						<tr>
							<td><?php echo $form->checkBox($model,'purpose90',array('label'=>false)); ?> Lainnya</td>
							<td colspan="2">
							    <?php echo $form->textField($model,'purpose_lainnya',array('class'=>'span10','maxlength'=>30)); ?>
							</td>
						</tr>
					</table>			
				</div>
			</div>
		</div>
	</div>
    
    <div class="row-fluid">
    	<div class="span12">
    		<?php echo $form->dropDownListRow($model,'invesment_period',Parameter::getCombo('JANGKA','-Choose Period-')); ?>
    	</div>
    </div>
    
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Submit' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript" charset="utf-8">

//bentuk institusi
$('#Cif_inst_type').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Cif_inst_type_txt').show().attr('required','required');
		else 
			$('#Cif_inst_type_txt').hide().removeAttr('required');
	});
$('#Cif_inst_type').trigger('change');


$('#Cif_industry_cd').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Cif_addl_fund').show().attr('required','required');
		else 
			$('#Cif_addl_fund').hide().removeAttr('required');
	});
$('#Cif_industry_cd').trigger('change');

$('#Cif_funds_code').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Cif_source_of_funds').show().attr('required','required');
		else 
			$('#Cif_source_of_funds').hide().removeAttr('required');
	});
$('#Cif_funds_code').trigger('change');

</script>





























