<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php

$this->breadcrumbs=array(
	'Interest Process'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Interest Process', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

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
	//$year=array(2015=>'2015',2014=>'2014',2013=>'2013');
	$currYear=date('Y');
	$year=array();
	
	$result=Dao::queryRowSql("SELECT DDATE1 FROM MST_SYS_PARAM WHERE PARAM_ID='SOA' AND PARAM_CD1='BGN_DATE'");
	$bgnDate=$result['ddate1'];
	
	$bgnYear = DateTime::createFromFormat('Y-m-d H:i:s',$bgnDate)->format('Y');
	
	for($x=$currYear;$x>=$bgnYear;$x--){
		$year[$x]=$x;
	}
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'processDepFixAsset-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	
	<?php echo $form->errorSummary($model); ?>
	<?php AHelper::showFlash($this) ?> 
	 <br/>
 	<!--<center><strong style="font-size: 15pt;">Interest Process</strong></center>-->
	<div class="row-fluid">
		<div class="span9">
			<div class="control-group">
				<div class="span4">
					<?php echo $form->radioButton($model, 'search_md',array('id'=>'option1','value'=>'0','class'=>'span1 option')). " All Client (SPV access only)" ?>
					<br/>
					<?php echo $form->radioButton($model, 'search_md',array('id'=>'option2','value'=>'1','class'=>'span1 option')). " By Client" ?>	
			 	</div>
			</div>
			
			<div class="control-group">
				
				<div class="span2">
					<?php echo $form->label($model,'Search By',array('class'=>'control-label')) ?>
				</div>
					<?php echo $form->dropDownList($model,'client_search_type',array('Code'=>'Client Code','Name'=>'Client Name'),array('id'=>'clientSearchType','class'=>'span3')) ?>
					
					<?php echo $form->dropDownList($model,'client_search_susp',array('All'=>'ALL','Active'=>'Active'),array('id'=>'clientSearchSusp','class'=>'span3')) ?>
					
			</div>
			
			<div class="control-group">
				
				<div class="span2">
					<?php echo $form->label($model,'Client : ',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'client_cd',array('id'=>'client_Cd','required'=>'required','class'=>'span2','style'=>'width:85px'));?>
				<?php echo $form->textField($model,'client_susp',array('id'=>'client_Susp','readonly'=>true,'class'=>'clientSusp span1','style'=>'width:25px'));?>
		 		<?php echo $form->textField($model,'client_branch',array('id'=>'client_Branch','readonly'=>true,'class'=>'clientBranch span1','style'=>'width:35px'));?>
		 		<?php echo $form->textField($model,'client_nm',array('id'=>'client_Name','readonly'=>true,'class'=>'clientName span4'));?>
			</div>
			<div class="control-group">
				
				<div class="span2">
					<?php echo $form->label($model,'Client Type ',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'client_type',array('id'=>'client_Type','readonly'=>true,'class'=>'clientType span1','style'=>'width:35px'));?>
				<?php echo $form->textField($model,'type_desc',array('id'=>'client_Type_Desc','readonly'=>true,'class'=>'clientTypeDesc span1','style'=>'width:160px'));?>
			</div>
			
			<div class="control-group ">
				<div class="span6">
					<?php echo $form->labelEx($model,'branch_code',array('class'=>'control-label')) ?>
					<?php echo $form->checkBox($model,'branch_all_flg',array('value'=>'Y','uncheckValue'=>'N','id'=>'branchAllFlg')) ?>
					All
					&emsp;
					<?php echo $form->dropDownList($model,'branch_code',CHtml::listData(Branch::model()->findAll(array('condition'=>"approved_stat = 'A'",'order'=>'brch_cd')), 'brch_cd', 'codeAndName'),array('class'=>'span4','id'=>'branchCode','prompt'=>'-Choose Branch-')) ?>
				</div>
			</div>
			
			<br/>
			
			<div class="control-group">
				
				<div class="span2">
					<?php echo $form->label($model,'For The Month Of : ',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->dropDownList($model,'month',$month,array('id'=>'month','class'=>'span2')) ?>
				<?php echo $form->dropDownList($model,'year',$year,array('id'=>'year','class'=>'span2')) ?>
				
			</div>	
			<!--
			<div class="control-group">
				<div class="span1">
					<?php echo $form->checkbox($model,'take_from_soa',array('value'=>'Y','uncheckValue'=>'N')) ?>
				</div>
					<?php echo $form->label($model,'Take Beginning Balance from statement of account') ?>
			</div>
			-->
			
			<div class="control-group"></div>
			
			<div class="control-group">
				Due Date From &nbsp;
				<?php echo $form->textField($model,'from_due_dt',array('id'=>'fromDueDt','readonly'=>false,'placeholder'=>'dd/mm/yyyy','class'=>'span2 tdate','required'=>true)); ?>
				&emsp;
				To &nbsp;
				<?php echo $form->textField($model,'to_due_dt',array('id'=>'toDueDt','readonly'=>false,'placeholder'=>'dd/mm/yyyy','class'=>'span2 tdate','required'=>true)); ?>
				&emsp;&emsp;&emsp;
				Closing Date &nbsp;
				<?php echo $form->textField($model,'closing_dt',array('id'=>'closingDt','placeholder'=>'dd/mm/yyyy','class'=>'span2 tdate','required'=>true)); ?>
			</div>
			
		</div>	
	</div>
	
	
	
	<div class="control-group">
	</div>
	
	<div class="control-group">
		<div class="span2">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Process',
			'id'=>'btnProcess',
			'htmlOptions'=>array("class"=>"control-group",'disabled'=>$flag=='Y'?true:false,'style'=>$flag=='Y'?'opacity:0.2':'opacity:1'),
		)); ?>
		</div>
		
	</div>
	
	<?php echo $form->datePickerRow($model,'dummy_dt',array('label'=>false,'style'=>'display:none')) ?>
	<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'Interest Process In Progress',
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


<script type="text/javascript" charset="utf-8">
	
	var searchOpt;
	var suspFlg;
	var authorizedSpv = true;
	
	optionClientCd();
	
	$(document).ready(function()
	{
	//	$("#fromDueDt").datepicker({format:'dd/mm/yyyy'});
	//	$("#toDueDt").datepicker({format:'dd/mm/yyyy'});
		$(".tdate").datepicker({format:'dd/mm/yyyy'});
		
		setAutoCompleteClient();
		//setAutoCompleteOther();
		
		
	});
	
	$("#clientSearchType, #clientSearchSusp").change(function()
	{
		setAutoCompleteClientOpt();
	});
	
	$("#branchCode").change(function()
	{
		if($(this).val())$("#branchAllFlg").prop('checked',false);
		else
			$("#branchAllFlg").prop('checked',true);
	});
	
	$("#branchAllFlg").click(function()
	{
		if($(this).is(":checked"))$("#branchCode").val("").removeAttr("required");
		else
			$("#branchCode").attr("required",true);
	});
	
	function setAutoCompleteClientOpt()
	{
		searchOpt = $("#clientSearchType").val();
		suspFlg = $("#clientSearchSusp").val();
	}
	
	function setAutoCompleteClient()
	{
		var result;
		
		setAutoCompleteClientOpt();
		
		$("#client_Cd").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getClient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						'searchOpt' : searchOpt,
		        						'suspFlg' : suspFlg
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				response(data);
				           				result = data;
				    				}
				});
		   },
		   minLength: 1,
		   open: function()
		   {
        		$(this).autocomplete("widget").width(500); 
           },
           position: 
           {
           	    offset: '-150 0' // Shift 150px to the left, 0px vertically.
    	   }
        
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        }).blur(function()
        {
        	$(this).val($(this).val().toUpperCase());
        	var inputVal = $(this).val();
        	var branch = '';
        	var name = '';
        	var susp_stat = 'C';
        	var client_type='';
        	var client_type_desc='';
        	$.each(result,function()
        	{
        		if(this.value.toUpperCase() == inputVal)
        		{
        			branch = this.branch;
        			name = this.name
        			susp_stat = this.susp_stat
        			client_type=this.client_type;
        			client_type_desc=this.client_type_desc;
        		}
        	});
        	// console.log("branch: "+branch);
        	// console.log("name: "+name);
        	// console.log("susp: "+susp_stat);
        	// console.log("type: "+client_type);
        	// console.log("desc: "+client_type_desc);
        	$(this).siblings('.clientBranch').val(branch);
        	$(this).siblings('.clientName').val(name);
        	$(this).siblings('.clientSusp').val(susp_stat);
        	$('#client_Type').val(client_type);
        	$('#client_Type_Desc').val(client_type_desc);
        });
	}
	
	
	$("#btnProcess").click(function(event)
	{	
		//event.preventDefault();
		//console.log("klik");
		if($("input[type='radio'][id='option1']:checked").val()||($("input[type='radio'][id='option2']:checked").val()&&$("#client_Cd").val())){
			if(confirm("Process Interest ?")){
				$('#mywaitdialog').dialog("open"); 
			}else{
				return false;
			}
		
		}
	})
	
	$("#openClientSelection").click(function(event)
		{
			//console.log("open");
			$('#clientSelection').dialog("open"); 
		}
	)
	
	$('.option').change(function(){
		optionClientCd();
	})
	
	function optionClientCd()
	{	
		if(!checkSpv()){
			
			 $('#option1').attr('disabled',true);
			// $('#option2').attr('disabled',true);
			
		}else{
			var isByClient=$('#option2').is(':checked');
			$('#clientSearchType').attr('readonly',!isByClient);
			$('#clientSearchSusp').attr('readonly',!isByClient);
			$('#clientSearchType').attr('disabled',!isByClient);
			$('#clientSearchSusp').attr('disabled',!isByClient);
			$('#client_Cd').attr('readonly',!isByClient);
			
		}
		if($('#option1:checked').val()){
			
			$('#Interestprs_take_from_soa').attr('disabled',true);
			$('#Interestprs_take_from_soa').attr('checked',false);
		}else{
			
			$('#Interestprs_take_from_soa').attr('disabled',false);
		}
		
	}
	function checkSpv()
	{
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ajxValidateSpv'); ?>',
				'dataType' : 'json',
				'statusCode':
				{
					403		: function(data){
						authorizedSpv = false;
					}
				},
				'async':false
			});
			
			return authorizedSpv;
	}		
	
	$("#month, #year").change(function()
	{
		var firstDate = new Date($("#year").val(),$("#month").val()-1,1);
		var lastDate  = new Date($("#year").val(),$("#month").val(),0);
		
		$("#fromDueDt").val('0'+firstDate.getDate() + '/' + ('0'+(firstDate.getMonth()+1)).slice(-2) + '/' + firstDate.getFullYear());
		$("#toDueDt").val(lastDate.getDate() + '/' + ('0'+(lastDate.getMonth()+1)).slice(-2) + '/' + lastDate.getFullYear());
		
		$("#closingDt").val(lastDate.getDate() + '/' + ('0'+(lastDate.getMonth()+1)).slice(-2) + '/' + lastDate.getFullYear()).datepicker('update');
		
	});
	
</script>


