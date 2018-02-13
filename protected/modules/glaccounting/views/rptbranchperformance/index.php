<?php
$this->breadcrumbs = array(
	'Branch Performance' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Branch Performance',
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

<?php echo $form->errorSummary($model); ?>
<?php AHelper::showFlash($this)
?>

<br>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>Month</label>
			</div>
			<div class="span4">
				<?php echo $form->dropDownList($model, 'month', AConstant::getArrayMonth(), array(
					'class' => 'span8',
					'prompt' => '-Select-'
				));
				?>
			</div>
			<div class="span1">
				<label>Year</label>
			</div>
			<div class="span4">
				<?php echo $form->dropDownList($model,'year',AConstant::getArrayYear(),array('class'=>'span8'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">From Date</div>
			<div class="span4">
				<?php echo $form->textField($model,'bgn_date',array('class'=>'span8 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span4">
				<?php echo $form->textField($model,'end_date',array('class'=>'span8 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">Contract Type</div>
			<div class="span3">
				<input type="radio" id="contract_option_0" name="Rptbranchperformance[contract_option]" value="0" <?php echo $model->contract_option==0?'checked':''?> class="contract_option"/>&nbsp;All
			</div>
			<div class="span2">
				<input type="radio" id="contract_option_1" name="Rptbranchperformance[contract_option]" value="1" <?php echo $model->contract_option==1?'checked':''?> class="contract_option"/>&nbsp;Specified
			</div>
			<div class="span4">
				<?php echo $form->dropDownList($model,'contract_type',array('I'=>'TITIP','R'=>'REGULAR'),array('class'=>'span8','prompt'=>'-Select-'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span5">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'submit',
					'type' => 'primary',
					'label' => 'OK',
					'id' => 'btnSubmit'
				));
				?>
			<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>
			</div>
		</div>
	</div>
	<!--End Span6  -->

	<div class="span6">
	
		<div class="control-group">
			<div class="span3">
				<label>Branch</label>
			</div>
			<div class="span5">
				<input type="radio" id="branch_option_0" name="Rptbranchperformance[branch_option]" value="0" <?php echo $model->branch_option==0?'checked':''?> class="branch_option"/>&nbsp;All
				&emsp;
				<input type="radio" id="branch_option_1" name="Rptbranchperformance[branch_option]" value="1" <?php echo $model->branch_option==1?'checked':''?> class="branch_option"/>&nbsp;Specified
			</div>
			<div class="span4">
				<?php echo $form->dropDownList($model,'branch_cd',CHtml::listData($branch_cd, 'brch_cd', 'brch_name'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Remiser(s)</label>
			</div>
			<div class="span5">
				<input type="radio" id="rem_option_0" name="Rptbranchperformance[rem_option]" value="0" <?php echo $model->rem_option==0?'checked':''?> class="rem_option"/>&nbsp;All
				&emsp;
				<input type="radio" id="rem_option_1" name="Rptbranchperformance[rem_option]" value="1" <?php echo $model->rem_option==1?'checked':''?> class="rem_option"/>&nbsp;Specified
			</div>
			<div class="span4">
				<?php echo $form->dropDownList($model,'rem_cd',CHtml::listData($rem_cd, 'rem_cd', 'rem_name'),array('prompt'=>'-Select-','class'=>'span12','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">Report Type</div>
			<div class="span3">
				<input type="radio" id="rpt_type_0" name="Rptbranchperformance[rpt_type]" value="0" <?php echo $model->rpt_type==0?'checked':''?> class="rpt_type"/>&nbsp;Summary
			</div>
			<div class="span3">
				<input type="radio" id="rpt_type_1" name="Rptbranchperformance[rpt_type]" value="1" <?php echo $model->rpt_type==1?'checked':''?> class="rpt_type"/>&nbsp;Detail
			</div>
		</div>
		
		
	</div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'disabled'=>true,'style'=>'display:none'));?>
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
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		contract_option();
		branch_option();
		rem_option();
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
	$('.contract_option').change(function(){
		contract_option();
	})
	$('.branch_option').change(function(){
		branch_option();
	})
	$('.rem_option').change(function(){
		rem_option();
	})
	
	function contract_option()
	{
		if($('#contract_option_0').is(':checked'))
		{
			$('#Rptbranchperformance_contract_type').prop('disabled',true);
		}
		else
		{
			$('#Rptbranchperformance_contract_type').prop('disabled',false);
		}
	}
	function branch_option()
	{
		if($('#branch_option_0').is(':checked'))
		{
			$('#Rptbranchperformance_branch_cd').prop('disabled',true);
		}
		else
		{
			$('#Rptbranchperformance_branch_cd').prop('disabled',false);
		}
	}
	function rem_option()
	{
		if($('#rem_option_0').is(':checked'))
		{
			$('#Rptbranchperformance_rem_cd').prop('disabled',true);
		}
		else
		{
			$('#Rptbranchperformance_rem_cd').prop('disabled',false);
		}
	}
	
	$('#Rptbranchperformance_bgn_date').change(function()
	{
			$('#Rptbranchperformance_end_date').val($('#Rptbranchperformance_bgn_date').val());
			$('.tdate').datepicker('update');
	});
		$('#Rptbranchperformance_month').change(function(){
	    var from_date = $('#Rptbranchperformance_bgn_date').val().split('/');
		$('#Rptbranchperformance_bgn_date').val(from_date[0]+'/'+$('#Rptbranchperformance_month').val()+'/'+from_date[2]);
		var end_date = $('#Rptbranchperformance_end_date').val().split('/');
		$('#Rptbranchperformance_end_date').val(end_date[0]+'/'+$('#Rptbranchperformance_month').val()+'/'+end_date[2]);
		Get_End_Date($('#Rptbranchperformance_end_date').val());
	});
	
	$('#Rptbranchperformance_year').on('change',function(){
		 var from_date = $('#Rptbranchperformance_bgn_date').val().split('/');
		$('#Rptbranchperformance_bgn_date').val(from_date[0]+'/'+from_date[1]+'/'+$('#Rptbranchperformance_year').val());
		var end_date = $('#Rptbranchperformance_end_date').val().split('/');
		$('#Rptbranchperformance_end_date').val(end_date[0]+'/'+end_date[1]+'/'+$('#Rptbranchperformance_year').val());
	})
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
		  
		$('#Rptbranchperformance_end_date').val(new_date);
		$('.tdate').datepicker('update');
	}
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');
	})
</script>