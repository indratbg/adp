<?php
$this->breadcrumbs = array(
	'MKBD VD55 XE13 (Bulanan)' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'MKBD VD55 XE13 (Bulanan)',
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
		'id' => 'MKBD-vd55_xe13-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>

<?php AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<br />

<div class="row-fluid">
		<div class="control-group">
			<div class="span5">
				<?php echo $form->datePickerRow($model, 'doc_date', array(
					'prepend' => '<i class="icon-calendar"></i>',
					'placeholder' => 'dd/mm/yyyy',
					'class' => 'tdate span7',
					'options' => array('format' => 'dd/mm/yyyy')
				));
				?>
			</div>
			<div class="span6">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label' => 'OK',
					'type' => 'primary',
					'id' => 'btnOK',
					'buttonType' => 'submit',
				));
				?>
				&emsp;

				<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>				
				&emsp;
				<a href="<?php echo Yii::app()->request->baseUrl.'?r=glaccounting/Rptmkbdvd55xe13/GetTextFile&rand_value='.$rand_value.'&user_id='.$user_id ;?> " id="btn_txt" class="btn btn-primary">Save Text File</a>	
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
var url_xls = '<?php echo $url_xls ?>';

init();
	function init()
	{
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
			$('#btn_txt').attr('disabled',true);
		}
	}
	$('#btnOK').click(function(){
		$('#mywaitdialog').dialog('open');
	})	
	
	
</script>

