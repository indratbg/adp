<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Aging and Saldo Rekening Dana' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Aging and Saldo Rekening Dana',
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
			<div class="span3">
				<label>Due Date</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'end_date', array(
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
				?>
			</div>

		</div>

		<div class="control-group">
			<div class="span3">
				<label>AR/AP Balance</label>
			</div>
			<div class="span3">
				<input type="radio" name="Rptagingandsaldorekdana[arap_bal]" value="0" <?php echo $model->arap_bal=='0'?'checked':'' ?>
				/> &nbsp; All
			</div>
			<div class="span3">
				<input type="radio" name="Rptagingandsaldorekdana[arap_bal]" value="1" <?php echo $model->arap_bal=='1'?'checked':'' ?>
				/> &nbsp; AR
			</div>
			<div class="span3">
				<input type="radio" name="Rptagingandsaldorekdana[arap_bal]" value="2" <?php echo $model->arap_bal=='2'?'checked':'' ?>
				/> &nbsp; AP
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Saldo Rek Dana</label>
			</div>
			<div class="span3">
				<input type="radio" name="Rptagingandsaldorekdana[saldo_rek]" value="0" <?php echo $model->saldo_rek=='0'?'checked':'' ?>
				/> &nbsp; All
			</div>
			<div class="span3">
				<input type="radio" name="Rptagingandsaldorekdana[saldo_rek]" value="1" <?php echo $model->saldo_rek=='1'?'checked':'' ?>
				/> &nbsp; Ada Saldo
			</div>

		</div>

		<div class="control-group">
			<div class="span5">

				<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label' => 'OK',
		'type' => 'primary',
		'id' => 'btnPrint',
		'buttonType' => 'submit',
	));
				?>
			</div>
		</div>
	</div>
	<div class="span6">

		<div class="control-group">
			<div class="span3">
				<label>Branch</label>
			</div>
			<div class="span8">
				<?php echo $form->dropDownList($model, 'branch_cd', CHtml::listData(Branch::model()->findAll(array(
					'select' => "brch_cd, brch_cd||' - '||brch_name brch_name",
					'condition' => " approved_stat='A'",
					'order' => 'brch_cd'
				)), 'brch_cd', 'brch_name'), array(
					'class' => 'span5',
					'prompt' => '-ALL-',
					'style' => 'font-family:courier'
				));
				?>
			</div>
		</div>

		<div class="control-group">
			<div class="span3">
				<label>Specified</label>
			</div>
			<div class="span5">
				<?php echo $form->textField($model, 'client_cd', array('class' => 'span7', )); ?>
			</div>
		</div>

	</div>
	<br />
	<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
	<?php echo $form->datePickerRow($model, 'dummy_date', array(
			'label' => false,
			'style' => 'display:none'
		));
	?>
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
}

function getClient()
{
var result = [];
$('#Rptagingandsaldorekdana_client_cd').autocomplete(
{
source: function (request, response)
{
$.ajax({
'type'		: 'POST',
'url'		: '<?php echo $this->createUrl('getclient'); ?>
	',
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

	$('#Rptagingandsaldorekdana_bgn_date').change(function(){
	$('#Rptagingandsaldorekdana_end_date').val($('#Rptagingandsaldorekdana_bgn_date').val());
	})
	$('#Rptagingandsaldorekdana_bank_cd').change(function(){
	$('#Rptagingandsaldorekdana_bank_cd').val($('#Rptagingandsaldorekdana_bank_cd').val().toUpperCase());
	})
	</script>
