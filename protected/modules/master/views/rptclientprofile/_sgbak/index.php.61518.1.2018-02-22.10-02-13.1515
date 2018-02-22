<style>
	.help-inline.error{display: none;}
	.radio.inline {margin-right: 15px;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>


<?php
$this->breadcrumbs=array(
	'Client Profile',
);
?>
<?php
$this->menu=array(
	array('label'=>'Client Profile', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
);

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'RptClientProfile-form',
	 'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<br />

<div id="error_msg" class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <div id="msg"></div>
</div>
	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->radioButtonListInlineRow($model, 'vp_status', AConstant::$client_status,array('class'=>'status_option')); ?>
			
	<?php echo $form->textFieldRow($model,'vp_client',array('class'=>'span2'));?>
	
	<?php echo $form->textFieldRow($model,'old_cd',array('class'=>'span2','disabled'=>'disabled'));?>
	
	<?php echo $form->dropDownListRow($model,'vp_branch',CHtml::listData(Branch::model()->findAll("approved_stat = 'A'"),'brch_cd', 'CodeAndName'),array('percent'=>'-All-','class'=>'span2','style'=>'font-family:courier;'));?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Show Report',
			'id'=>'btnSubmit'
		)); ?>
	</div>
<div id="report"></div>

    
    
<?php $this->endWidget(); ?>

<script>
	
	var status='';
	init();
	function init()
	{
		getClientStatus();
		getClient();
		getOldCode();
		$('#error_msg').hide();
	}
	
	$('.status_option').change(function()
	{
		getClientStatus();
		
	})
	function getClientStatus()
	{

		if( $('#Rptclientprofile_vp_status_0').is(':checked'))
			{
				status='%';
			}
			else if($('#Rptclientprofile_vp_status_1').is(':checked'))
			{
				status='N';
			}
			else if($('#Rptclientprofile_vp_status_2').is(':checked'))
			{
				status='C';
			}
			else if($('#Rptclientprofile_vp_status_3').is(':checked'))
			{
				status='Y';
			}
	}
	

	
	function getClient()
	{
		var result = [];
		$('#Rptclientprofile_vp_client').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getclient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,		
		        						'status':status        						
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
	            	if(!match)
	            	{
	            	    alert('Client tida ditemukan')
	            	    $('#Rptclientprofile_vp_client').val('');
	            	}
	            }
	        },
		  minLength: 0,
		  open: function() 
		  { 
			        $(this).autocomplete("widget").width(400);
			        $(this).autocomplete("widget").css('overflow-y','scroll');
			         $(this).autocomplete("widget").css('max-height','250px');
			          $(this).autocomplete("widget").css('font-family','courier');
		  },
		       
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
		
	}
	function getOldCode()
	{
		var result = [];
		$('#Rptclientprofile_old_cd').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('GetOldCd'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,		
		        						'status':status        						
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
		  open: function() 
		  { 
			        $(this).autocomplete("widget").width(500);
			        $(this).autocomplete("widget").css('overflow-y','scroll');
			         $(this).autocomplete("widget").css('max-height','250px');
			          $(this).autocomplete("widget").css('font-family','courier');
		  },
		
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });;
		
	}
	
		$('#btnSubmit').click(function(e){
			e.preventDefault();
			var client_cd = $('#Rptclientprofile_vp_client').val();
			if($('#Rptclientprofile_vp_client').val()=='')
			{
			    $('#error_msg').show();
			    $('#msg').html('<b>Client Code tidak boleh kosong</b>');
			}
			 $.ajax({
				type:"POST",
				url:'<?php echo $this->createUrl('index')?>',
				data:$("#RptClientProfile-form").serialize(),
				dataType: 'html',
				success: function(response)
            			{
            			      $('#report').html(response);   
            			}
			});
		})
		
	
	
</script>
