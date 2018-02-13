<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Profit Loss Recapitulation' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Profit Loss Recapitulation',
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
<?php echo $form->errorSummary(array($model)); ?>

<?php
$month = array(
	'01' => 'January',
	'02' => 'February',
	'03' => 'March',
	'04' => 'April',
	'05' => 'May',
	'06' => 'June',
	'07' => 'July',
	'08' => 'August',
	'09' => 'September',
	'10' => 'October',
	'11' => 'November',
	'12' => 'December'
);
?>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>For the month of</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model, 'month', $month, array(
					'class' => 'span9',
					'prompt' => '-Select-'
				));
				?>
			</div>
			<div class="span1">
				<label>Year</label>
			</div>
			<div class="spa2">
				<?php echo $form->textField($model, 'year', array('class' => 'span2')); ?>
			</div>

		</div>

	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span5">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'submit',
					'type' => 'primary',
					'label' => 'OK',
					'id' => 'btnPrint'
				));
 ?>
				<a href="<?php echo $url_xls; ?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>
			</div>
		</div>
	</div>
</div>
<br />
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px"></iframe>

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

	var url_xls =  '<?php echo $url_xls ?>';
	init();
	function init()
	{
	
		if(url_xls=='')
		{
		$('#btn_xls').attr('disabled',true);
		}
		$("#iframe").offset({left:2});
        $("#iframe").css('width',($(window).width()));
	}
	$(window).resize(function()
    {
        $("#iframe").offset({left:2});
        $("#iframe").css('width',($(window).width()));
    });
	$('#btnPrint').click(function(){
		$('#mywaitdialog').dialog('open');
	})
</script>
