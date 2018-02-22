
<?php
$this->menu=array(
	array('label'=>'Fixed Asset Report', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
	<div class="control-group">
		<div class="span5">
			<?php echo $form->datePickerRow($model,'end_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="span5">
			<?php echo $form->dropDownListRow($model,'branch_cd',
				CHtml::listData(Branch::model()->findAll(array('select'=>"brch_cd||' - '||brch_name brch_name, brch_cd",'order'=>'brch_cd')), 'brch_cd', 'brch_name'),
				array('class'=>'span4','style'=>'font-family:courier','prompt'=>'-All-'));?>
		</div>
	</div>
</div>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnSubmit',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'OK',
	)); ?>
</div>

<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php $this->endWidget();?>


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
	
	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		getClient();
		cek_option();
		cek_client_option();
		$("#iframe").offset({left:2});
		$("#iframe").css('width',($(window).width()));
	}
	
		function getClient()
	{
		var result = [];
		$('#Rptoutsarapclient_client_cd').autocomplete(
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
		  open: function() 
		  { 
			        $(this).autocomplete("widget").width(400);
		  },
		   position: 
           {
           	    offset: '-150 0' // Shift 150px to the left, 0px vertically.
    	   }
         
		});
		
	}
	
	$('.option').change(function(){
		cek_option();
	});
	$('.client_option').change(function(){
		cek_client_option();
	})
	
	$('#Rptoutsarapclient_from_date').change(function(){
	$('#Rptoutsarapclient_to_date').val($('#Rptoutsarapclient_from_date').val());
	})
	
	function cek_option()
	{
		if($('#option_0').is(':checked'))
		{
			$('#Rptoutsarapclient_as_at_date').attr('required',true);
			$('#Rptoutsarapclient_from_date').attr('required',false);
			$('#Rptoutsarapclient_to_date').attr('required',false);
			$('#Rptoutsarapclient_from_date').prop('disabled',true);
			$('#Rptoutsarapclient_to_date').prop('disabled',true);
			$('#Rptoutsarapclient_as_at_date').prop('disabled',false);
			$('.sortby').prop('disabled',false);
		}
		else
		{
			$('#Rptoutsarapclient_as_at_date').attr('required',true);
			$('#Rptoutsarapclient_from_date').attr('required',true);
			$('#Rptoutsarapclient_to_date').attr('required',true);
			$('#Rptoutsarapclient_from_date').prop('disabled',false);
			$('#Rptoutsarapclient_to_date').prop('disabled',false);
			$('#Rptoutsarapclient_as_at_date').prop('disabled',false);
			$('.sortby').prop('disabled',true);
		}
	}
	function cek_client_option()
	{
		if($('#client_option_0').is(':checked'))
		{
			$('#Rptoutsarapclient_client_cd').prop('disabled',true);
			$('#Rptoutsarapclient_client_cd').val('');
		}
		else
		{
			$('#Rptoutsarapclient_client_cd').prop('disabled',false);
			
		}
	}
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');
	})
	
	$(window).resize(function()
	{
		$("#iframe").offset({left:2});
		$("#iframe").css('width',($(window).width()));
	});
	
</script>