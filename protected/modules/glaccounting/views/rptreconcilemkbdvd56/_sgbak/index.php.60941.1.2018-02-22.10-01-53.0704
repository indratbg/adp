<style>
input[type="radio"], input[type="radio"]+label {
    display: inline;
}
input[type="radio"] {
  margin-left: 10px;
}
</style>
<?php
$this->breadcrumbs = array(
	'Reconcile VD56 Baris 10 vs Baris 24' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Reconcile VD56 Baris 10 vs Baris 24',
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
		<div class="control-group">
			<?php echo $form->datePickerRow($model,'end_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		
		</div>
		<div class="control-group">
		<?php echo $form->radioButtonListInlineRow($model,'rpt_type',AConstant::$reconcile_bank_acct);?>
		</div>
		
	<div class="control-group">
			<div class="span5">

				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'label' => 'Show',
						'type' => 'primary',
						'id' => 'btnPrint',
						'buttonType' => 'submit',
					));
				 ?>
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
