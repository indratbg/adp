<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'General Ledger' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'General Ledger',
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
				<?php echo $form->textField($model, 'year', array('class' => 'span8 numeric')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Begin Date</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'bgn_date', array(
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>End Date</label>
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
				<label>Report Mode</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model, 'report_mode', array('value' => '0')) . "&nbsp Regular"; ?>
				<br/>
				<?php echo $form->radioButton($model, 'report_mode', array('value' => '1')) . "&nbsp By Account"; ?>
			</div>
		</div>
<!--
		<div class="control-group">
			<div class="span6">
				<label>Cancelled + Reversal Journal</label>
			</div>

		</div>
		<div class="control-group">
			<div class="span6 offset3">
				<?php echo $form->radioButton($model, 'cancel_flg', array('value' => '0')) . "&nbsp Show"; ?>
				&emsp;
				<?php echo $form->radioButton($model, 'cancel_flg', array('value' => '1')) . "&nbsp Hide"; ?>
			</div>
		</div>-->

	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span2">

			</div>
			<div class="span2">
				<label>Main</label>
			</div>
			<div class="span5">
				<label>Sub</label>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>From</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model,'from_gla',CHtml::listData($gl_a, 'gl_a', 'acct_name'),array('class'=>'span12','style'=>'font-family:courier;','prompt'=>'-ALL-'));?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'from_sla', array('class' => 'span12')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>To</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model,'to_gla',CHtml::listData($gl_a, 'gl_a', 'acct_name'),array('class'=>'span12','style'=>'font-family:courier;','prompt'=>'-ALL-'));?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'to_sla', array('class' => 'span12')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Branch</label>
			</div>
			<div class="span5">
				<?php echo $form->radioButton($model, 'branch_option', array(
					'value' => '0',
					'class' => 'branch_option',
					'id' => 'branch_option_0'
				)) . "&nbsp All"; ?>
				&emsp;
				&emsp;
				&emsp;
				<?php echo $form->radioButton($model, 'branch_option', array(
						'value' => '1',
						'class' => 'branch_option',
						'id' => 'branch_option_1'
					)) . "&nbsp Specified";
				?>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model, 'branch_cd', CHtml::listData(Branch::model()->findAll(array(
					'select' => "brch_cd, brch_cd||' - '||brch_name brch_name",
					'condition' => " approved_stat='A'",
					'order' => 'brch_cd'
				)), 'brch_cd', 'brch_name'), array(
					'class' => 'span10',
					'prompt' => '-Select-',
					'style' => 'font-family:courier'
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<div class="span5">

				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'label' => 'Print',
						'type' => 'primary',
						'id' => 'btnPrint',
						'buttonType' => 'submit',
					));
				 ?>
				 &emsp;
				 
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Save to Excel',
                        'type' => 'primary',
                        'id' => 'btn_xls',
                        'buttonType' => 'submit',
                    ));
                 ?>
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

	var url_xls = '<?php echo $url ?>';
	var glAcctCd='';
	init();
	function init()
	{
		cek_branch();
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled','disabled');
		}
		 GetSLA(glAcctCd);
	}


	$('.branch_option').change(function()
	{
		cek_branch();
	});

	function cek_branch()
	{
		if ($('#branch_option_0').is(':checked'))
		{
			$('#Rptgeneralledger_branch_cd').attr('disabled', true);
		}
		else
		{
			$('#Rptgeneralledger_branch_cd').attr('disabled', false);
		}
	}
	$('#Rptgeneralledger_month').change(function(){
	    var from_date = $('#Rptgeneralledger_bgn_date').val().split('/');
		$('#Rptgeneralledger_bgn_date').val(from_date[0]+'/'+$('#Rptgeneralledger_month').val()+'/'+from_date[2]);
		var end_date = $('#Rptgeneralledger_end_date').val().split('/');
		$('#Rptgeneralledger_end_date').val(end_date[0]+'/'+$('#Rptgeneralledger_month').val()+'/'+end_date[2]);
		Get_End_Date($('#Rptgeneralledger_end_date').val());
	});
	
	$('#Rptgeneralledger_year').on('keyup',function(){
		 var from_date = $('#Rptgeneralledger_bgn_date').val().split('/');
		$('#Rptgeneralledger_bgn_date').val(from_date[0]+'/'+from_date[1]+'/'+$('#Rptgeneralledger_year').val());
		var end_date = $('#Rptgeneralledger_end_date').val().split('/');
		$('#Rptgeneralledger_end_date').val(end_date[0]+'/'+end_date[1]+'/'+$('#Rptgeneralledger_year').val());
		$('.tdate').datepicker('update');
	})
	


	$('#Rptgeneralledger_from_gla').change(function(){
		var glAcctCd = $('#Rptgeneralledger_from_gla').val();
		GetSLA(glAcctCd);
	});
	
	$('#Rptgeneralledger_to_gla').change(function(){
		var glAcctCd = $('#Rptgeneralledger_to_gla').val();
		GetSLA(glAcctCd);
	})
	
	$('#Rptgeneralledger_from_gla').change(function(){
		$('#Rptgeneralledger_from_gla').val($('#Rptgeneralledger_from_gla').val().toUpperCase());
		$('#Rptgeneralledger_to_gla').val($('#Rptgeneralledger_from_gla').val().toUpperCase());
	});
	$('#Rptgeneralledger_from_sla').blur(function(){
	//	$('#Rptgeneralledger_from_sla').val($('#Rptgeneralledger_from_sla').val().toUpperCase());
	//alert('test')
		$('#Rptgeneralledger_to_sla').val($('#Rptgeneralledger_from_sla').val().toUpperCase());
	});
	$('#Rptgeneralledger_to_sla').change(function(){
		$('#Rptgeneralledger_to_sla').val($('#Rptgeneralledger_to_sla').val().toUpperCase());
	});
	$('#Rptgeneralledger_to_gla').change(function(){
		$('#Rptgeneralledger_to_gla').val($('#Rptgeneralledger_to_gla').val().toUpperCase());
	});
	
	function GetSLA(glAcctCd)
	{
			$('#Rptgeneralledger_from_sla ,#Rptgeneralledger_to_sla').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo Yii::app()->createUrl('share/sharesql/getSlAcct'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						'gl_acct_cd' : glAcctCd
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
	            	/*
															  if(!match)
										{
											alert("SL Account not found in chart of accounts");
											$(this).val('');
										}
										*/
					
		            //$(this).focus();
	            }
	        },
		    minLength: 0,
		      open: function() { 
			        $(this).autocomplete("widget").width(400);
			        $(this).autocomplete("widget").css('overflow-y','scroll');
			        $(this).autocomplete("widget").css('max-height','250px');
			    } 
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
        
	}
	


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
		  
		$('#Rptgeneralledger_end_date').val(new_date);
		$('.tdate').datepicker('update');
	}
	 $('#btnPrint').click(function(){
        $('#mywaitdialog').dialog('open');
        $('#scenario').val('print');
    })
    $('#btn_xls').click(function() {
        $('#scenario').val('export');
    });
	
</script>
