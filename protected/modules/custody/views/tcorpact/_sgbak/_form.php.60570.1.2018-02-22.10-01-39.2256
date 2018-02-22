<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tcorpact-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>
	
	<br/>

	<?php echo $form->errorSummary($model); ?>
	
	<?php if($model->isNewRecord || $check == 1): ?>
		<?php echo $form->dropDownListRow($model,'stk_cd',CHtml::listData(Counter::model()->findAllBySql('SELECT STK_CD FROM MST_COUNTER ORDER BY STK_CD'),'stk_cd','stk_cd'),array('class'=>'span3','prompt'=>'-Select Stock Code-')); ?>
	<?php else: ?>
		<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span3','readonly'=>'readonly')); ?>
	<?php endif; ?>
	
	<?php echo $form->dropDownListRow($model,'ca_type',CHtml::listData(Parameter::model()->findAll($criteriaCorp),'prm_desc','prm_desc2'),array('class'=>'span3','prompt'=>'-Select Corporate Action Type-')); ?>

	<?php echo $form->datePickerRow($model,'cum_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php if($model->isNewRecord || $check == 1): ?>
		<?php echo $form->datePickerRow($model,'x_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<?php else: ?>
		<?php echo $form->datePickerRow($model,'x_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','disabled'=>'disabled','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<?php endif; ?>

	<?php echo $form->datePickerRow($model,'recording_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php echo $form->datePickerRow($model,'distrib_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php echo $form->textFieldRow($model,'from_qty',array('class'=>'span3','maxlength'=>19,'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'to_qty',array('class'=>'span3','maxlength'=>19,'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'rate',array('class'=>'span3','maxlength'=>19,'style'=>'text-align:right')); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php 
	if($model->isNewRecord || $check == 1)$new = 1;
	else
		$new = 0;
 ?>

<script>
	function check_caType()
	{
		if($("#Tcorpact_ca_type").val() == "CASHDIV")
		{
			$("#Tcorpact_from_qty").val(0);
			$("#Tcorpact_to_qty").val(0);
			
			$("#Tcorpact_from_qty").prop('disabled',true);
			$("#Tcorpact_to_qty").prop('disabled',true);
		}
		else
		{
			$("#Tcorpact_from_qty").prop('disabled',false);
			$("#Tcorpact_to_qty").prop('disabled',false);
		}
	}

	check_caType();

	$("#Tcorpact_ca_type").change(function()
	{
		check_caType();
	});

	$("#Tcorpact_cum_dt").change(function()
	{
		if(<?php echo $new ?>)
		{
			var cum_dt = $("#Tcorpact_cum_dt").val();
			var cum_dt_split = cum_dt.split("/");
			
			var x_date = new Date(cum_dt_split[2],cum_dt_split[1]-1,cum_dt_split[0]);
			var recording_date = new Date(cum_dt_split[2],cum_dt_split[1]-1,cum_dt_split[0]);
			
			do{
				x_date.setDate(x_date.getDate()+1);
			}while(x_date.getDay() == 0 || x_date.getDay() == 6)
			
			var x = 0;
			
			do{
				recording_date.setDate(recording_date.getDate()+1);
				if(recording_date.getDay() != 0 && recording_date.getDay() != 6)x++;
			}while(x < 3)
			
			var x_date_date;
			var recording_date_date;
			var x_date_month;
			var recording_date_month;
			
			//Tambah prefix '0' untuk tanggal 1-9
			if(x_date.getDate() < 10)x_date_date = "0"+x_date.getDate();
			else
				x_date_date = x_date.getDate();
				
			if(recording_date.getDate() < 10)recording_date_date = "0"+recording_date.getDate();
			else
				recording_date_date = recording_date.getDate();
			
			//Tambah prefix '0' untuk bulan 1-9
			if(x_date.getMonth()+1 < 10)x_date_month = "0"+(x_date.getMonth()+1);
			else
				x_date_month = x_date.getMonth()+1;
				
			if(recording_date.getMonth()+1 < 10)recording_date_month = "0"+(recording_date.getMonth()+1);
			else
				recording_date_month = recording_date.getMonth()+1;
			
			
			$("#Tcorpact_x_dt").val(x_date_date+"/"+x_date_month+"/"+x_date.getFullYear());
			$("#Tcorpact_recording_dt").val(recording_date_date+"/"+recording_date_month+"/"+recording_date.getFullYear());
		}
	});
		
</script>