<style>
	#Type > label
	{
		width:100px;
		margin-left:-12px;
	}
	
	#Type > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-10px;
	}
	
	#Type > label > input
	{
		float:left;
	}
</style>
<?php
$this->breadcrumbs=array(
	'Corporate Action Journal'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Corporate Action Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tstkmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tcorpact-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br/>
<?php echo $form->errorSummary(array($model)); ?>

<input type="hidden" name="scenario" id="scenario"/>
<div class="row-fluid">
	
	<div class="span6">
		<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span4','readonly'=>$model->ca_type=='RIGHT'||$model->ca_type=='WARRANT'?FALSE:TRUE));?>
		<?php echo $form->textFieldRow($model,'ca_type',array('class'=>'span4','style'=>'text-align:left','readonly'=>true));?>
		<?php echo $form->textFieldRow($model,'from_qty',array('class'=>'span4','style'=>'text-align:right','readonly'=>true));?>
			<?php echo $form->textFieldRow($model,'to_qty',array('class'=>'span4','style'=>'text-align:right','readonly'=>true));?>
			<?php echo $form->textFieldRow($model,'rate',array('class'=>'span4','readonly'=>true,'style'=>'text-align:right'));?>
		<?php echo $form->textFieldRow($model,'stk_cd_merge',array('class'=>'span4','readonly'=>true));?>
		
		
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($model,'cum_dt',array('readonly'=>true,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),));?>
		<?php echo $form->datePickerRow($model,'x_dt',array('readonly'=>true,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy')));?>
		<?php echo $form->datePickerRow($model,'recording_dt',array('readonly'=>true,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy')));?>
		<?php echo $form->datePickerRow($model,'distrib_dt',array('readonly'=>true,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy')));?>		
		<?php echo $form->datePickerRow($model,'today_dt',array('label'=>false,'style'=>'display:none;','readonly'=>$cekParam=='Y'?false:true,'placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy')));?>
			
			<?php echo $form->textField($model,'jurnal_cumdt',array('class'=>'span5','style'=>'display:none'));?>
			<?php echo $form->textField($model,'jurnal_distribdt',array('class'=>'span5','style'=>'display:none'));?>
	</div>
	
</div>


<br/>
<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'htmlOptions'=>array('id'=>'btnOk','class'=>'btn btn-primary'),
					'label'=> 'Show Report',
					//'url'=>Yii::app()->request->baseUrl.'?r=custody/Corpactjournal/report'
				)); ?>
</div>



<?php $this->endWidget(); ?>

<script>
	$('#btnOk').click(function(){
		$('#scenario').val('report');
	});
	$('#Tcorpact_stk_cd').change(function(){
		$('#Tcorpact_stk_cd').val($('#Tcorpact_stk_cd').val().toUpperCase())
	})
</script>
