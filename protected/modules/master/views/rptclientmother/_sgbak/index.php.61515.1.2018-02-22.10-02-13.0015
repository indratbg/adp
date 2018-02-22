<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Clients Mother' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => "List of Client's Mother Name",
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

<?php 
	AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<br />
<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>Client Status</label>
			</div>
			<div class="span2">		
				<input type="radio" id="client_status_0" class="client_status" <?php echo $model->client_status=='0'?'checked':'' ?> value="0" name="Rptclientmother[client_status]"/>&nbsp All
			</div>
			<div class="span2">				
				<input type="radio" id="client_status_1" class="client_status" <?php echo $model->client_status=='1'?'checked':'' ?> value="1" name="Rptclientmother[client_status]"/>&nbsp Active
			</div>
			<div class="span2">
				<input type="radio" id="client_status_2" class="client_status" <?php echo $model->client_status=='2'?'checked':'' ?> value="2" name="Rptclientmother[client_status]"/>&nbsp Inactive
			</div>
			<div class="span2">				
				<input type="radio" id="client_status_3" class="client_status" <?php echo $model->client_status=='3'?'checked':'' ?> value="3" name="Rptclientmother[client_status]"/>&nbsp Specified
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Client Cd</label>
			</div>
			<div class="span3">
				<?php 
					 echo $form->textField($model, 'client_cd', array('id'=>'Rptclientmother_client_cd','class' => 'span12')); 
				?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>All Branch</label>
			</div>
			<div class="span2">
				<?php echo $form->radioButton($model, 'branch_status', array(
					'value' => '0',
					'class' => 'branch_status',
					'id' => 'branch_status_0'
				)) . "&nbsp All"; ?>
			</div>
			<div class="span2">
				<?php
					echo $form->radioButton($model, 'branch_status', array(
						'value' => '1',
						'class' => 'branch_status',
						'id'	=> 'branch_status_1'
					)) . "&nbsp Specified";
				?>
			</div>
			</div>
		<div class="control-group">
			<div class="span3">
				<label>Branch Code</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model, 'branch_cd', CHtml::listData(Branch::model()->findAll(array(
					'select' => "brch_cd, brch_cd||' - '||brch_name brch_name",
					'condition' => " approved_stat='A'",
					'order' => 'brch_cd'
				)), 'brch_cd', 'brch_name'), array(
					'id'=>'Rptclientmother_branch_cd',
					'class' => 'span10',
					'prompt' => '-Select-',
					'style' => 'font-family:courier'
				));
				?>
			</div>
		</div><hr/>
		<div class="control-group">
			<div class="span5">

<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label' => 'Show Report',
		'type' => 'primary',
		'id' => 'btnPrint',
		'buttonType' => 'submit',
	));
 ?>
			</div>
		</div>
	</div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
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
/*
	var glAcctCd='%';
	var url_xls = '<?php echo $url_xls ?>';*/

	init();
	function init()
	{
		getClient();
		clientStatusOption();
		BranchCdOption();
	}
function getClient()
	{
		var result = [];
		$('#Rptclientmother_client_cd').autocomplete(
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

	$('#btnPrint').click(function(){
		$('#mywaitdialog').dialog('open');
	})
	
	$('.client_status').change(function(){
		clientStatusOption();
	})
	
	$('.branch_status').change(function(){
		BranchCdOption();
	})
	
	function clientStatusOption(){
		if($('#client_status_3').is(':checked')){
			$('#Rptclientmother_client_cd').attr('disabled',false);
		}
		else{
			$('#Rptclientmother_client_cd').attr('disabled',true);
			$('#Rptclientmother_client_cd').val("");
		}
	}
	
	function BranchCdOption(){
		if($('#branch_status_1').is(':checked')){
			$('#Rptclientmother_branch_cd').attr('disabled',false);
		}
		else{
			$('#Rptclientmother_branch_cd').attr('disabled',true);
			$('#Rptclientmother_branch_cd').val('');
		}
	}
</script>
