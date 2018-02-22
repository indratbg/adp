<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
	
	label.radio input[type=radio]{margin-left:-50px}
	label.radio label{margin-left:-30px}
	
</style>

<?php
$this->breadcrumbs=array(
	'List'=>array('index'),
	'Generate',
);

$this->menu=array(
	array('label'=>'Generate Statement of Account ', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Generate', 'url'=>array('generate'),'icon'=>'plus','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::applyFormatting() ?>
	
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
	
	$currYear = date('Y');
	
	$year = array();
	
	$result = DAO::queryRowSql("SELECT DDATE1 FROM MST_SYS_PARAM WHERE PARAM_ID = 'SOA' AND PARAM_CD1 = 'BGN_DATE'");
	$bgnDate = $result['ddate1'];
	
	$bgnYear = DateTime::createFromFormat('Y-m-d H:i:s',$bgnDate)->format('Y');
 	
	for($x=$currYear;$x>=$bgnYear;$x--)
	{
		$year[$x] = $x;
	}
	
	$purpose = array('C'=>'Client','D'=>'Client Detail','O'=>'Operational by due date','T'=>'Operational by transaction date');
	
	$checkParam = DAO::queryRowSql("SELECT DFLG1 FROM MST_SYS_PARAM WHERE param_id = 'SOA' and param_cd1 = 'PURPOSE' AND param_cd2 = 'CLIENT_D'");
	
	if($checkParam['dflg1'] == 'N')
	{
		unset($purpose['D']);
	}
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'soa-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php echo $form->errorSummary($model); ?>

	<br/>

	<div class="row-fluid"> 
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'Transaction Date',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->dropDownList($model,'month',$month,array('id'=>'month','class'=>'span3')) ?>
				<?php echo $form->dropDownList($model,'year',$year,array('id'=>'year','class'=>'span2')) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					From
				</div>	 
				<?php echo $form->textField($model,'from_dt',array('id'=>'fromDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span3','required'=>true)); ?>
				&emsp;
				To &nbsp;
				<?php echo $form->textField($model,'to_dt',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span3','required'=>true)); ?>
			</div>
			
			<?php 
				$x = 0;
				
				foreach($purpose as $key=>$value)
				{
			?>
			<div class="control-group">
				<div class="span3">
				<?php 
					if($x == 0)
					{
						echo $form->label($model,'Purpose',array('class'=>'control-label'));
					}
					else
					{
						echo '&nbsp;';
					}
				?>
				</div>
				<input id="Soa_purpose_<?php echo $x ?>" class="purpose" type="radio" name="Soa[purpose]" value="<?php echo $key ?>" style="float:left" <?php if($model->purpose == $key)echo 'checked' ?>>
				<label for="Soa_purpose_<?php echo $x ?>" style="float:left">&emsp;<?php echo $value ?></label>
			</div>
			
			<?php 
					$x++;
				} 
			?>
			
			<!--
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'Purpose',array('class'=>'control-label')) ?>
				</div>
				<?php //echo $form->radioButtonListRow($model,'purpose',$purpose,array('class'=>'purpose','label'=>false)) ?>
				<div class="controls">
					<input id="Soa_purpose_0" class="purpose" type="radio" name="Soa[purpose]" value="C" style="float:left" <?php if($model->purpose == 'C')echo 'checked' ?>>
					<label for="Soa_purpose_0" style="float:left">&emsp;Client</label>
				</div>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="Soa_purpose_1" class="purpose" type="radio" name="Soa[purpose]" value="O" style="float:left" <?php if($model->purpose == 'O')echo 'checked' ?>>
				<label for="Soa_purpose_1" style="float:left">&emsp;Operational by due date</label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="Soa_purpose_2" class="purpose" type="radio" name="Soa[purpose]" value="T" style="float:left" <?php if($model->purpose == 'T')echo 'checked' ?>>
				<label for="Soa_purpose_2" style="float:left">&emsp;Operational by transaction date</label>
			</div>
			-->
		</div>
		
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'Client',array('class'=>'control-label')) ?>
				</div>
				Search By &emsp;<?php echo $form->dropDownList($model,'client_search_type',array('Code'=>'Client Code','Name'=>'Client Name'),array('id'=>'clientSearchType','class'=>'span3')) ?>
				<?php echo $form->dropDownList($model,'client_susp',array('All'=>'ALL','Active'=>'Active'),array('id'=>'clientSusp','class'=>'span3')) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'From Client',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'client_from',array('id'=>'clientFrom','class'=>'span2','style'=>'width:85px')) ?>
				<?php echo $form->textField($model, 'client_from_susp',array('id'=>'clientFromSusp','class'=>'clientSusp span1','readonly'=>true,'style'=>'width:25px')) ?>
				<?php echo $form->textField($model, 'client_from_branch',array('id'=>'clientFromBranch','class'=>'clientBranch span1','readonly'=>true,'style'=>'width:35px')) ?>
				<?php echo $form->textField($model, 'client_from_name',array('id'=>'clientFromName','class'=>'clientName span5','readonly'=>true)) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'To Client',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'client_to',array('id'=>'clientTo','class'=>'span2','style'=>'width:85px')) ?>
				<?php echo $form->textField($model, 'client_to_susp',array('id'=>'clientToSusp','class'=>'clientSusp span1','readonly'=>true,'style'=>'width:25px')) ?>
				<?php echo $form->textField($model, 'client_to_branch',array('id'=>'clientToBranch','class'=>'clientBranch span1','readonly'=>true,'style'=>'width:35px')) ?>
				<?php echo $form->textField($model, 'client_to_name',array('id'=>'clientToName','class'=>'clientName span5','readonly'=>true)) ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'From Branch',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'branch_from',array('id'=>'branchFrom','class'=>'span2')) ?>
				<?php echo $form->textField($model, 'branch_from_name',array('id'=>'branchFromName','class'=>'branchName span4','readonly'=>true)) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'To Branch',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'branch_to',array('id'=>'branchTo','class'=>'span2')) ?>
				<?php echo $form->textField($model, 'branch_to_name',array('id'=>'branchToName','class'=>'branchName span4','readonly'=>true)) ?>
			</div>
		</div>
		
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'From Sales',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'sales_from',array('id'=>'salesFrom','class'=>'span2')) ?>
				<?php echo $form->textField($model, 'sales_from_name',array('id'=>'salesFromName','class'=>'salesName span6','readonly'=>true)) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'To Sales',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'sales_to',array('id'=>'salesTo','class'=>'span2')) ?>
				<?php echo $form->textField($model, 'sales_to_name',array('id'=>'salesToName','class'=>'salesName span6','readonly'=>true)) ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid"> 
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'Online Trading',array('class'=>'control-label')) ?>
				</div>
				<?php //echo $form->radioButtonListRow($model,'olt_flg',array('A'=>'All','Y'=>'Online Trading','N'=>'Non Online Trading'),array('class'=>'oltFlg','label'=>false)) ?>
			
				<div class="controls">
					<input id="Soa_olt_flg_0" class="oltFlg" type="radio" name="Soa[olt_flg]" value="A" style="float:left" <?php if($model->olt_flg == 'A')echo 'checked' ?>>
					<label for="Soa_olt_flg_0" style="float:left">&emsp;ALL</label>
				</div>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="Soa_olt_flg_1" class="oltFlg" type="radio" name="Soa[olt_flg]" value="Y" style="float:left" <?php if($model->olt_flg == 'Y')echo 'checked' ?>>
				<label for="Soa_olt_flg_1" style="float:left">&emsp;Online Trading</label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="Soa_olt_flg_2" class="oltFlg" type="radio" name="Soa[olt_flg]" value="N" style="float:left" <?php if($model->olt_flg == 'N')echo 'checked' ?>>
				<label for="Soa_olt_flg_2" style="float:left">&emsp;Non Online Trading</label>
			</div>
		</div>
		
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'email_flg',array('class'=>'control-label')) ?>
				</div>
			
				<div class="controls">
					<input id="Soa_email_flg_0" class="emailFlg" type="radio" name="Soa[email_flg]" value="A" style="float:left" <?php if($model->email_flg == 'A')echo 'checked' ?>>
					<label for="Soa_email_flg_0" style="float:left">&emsp;ALL</label>
				</div>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="Soa_email_flg_1" class="emailFlg" type="radio" name="Soa[email_flg]" value="Y" style="float:left" <?php if($model->email_flg == 'Y')echo 'checked' ?>>
				<label for="Soa_email_flg_1" style="float:left">&emsp;Clients with e-mail</label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="Soa_email_flg_2" class="emailFlg" type="radio" name="Soa[email_flg]" value="N" style="float:left" <?php if($model->email_flg == 'N')echo 'checked' ?>>
				<label for="Soa_email_flg_2" style="float:left">&emsp;Clients without e-mail</label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="Soa_email_flg_3" class="emailFlg" type="radio" name="Soa[email_flg]" value="E" style="float:left" <?php if($model->email_flg == 'E')echo 'checked' ?>>
				<label for="Soa_email_flg_3" style="float:left">&emsp;Delivery preference: E-Mail, Both</label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="Soa_email_flg_4" class="emailFlg" type="radio" name="Soa[email_flg]" value="F" style="float:left" <?php if($model->email_flg == 'F')echo 'checked' ?>>
				<label for="Soa_email_flg_4" style="float:left">&emsp;Delivery preference: Fax, None</label>
			</div>
		</div>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnPrint',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Process',
		)); ?>
	</div>
	
	<div id="showloading" style="display:none;margin-top: -50px; width: auto; text-align: center;">
		Please wait...<br />
		<img src="<?php echo Yii::app()->request->baseUrl ?>/images/loading2.gif" width="25px">	
	</div>
	
	<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'style'=>'display:none')) ?>
	
<?php $this->endWidget(); ?>

<iframe id="iframe" src="<?php echo $url; ?>" style="min-height:600px; margin-top: -30px;"></iframe>

<script>
	var searchOpt;
	var suspFlg;

	$(document).ready(function()
	{
		$("#fromDt").datepicker({format:'dd/mm/yyyy'});
		$("#toDt").datepicker({format:'dd/mm/yyyy'});
		
		setAutoCompleteClient();
		setAutoCompleteOther();
		
		if('<?php echo $url ?>')
		{
			$("#showloading").show();
			adjustIframeSize();
		}
	});
	
	$(window).resize(function()
	{
		adjustIframeSize();
	});
	
	$("#btnPrint").click(function()
	{
		if($("#clientFrom").val() == '' || $("#clientTo").val() == '')
		{
			if(!confirm("\"From Client\" and/or \"To Client\" is blank. Do you want to continue?"))
			{
				return false;
			}
		}
	});
	
	$("#iframe").load(function()
	{
		$("#showloading").hide();
	});
	
	$("#clientSearchType, #clientSusp").change(function()
	{
		setAutoCompleteClientOpt();
	});
	
	$("#clientFrom").blur(function()
	{
		if($("#clientFrom").val())
			$("#clientTo").val($("#clientFrom").val()).blur();
	});
	
	$("#branchFrom").blur(function()
	{
		if($("#branchFrom").val())
			$("#branchTo").val($("#branchFrom").val()).blur();
	});
	
	$("#salesFrom").blur(function()
	{
		if($("#salesFrom").val())
			$("#salesTo").val($("#salesFrom").val()).blur();
	});
	
	$("#month, #year").change(function()
	{
		var firstDate = new Date($("#year").val(),$("#month").val()-1,1);
		var lastDate = new Date($("#year").val(),$("#month").val(),0);
		
		$("#fromDt").val('0'+firstDate.getDate() + '/' + ('0'+(firstDate.getMonth()+1)).slice(-2) + '/' + firstDate.getFullYear()).datepicker('update');
		$("#toDt").val(lastDate.getDate() + '/' + ('0'+(lastDate.getMonth()+1)).slice(-2) + '/' + lastDate.getFullYear()).datepicker('update');
	});
	
	function adjustIframeSize()
	{
		$("#iframe").offset({left:-26});
		$("#iframe").css('width',($(window).width()+35));
	}
	
	function setAutoCompleteClientOpt()
	{
		searchOpt = $("#clientSearchType").val();
		suspFlg = $("#clientSusp").val();
	}
	
	function setAutoCompleteClient()
	{
		var result = '';
		
		setAutoCompleteClientOpt();
		
		$("#clientFrom, #clientTo").autocomplete(
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
        	var susp_stat = '';
        	
        	$.each(result,function()
        	{
        		if(this.value.toUpperCase() == inputVal)
        		{
        			branch = this.branch;
        			name = this.name
        			susp_stat = this.susp_stat
        		}
        	});
        	
        	$(this).siblings('.clientBranch').val(branch);
        	$(this).siblings('.clientName').val(name);
        	$(this).siblings('.clientSusp').val(susp_stat);
        });
	}
	
	function setAutoCompleteOther()
	{
		var result;
		
		$("#branchFrom, #branchTo").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getBranch'); ?>',
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
		   minLength: 0,
		   open: function(){
        		$(this).autocomplete("widget").width(300).css({'max-height':300,'overflow-y':'auto'}); 
        	}
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        }).blur(function()
        {
        	$(this).val($(this).val().toUpperCase());
        	var inputVal = $(this).val();
        	var name = '';
        	
        	$.each(result,function()
        	{
        		if(this.value.toUpperCase() == inputVal)
        		{
        			name = this.name
        		}
        	});
        	
        	$(this).siblings('.branchName').val(name);
        });
        
        $("#salesFrom, #salesTo").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getSales'); ?>',
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
		   minLength: 0,
		   open: function(){
        		$(this).autocomplete("widget").width(350).css({'max-height':300,'overflow-y':'auto'}); 
        	}
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        }).blur(function()
        {
        	$(this).val($(this).val().toUpperCase());
        	var inputVal = $(this).val();
        	var name = '';
        	
        	$.each(result,function()
        	{
        		if(this.value.toUpperCase() == inputVal)
        		{
        			name = this.name
        		}
        	});
        	
        	$(this).siblings('.salesName').val(name);
        });
	}
</script>
