<style>
.inline-checkbox input{
	display:inline;float:left;margin-right:5px;
}
.inline-checkbox label{
	display:inline;float:left;margin-right:25px;
}

.inline-datepicker .controls{
	margin-left:0px; display:inline;
}

.inline-datepicker .control-group{
	margin-left:0px; display:inline;
}

.inline-datepicker .front{
	width: 140px !important;
}

table tr td{
	padding: 0px;
	margin: 0px;
	min-width: 0px;
}

table{
	margin: 0px;
}
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'counter-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
		<div class="span7">
			<?php if($model->isNewRecord):?>
				<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span3','maxlength'=>50)); ?>
			<?php else: ?>
				<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span4','maxlength'=>50,'readonly'=>'readonly')); ?>
			<?php endif; ?>
		</div>
		<div class="span5">
			<?php echo $form->dropDownListRow($model, 'ctr_type', Parameter::getCombo('CTRTYP','-Select Stock Type-'),array('class'=>'span6','id'=>'ctrtype')); ?>
		</div>
	</div>
	
	<?php echo $form->textFieldRow($model,'stk_desc',array('class'=>'span5','maxlength'=>50)); ?>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->dropDownListRow($model, 'indry_type', Parameter::getCombo('INDRYT','-Select Industry Type-'),array('class'=>'span6')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span7">
			<?php echo $form->textFieldRow($model,'exch_lisd',array('class'=>'span3','maxlength'=>4)); ?>
		</div>
		<?php if(!$model->isNewRecord): ?>
		<div class="span5">
			<?php echo $form->datePickerRow($model,'eff_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<?php endif; ?>
	</div>
	<div class="row-fluid" id="sbiflg">
		<?php echo $form->dropDownListRow($model, 'sbi_flg', array('N'=>'Korporasi','Y'=>'Pemerintah'),array('class'=>'span2')); ?>
	</div>
	<div class="row-fluid">
		<div class="span7">
			<?php echo $form->datePickerRow($model,'pp_from_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span5">
			<div class="control-group">
				<?php echo $form->label($model,'pp_to_dt',array('class'=>'control-label','id'=>'txtperiodto','value'=>'To')); ?>
				<?php echo $form->datePickerRow($model,'pp_to_dt',array('id'=>'pptodt','label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			</div>
		</div>
		
	</div>
	<div class="row-fluid">
		<div class="span7">
			<?php echo $form->dropDownListRow($model, 'regr_cd', Parameter::getCombo('REGRCD','-Select BAE Code-'),array('class'=>'span8')); ?>
		</div>
		<div class="span5">
			<?php echo $form->datePickerRow($model,'stk_lisd_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span7">
			<?php echo $form->textFieldRow($model,'mrg_stk_cap',array('class'=>'span3')); ?>
		</div>
		<div class="span5">
			<?php echo $form->textFieldRow($model,'layer',array('class'=>'span3','maxlength'=>3)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span7">
			<?php echo $form->textFieldRow($model,'lot_size',array('class'=>'span6 tnumber','maxlength'=>12)); ?>
		</div>
		<div class="span5">
			<div class="control-group">
				<div class="controls inline-checkbox" style="margin-left: 0px;">
					<?php echo $form->checkBox($model,'pph_appl_flg',array('value' => 'Y', 'uncheckValue'=>'N','id'=>'pphflg')); ?>
					<?php echo $form->label($model,'pph_appl_flg'); ?>
					
					<?php echo $form->checkBox($model,'levy_appl_flg',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
					<?php echo $form->label($model,'levy_appl_flg'); ?>
					
					<?php echo $form->checkBox($model,'stk_scripless',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
					<?php echo $form->label($model,'stk_scripless'); ?>				
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span7">
			<?php echo $form->textFieldRow($model,'isin_code',array('class'=>'span6')); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
	
	<script>		
		<?php if($model->ctr_type == 'OB'){?>
			checkBondType('<?php echo 'OB';?>');
		<?php }else if($model->ctr_type == 'RT'){?>
			checkBondType('<?php echo 'RT';?>');
		<?php }else if($model->ctr_type == 'WR'){?>
			checkBondType('<?php echo 'WR';?>');
		<?php }else{?>
			$("#sbiflg").hide();
			$("#txtperiodto").html('To&emsp;&emsp;');
		<?php }?>
		
		$("#ctrtype").change(function(){
			var ctrtypeval = $("#ctrtype option:selected").val();
			if(ctrtypeval == 'RT' || ctrtypeval == 'WR'){
				$("#pphflg").attr('checked',false);
				$("#pphflg").prop('disabled','disabled');
			}else{
				$("#pphflg").attr('checked',true);
				$("#pphflg").prop('disabled',false);
			}
			checkBondType(ctrtypeval);
		});
		
		function checkBondType(ctrtype){
			if(ctrtype == 'OB'){
				$("#sbiflg").show();
				$("#txtperiodto").html('Maturity Date <span class="required">*</span>&emsp;');				
			}else if(ctrtype == 'RT' || ctrtype == 'WR'){
				$("#sbiflg").hide();
				$("#txtperiodto").html('To <span class="required">*</span>&emsp;&emsp;');
			}else{
				$("#sbiflg").hide();
				$("#txtperiodto").html('To&emsp;&emsp;');
			}
			
		}
	</script>

<?php $this->endWidget(); ?>
