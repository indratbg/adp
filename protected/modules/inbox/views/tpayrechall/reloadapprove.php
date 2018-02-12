<?php 
Yii::app()->clientScript->registerScript('autoclick', "
	setTimeout(function(){
		var thisform = $('#voucher-checked-form');
		thisform.submit();
	}, 10);
");
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'voucher-checked-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo 'Please wait...<br />Processing '.($totalAll - count($processed)).' of '.$totalAll; ?>
	
	<input type="hidden" value="<?php echo $totalAll; ?>" name="total_all" />
	
	<?php foreach ($processed as $voucher) { ?>
		<input type="hidden" value="<?php echo $voucher; ?>" name="arrid[]" />
	<?php } ?>
	
	<?php foreach ($key as $keyId) { ?>
		<input type="hidden" value="<?php echo $keyId; ?>" name="arrkey[]" />
	<?php } ?>
	
<?php $this->endWidget(); ?>