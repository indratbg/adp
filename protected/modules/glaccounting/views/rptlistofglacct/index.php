<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Report List of GL Account' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Report List of GL Account',
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
	<div class="span2">
		<div class="control-group">
			Report Selection
			<br/>
			<input type="radio" id="arap1" name="Rptlistofglacct[arap]" value="A" <?php echo $model->arap=='A'?'checked':'' ?>/> &nbsp; All
			<br/>
			<input type="radio" id="arap2" name="Rptlistofglacct[arap]" value="N" <?php echo $model->arap=='N'?'checked':'' ?>/> &nbsp; Without AR/AP accounts
			<br/>
			<input type="radio" id="arap3" name="Rptlistofglacct[arap]" value="Y" <?php echo $model->arap=='Y'?'checked':'' ?>/> &nbsp; AR/AP account only
		</div>
	</div>
	<div class="span2">
		<div class="control-group">
			Account Status
			<br/>
			<input type="radio" id="acct_sts1" name="Rptlistofglacct[acct_stat]" value="ALL" <?php echo $model->acct_stat=='ALL'?'checked':'' ?>/> &nbsp; All
			<br/>
			<input type="radio" id="acct_sts2" name="Rptlistofglacct[acct_stat]" value="A" <?php echo $model->acct_stat=='A'?'checked':'' ?>/> &nbsp; Active
			<br/>
			<input type="radio" id="acct_sts2" name="Rptlistofglacct[acct_stat]" value="C" <?php echo $model->acct_stat=='C'?'checked':'' ?>/> &nbsp; Closed
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span1">

			</div>
			<div class="span2">
				<label>Main</label>
			</div>
			<div class="span5">
				<label>Sub</label>
			</div>
		</div>
		<div class="control-group">
			<div class="span1">
				<label>From</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model,'rpt_bgn_acct',CHtml::listData($gl_a, 'gl_a', 'acct_name'),array('class'=>'span12','style'=>'font-family:courier;','prompt'=>'-ALL-'));?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'rpt_bgn_sub', array('class' => 'span12')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model,'rpt_end_acct',CHtml::listData($gl_a, 'gl_a', 'acct_name'),array('class'=>'span12','style'=>'font-family:courier;','prompt'=>'-ALL-'));?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'rpt_end_sub', array('class' => 'span12')); ?>
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

	var glAcctCd='';
	init();
	function init()
	{
		getSla(glAcctCd);
	}
		
	$('#Rptlistofglacct_rpt_bgn_acct').change(function(){
		var glAcctCd = $('#Rptlistofglacct_rpt_bgn_acct').val();
		getSla(glAcctCd);
	});
	
	$('#Rptlistofglacct_rpt_end_acct').change(function(){
		var glAcctCd = $('#Rptlistofglacct_rpt_end_acct').val();
		getSla(glAcctCd);
	})
	
	$('#Rptlistofglacct_rpt_bgn_acct').change(function(){
		$('#Rptlistofglacct_rpt_bgn_acct').val($('#Rptlistofglacct_rpt_bgn_acct').val().toUpperCase());
		$('#Rptlistofglacct_rpt_end_acct').val($('#Rptlistofglacct_rpt_bgn_acct').val().toUpperCase());
	});
	$('#Rptlistofglacct_rpt_bgn_sub').blur(function(){
		$('#Rptlistofglacct_rpt_end_sub').val($('#Rptlistofglacct_rpt_bgn_sub').val().toUpperCase());
	});
	$('#Rptlistofglacct_rpt_end_sub').change(function(){
		$('#Rptlistofglacct_rpt_end_sub').val($('#Rptlistofglacct_rpt_end_sub').val().toUpperCase());
	});
	$('#Rptlistofglacct_rpt_end_sub').change(function(){
		$('#Rptlistofglacct_rpt_end_sub').val($('#Rptlistofglacct_rpt_end_sub').val().toUpperCase());
	});
	
	function getSla(glAcctCd)
	{
		var result = [];
		$('#Rptlistofglacct_rpt_bgn_sub,#Rptlistofglacct_rpt_end_sub').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getsla'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						'gl_acct_cd' : glAcctCd
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
			    } 
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
	}
</script>
