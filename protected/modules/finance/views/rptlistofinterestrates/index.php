<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Report List of Interest Rates' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Report List of Interest Rates',
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
<br/>
<div class="row-fluid">
	<div class="control-group">
		Effective Date&nbsp;
		<?php echo $form->textField($model,'end_date',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate','required'=>true)); ?>
	</div>
	<br/>
	<div class="control-group">
		<div class="span4">
			<div class="control-group">
				<div class="span9">
					<div class="control-group">
						Option
						<br/>
						<input type="radio" name="Rptlistofinterestrates[opt]" class="opt" value="0" <?php echo $model->opt=='0'?'checked':'' ?>/> &nbsp; All
						<br/>
						<input type="radio" name="Rptlistofinterestrates[opt]" class="opt" value="1" <?php echo $model->opt=='1'?'checked':'' ?>/> &nbsp; without 'manual calculated' client
						<br/>
						<input type="radio" name="Rptlistofinterestrates[opt]" class="opt" value="2" <?php echo $model->opt=='2'?'checked':'' ?>/> &nbsp; Manually calculated interest only
						<br/>
						<input id="notDefault" type="radio" name="Rptlistofinterestrates[opt]" class="opt" value="3" <?php echo $model->opt=='3'?'checked':'' ?>/> &nbsp; Rate tidak sama dengan default
						<br/>
						<input id="default" type="radio" name="Rptlistofinterestrates[opt]" class="opt" value="4" <?php echo $model->opt=='4'?'checked':'' ?>/> &nbsp; Default Rate
					</div>
				</div>
				
				<div class="span3">
					<div class="control-group">
						Client Type
						<br/>
						<input type="radio" id="opt_mt1" name="Rptlistofinterestrates[opt_mt]" value="0" <?php echo $model->opt_mt=='0'?'checked':'' ?>/> &nbsp; All types
						<br/>
						<input type="radio" id="opt_mt2" name="Rptlistofinterestrates[opt_mt]" value="1" <?php echo $model->opt_mt=='1'?'checked':'' ?>/> &nbsp; Margin
						<br/>
						<input type="radio" id="opt_mt3" name="Rptlistofinterestrates[opt_mt]" value="2" <?php echo $model->opt_mt=='2'?'checked':'' ?>/> &nbsp; Reguler
						<br/>
						<input type="radio" id="opt_mt4" name="Rptlistofinterestrates[opt_mt]" value="3" <?php echo $model->opt_mt=='3'?'checked':'' ?>/> &nbsp; Deposit
					</div>
				</div>
			</div>
		</div>
		
		<div class="span6">
			
			<div class="control-group">
				<div class="span2">Client Status</div>
				<div class="span2"><input type="radio" id="opt_sts1" name="Rptlistofinterestrates[opt_sts]" value="0" <?php echo $model->opt_sts=='0'?'checked':'' ?>/> &nbsp; Active</div>
				<div class="span3"><input type="radio" id="opt_sts2" name="Rptlistofinterestrates[opt_sts]" value="1" <?php echo $model->opt_sts=='1'?'checked':'' ?>/> &nbsp; All</div>
			</div>
			
			<div class="control-group">
				<div class="span2">Client Code</div>
				<div class="span2"><?php echo $form->checkBox($model,'opt_clt',array('id'=>'clt1','value'=>'1')) ?> &nbsp; All</div>
				<div class="span3">Selected Client</div>
				<?php echo $form->textField($model,'bgn_clt',array('id'=>'clt2','class'=>'span3'))?>
			</div>
			
			<div class="control-group">
				<div class="span2">Branch</div>
				<div class="span2"><?php echo $form->checkBox($model,'opt_branch',array('id'=>'brch1','value'=>'1')) ?> &nbsp; All</div>
				<div class="span3">Selected Branch</div>
				<?php echo $form->dropdownList($model, 'bgn_branch',CHtml::listData($mbranch, 'brch_cd', 'brch_name'),array('id'=>'brch2','class'=>'span3','prompt'=>'-- Select Branch --'))?>
			</div>
		
		</div>
	</div>

	<div class="control-group">
		<div class="span3">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Show Report',
				'id'=>'btnProcess'
			)); ?>
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
		optionclient_CD();
		optionbranch_CD();
	}
	
	$('.opt').click(function(){
		optDefault();
	})
	
	function optDefault()
	{	
		if($('#default,#notDefault').is(':checked')){
			$('#toDt').attr('disabled',true);
			$('#opt_mt1').attr('disabled',true);
			$('#opt_mt2').attr('disabled',true);
			$('#opt_mt3').attr('disabled',true);
			$('#opt_mt4').attr('disabled',true);
			$('#opt_sts1').attr('disabled',true);
			$('#opt_sts2').attr('disabled',true);
			$('#clt1').attr('disabled',true);
			$('#clt2').attr('disabled',true);
			$('#brch1').attr('disabled',true);
			$('#brch2').attr('disabled',true);
		}else{
			$('#toDt').attr('disabled',false);
			$('#opt_mt1').attr('disabled',false);
			$('#opt_mt2').attr('disabled',false);
			$('#opt_mt3').attr('disabled',false);
			$('#opt_mt4').attr('disabled',false);
			$('#opt_sts1').attr('disabled',false);
			$('#opt_sts2').attr('disabled',false);
			$('#clt1').attr('disabled',false);
			$('#clt2').attr('disabled',false);
			$('#brch1').attr('disabled',false);
			$('#brch2').attr('disabled',false);
		}		
	}
	
	$('#clt1').click(function(){
		optionclient_CD();
	})
	
	function optionclient_CD()
	{	
		
		var client_CD=$('input:checkbox[name="Rptlistofinterestrates[opt_clt]"]:checked').val();
		var isclient_CD=(client_CD==='1');
		$('#clt2').attr('disabled',isclient_CD);
			
	}
	
	$('#brch1').click(function(){
		optionbranch_CD();
	})
	
	function optionbranch_CD()
	{	
		
		var branch_CD=$('input:checkbox[name="Rptlistofinterestrates[opt_branch]"]:checked').val();
		var isbranch_CD=(branch_CD==='1');
		$('#brch2').attr('disabled',isbranch_CD);
			
	}

	function getClient()
	{
		var result = [];
		$('#clt2').autocomplete(
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
