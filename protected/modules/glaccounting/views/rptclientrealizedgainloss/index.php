<?php
$this->breadcrumbs = array(
	'Realized Gain / Loss' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Client Realized Gain / Loss',
		'itemOptions' => array('style' => 'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
	),
	array(
		'label' => 'List',
		'url' => array('index'),
		'icon' => 'list',
		'itemOptions' => array(
			'class' => 'active',
			'style' => 'float:right'
		)
	),
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'importTransaction-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>

<?php echo $form->errorSummary($model); ?>
<?php AHelper::showFlash($this)
?>

<br>

<div class="row-fluid">
	<div class="span6">

		<div class="control-group">
			<div class="span2">From Date</div>
			<div class="span3">
				<?php echo $form->textField($model,'bgn_date',array('class'=>'span12 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span1"></div>
			<div class="span2">
				<label>To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'end_date',array('class'=>'span12 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Client</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'client_cd',array('class'=>'span12'));?>
			</div>
			<!-- <div class="span1"></div>
			<div class="span2">
				<label>Random Value</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'vo_random_value',array('class'=>'span12'));?>
			</div> -->
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Stock</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'stk_cd',CHtml::listData($dropdown_stk_cd, 'stk_cd', 'stk_desc'),array('class'=>'span12','prompt'=>'-All-','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span5">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'submit',
					'type' => 'primary',
					'label' => 'OK',
					'id' => 'btnSubmit'
				));
				?>
			<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>
		</div>
		</div>
	</div>
	<!--End Span6  -->

	<div class="span6">
	
		<div class="control-group">
			<div class="span3">
				<label>Branch</label>
			</div>
			<div class="span3">
				<input type="radio" id="branch_option_0" name="Rptclientrealizedgainloss[branch_option]" value="0" <?php echo $model->branch_option==0?'checked':''?> class="branch_option"/>&nbsp;All
			</div>
			<div class="span3">
				<input type="radio" id="branch_option_1" name="Rptclientrealizedgainloss[branch_option]" value="1" <?php echo $model->branch_option==1?'checked':''?> class="branch_option"/>&nbsp;Specified
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'branch_cd',CHtml::listData($branch_cd, 'brch_cd', 'brch_name'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Sales</label>
			</div>
			<div class="span3">
				<input type="radio" id="rem_option_0" name="Rptclientrealizedgainloss[rem_option]" value="0" <?php echo $model->rem_option==0?'checked':''?> class="rem_option"/>&nbsp;All
			</div>
			<div class="span3">
				<input type="radio" id="rem_option_1" name="Rptclientrealizedgainloss[rem_option]" value="1" <?php echo $model->rem_option==1?'checked':''?> class="rem_option"/>&nbsp;Specified
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'rem_cd',CHtml::listData($rem_cd, 'rem_cd', 'rem_name'),array('prompt'=>'-Select-','class'=>'span12','style'=>'font-family:courier'));?>
			</div>
		</div>
	
		<div class="control-group">

		</div>
	
		
	</div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'disabled'=>true,'style'=>'display:none'));?>
<?php $this->endWidget(); ?>



<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
							array(
							'id'=>'mywaitdialog',
										'options'=>array(
										'title'=>'In Progress',
										'modal'=>true,
										'autoOpen'=>false,// default is true
										'closeOnEscape'=>false,
										'resizable'=>false,
										'draggable'=>false,
										'height'=>120,
										'open'=>// supply a callback function to handle the open event
										'js:function(){ // in this function hide the close button
										$(".ui-dialog-titlebar-close").hide();
										//$(".ui-dialog-content").hide();
										
										}'
							))
							);

$this->widget('bootstrap.widgets.TbProgress',
			array('percent' => 100, // the progress
			'striped' => true,
			'animated' => true,
			)
			);
?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script>



var url_xls = '<?php echo $url_xls ?>';

init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		contract_option();
		branch_option();
		rem_option();
		getClient();
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
	$('.contract_option').change(function(){
		contract_option();
	})
	$('.branch_option').change(function(){
		branch_option();
	})
	$('.rem_option').change(function(){
		rem_option();
	})
	
	function contract_option()
	{
		if($('#contract_option_0').is(':checked'))
		{
			$('#Rptclientrealizedgainloss_contract_type').prop('disabled',true);
		}
		else
		{
			$('#Rptclientrealizedgainloss_contract_type').prop('disabled',false);
		}
	}
	function branch_option()
	{
		if($('#branch_option_0').is(':checked'))
		{
			$('#Rptclientrealizedgainloss_branch_cd').prop('disabled',true);
		}
		else
		{
			$('#Rptclientrealizedgainloss_branch_cd').prop('disabled',false);
		}
	}
	function rem_option()
	{
		if($('#rem_option_0').is(':checked'))
		{
			$('#Rptclientrealizedgainloss_rem_cd').prop('disabled',true);
		}
		else
		{
			$('#Rptclientrealizedgainloss_rem_cd').prop('disabled',false);
		}
	}
	
	$('#Rptclientrealizedgainloss_bgn_date').change(function()
	{
			$('#Rptclientrealizedgainloss_end_date').val($('#Rptclientrealizedgainloss_bgn_date').val());
			$('.tdate').datepicker('update');
	})
		$('#Rptclientrealizedgainloss_bgn_date').change(function()
	{
			$('#Rptclientrealizedgainloss_end_date').val($('#Rptclientrealizedgainloss_bgn_date').val());
			 Get_End_Date($('#Rptclientrealizedgainloss_bgn_date').val());
			$('.tdate').datepicker('update');
	});
	
	$('#Rptclientrealizedgainloss_month').change(function(){
	    var from_date = $('#Rptclientrealizedgainloss_bgn_date').val().split('/');
		$('#Rptclientrealizedgainloss_bgn_date').val(from_date[0]+'/'+$('#Rptclientrealizedgainloss_month').val()+'/'+from_date[2]);
		var end_date = $('#Rptclientrealizedgainloss_end_date').val().split('/');
		$('#Rptclientrealizedgainloss_end_date').val(end_date[0]+'/'+$('#Rptclientrealizedgainloss_month').val()+'/'+end_date[2]);
		Get_End_Date($('#Rptclientrealizedgainloss_end_date').val());
	});
	
	$('#Rptclientrealizedgainloss_year').on('keyup',function(){
		 var from_date = $('#Rptclientrealizedgainloss_bgn_date').val().split('/');
		$('#Rptclientrealizedgainloss_bgn_date').val(from_date[0]+'/'+from_date[1]+'/'+$('#Rptclientrealizedgainloss_year').val());
		var end_date = $('#Rptclientrealizedgainloss_end_date').val().split('/');
		$('#Rptclientrealizedgainloss_end_date').val(end_date[0]+'/'+end_date[1]+'/'+$('#Rptclientrealizedgainloss_year').val());
	})
	function Get_End_Date(tgl)
	{
		var date = tgl.split('/');
		var day = parseInt(date[0]);
		var month = parseInt(date[1]);
		var year = parseInt(date[2]);
		
		var d = new Date(year,month,day);
		  d.setDate(d.getDate() - day);
		var month = d.getMonth()+1;
		var new_date = d.getDate()+'/'+month+'/'+d.getFullYear();
		  
		$('#Rptclientrealizedgainloss_end_date').val(new_date);
		$('.tdate').datepicker('update');
	}
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');
	})
	function getClient()
	{
		var result = [];
		$('#Rptclientrealizedgainloss_client_cd').autocomplete(
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
		    minLength: 1,
		     open: function() { 
			        $(this).autocomplete("widget").width(400);
			    } 
		});
	}
</script>