<style>
	input[type=radio] {
		margin-top: -3px;
	}
	.radio, .checkbox {
    min-height: 20px;
    padding-left: 10px;
}
</style>
<?php
$this->breadcrumbs = array(
	'List of Stock Movement' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'List of Stock Movement',
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


<?php AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<br />
<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>Date From</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'bgn_date', array(
					'id'=>'fromDt',
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
				?>
			</div>
			<div class="span2">
				<label>To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'end_date', array(
					'id'=>'toDt',
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
				?>
			</div>
		</div>
	
		<div class="control-group">
			<div class="span3">
				<label>Client</label>
			</div>
			<div class="span2">
				<input type="radio" class="option_client_cd" id="option_client_cd_0" name="Rptstkmovement[option_client_cd]" value="0" <?php echo $model->option_client_cd=='0'?'checked':'' ?>/> &nbsp; All
			</div>
			<div class="span3">
				<input type="radio" class="option_client_cd" id="option_client_cd_1" name="Rptstkmovement[option_client_cd]" value="1" <?php echo $model->option_client_cd=='1'?'checked':'' ?>/> &nbsp; Specified
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'client_cd',array('class'=>'span10'));?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="span3">
				<label>Stock Code</label>
			</div>
			<div class="span2">
				<input type="radio" class="option_stk_cd" id="option_stk_cd_0" name="Rptstkmovement[option_stk_cd]" value="0" <?php echo $model->option_stk_cd=='0'?'checked':'' ?>/> &nbsp; All
			</div>
			<div class="span3">
				<input type="radio" class="option_stk_cd" id="option_stk_cd_1" name="Rptstkmovement[option_stk_cd]" value="1" <?php echo $model->option_stk_cd=='1'?'checked':'' ?>/> &nbsp; Specified
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'stk_cd',CHtml::listData($mStk,'stk_cd', 'stk_desc'),array('class'=>'span10','prompt'=>'- Pilih Stock Code -'));?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="span3">
				<label>Show Journal Number</label>
			</div>
			<div class="span2">
				<input type="checkbox" class="show_journal" id="show_journal" name="Rptstkmovement[show_jur]" value="Y" <?php echo $model->show_jur=='Y'?'checked':'' ?>/>
			</div>	
		</div>
		
		<div class="control-group">
			<div class="span5">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'label' => 'OK',
						'type' => 'primary',
						'id' => 'btnPrint',
						'buttonType' => 'submit',
					));
				 ?>
			</div>
		</div>
	</div>
	
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>Movement Type</label>
			</div>
			<div class="span4">
				<?php echo $form->checkBoxRow($model, 'p_type1',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_type2',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_type3',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_type4',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_typea',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_typeb',array('value'=>1))?>
		        <?php echo $form->checkBoxRow($model, 'p_typec',array('value'=>1))?>                                                                    
			</div>                                                                  
			<div class="span4">                                                     
				<?php echo $form->checkBoxRow($model, 'p_typed',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_type5',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_typee',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_typef',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_typeg',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_typeh',array('value'=>1))?>
				<?php echo $form->checkBoxRow($model, 'p_type6',array('value'=>1))?>
			</div>
		</div>
	</div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'style'=>'display:none'));?>
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

	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		getClient();
		option_client();
		option_stk();
		// updateDate();
	}


	$('#fromDt').change(function(){
		updateDate();
	    //alert('dd');
	})
	
	function updateDate(){
		var tgl = $('#fromDt').val(); 
	    var dd = tgl.slice(0, 2);
	    var mm = tgl.slice(3, 5);
	    var yyyy = tgl.slice(6, 10);
	 	var lastDate  = new Date(yyyy, mm, 0);
		$("#toDt").val(lastDate.getDate() + '/' + ('0'+(lastDate.getMonth()+1)).slice(-2) + '/' + lastDate.getFullYear());
		$("#toDt").datepicker("update");
	}

	function getClient()
	{
		var result = [];
		$('#Rptstkmovement_client_cd').autocomplete(
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
	
	$('#Rptstkmovement_bgn_date').change(function(){
		$('#Rptstkmovement_end_date').val($('#Rptstkmovement_bgn_date').val());
	})
	$('#Rptstkmovement_bank_cd').change(function(){
		$('#Rptstkmovement_bank_cd').val($('#Rptstkmovement_bank_cd').val().toUpperCase());
	})
	$('.option_client_cd').change(function(){
		option_client();	
	});
	function option_client()
	{
		if($('#option_client_cd_1').is(':checked'))
		{
			$('#Rptstkmovement_client_cd').prop('disabled',false);
		}
		else
		{
			$('#Rptstkmovement_client_cd').prop('disabled',true);
		}
	}
	$('.option_stk_cd').change(function(){
		option_stk();	
	});
	function option_stk()
	{
		if($('#option_stk_cd_1').is(':checked'))
		{
			$('#Rptstkmovement_stk_cd').prop('disabled',false);
		}
		else
		{
			$('#Rptstkmovement_stk_cd').prop('disabled',true);
		}
	}
</script>
