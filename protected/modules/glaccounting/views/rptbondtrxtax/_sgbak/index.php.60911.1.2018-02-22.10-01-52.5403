<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Bond Transaction Tax Report' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Bond Transaction Tax Report',
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
<?php AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<br />
<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>Date</label>
			</div>
			<div class="span3">
				<input type="radio" name="Rptbondtrxtax[date_flg]" id="date_flg0" value="0" <?php echo $model->date_flg == '0' ? 'checked' : ''; ?>
				/> &nbsp;Transaction
			</div>
			<div class="span3">
				<input type="radio" name="Rptbondtrxtax[date_flg]" id="date_flg1" value="1" <?php echo $model->date_flg == '1' ? 'checked' : ''; ?>
				/> &nbsp;Value
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Month</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model, 'month', $month, array(
					'class' => 'span12',
					'prompt' => '-Select-'
				));
				?>
			</div>
			<div class="span1">
				<label>Year</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'year', array('class' => 'span10 numeric')); ?>
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
				<label>Ticket No.</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'fr_ticket_no',array(),array('class'=>'span10','prompt'=>'-Select-'));?>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'to_ticket_no',array(),array('class'=>'span10','prompt'=>'-Select-'));?>
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
	<a href="<?php echo Yii::app()->request->baseUrl.'?r=glaccounting/Rptbondtrxtax/GetXls&rand_value='.$rand_value.'&user_id='.$user_id ;?> " id="btn_xls" class="btn btn-primary">Save to Excel</a>
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
    var bgn_trx_id = '<?php echo $model->fr_ticket_no;?>';
    var end_trx_id = '<?php echo $model->to_ticket_no;?>';
	init();
	function init()
	{
		$('.tdate').datepicker(
		{
			'format' : 'dd/mm/yyyy'
		});
		getTicket_List();
	}


	$('#Rptbondtrxtax_bgn_date').change(function()
	{
		$('#Rptbondtrxtax_end_date').val($('#Rptbondtrxtax_bgn_date').val());
	})
	$('#Rptbondtrxtax_fr_ticket_no').change(function(){
		$('#Rptbondtrxtax_to_ticket_no').val($('#Rptbondtrxtax_fr_ticket_no').val());
	})
	
	$('#Rptbondtrxtax_bgn_date').change(function(){
		getTicket_List();
	})
	
	function getTicket_List()
	{
		var date_flg='';
		if($('#date_flg0').is(':checked'))
		{
			date_flg='TRX';
		}
		else
		{
			date_flg='VAL';
		}
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetTicketList'); ?>',
			'dataType' : 'json',
			'data'     : {
							'bgn_date' : $('#Rptbondtrxtax_bgn_date').val(),
							'end_date' : $('#Rptbondtrxtax_end_date').val(),
							'date_flg' : date_flg
						}, 
			'success'  : function(data){
				var result = data.content.ticket_no;
				
				$('#Rptbondtrxtax_fr_ticket_no').empty();
				$('#Rptbondtrxtax_fr_ticket_no').append($('<option>').val('').text('-Select-'));
				$('#Rptbondtrxtax_to_ticket_no').empty();
				$('#Rptbondtrxtax_to_ticket_no').append($('<option>').val('').text('-Select-'));
				
				$.each(result, function(i, item) {
			    	$('#Rptbondtrxtax_fr_ticket_no').append($('<option>').val(result[i]).text(result[i]));
			    	$('#Rptbondtrxtax_to_ticket_no').append($('<option>').val(result[i]).text(result[i]));
				});		
				$('#Rptbondtrxtax_fr_ticket_no').val(bgn_trx_id?bgn_trx_id:'');
				$('#Rptbondtrxtax_to_ticket_no').val(end_trx_id?end_trx_id:'');
			}
		});
	}
	$('#Rptbondtrxtax_year').on('keyup',function(){
		 var from_date = $('#Rptbondtrxtax_bgn_date').val().split('/');
		$('#Rptbondtrxtax_bgn_date').val(from_date[0]+'/'+from_date[1]+'/'+$('#Rptbondtrxtax_year').val());
		var end_date = $('#Rptbondtrxtax_end_date').val().split('/');
		$('#Rptbondtrxtax_end_date').val(end_date[0]+'/'+end_date[1]+'/'+$('#Rptbondtrxtax_year').val());
		getTicket_List();
	});
	$('#Rptbondtrxtax_month').change(function(){
	    var from_date = $('#Rptbondtrxtax_bgn_date').val().split('/');
		$('#Rptbondtrxtax_bgn_date').val(from_date[0]+'/'+$('#Rptbondtrxtax_month').val()+'/'+from_date[2]);
		var end_date = $('#Rptbondtrxtax_end_date').val().split('/');
		$('#Rptbondtrxtax_end_date').val(end_date[0]+'/'+$('#Rptbondtrxtax_month').val()+'/'+end_date[2]);
		Get_End_Date($('#Rptbondtrxtax_end_date').val());
		getTicket_List();
	});
	$('#Rptbondtrxtax_end_date').change(function(){
		getTicket_List();
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
		  
		$('#Rptbondtrxtax_end_date').val(new_date);
		$('.tdate').datepicker('update');
	}
</script>
