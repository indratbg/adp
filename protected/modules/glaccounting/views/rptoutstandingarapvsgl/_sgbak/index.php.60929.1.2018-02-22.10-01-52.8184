<?php
$this->menu=array(
	array('label'=>'Outstanding AR / Ap vs GL', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
<input type="hidden"  name="scenario" id="scenario"/>
<div class="row-fluid">
	
	<div class="span7">
		<div class="control-group">
			<div class="span3">
				<label>Date</label>
			</div>
			<div class="span3">
				<?php //echo $form->datePickerRow($model,'end_date',array('prepend'=>'<i class="icon-calendar"></i>',
					//'placeholder'=>'dd/mm/yyyy','class'=>'tdate span7','options'=>array('format' => 'dd/mm/yyyy'))); ?>
				<?php echo $form->textField($model,'end_date',array('class'=>'span8 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
	
		<div class="control-group">
			<div class="span3">
				<label></label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'report_type',array('value'=>'0')) ."&emsp; Show All";?>
			</div>
			<div class="span4">
				<?php echo $form->radioButton($model,'report_type',array('value'=>'1')) ."&emsp; Show Difference Only";?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Client</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'client_option',array('value'=>'0','class'=>'client_option','id'=>'client_option_0')) ."&emsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'client_option',array('value'=>'1','class'=>'client_option','id'=>'client_option_1')) ."&emsp; Specified";?>
			</div>
		</div>
		<div class="control-group">
			<div class="offset3 span3">
				<?php echo $form->textField($model,'bgn_client_cd',array('class'=>'span8'));?>
			</div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'end_client_cd',array('class'=>'span8'));?>
			</div>
		</div>
	
	</div>
	<div class="span5">
		<div class="control-group">
			<div class="span7">
				<?php echo $form->radioButton($model,'option_outs',array('value'=>'0','class'=>'option_aft_date','id'=>'option_aft_date_0')) ."&emsp;Start Date of Outstanding AFTER ";?>
			</div>
			<div class="span5">
				<?php echo $form->textField($model,'outs_aft_date',array('class'=>'span7 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span7">
				<?php echo $form->radioButton($model,'option_outs',array('value'=>'1','class'=>'option_aft_date','id'=>'option_aft_date_0')) ."&emsp;Start Date of Outstanding BEFORE ";?>
			</div>
			<div class="span5">
				<?php echo $form->textField($model,'outs_bfr_date',array('class'=>'span7 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		<div class="control-group">
			
			<div class="span7">
				<label>Process Start Date of Outstanding </label>
			</div>
				<div class="span3">
				
				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'id'=>'btnProcess',
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Process',
						'disabled'=>'disabled'
					)); ?>
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
		
		<button formaction="<?php echo Yii::app()->request->baseUrl.'?r=glaccounting/Rptoutstandingarapvsgl/GetXls&rand_value='.$rand_value.'&user_id='.$user_id ;?> " id="btn_xls" class="btn btn-primary">Save to Excel</button>
	</div>

<br/>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget() ?>


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
	$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	getClient();
	client_option();
		if(url_xls=='')
		{
			//$('#btn_xls').attr('disabled','disabled');
			$('#btn_xls').addClass('disabled');
		}
	}

	$('.client_option').change(function(){
		client_option();
	})
	
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');	
	})
	
	
	function client_option()
	{
		if($('#client_option_1').is(':checked'))
		{
			$('#Rptoutstandingarapvsgl_bgn_client_cd').attr('disabled',false);
			$('#Rptoutstandingarapvsgl_end_client_cd').attr('disabled',false);
		}
		else
		{	
			$('#Rptoutstandingarapvsgl_bgn_client_cd').attr('disabled',true);
			$('#Rptoutstandingarapvsgl_end_client_cd').attr('disabled',true);
		}
	}
	
	function getClient()
	{
		var result = [];
		$('#Rptoutstandingarapvsgl_bgn_client_cd, #Rptoutstandingarapvsgl_end_client_cd').autocomplete(
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
	
	$('#btnSubmit').click(function(){
		$('#scenario').val('show');
	});	
	$('#btnProcess').click(function(){
		$('#scenario').val('process');
	});	
	$('#Rptoutstandingarapvsgl_bgn_client_cd').change(function(){
		$('#Rptoutstandingarapvsgl_bgn_client_cd').val($('#Rptoutstandingarapvsgl_bgn_client_cd').val().toUpperCase());
		$('#Rptoutstandingarapvsgl_end_client_cd').val($('#Rptoutstandingarapvsgl_bgn_client_cd').val());
	});	
</script>

