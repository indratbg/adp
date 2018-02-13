<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'List of Interest' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'List of Interest',
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

<?php
	$month = array(
		1 => 'January',
		2 => 'February',
		3 => 'March',
		4 => 'April',
		5 => 'May',
		6 => 'June',
		7 => 'July',
		8 => 'August',
		9 => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December'
	);
	$currYear=date('Y');
	$year=array();
	
	$result=Dao::queryRowSql("SELECT DDATE1 FROM MST_SYS_PARAM WHERE PARAM_ID='SOA' AND PARAM_CD1='BGN_DATE'");
	$bgnDate=$result['ddate1'];
	
	$bgnYear = DateTime::createFromFormat('Y-m-d H:i:s',$bgnDate)->format('Y');
	
	for($x=$currYear;$x>=$bgnYear;$x--){
		$year[$x]=$x;
	}
	
?>	
<br />
<div class="row-fluid">
	<div class="control-group">
		<div class="span6">
			<div class="span2">
				<label>From</label>
			</div>
			<div class="span3">
				<input type="radio" id="opt1" name="Rptlistofinterest[opt]" class="opt" value="JOURNAL" <?php echo $model->opt=='JOURNAL'?'checked':'' ?>/> &nbsp; Journal
			</div>
			<div class="span4">
				<input type="radio" id="opt2" name="Rptlistofinterest[opt]" class="opt" value="WORKSHEET" <?php echo $model->opt=='WORKSHEET'?'checked':'' ?>/> &nbsp; Worksheet
			</div>
		</div>
	</div>
	<div class="control-group">
		<div class="span6">
			<div class="control-group">
				<div class="span2">
					<label>Month</label>
				</div>
				<div class="span4">
					<?php echo $form->dropDownList($model,'month',$month,array('id'=>'month','class'=>'span12')) ?>
				</div>
				<div class="span2">
					<labe>Years</labe>
				</div>
				<div class="span4">
					<?php echo $form->dropDownList($model,'year',$year,array('id'=>'year','class'=>'span12')) ?>
				</div>
			</div>
			<div class="control-group">
				<div class="span2">
					<label>Posting Date</label> 
				</div>
				<div class="span4">
					<input type="text" id="fromDt" class="tdate" style="display: none;"/>
					<?php echo $form->textField($model,'post_dt',array('id'=>'postDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span12','required'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<div class="span3">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Show Report',
						'id'=>'btnProcess'
					)); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<div class="span2">
					<label>Branch</label>
				</div>
				<div class="span2">
					<input type="radio" id="opt_bc1" name="Rptlistofinterest[opt_branch_cd]" class="opt_bc" value="0" <?php echo $model->opt_branch_cd=='0'?'checked':'' ?>/> &nbsp; All
				</div>
				<div class="span3">
					<input type="radio" id="opt_bc2" name="Rptlistofinterest[opt_branch_cd]" class="opt_bc" value="1" <?php echo $model->opt_branch_cd=='1'?'checked':'' ?>/> &nbsp; Specified
				</div>
				<div class="span4">
					<?php echo $form->dropdownList($model,'branch_cd',CHtml::listData($mbranch, 'brch_cd', 'brch_name'),array('id'=>'opt_bc3','class'=>'span12')) ?>
				</div>
			</div>
			<div class="control-group">
				<div class="span2">
					<label>Client</label>
				</div>
				<div class="span2">
					<input type="radio" id="opt_cl1" name="Rptlistofinterest[client_type]" value="%" <?php echo $model->client_type=='%'?'checked':'' ?>/> &nbsp; All
				</div>
				<div class="span3">
					<input type="radio" id="opt_cl2" name="Rptlistofinterest[client_type]" value="M" <?php echo $model->client_type=='M'?'checked':'' ?>/> &nbsp; Margin
				</div>
				<div class="span4">
					<input type="radio" id="opt_cl3" name="Rptlistofinterest[client_type]" value="N" <?php echo $model->client_type=='N'?'checked':'' ?>/> &nbsp; All Non Margin
				</div>
			</div>
		</div>
	</div>
</div>

<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'style'=>'display:none'));?>
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
		updateDate();
		if($("#opt1").is(':checked')){
			getPostdate();	
		}else{
			endDate();
		}
		// optForm();
		optBranch();
	}
	
	$('#fromDt').change(function(){
		if($("#opt1").is(':checked')){
			getPostdate();	
		}else{
			endDate();
		}
	})
	
	$("#month, #year").change(function()
	{	
		updateDate();
		if($("#opt1").is(':checked')){
			getPostdate();	
		}else{
			endDate();
		}
		
	});
	
	$(".opt_bc").change(function(){
		optBranch();
	});
	
	$(".opt").change(function(){
		// optForm();
		optBranch();
		if($("#opt1").is(':checked')){
			getPostdate();	
		}else{
			endDate();
		}
	});
	
	function updateDate(){
		var firstDate = new Date($("#year").val(),$("#month").val()-1,1);
	 	
		$("#fromDt").val('0'+firstDate.getDate() + '/' + ('0'+(firstDate.getMonth()+1)).slice(-2) + '/' + firstDate.getFullYear());
		$("#fromDt").datepicker("update");
	}
	
	function endDate(){
		var lastDate  = new Date($("#year").val(),$("#month").val(),0);
	 	
		$("#postDt").val(lastDate.getDate() + '/' + ('0'+(lastDate.getMonth()+1)).slice(-2) + '/' + lastDate.getFullYear());
		$("#postDt").datepicker("update");
	}
	
	function getPostdate(){
		var fromDt = $('#fromDt').val();
		$.ajax({
		    		'type'     :'POST',
		    		'url'      : '<?php echo $this->createUrl('getpostdate'); ?>',
					'dataType' : 'json',
					'data'		:{	
									fromdt : fromDt,
								},
					'success': function(result)
								{
									$("#postDt").val(result.post_dt);
								}
					,
					'async':false
				});
	}
	
	function optBranch()
	{
		if($("#opt_bc1").is(':checked')){
			$("#opt_bc3").attr('disabled',true);
		}else{
			$("#opt_bc3").attr('disabled',false);
		}
	}
	
	// function optForm()
	// {
		// if($("#opt2").is(':checked')){
			// $("#opt_bc1,#opt_bc2,#opt_bc3").attr('disabled',true);
		// }else{
			// $("#opt_bc1,#opt_bc2,#opt_bc3").attr('disabled',false);
		// }
	// }
</script>
