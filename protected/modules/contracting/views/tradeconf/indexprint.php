
<style>
	.radio.inline{
	width: 130px;
}
</style>
<?php
$this->breadcrumbs=array(
	'Trade Confirmation'=>array('index'),
	'Import',
);

$this->menu=array(
array('label'=>'Trade Confirmation', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'Generate','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Print','url'=>array('indexprint'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tradeconf/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>

<br />

<?php AHelper::showFlash($this) ?>
<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tcontracts-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<input type="hidden" name='scenario' id="scenario" />
	
	<div class="row-fluid">
		<div class="span6">
			<div class="row-fluid">
				<div class="span3">
					<?php echo $form->label($model,'Trade Confirmation Date',array('for'=>'tcDate','class'=>'control-label')) ?>
				</div>
				<div class="span4">
					<?php echo $form->datePickerRow($model,'tc_date',array('id'=>'tcDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span10 datepicker','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
				</div>
				<div class="span1">
					<?php echo $form->label($model,'to_date',array('for'=>'to_date','class'=>'control-label')) ?>
				</div>
				<div class="span4">
					<?php echo $form->datePickerRow($model,'to_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span10 datepicker','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span4">
					<?php echo $form->label($model,'Client',array('class'=>'control-label')) ?>
				</div>
				<div class="span5">
					<?php //echo $form->radioButtonListInlineRow($model,'client_type',array('All','Specified'),array('id'=>'clientType','label'=>false,'onChange'=>'clientList()')) ?>
					<input type="radio" name="Rpttradeconf[client_type]" id="Rpttradeconf_client_type_0" onchange="clientList()" value="0"  <?php if($model->client_type == 0)echo 'checked' ?>/>
					&nbsp;All
					&emsp;
					<input type="radio" name="Rpttradeconf[client_type]" id="Rpttradeconf_client_type_1" onchange="clientList()" value="1" <?php if($model->client_type == 1)echo 'checked' ?>/>
					&nbsp;Specified
				</div>
				<div class="span3">
					<?php // echo $form->dropDownList($model,'client_cd',CHtml::listData(Tcontracts::model()->findAll(array('select'=>'DISTINCT client_cd','condition'=>"contr_dt = TO_DATE('$model->tc_date','DD/MM/YYYY') AND contr_stat <> 'C' ",'order'=>'client_cd')), 'client_cd', 'client_cd'),array('id'=>'clientCd','class'=>'span','style'=>'display:none;')) ?>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span4">
					<?php echo $form->label($model,'From client',array('class'=>'control-label')) ?>
				</div>
				<div class="span3">
					<?php //echo $form->dropDownListRow($model,'cl_type',CHtml::listData(Lsttype3::model()->findAll(array('order'=>'cl_type3')), 'cl_type3','cl_desc'),array('label'=>false,'class'=>'span','prompt'=>'-All-')) ?>
					<?php echo $form->textField($model,'from_client',array('class'=>'span','style'=>'margin-left:-10%'));?>
				</div>
				<div class="span2">
					<?php echo $form->label($model,'To client',array('for'=>'to_date','class'=>'control-label')) ?>
				</div>
				<div class="span3">
					<?php echo $form->textField($model,'to_client',array('class'=>'span','style'=>'margin-left:-10%'));?>
				</div>
			</div>
			<div class="row-fluid">
					<div class="span4">
						<?php echo $form->label($model,'Branch',array('class'=>'control-label')) ?>
					</div>
					<div class="span5">
						<input type="radio" name="Rpttradeconf[brch_type]" id="Rpttradeconf_brch_type_0" onchange="brchList()" value="0"  <?php if($model->brch_type == 0)echo 'checked' ?>/>
						&nbsp;All
						&emsp;
						<input type="radio" name="Rpttradeconf[brch_type]" id="Rpttradeconf_brch_type_1" onchange="brchList()" value="1" <?php if($model->brch_type == 1)echo 'checked' ?>/>
						&nbsp;Specified
					
					</div>
						<?php //echo $form->dropDownList($model,'brch_cd',CHtml::listData(Ttcdoc1::model()->findAll(array('select'=>'DISTINCT brch_cd','condition'=>"tc_date = TO_DATE('$model->tc_date','DD/MM/YYYY') AND tc_status = 0",'order'=>'brch_cd')), 'brch_cd', 'brch_cd'),array('id'=>'brchCd','class'=>'span3','style'=>'display:none')) ?>
						<?php echo $form->dropDownList($model,'brch_cd',CHtml::listData(Branch::model()->findAll(array('select'=>"brch_cd, brch_cd||' - '||brch_name brch_name",'condition'=>"approved_stat='A' ",'order'=>'brch_cd')), 'brch_cd', 'brch_name'),array('id'=>'brchCd','class'=>'span3','prompt'=>'-Select-','style'=>'display:none;font-family:courier')) ?>
				</div>
				
			<div class="row-fluid">
					<div class="span4">
						<?php echo $form->label($model,'Sales',array('class'=>'control-label')) ?>
					</div>
					<div class="span5">
						<input type="radio" name="Rpttradeconf[rem_type]" id="Rpttradeconf_rem_type_0" onchange="remList()" value="0"  <?php if($model->rem_type == 0)echo 'checked' ?>/>
						&nbsp;All
						&emsp;
						<input type="radio" name="Rpttradeconf[rem_type]" id="Rpttradeconf_rem_type_1" onchange="remList()" value="1" <?php if($model->rem_type == 1)echo 'checked' ?>/>
						&nbsp;Specified
						
					</div>
						<?php //echo $form->dropDownList($model,'rem_cd',CHtml::listData(Ttcdoc1::model()->findAll(array('select'=>'DISTINCT rem_cd','condition'=>"tc_date = TO_DATE('$model->tc_date','DD/MM/YYYY') AND tc_status = 0",'order'=>'rem_cd')), 'rem_cd', 'rem_cd'),array('id'=>'remCd','class'=>'span3','style'=>'display:none')) ?>
						<?php echo $form->dropDownList($model,'rem_cd',CHtml::listData(Sales::model()->findAll(array('select'=>"rem_cd,rem_cd ||' - '|| rem_name rem_name",'condition'=>"APPROVED_STAT='A'",'order'=>'rem_cd')), 'rem_cd', 'rem_name'),array('id'=>'remCd','class'=>'span3','prompt'=>'-Select-','style'=>'display:none;font-family:courier')) ?>
			</div>
				
			<div class="control-group">
			
				<div class="span10">
					<?php echo $form->dropDownListRow($model,'cl_type',CHtml::listData(Lsttype3::model()->findAll(array('order'=>'cl_type3')), 'cl_type3','cl_desc'),array('class'=>'offset1 span4','prompt'=>'-All-')) ?>
				</div>
			</div>
			
		</div>
		<div class="span6">
	
			<div class="control-group">
				<div class="span3">
					<label>E-Mail Status</label>
				</div>
				<div class="span8">
					<input type="radio"  id="email_option_0" value="A" name="Rpttradeconf[email_option]" style="float:left" <?php if($model->email_option == 'A')echo 'checked' ?> />
					<label for="email_option_0" style="float:left">&nbsp; ALL</label>
				</div>
			</div>
			<div class="control-group">
				<div class="offset3 span10">
				<input type="radio"  id="email_option_1" value="Y" name="Rpttradeconf[email_option]" style="float:left" <?php if($model->email_option == 'Y')echo 'checked' ?> />
					<label for="email_option_1" style="float:left">&nbsp; Clients with e-mail</label>
				</div>
			</div>
			<div class="control-group">
				<div class="offset3 span10">
				<input type="radio"  id="email_option_2" value="N" name="Rpttradeconf[email_option]" style="float:left" <?php if($model->email_option == 'N')echo 'checked' ?> />
					<label for="email_option_2" style="float:left">&nbsp; Clients without e-mail</label>
				</div>
			</div>
			<div class="control-group">
				<div class="offset3 span10">
				<input type="radio"  id="email_option_3" value="E" name="Rpttradeconf[email_option]" style="float:left" <?php if($model->email_option == 'E')echo 'checked' ?> />
					<label for="email_option_3" style="float:left">&nbsp; Delivery preference: E-Mail, Both</label>
				</div>
			</div>
			<div class="control-group">
				<div class="offset3 span10">
				<input type="radio"  id="email_option_4" value="F" name="Rpttradeconf[email_option]" style="float:left" <?php if($model->email_option == 'F')echo 'checked' ?> />
					<label for="email_option_4" style="float:left">&nbsp; Delivery preference: Fax, None</label>
				</div>
			</div>
			
		</div>		
	</div>
	
	
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Print English Version',
					'id'=>'btnEng',
					'disabled'=>$button_flg->dflg1=='Y'?false:true
					//'htmlOptions'=>array('onclick'=>'printTCEng();')
		)); ?>
		&emsp;
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Print Indonesian Version',
					'id'=>'btnIndo',
					'disabled'=>$button_flg->dflg2=='Y'?false:true
					//'htmlOptions'=>array('onclick'=>'printTCInd();')
		)); ?>
	</div>
	<iframe  src="<?php echo $url;?>" id="report" class="span12" style="min-height:600px;max-width: 100%;"></iframe>	
	<br/><br/>
	
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
	
	$('.tdate').change(function(){
	    //getClientList();
       // getBrchList();
      //  getRemList();
	})
	
	function init()
	{
		$(".datepicker").datepicker({format : "dd/mm/yyyy"});
		if($('#report').attr('src') =='')
		{
			$('#report').hide();
		}
		clientList();
		//brchList();
		//remList();
		getClient();
	}
		
	/*	
	function getClientList()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php //echo $this->createUrl('ajxGetClientList2'); ?>',
			'dataType' : 'json',
			'data'     : {
							'tc_date' : $("#tcDate").val(),
						}, 
			'success'  : function(data){
				var result = data.content.client_cd;
				
				$('#clientCd').empty();
				
				$.each(result, function(i, item) {
			    	$('#clientCd').append($('<option>').val(result[i]).text(result[i]));
				});		
			}
		});
	}
	
	function getBrchList()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php //echo $this->createUrl('ajxGetBrchList'); ?>',
			'dataType' : 'json',
			'data'     : {
							'from_date' : $('#tcDate').val(),
                            'to_date' : $('#Rpttradeconf_to_date').val()
						}, 
			'success'  : function(data){
				var result = data.content.brch_cd;
				
				$('#brchCd').empty();
				
				$.each(result, function(i, item) {
			    	$('#brchCd').append($('<option>').val(result[i]).text(result[i]));
				});		
			}
		});
	}
	
    	function getRemList()
    	{
    		$.ajax({
        		'type'     :'POST',
        		'url'      : '<?php //echo $this->createUrl('ajxGetRemList'); ?>',
    			'dataType' : 'json',
    			'data'     : {
    							'from_date' : $('#tcDate').val(),
                                'to_date' : $('#Rpttradeconf_to_date').val()
    						}, 
    			'success'  : function(data){
    				var result = data.content.rem_cd;
    				
    				$('#remCd').empty();
    				
    				$.each(result, function(i, item) {
    			    	$('#remCd').append($('<option>').val(result[i]).text(result[i]));
    				});		
    			}
    		});
    	}
	*/
	function clientList()
	{	
		if($("#Rpttradeconf_client_type_1").is(':checked'))
		{
			//$("#clientCd").show();
			$('#Rpttradeconf_from_client').prop('disabled',false);
			$('#Rpttradeconf_to_client').prop('disabled',false);
			
		}
		else
		{
			//$("#clientCd").hide();
			$('#Rpttradeconf_from_client').prop('disabled',true);
			$('#Rpttradeconf_to_client').prop('disabled',true);
		}
	}
	
	function brchList()
	{	
		if($("#Rpttradeconf_brch_type_1").is(':checked'))
		{
			$("#brchCd").show();
		}
		else
		{
			$("#brchCd").hide();
		}
	}
	
	function remList()
	{	
		if($("#Rpttradeconf_rem_type_1").is(':checked'))
		{
			$("#remCd").show();
		}
		else
		{
			$("#remCd").hide();
		}
	}
	
	$('#btnEng').click(function(){
		$('#mywaitdialog').dialog("open");
		$('#scenario').val('english');
	});
	$('#btnIndo').click(function(){
		$('#mywaitdialog').dialog("open");
		$('#scenario').val('indonesia');
	});
	$('#tcDate').change(function(){
		$('#Rpttradeconf_to_date').val($('#tcDate').val());
		getClient();
	})
	
	
	function getClient()
	{
		//alert('est');
		//var glAcctCd = $(obj).val();
		var result = [];
		 
		$('#Rpttradeconf_from_client ,#Rpttradeconf_to_client').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getclient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						'from_date' : $('#tcDate').val(),
		        						'to_date' : $('#Rpttradeconf_to_date').val()
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
		    minLength: 0,
		    open: function()
		   {
        		$(this).autocomplete("widget").width(400); 
           },
          /*
           position: 
           {
           	    offset: '0 0' // Shift 150px to the left, 0px vertically.
    	   }
		*/
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
	}
	
	
	$('#Rpttradeconf_from_client').change(function(){
		$('#Rpttradeconf_to_client').val($('#Rpttradeconf_from_client').val().toUpperCase($('#Rpttradeconf_from_client').val()));
	})
</script>