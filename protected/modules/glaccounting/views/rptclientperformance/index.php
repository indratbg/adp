<?php
$this->breadcrumbs = array(
	'Client Performance' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Client Performance',
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
				<input type="radio" id="contract_option_0" name="Rptclientperformance[contract_option]" value="0" <?php echo $model->contract_option==0?'checked':''?> class="contract_option"/>&nbsp;All
			</div>
			<div class="span2">
				<input type="radio" id="contract_option_1" name="Rptclientperformance[contract_option]" value="1" <?php echo $model->contract_option==1?'checked':''?> class="contract_option"/>&nbsp;Specified
			</div>
			<div class="span4">
				<?php echo $form->dropDownList($model,'contract_type',array('I'=>'TITIP','R'=>'REGULAR'),array('class'=>'span10','prompt'=>'-Select-'));?>
			</div>
		</div>
			<div class="control-group">
			<div class="span3">
				<label>Branch</label>
			</div>
			<div class="span3">
				<input type="radio" id="branch_option_0" name="Rptclientperformance[branch_option]" value="0" <?php echo $model->branch_option==0?'checked':''?> class="branch_option"/>&nbsp;All
			</div>
			<div class="span2">
				<input type="radio" id="branch_option_1" name="Rptclientperformance[branch_option]" value="1" <?php echo $model->branch_option==1?'checked':''?> class="branch_option"/>&nbsp;Specified
			</div>
			<div class="span4">
				<?php echo $form->dropDownList($model,'branch_cd',CHtml::listData($branch_cd, 'brch_cd', 'brch_name'),array('class'=>'span10','prompt'=>'-Select-','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
				<div class="span3">
				<label>Client</label>
			</div>
			<div class="span3">
				<input type="radio" id="client_option_0" name="Rptclientperformance[client_option]" value="0" <?php echo $model->client_option==0?'checked':''?> class="client_option"/>&nbsp;All
			</div>
			<div class="span2">
				<input type="radio" id="client_option_1" name="Rptclientperformance[client_option]" value="1" <?php echo $model->client_option==1?'checked':''?> class="client_option"/>&nbsp;Specified
			</div>
			<div class="span4">
				<?php echo $form->textField($model,'client_cd',array('class'=>'span10'));?>
			</div>
		</div>
	
		
	</div>
	<!--End Span6  -->

	<div class="span6">
	
	
		<div class="control-group">
			<div class="span3">
				<label>Option</label>
			</div>
			<div class="span2">
				<input type="radio" id="option_0" name="Rptclientperformance[option]" value="0" <?php echo $model->option==0?'checked':''?> class="option"/>&nbsp;All
			</div>
			<div class="span2">
				<input type="radio" id="option_1" name="Rptclientperformance[option]" value="1" <?php echo $model->option==1?'checked':''?> class="option"/>&nbsp;Corporate
			</div>
			<div class="span3">
				<input type="radio" id="option_2" name="Rptclientperformance[option]" value="2" <?php echo $model->option==2?'checked':''?> class="option"/>&nbsp;Online Trading
			</div>
		</div>
		<div class="control-group">
			<div class="span3">Report Type</div>
			<div class="span2">
				<input type="radio" id="rpt_type_0" name="Rptclientperformance[rpt_type]" value="0" <?php echo $model->rpt_type==0?'checked':''?> class="rpt_type"/>&nbsp;Summary
			</div>
			<div class="span2">
				<input type="radio" id="rpt_type_1" name="Rptclientperformance[rpt_type]" value="1" <?php echo $model->rpt_type==1?'checked':''?> class="rpt_type"/>&nbsp;Detail
			</div>
		</div>
		<div class="control-group">
			<div class="span3">Sort By</div>
			<div class="span8">
				<input type="radio" id="sort_by_0" name="Rptclientperformance[sort_by]" value="0" <?php echo $model->sort_by==0?'checked':''?> class="sort_by"/>&nbsp;Transaction Descending / by branch
			</div>
		</div>
		<div class="control-group">
			<div class="offset3 span3">
				<input type="radio" id="sort_by_1" name="Rptclientperformance[sort_by]" value="1" <?php echo $model->sort_by==1?'checked':''?> class="sort_by"/>&nbsp;Client
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
		client_option();
		getClient();
		sort_by();
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
	$('.client_option').change(function(){
		client_option();
	})


	
	function contract_option()
	{
		if($('#contract_option_0').is(':checked'))
		{
			$('#Rptclientperformance_contract_type').prop('disabled',true);
		}
		else
		{
			$('#Rptclientperformance_contract_type').prop('disabled',false);
		}
	}
	function branch_option()
	{
		if($('#branch_option_0').is(':checked'))
		{
			$('#Rptclientperformance_branch_cd').prop('disabled',true);
		}
		else
		{
			$('#Rptclientperformance_branch_cd').prop('disabled',false);
		}
	}
	function client_option()
	{
		if($('#client_option_0').is(':checked'))
		{
			$('#Rptclientperformance_client_cd').prop('disabled',true);
		}
		else
		{
			$('#Rptclientperformance_client_cd').prop('disabled',false);
		}
	}
	
	$('#Rptclientperformance_bgn_date').change(function()
	{
			$('#Rptclientperformance_end_date').val($('#Rptclientperformance_bgn_date').val());
			 Get_End_Date($('#Rptclientperformance_bgn_date').val());
			$('.tdate').datepicker('update');
	});
	
	$('#Rptclientperformance_month').change(function(){
	    var from_date = $('#Rptclientperformance_bgn_date').val().split('/');
		$('#Rptclientperformance_bgn_date').val(from_date[0]+'/'+$('#Rptclientperformance_month').val()+'/'+from_date[2]);
		var end_date = $('#Rptclientperformance_end_date').val().split('/');
		$('#Rptclientperformance_end_date').val(end_date[0]+'/'+$('#Rptclientperformance_month').val()+'/'+end_date[2]);
		Get_End_Date($('#Rptclientperformance_end_date').val());
	});
	
	$('#Rptclientperformance_year').on('change',function(){
		 var from_date = $('#Rptclientperformance_bgn_date').val().split('/');
		$('#Rptclientperformance_bgn_date').val(from_date[0]+'/'+from_date[1]+'/'+$('#Rptclientperformance_year').val());
		var end_date = $('#Rptclientperformance_end_date').val().split('/');
		$('#Rptclientperformance_end_date').val(end_date[0]+'/'+end_date[1]+'/'+$('#Rptclientperformance_year').val());
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
		  
		$('#Rptclientperformance_end_date').val(new_date);
		$('.tdate').datepicker('update');
	}
	function getClient()
    {
        var result = [];
        $('#Rptclientperformance_client_cd').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getclient'); ?>',
                    'dataType'  : 'json',
                    'data'      :   {
                                        'term': request.term,
                                        
                                    },
                    'success'   :   function (data) 
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
            minLength: 0,
             open: function() { 
                    $(this).autocomplete("widget").width(400);
                     $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });;
    }
	$('.rpt_type').change(function(){
		sort_by();
	})
	function sort_by()
	{
		if(!$('#rpt_type_0').is(':checked'))
		{
			$('.sort_by').prop('disabled',true);
		}
		else
		{
			$('.sort_by').prop('disabled',false);
		}
	}
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');
	})
</script>