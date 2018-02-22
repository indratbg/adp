<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Journal List' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Journal List',
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
<br />
<?php echo $form->errorSummary(array($model));?>
<input type="hidden" name="scenario" id="scenario" />
<div class="row-fluid">
	<div class="span6">
	<div class="control-group">
		<div class="span1">
			<label>Date</label>
		</div>
		<div class="span4">
			<?php echo $form->textField($model,'from_date',array('class'=>'span8 tdate','placeholder'=>'dd/mm/yyyy'));?>
			<?php echo $form->textField($model,'vo_random_value',array('style'=>'display:none'));?>
		</div>
		<div class="span1">
			<label>To</label>
		</div>
		<div class="span4">
			<?php echo $form->textField($model,'to_date',array('class'=>'span8 tdate','placeholder'=>'dd/mm/yyyy'));?>
		</div>
	</div>
	<div class="control-group">
		<div class="span1">
			<label>Type</label>
		</div>
		<div class="span6">
			<input type="radio" name="Rptjournallist[type]" value="0" <?php echo $model->type=='0'?'checked':'';?> />&nbsp; All (w/o Cancelled + reversal)
		</div>
	</div>
	<div class="control-group">
		<div class="span5 offset1">
			<input type="radio" name="Rptjournallist[type]" value="1" <?php echo $model->type=='1'?'checked':'';?> />&nbsp; Transaction
		</div>
	</div>
	<div class="control-group">
		<div class="span5 offset1">
			<input type="radio" name="Rptjournallist[type]" value="2" <?php echo $model->type=='2'?'checked':'';?> />&nbsp;  Cancelled + reversal
		</div>
	</div>
	<div class="control-group">
		<div class="span5">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'OK',
					'id'=>'btnPrint'
				)); ?>
				&emsp;
			<?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Save to Excel',
                    'id'=>'btn_xls'
                )); ?>
		</div>
	</div>
	</div>
	<div class="span6">
		
	</div>
</div><br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>

<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'disabled'=>'disabled','style'=>'display:none'));?>
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
	var url_xls = '<?php echo $url ?>';
	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
	$('#Rptjournallist_from_date').change(function(){
		$('#Rptjournallist_to_date').val($('#Rptjournallist_from_date').val());
		$('.tdate').datepicker('update');
	})
    $('#btnPrint').click(function(){
		$('#mywaitdialog').dialog('open');
		$('#scenario').val('print');
	})
	$('#btn_xls').click(function() {
		$('#scenario').val('export');
	});
	
</script>
