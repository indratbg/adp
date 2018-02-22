<?php
$this->breadcrumbs = array(
	'Bond Summary' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Bond Summary',
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
<input type="hidden" name="scenario" id="scenario" />
<br />
<div class="row-fluid">
	<div class="span6">
		
		<div class="control-group">
			<div class="span3">
				<label>Month</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model, 'month', AConstant::getArrayMonth(), array(
					'class' => 'span10',
					'prompt' => '-Select-'
				));
				?>
				<?php echo $form->textField($model,'vo_random_value',array('style'=>'display:none'));?>
			</div>
			<div class="span1">
				<label>Year</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model, 'year', AConstant::getArrayYear(), array(
                    'class' => 'span10',
                    'prompt' => '-Select-'
                ));
                ?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Date From</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'bgn_date', array(
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
				?>
			</div>
			<div class="span1">
				<label>To</label>
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

				<?php $this->widget('bootstrap.widgets.TbButton', array(
    		'label' => 'SHOW',
    		'type' => 'primary',
    		'id' => 'btnPrint',
    		'buttonType' => 'submit',
    	));
				?>
			</div>
		<div class="span3">
	
                <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Export to Excel',
            'type' => 'primary',
            'id' => 'btnExport',
            'buttonType' => 'submit',
        ));
                ?>
			</div>
		</div>
	</div>
	<div class="span6">

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
<script>
	init();
	function init()
	{
		$('.tdate').datepicker(
		{
			'format' : 'dd/mm/yyyy'
		});
		if('<?php echo $url; ?>'=='')
		$('#btnExport').prop('disabled',true);
	
	}
	$('#Rptbondsummary_bgn_date').change(function()
	{
		$('#Rptbondsummary_end_date').val($('#Rptbondsummary_bgn_date').val());
	})

	$('#Rptbondsummary_year').on('keyup',function(){
		 var from_date = $('#Rptbondsummary_bgn_date').val().split('/');
		$('#Rptbondsummary_bgn_date').val(from_date[0]+'/'+from_date[1]+'/'+$('#Rptbondsummary_year').val());
		var end_date = $('#Rptbondsummary_end_date').val().split('/');
		$('#Rptbondsummary_end_date').val(end_date[0]+'/'+end_date[1]+'/'+$('#Rptbondsummary_year').val());
		getTicket_List();
	});
	$('#Rptbondsummary_month').change(function(){
	    var from_date = $('#Rptbondsummary_bgn_date').val().split('/');
		$('#Rptbondsummary_bgn_date').val(from_date[0]+'/'+$('#Rptbondsummary_month').val()+'/'+from_date[2]);
		var end_date = $('#Rptbondsummary_end_date').val().split('/');
		$('#Rptbondsummary_end_date').val(end_date[0]+'/'+$('#Rptbondsummary_month').val()+'/'+end_date[2]);
		Get_End_Date($('#Rptbondsummary_end_date').val());
		getTicket_List();
	});
	
function Get_End_Date(tgl)
	{
		var date = tgl.split('/');
		var day = parseInt(date[0]);
		var month = parseInt(date[1]);
		var year = parseInt(date[2]);
		
		var d = new Date(year,month,day);
		  d.setDate(d.getDate() - day);
		var month = d.getMonth()+1;
		var new_date = d.getDate()+'/'+month+'/'+d.getFullYear();
		  
		$('#Rptbondsummary_end_date').val(new_date);
		$('.tdate').datepicker('update');
	}
	
	$('#btnPrint').click(function(){
	    $('#scenario').val('print')
	})
	
    $('#btnExport').click(function(){
        $('#scenario').val('export')
    })
</script>
