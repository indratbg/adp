<style>
#optionStock > label
	{
		width:130px;
		margin-left:-19px;
	}
	
	#optionStock > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-10px;
	}
	
	#optionStock > label > input
	{
		float:left;
	}
	
	#optionClient > label
	{
		width:130px;
		margin-left:-19px;
	}
	
	#optionClient > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-10px;
	}
	
	#optionClient > label > input
	{
		float:left;
	}
	#view_report > label
	{
		width:130px;
		margin-left:-19px;
	}
	
	#view_report > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-10px;
	}
	
	#view_report > label > input
	{
		float:left;
	}

	.report_type{
		margin-top:-5px;
		margin-left:100px;
	}
	</style>
	
	
	
<?php
$this->breadcrumbs=array(
	'Reconcile Stock Balance',
);
?>
<?php
$this->menu=array(
	//array('label'=>'Trekdanaksei', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Reconcile Stock Balance', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
);

?>

<br/>

	
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'import-form',
				'enableAjaxValidation'=>false,
				'type'=>'horizontal',
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			)); ?>
			<?php echo $form->errorSummary(array($model,$modelMain001,$modelMain004,$modelRincian)); ?>
	<input type="hidden" name="scenario" id="scenario" />
	
	<div class="row-fluid control-group">
		<div class="span7">
			<div class="control-group">
				<div class="span2">
					<label>Balance as at</label>
				</div>
				<div class="span3">
					<?php echo $form->datePickerRow($model,'bal_dt',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span','options'=>array('format' => 'dd/mm/yyyy'))); ?>
				</div>
			</div>	
			<div class="control-group stock_code">
				<div class="span2">
					<label>Stock Code</label>
				</div>
				<div class="span6">
					<?php echo $form->radioButtonListInlineRow($model,'option_stock',array('0'=>'All','1'=>'Selected'),array('id'=>'optionStock','class'=>'span5 stock','label'=>false)); ?>
				</div>
				<div class="span2">
					<?php echo $form->textField($model,'stk_cd',array('class'=>'span'));?>
				</div>
			</div>
				<div class="control-group client_cd">
				<div class="span2">
					<label>Client Cd</label>
				</div>
				<div class="span6">
					<?php echo $form->radioButtonListInlineRow($model,'option_client',array('0'=>'All','1'=>'Selected'),array('id'=>'optionClient','class'=>'span5 client','label'=>false)); ?>
				</div>
				<div class="span2">
					<?php echo $form->textField($model,'client_cd',array('class'=>'span'));?>
				</div>
			</div>
		<div class="control-group">
				<div class="span2">
					<label>Show</label>
				</div>
				<div class="span8">
					<?php echo $form->radioButtonListInlineRow($model,'view_report',array('0'=>'All','1'=>'Difference only'),array('id'=>'view_report','class'=>'span5','label'=>false)); ?>
				</div>
				
		</div>	
		
		</div>
		
		<div class="span5">
			<div class="row-fluid control-group">
				<div class="span3">
					<label>Report Type</label>
				</div>
				<div class="span1 report_type" >
					<!-- <input type="radio" id="report_type1" name="Rptstkksei[report_type]" value="0" class="span1 rep_type" <?php if($model->report_type == 0)echo 'checked' ?> /> -->
					<input type="radio" id="report_type2" name="Rptstkksei[report_type]" value="1" class="span1 rep_type" <?php if($model->report_type == 1)echo 'checked' ?> />
					<input type="radio" id="report_type3" name="Rptstkksei[report_type]" value="2" class="span1 rep_type" <?php if($model->report_type == 2)echo 'checked' ?>/>
					<input type="radio" id="report_type4" name="Rptstkksei[report_type]" value="3" class="span1 rep_type" <?php if($model->report_type == 3)echo 'checked' ?>/>
					<input type="radio" id="report_type5" name="Rptstkksei[report_type]" value="4" class="span1 rep_type" <?php if($model->report_type == 4)echo 'checked' ?>/>
					<!-- <input type="radio" id="report_type6" name="Rptstkksei[report_type]" value="5" class="span1 rep_type" <?php if($model->report_type == 5)echo 'checked' ?>/> -->
					
				</div>
				<div class="span5">
					<!-- <label>Rincian Portofolio</label> -->
					<label>Sub rekening 001</label>
					<label>Sub rekening 004</label>
					<label>Main 001</label>
					<label>Main 004</label>
					<!-- <label>Internal Insistpro</label> -->
				</div>
			</div>
		
		</div>
		
	</div>
	<div class="row-fluid">
		<div class="span3"></div>
		<div class="span2">
		<?php $this->widget('bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Process',
			        'size' => 'medium',
			        'id' => 'btnImport',
			        'buttonType'=>'submit',
			        'htmlOptions'=>array('class'=>'btn btn-primary')
			    )
			); ?>
		
		</div>
		<div class="span5">
			<a id="Export_Excel" href="<?php echo $url_xls; ?>" class="btn btn-primary"> Export to Excel</a>
		</div>
	</div>
<br/>

<iframe id="iframe"  src="<?php echo $url; ?>" class="span12" style="min-height:500px;"></iframe>		

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

var url = '<?php echo $url;?>';

function init(){
	cekStock();
	cekClient();
	$(window).resize();
	getClient();
	showClient();
	if(url=='')
	{	
		$('#iframe').hide();
		$('#Export_Excel').hide();
	}
}
	$(window).resize(function()
	{
		$("#iframe").offset({left:2});
		$("#iframe").css('width',($(window).width()));
	});


//	$('#progressbar').hide();
	$('#btnImport').click(function(event){
		//$('#progressbar').show();
		$('#scenario').val('import');
		$('#mywaitdialog').dialog("open"); 
	})
	$('#btnReport').click(function(event){
		//$('#progressbar').show();
		$('#scenario').val('report');
		$('#mywaitdialog').dialog("open"); 
	})
	
	
	$('.stock').change(function(){
		cekStock();
	})
	$('.client').change(function(){
		cekClient();
	})
	function cekStock(){
		if($('#Rptstkksei_option_stock_1').is(':checked'))
		{
			$('#Rptstkksei_stk_cd').prop('readonly',false);
			
		}
		else{
			$('#Rptstkksei_stk_cd').prop('readonly',true);
			$('#Rptstkksei_stk_cd').val('');
		}
	}
	$('#Rptstkksei_stk_cd').change(function(){
		$('#Rptstkksei_stk_cd').val($('#Rptstkksei_stk_cd').val().toUpperCase());
	})
	$('#Rptstkksei_client_cd').change(function(){
		$('#Rptstkksei_client_cd').val($('#Rptstkksei_client_cd').val().toUpperCase());
	})
	
	
	function cekClient(){
		if($('#Rptstkksei_option_client_1').is(':checked'))
		{
			$('#Rptstkksei_client_cd').prop('readonly',false);
		}	
		else
		{
			$('#Rptstkksei_client_cd').prop('readonly',true);
			$('#Rptstkksei_client_cd').val('');
		}
	}	

	init();
	function getClient()
	{
	
		var result = [];
		$('#Rptstkksei_client_cd').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getclient'); ?>',
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
		    minLength: 1
		});
	}
	
	$('.rep_type').change(function(){
	
		showClient();
	})
	
	
	function showClient()
	{
			
		if($('#report_type1').is(':checked'))
		{
			$('.client_cd').hide();	
			$('.stock_code').hide();
		}
		else
		{
			$('.client_cd').show();
			$('.stock_code').show();
		}
	}
</script>