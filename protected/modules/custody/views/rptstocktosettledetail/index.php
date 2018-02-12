<style>
	.stock_type >label
	{
		margin-left:-120px;
	}
</style>
<?php
$this->menu=array(
	array('label'=>'Stock to Settle Detail', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
		<div class="control-group">
			<div class="span2">
				<label>Client</label>
			</div>
			<div class="span8">
				<?php echo $form->radioButton($model,'client_option',array('value'=>'0','class'=>'option2','id'=>'client_option_0')) ."&emsp; All";?>
				
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'client_option',array('value'=>'1','class'=>'option2','id'=>'client_option_1')) ."&emsp; Specified";?>
			</div>
			<div class="span2">
				<label>From</label>
			</div>
			<div class="span2">
				<?php echo $form->textField($model,'bgn_client',array('class'=>'span12'));?>
			</div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span2">
				<?php echo $form->textField($model,'end_client',array('class'=>'span12'));?>
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
		
		<div class="control-group">
			<div class="span2">
				<label>Stock Type</label>
			</div>
			<div class="span10 stock_type">
				<?php echo $form->radioButtonList($model,'stk_type',array('0'=>'All','1'=>'On Custody'),array('label'=>false));?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="span2">
				<label>Market Type</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'market_type',array('NG'=>'Nego','TS'=>'Tutup','RG'=>'Regular','TN'=>'Tunai'),array('class'=>'span10','prompt'=>'-Select-'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnSubmit',
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Show Report',
			)); ?>
			</div>
			<div class="span5">
				<a href="<?php echo Yii::app()->request->baseUrl.'?r=custody/Rptstocktosettledetail/GetXls&rand_value='.$rand_value.'&user_id='.$user_id ;?> " id="btn_xls" class="btn btn-primary">Save to Excel</a>
			</div>
		</div>
	</div>

</div>

<br/>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget() ?>
<script>
var url_xls = '<?php echo $url_xls ?>';
	init();
	function init()
	{
	$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	cek_option_stock();
	getClient();
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
	
	$('#Rptstocktosettledetail_contr_dt_from').change(function(){
		 cek_contr_date();
		 getDueDate();
	})
	
	$('.option').change(function(){
		cek_option_stock();
	})
	$('.option2').change(function(){
		cek_option_client();
	})
	$('#Rptstocktosettledetail_stk_cd_from').change(function(){
		$('#Rptstocktosettledetail_stk_cd_to').val($('#Rptstocktosettledetail_stk_cd_from').val());
	})
	$('#Rptstocktosettledetail_due_dt_from').change(function(){
		cek_due_date();
	})
	$('#Rptstocktosettledetail_bgn_client').change(function(){
		$('#Rptstocktosettledetail_end_client').val($('#Rptstocktosettledetail_bgn_client').val());
	})
	
	function cek_contr_date()
	{
		$('#Rptstocktosettledetail_contr_dt_to').val($('#Rptstocktosettledetail_contr_dt_from').val());
	}
	function cek_due_date()
	{
		$('#Rptstocktosettledetail_due_dt_to').val($('#Rptstocktosettledetail_due_dt_from').val());
	}
	function cek_option_stock()
	{
		if($('#option_1').is(':checked'))
		{
			$('#Rptstocktosettledetail_stk_cd_from').attr('readonly',false);
			$('#Rptstocktosettledetail_stk_cd_to').attr('readonly',false);
		}
		else
		{
			$('#Rptstocktosettledetail_stk_cd_from').attr('readonly',true);
			$('#Rptstocktosettledetail_stk_cd_to').attr('readonly',true);
		}
	}
	function cek_option_client()
	{
		if($('#client_option_1').is(':checked'))
		{
			$('#Rptstocktosettledetail_bgn_client').attr('readonly',false);
			$('#Rptstocktosettledetail_end_client').attr('readonly',false);
		}
		else
		{
			$('#Rptstocktosettledetail_bgn_client').attr('readonly',true);
			$('#Rptstocktosettledetail_end_client').attr('readonly',true);
		}
	}
	
	function getClient()
	{
		var result = [];
		$('#Rptstocktosettledetail_bgn_client ,#Rptstocktosettledetail_end_client').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getclient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				           				 result = data;
				    				}
				});
		    },
		    change: function(event,ui)
	        {
	        	$(this).val($(this).val().toUpperCase());
	        	if (ui.item==null)
	            {
	            	// Only accept value that matches the items in the autocomplete list
	            	
	            	var inputVal = $(this).val();
	            	var match = false;
	            	
	            	$.each(result,function()
	            	{
	            		if(this.value.toUpperCase() == inputVal)
	            		{
	            			match = true;
	            			return false;
	            		}
	            	});
	            	
	            }
	        },
		    minLength: 1
		});
	}
	
	
	function getDueDate()
	{
		var date = $('#Rptstocktosettledetail_contr_dt_from').val();
		 $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getduedate'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'date': date,
		        						
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				$('#Rptstocktosettledetail_due_dt_from').val(data.due_date);
				           				$('#Rptstocktosettledetail_due_dt_to').val(data.due_date);
				    				}
		});
	}
</script>

