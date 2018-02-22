<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Rincian Piutang NPR Lewat Jatuh Tempo (VD51 Baris 103)' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Rincian Piutang NPR Lewat Jatuh Tempo (VD51 Baris 103)',
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
				<?php echo $form->textField($model,'end_date',array('readonly'=>false,'class'=>'span6 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		<div class="control-group">
		    <div class="span2">Show</div>
		    <div class="span10">
		        <input type="radio" name="Rptmkbdvd51baris103[option]" value="0" <?php echo $model->option=='0'?'checked':'';?>/>&nbsp;Detail Piutang NPR  
		    </div>
		</div>
		<div class="control-group">
            <div class="span10 offset2">
                <input type="radio" name="Rptmkbdvd51baris103[option]" value="1" <?php echo $model->option=='1'?'checked':'';?>/>&nbsp;Rincian Efek  
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
<iframe id="report" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>
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
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled','disabled');
		}
	}
	
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');
	})
	
	$(window).resize(function()
	{
		$("#report").offset({left:3});
		$("#report").css('width',($(window).width()-3));
	});
	$(window).resize();
</script>
