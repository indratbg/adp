<?php
$this->breadcrumbs = array(
    'Margin Transaction with Capping 0'=> array('index'),
    'List',
);

$this->menu = array(
    array(
        'label'=>'Margin Transaction with Capping 0',
        'itemOptions'=> array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
    ),
    array(
        'label'=>'List',
        'url'=> array('index'),
        'icon'=>'list',
        'itemOptions'=> array(
            'class'=>'active',
            'style'=>'float:right'
        )
    ),
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'importTransaction-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal'
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
                    'class'=>'span10 tdate',
                    'placeholder'=>'dd/mm/yyyy'
                ));
				?>
			</div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'end_date', array(
                    'class'=>'span10 tdate',
                    'placeholder'=>'dd/mm/yyyy'
                ));
				?>
			</div>
		</div>

		<div class="control-group">
			<div class="span5">

				<?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'SHOW',
        'type'=>'primary',
        'id'=>'btnPrint',
        'buttonType'=>'submit',
    ));
				?>
			</div>
		</div>
	</div>

</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php echo $form->datePickerRow($model, 'dummy_date', array(
        'label'=>false,
        'style'=>'display:none'
    ));
?>
<?php $this->endWidget(); ?>
<script>
	init();
	function init()
	{
		$('.tdate').datepicker(
		{
			'format' : 'dd/mm/yyyy'
		});
	}


	$('#Rptmargintrx_bgn_date').change(function()
	{
		$('#Rptmargintrx_end_date').val($('#Rptmargintrx_bgn_date').val());
	})

</script>
