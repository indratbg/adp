
<?php
$this->menu=array(
	array('label'=>'Cash Dividen History Report', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
		<!-- <legend><h5>Periode Date</h5></legend> -->
		<div class="control-group">
			<div class="span2">
				<label>Date From</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'bgn_date',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span2">
				<label>Date To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'end_date',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="span2">
				<label>Name</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'client_option',array('value'=>'0','class'=>'client_option','id'=>'client_option_0')) ."&emsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'client_option',array('value'=>'1','class'=>'client_option','id'=>'client_option_1')) ."&emsp; Specified";?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
			</div>
			<div class="span10">
				<?php echo $form->textField($model,'client_cd',array('class'=>'span9'));?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span2">
				<label>Stock</label>
			</div>
			<div class="span8">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'0','class'=>'stk_option','id'=>'stk_option_0')) ."&emsp; All";?>
				
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'1','class'=>'stk_option','id'=>'stk_option_1')) ."&emsp; Specified";?>
			</div>
			<div class="span7">
				<?php echo $form->dropDownList($model,'stk_cd',CHtml::listData($stk_cd,'stk_cd', 'stk_desc'),array('class'=>'span9','prompt'=>'-Select-','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Branch</label>
			</div>
			<div class="span7">
				<?php echo $form->dropDownList($model, 'branch_cd', CHtml::listData(Branch::model()->findAll(array(
					'select' => "brch_cd, brch_cd||' - '||brch_name brch_name",
					'condition' => " approved_stat='A'",
					'order' => 'brch_cd'
				)), 'brch_cd', 'brch_name'), array(
					'class' => 'span6',
					'prompt' => '-All-',
					'style' => 'font-family:courier'
				));
				?>
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
	stk_option();
	getClient();
	client_option();
	}
	
	$('.stk_option').change(function(){
		stk_option();
	})
	
	$('.client_option').change(function(){
		client_option();
	})
	
	
	$('#Rptcashdividenhistory_bgn_date').change(function(){
		$('#Rptcashdividenhistory_end_date').val($('#Rptcashdividenhistory_bgn_date').val());
	})
	
	
	function stk_option()
	{
		if($('#stk_option_1').is(':checked'))
		{
			$('#Rptcashdividenhistory_stk_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptcashdividenhistory_stk_cd').val('');
			$('#Rptcashdividenhistory_stk_cd').attr('disabled',true);
		}
	}

	function client_option()
	{
		if($('#client_option_1').is(':checked'))
		{
			$('#Rptcashdividenhistory_client_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptcashdividenhistory_client_cd').val('');
			$('#Rptcashdividenhistory_client_cd').attr('disabled',true);
		}
	}
	
	function getClient()
	{
		var result = [];
		$('#Rptcashdividenhistory_client_cd').autocomplete(
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
		    minLength: 0,
		     open: function() { 
			        $(this).autocomplete("widget").width(400);
			        $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
			    } 
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
	}
		
</script>

