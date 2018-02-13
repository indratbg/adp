
<?php
$this->menu=array(
	array('label'=>'Stock to Settle', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'iporeport-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	echo $form->errorSummary($model);
?>

<br/>

<div class="row-fluid">
	
	<div class="span6">
		<legend><h5>Contract Date</h5></legend>
		<div class="control-group">
			<div class="span2">
				<label>Date From</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'contr_dt_from',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span2">
				<label>Date To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'contr_dt_to',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Stock</label>
			</div>
			<div class="span8">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'0','class'=>'option','id'=>'option_0')) ."&emsp; All";?>
				
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'1','class'=>'option','id'=>'option_1')) ."&emsp; Specified";?>
			</div>
			<div class="span2">
				<label>From</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model,'stk_cd_from',CHtml::listData($stk_cd,'stk_cd', 'stk_desc'),array('class'=>'span12','prompt'=>'-Select-'));?>
			</div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model,'stk_cd_to',CHtml::listData($stk_cd,'stk_cd', 'stk_desc'),array('class'=>'span12','prompt'=>'-Select-'));?>
			</div>
		</div>
		
	</div>
	<div class="span6">
		<legend><h5>Due Date</h5></legend>
		<div class="control-group">
			<div class="span2">
				<label>Date From</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'due_dt_from',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span2">
				<label>Date To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'due_dt_to',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			
		</div>
	</div>

</div>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnSubmit',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Show Report',
	)); ?>
</div>

<br/>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget() ?>
<script>
	init();
	function init()
	{
	$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	cek_option();
	cek_contr_date();
	cek_due_date();
	}
	
	$('#Rptstocktosettle_contr_dt_from').change(function(){
		 cek_contr_date();
		 getDueDate();
	})
	
	$('.option').change(function(){
		cek_option();
	})
	$('#Rptstocktosettle_stk_cd_from').change(function(){
		$('#Rptstocktosettle_stk_cd_to').val($('#Rptstocktosettle_stk_cd_from').val());
	})
	
	
	function cek_contr_date()
	{
		$('#Rptstocktosettle_contr_dt_to').val($('#Rptstocktosettle_contr_dt_from').val());
	}
	function cek_due_date()
	{
		$('#Rptstocktosettle_due_dt_to').val($('#Rptstocktosettle_due_dt_from').val());
	}
	function cek_option()
	{
		if($('#option_1').is(':checked'))
		{
			$('#Rptstocktosettle_stk_cd_from').attr('readonly',false);
			$('#Rptstocktosettle_stk_cd_to').attr('readonly',false);
		}
		else
		{
			$('#Rptstocktosettle_stk_cd_from').attr('readonly',true);
			$('#Rptstocktosettle_stk_cd_to').attr('readonly',true);
		}
	}
	
		
	function getDueDate()
	{
		var date = $('#Rptstocktosettle_contr_dt_from').val();
		 $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getduedate'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'date': date,
		        						
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				$('#Rptstocktosettle_due_dt_from').val(data.due_date);
				           				$('#Rptstocktosettle_due_dt_to').val(data.due_date);
				    				}
		});
	}
</script>

