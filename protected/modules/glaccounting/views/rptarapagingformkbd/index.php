<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'AR / AP aging for MKBD' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'AR / AP aging for MKBD',
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
			<div class="span2">
				<label>Date</label>
			</div>
			<div class="span5">
				<?php echo $form->textField($model,'end_date',array('class'=>'span6 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="span2">
				<label>Branch</label>
			</div>
			<div class="span2">
				<?php echo $form->radioButton($model,'branch_option',array('value'=>'0','class'=>'branch_option','id'=>'branch_option_1'));?> &nbsp; All
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'branch_option',array('value'=>'1','class'=>'branch_option','id'=>'branch_option_1'));?>&nbsp; Specified
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'branch_cd',CHtml::listData($branch_cd, 'brch_cd', 'brch_name'),array('class'=>'span10','prompt'=>'-Select-','style'=>'font-family:courier'));?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="span6">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'submit',
					'type' => 'primary',
					'label' => 'Show',
					'id' => 'btnSubmit'
				));
				?>
			&emsp;
				<button formaction="<?php echo $url_xls ?>" id="btn_xls" class="btn btn-primary">Save to Excel</button>
			</div>
		</div>
		
	</div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'style'=>'display:none'));?>
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
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		optionBranch();
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled','disabled');
		}
	}
	
	$('.branch_option').change(function(){
	optionBranch();
	});
	
	function optionBranch()
	{
		if($('#branch_option_1').is(':checked'))
		{
			$('#Rptarapagingformkbd_branch_cd').prop('disabled',true);
		}
		else
		{
		$('#Rptarapagingformkbd_branch_cd').prop('disabled',false);	
		}
	}
	
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');
	})
</script>
