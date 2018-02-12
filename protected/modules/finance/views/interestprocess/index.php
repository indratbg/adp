<?php

$this->breadcrumbs=array(
	'Interest Process'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Interest Process', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'processDepFixAsset-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	
	<?php echo $form->errorSummary($model); ?>
	<?php AHelper::showFlash($this) ?> 
	<input type="hidden" name="cancel_posted_int" id="cancel_posted_int" />
	 <br/>
	 
	 <div class="row-fluid">
	 	<div class="span6">
	 		<div class="control-group">
	 			<div class="span3">
	 				<label>Process</label>
	 			</div>
	 			<div class="span3">
	 				<input type="radio" name="Interestprocess[process_option]" class="process_option" id="process_option_0" value="0" <?php echo $model->process_option=='0'?'checked':'';?> /> &nbsp; Calculate
	 			</div>
	 			<div class="span3">
	 				<input type="radio" name="Interestprocess[process_option]" class="process_option" id="process_option_1" value="1" <?php echo $model->process_option=='1'?'checked':'';?> /> &nbsp; Posting
	 			</div>
	 			<div class="span3">
	 				<input type="radio" name="Interestprocess[process_option]" class="process_option" id="process_option_2" value="2" <?php echo $model->process_option=='2'?'checked':'';?> /> &nbsp; View / Print
	 			</div>
	 		</div>

			<div class="control-group mode_rpt">
	 			<div class="span3">
	 				<label class="mode_rpt">View</label>
	 			</div>
	 			<div class="span3">
	 				<input type="radio" name="Interestprocess[mode_rpt]" class="mode_rpt" id="mode_rpt_0" value="0" <?php echo $model->mode_rpt=='0'?'checked':'';?> /> &nbsp; All
	 			</div>
	 			<div class="span3">
	 				<input type="radio" name="Interestprocess[mode_rpt]" class="mode_rpt" id="mode_rpt_1" value="1" <?php echo $model->mode_rpt=='1'?'checked':'';?> /> &nbsp; 8%
	 			</div>
	 			<div class="span3">
	 				<input type="radio" name="Interestprocess[mode_rpt]" class="mode_rpt" id="mode_rpt_2" value="2" <?php echo $model->mode_rpt=='2'?'checked':'';?> /> &nbsp; 10%
	 			</div>
	 		</div>
	 
	 		<div class="control-group">
	 			<div class="span3">
	 				<label>Client</label>
	 			</div>
	 			<div class="span3">
	 				<input type="radio" name="Interestprocess[client_option]" class="client_option" id="client_option_0" value="0" <?php echo $model->client_option=='0'?'checked':'';?> /> &nbsp; All
	 			</div>
	 			<div class="span3">
	 				<input type="radio" name="Interestprocess[client_option]" class="client_option" id="client_option_1"  value="1" <?php echo $model->client_option=='1'?'checked':'';?> /> &nbsp; Specified
	 			</div>
	 			<div class="span3">
	 				<?php echo $form->textField($model,'client_cd',array('class'=>'span12'));?>
	 			</div>
	 		</div>
	 		<div class="control-group">
	 			<div class="span3">
	 				<label>Branch</label>
	 			</div>
	 			<div class="span3">
	 				<input type="radio" name="Interestprocess[branch_option]" class="branch_option" id="branch_option_0" value="0" <?php echo $model->branch_option=='0'?'checked':'';?> /> &nbsp; All
	 			</div>
	 			<div class="span3">
	 				<input type="radio" name="Interestprocess[branch_option]" class="branch_option" id="branch_option_1"  value="1" <?php echo $model->branch_option=='1'?'checked':'';?> /> &nbsp; Specified
	 			</div>
	 			<div class="span3">
	 				<?php echo $form->dropDownList($model,'brch_cd',CHtml::listData($branch_cd, 'brch_cd', 'brch_name'),array('prompt'=>'-Select-','class'=>'span12','style'=>'font-family:courier'));?>
	 			</div>
	 		</div>
	 		<div class="control-group">
	 			<div class="span3">
	 				<label>For the month of</label>
	 			</div>
	 			<div class="span3">
	 				<?php echo $form->dropDownList($model,'month',AConstant::getArrayMonth(),array('id'=>'month','class'=>'span12')) ?>
	 			</div>
	 			<div class="span3">
	 				<label>Year</label>
	 			</div>
	 			<div class="span3">
	 				<?php echo $form->dropDownList($model,'year',AConstant::getArrayYear(),array('id'=>'year','class'=>'span12')) ?>
	 			</div>
	 		</div>
	 		<div class="control-group">
	 			<div class="span3">
	 				<label>Due Date From</label>
	 			</div>
	 			<div class="span3">
	 				<?php echo $form->textField($model,'from_due_dt',array('id'=>'fromDueDt','readonly'=>false,'placeholder'=>'dd/mm/yyyy','class'=>'span12 tdate','required'=>true)); ?>
	 			</div>
	 			<div class="span3">
	 				<label>To</label>
	 			</div>
	 			<div class="span3">
	 				<?php echo $form->textField($model,'to_due_dt',array('id'=>'toDueDt','readonly'=>false,'placeholder'=>'dd/mm/yyyy','class'=>'span12 tdate','required'=>true)); ?>
	 			</div>
	 		</div>	 		
	 	</div>
	 	<div class="span6">
	 		<div class="control-group">
	 			<div class="span4">
	 				<input type="radio" name="Interestprocess[process_option]" class="process_option" id="process_option_3" value="3" <?php echo $model->process_option=='3'?'checked':'';?> /> &nbsp; Posting Month End
	 			</div>
	 		</div>
	 		<div class="control-group">
	 			<div class="span7">
	 				<?php echo $form->textField($model,'client_nm',array('id'=>'client_Name','readonly'=>true,'class'=>'clientName span12'));?>
	 			</div>
	 			<div class="span2">
	 				<?php echo $form->textField($model,'client_type',array('id'=>'client_Type','readonly'=>true,'class'=>'clientType span12'));?>
	 				<?php echo $form->textField($model,'client_type_3',array('style'=>'display:none'));?>
	 			</div>
	 			<div class="span3">
	 				<?php echo $form->textField($model,'cl_desc',array('readonly'=>true,'class'=>'span12'));?>
	 			</div>
	 		</div>
	 		<div class="control-group">
	 			<div class="span2">
	 				<label id="amt_int_flg"><?php echo $model->amt_int_flg?$model->amt_int_flg:''; ?></label>
	 				<?php echo $form->textField($model,'amt_int_flg',array('style'=>'display:none'));?>
	 			</div>
	 		</div>
	 		<div class="control-group">
	 		</div>
	 		<div class="control-group">
	 			<div class="span2">
	 				<label>Journal</label>
	 			</div>
	 			<div class="span3">
	 				<?php echo $form->textField($model,'journal_date',array('placeholder'=>'dd/mm/yyyy','class'=>'span12 tdate')); ?>
	 				
	 			</div>
	 			<div class="span2">
	 				<label>Closed</label>
	 			</div>
	 			<div class="span3">
	 				<?php echo $form->textField($model,'closing_dt',array('id'=>'closingDt','placeholder'=>'dd/mm/yyyy','class'=>'span12 tdate','required'=>true)); ?>
	 			</div>
	 		</div>
	 		
	 	</div>
	 </div>
	 

	
	<div class="control-group">
		<div class="span2">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Process',
			'id'=>'btnProcess',
			//'htmlOptions'=>array("class"=>"control-group",'disabled'=>$flag=='Y'?true:false,'style'=>$flag=='Y'?'opacity:0.2':'opacity:1'),
		)); ?>
		</div>
		
	</div>
	<br />
	<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
	
	<?php echo $form->datePickerRow($model,'dummy_dt',array('label'=>false,'style'=>'display:none')) ?>
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


<script type="text/javascript" charset="utf-8">

	var authorizedSpv = true;
	var authorizedNonSpv=true;
	var authorizedPosting =true;
	var branch_flg = '<?php echo $branch_flg ;?>';
	
	init();
	
	$(document).ready(function()
	{
		$(".tdate").datepicker({format:'dd/mm/yyyy'});
		getClient();
		option_client();
		option_branch();
		getDefaultDate();
		if(!checkPostingMonthEnd())
		{
			$('#process_option_3').prop('disabled',true);
		}
		
		if(branch_flg=='N')
		{
			$('.branch_option').prop('disabled',true);
			$('#Interestprocess_brch_cd').prop('disabled',true);
			$('#branch_option_0').prop('checked',true);
		}
		
		//IF SUPERVISOR DISABLE POSTING OPTION
		if(checkPostingMonthEnd())
		{
		    $('#process_option_3').prop('disabled',false);
		}
		else
		{
		    $('#process_option_3').prop('disabled',true);
		}
		//if non supervoisor disable month end option
		if(checkNonSpv())
		{
		     $('#process_option_1').prop('disabled',false);
		}
		else
		{
		   $('#process_option_1').prop('disabled',true);   
		}
		
		
	});
	
	function init(){
		if($('#process_option_2').is(':checked')){
			$('.mode_rpt').show();
		}else{
			$('.mode_rpt').hide();
		}
	}
	
	function getClient()
	{
		var result = [];
		$('#Interestprocess_client_cd').autocomplete(
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
		}).blur(function()
        {
        	$(this).val($(this).val().toUpperCase());
        	var inputVal = $(this).val();
        	var client_name='';
        	var client_type='';
        	var client_type_desc='';
        	var amt_int_flg ='';
        	var amt_int_flg_desc ='';
        	var client_type_3='';
        	var branch_cd = '';
        	$.each(result,function()
        	{
        		if(this.value.toUpperCase() == inputVal)
        		{
        			client_name = this.client_name
        			client_type=this.cl_type;
        			client_type_desc=this.cl_desc;
        			amt_int_flg =this.amt_int_flg;
        			client_type_3 = this.client_type_3;
        			branch_cd = this.branch_cd;
        			
        		}
        	});
        	
			if(amt_int_flg=='N')amt_int_flg_desc='Off BS';
			
        	$('#client_Name').val(client_name);
        	$('#client_Type').val(client_type);
        	$('#amt_int_flg').text(amt_int_flg_desc);
        	$('#Interestprocess_cl_desc').val(client_type_desc);
        	$('#Interestprocess_client_type_3').val(client_type_3);
        	if('<?php echo $branch_flg?>'=='Y')
        	{
        		$('#Interestprocess_brch_cd').val(branch_cd);
        	}
        });
	}
	
	
	function checkSpv()
	{
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ajxValidateSpv'); ?>',
				'dataType' : 'json',
				'statusCode':
				{
					403		: function(data){
						authorizedSpv = false;
					}
				},
				'async':false
			});
			
			return authorizedSpv;
	}
	   function checkNonSpv()
    {
            $.ajax({
                'type'     :'POST',
                'url'      : '<?php echo $this->createUrl('ajxValidateNonSpv'); ?>',
                'dataType' : 'json',
                'statusCode':
                {
                    403     : function(data){
                        authorizedNonSpv = false;
                    }
                },
                'async':false
            });
            
            return authorizedNonSpv;
    }   		
	function checkPostingMonthEnd()
	{
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('AjxValidateMonthEndSpv'); ?>',
				'dataType' : 'json',
				'statusCode':
				{
					403		: function(data){
						authorizedPosting = false;
					}
				},
				'async':false
			});
			
			return authorizedPosting;
	}		
	
	
	
	$('.client_option').change(function(){
		option_client();
	})
	$('.branch_option').change(function(){
		option_branch();
	})

	function option_client()
	{
		if($('#client_option_1').is(':checked'))
		{
			$('#Interestprocess_client_cd').prop('disabled',false);
		}
		else
		{
			$('#Interestprocess_client_cd').prop('disabled',true);
			$('#Interestprocess_client_cd').val('');
			$('#client_Name').val('');
			$('#client_Type').val('');
			$('#Interestprocess_cl_desc').val('');
			$('#Interestprocess_brch_cd').val('');
			
		}
		if($('#client_option_0').is(':checked') && !checkSpv())
		{
			alert('You are not authorized process all client');
			$('#client_option_0').prop('disabled',true);
			$('#client_option_1').prop('disabled',false);
			$('#client_option_1').prop('checked',true);
		}
	}
	function option_branch()
	{
		if($('#branch_option_1').is(':checked'))
		{
			$('#Interestprocess_brch_cd').prop('disabled',false);
		}
		else
		{
			$('#Interestprocess_brch_cd').prop('disabled',true);
		}
	}
	$('#btnProcess').click(function(){
		
		if($('#process_option_0').is(':checked') ) 
		{
			if(CheckPostFlg()=='Y')
			{
				if(confirm('Client sudah diposting, apakah anda tetap melanjutkan/tidak ? ' )== true)
				{
					$('#mywaitdialog').dialog('open');
					$('#cancel_posted_int').val('Y');
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				$('#mywaitdialog').dialog('open');
				$('#cancel_posted_int').val('N');
				return true;
			}
		}
		else
		{
			$('#cancel_posted_int').val('N');
			$('#mywaitdialog').dialog('open');
			return true;
		}
	})
		
		$('.process_option').change(function(){
			getDefaultDate();
			if($(this).val() == 2){
				$('.mode_rpt').show();
			}else{
				$('.mode_rpt').hide();
			}
		});
		
		$('#Interestprocess_journal_date').change(function(){
			getDefaultDate();
		});
		$('#month, #year').change(function(){
			
			var date = $('#Interestprocess_journal_date').val().split('/');
			$('#Interestprocess_journal_date').val(date[0]+'/'+$('#month').val()+'/'+$('#year').val());
			
			getDefaultDate();
		});
		
		function getDefaultDate()
		{
			
			var post_flg='';
			var to_date='';
			var close_date='';
			var journal_date='';
			var from_date='';
			
			if($('#process_option_0').is(':checked'))
			{
				post_flg ='calc'; 
			}
			else if($('#process_option_1').is(':checked'))
			{
				post_flg ='post';
			}
			else if($('#process_option_2').is(':checked'))
			{
				post_flg ='view';
			}
			else if($('#process_option_3').is(':checked'))
			{
				post_flg ='post_end';
				var date = $('#Interestprocess_journal_date').val().split('/');
				$('#Interestprocess_journal_date').val('01'+'/'+$('#month').val()+'/'+$('#year').val());
				
			}
			
			$.ajax({
		    		'type'     :'POST',
		    		'url'      : '<?php echo $this->createUrl('GetEndDateBourse'); ?>',
					'dataType' : 'json',
					'data'		:{	journal_date : $("#Interestprocess_journal_date").val(),
									post_flg :post_flg
									},
					'success': function(result)
								{
									journal_date = result.journal_date;
									to_date = result.to_date;
									close_date = result.close_date;
									from_date = result.from_date;
									$('#fromDueDt').val(from_date);
									$('#toDueDt').val(to_date);
									$('#closingDt').val(close_date);
									$('#Interestprocess_journal_date').val(journal_date);
								}
					,
					'async':false
				});
			
			if($('#process_option_3').is(':checked') && !checkPostingMonthEnd())
			{
				alert('You are not authorized to perform this action.');
				$('#process_option_3').prop('disabled',true);		
				$('#process_option_1').prop('checked',true);
			}
			if($('#process_option_3').is(':checked') && checkPostingMonthEnd())
			{
				$('#process_option_3').prop('disabled',false);		
			}
		
				$('.tdate').datepicker('update');
		}
		
		function CheckPostFlg()
		{
			var post_flg = 'N';
			if($('#process_option_0').is(':checked'))
			{
					$.ajax({
			    		'type'     :'POST',
			    		'url'      : '<?php echo $this->createUrl('AjxCheckPostFlg'); ?>',
						'dataType' : 'json',
						'data'		:{	bgn_date : $('#fromDueDt').val() ,
										end_date : $('#toDueDt').val(),
										client_cd : $('#Interestprocess_client_cd').val()
										},
						'success': function(result)
									{
									post_flg = result.post_flg;
									},
						'async':false
					});
			}
			return post_flg;
		}
		
</script>