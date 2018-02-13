<style>
#tableDetail
	{
		background-color:#C3D9FF;
	}
	#tableDetail thead, #tableDetail tbody
	{
		display:block;
	}
	#tableDetail tbody
	{
		height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}



	#Type > label
	{
		width:100px;
		margin-left:-12px;
	}
	
	#Type > label > label
	{
		float:left;
		margin-top:3px;
		margin-left:-10px;
	}
	
	#Type > label > input
	{
		float:left;
	}
</style>
<?php

$this->breadcrumbs=array(
	'Generate Receipt Dividen Voucher'=>array('index'),
	'List',
);

$this->menu=array(
	//array('label'=>'Tvd55', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Generate Receipt Dividen Voucher', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
		array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),

	
);

?>
<br />

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'VoucherDiv-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 
 ?>
 
 <?php if($cek_pape=='Y')
 {
 	$label_today='Today';
 }
else{
	$label_today='Payment';
}
?>
			
			<?php
	$gl_a = Glaccount::model()->findAll(array("select"=>"DISTINCT(TRIM(gl_a)) gl_a, acct_name","condition"=>"sl_a = '000000' AND acct_stat = 'A' AND approved_stat = 'A'","order"=>"gl_a"));
?>
<?php echo $form->errorSummary(array($model,$modelheader,$modelpayrech)); ?>
<?php foreach($modeldetail as $row)echo $form->errorSummary($row); ?>
<?php foreach($modelledger as $row)echo $form->errorSummary($row); ?>
<?php foreach($modelCashDIv as $row)echo $form->errorSummary($row); ?>
<input type="hidden" name="scenario" id="scenario">
<input type="hidden" name="debit" id="debit">
<input type="hidden" name="credit" id="credit">
<input type="hidden" name="balance" id="balance">

<div id="filter">
<div class="row-fluid control-group" >
	<div class="span1"></div>
	<div class="span2">
		<label>Select Voucher Type</label>
	</div>
	<div class="span3" style="margin-left: -50px;">
		<?php  echo $form->radioButtonListInlineRow($model,'type_vch',array('RD'=>'Dividen','TENDER'=>'Tender Offer'),array('id'=>'Type','class'=>'span5','label'=>false)); ?>
		
	</div>

</div>
<div class="row-fluid control-group">
	<div class="span1"></div>
	<div class="span1" style="width: 100px;"><label>Stock Code</label></div>
	<div class="span3">
		<?php //echo  $form->textField($model,'stock_code',array('class'=>'span8'));?>
		<?php echo $form->dropDownList($model,'stock_code',CHtml::listData($stk_cd, 'stk_cd', 'stk_cd'),array('prompt'=>'-Select Stock Code-'));?>
	</div>
</div>
<div class="row-fluid control-group">
	<div class="span1"></div>
		<div class="span1" style="width: 100px;">
		<label>Cum Date</label>
	</div>
	<div class="span3">
	<?php echo $form->textField($model,'cum_date1',array('readonly'=>true,'class'=>'tdate span5','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy'));?>
	</div>
	<div class="span1" style="margin-left: -10em">
		<?php //echo $form->checkBox($model,'check_cum_date',array('class'=>'span'));?>
		<?php echo $form->radioButton($model, 'check',array('id'=>'check_cum_date','value'=>'0','class'=>'span1')) ?>
	</div>
	
</div>
<div class="row-fluid control-group">
	<div class="span1"></div>
	<div class="span1" style="width: 100px;">
		<label><?php echo $label_today;?></label>
	</div>
	<div class="span3" >
	<?php echo $form->textField($model,'today_date',array('readonly'=>true,'class'=>'tdate span5','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy'));?>
	</div>
	<div class="span1" style="margin-left: -10em">
		<?php //echo $form->checkBox($model,'check_today_date',array('class'=>'span'));?>
		<?php echo $form->radioButton($model, 'check',array('id'=>'check_today_date','value'=>'1','class'=>'span1')) ?>
	</div>
</div>

<div class="row-fluid control-group">
	<div class="span1"></div>
	<div class="span1" style="width: 100px;">
		<label>Recording Date</label>
	</div>
	<div class="span3" >
	<?php echo $form->textField($model,'recording_dt',array('readonly'=>true,'class'=>'tdate span5','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy'));?>
</div>
</div>
<div class="row-fluid control-group">
	<div class="span1"></div>
	<div class="span1 branch_code" style="width: 100px;">
		<label>Branch Code</label>
	</div>
	<div class="span3 branch_code">
		<?php echo $form->dropDownList($model,'brch_cd',CHtml::listData(Branch::model()->findAll(array('order'=>'brch_cd')), 'brch_cd', 'brch_cd'),array('class'=>'span5','prompt'=>'-Select-'));?>
	</div>
</div>

<div class="row-fluid control-group">
	<div class="span1"></div>
	<div class="span1">
<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnRetrieve',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'Retrieve',
		'htmlOptions' => array('class'=>'btn btn-small'),
	)); ?>
	</div>
</div>

</div>

<div id="head">
<div class="row-fluid control-group">
	<div class="span2">
		<label>Stock :</label>
	</div>
	<div class="span2">
		<?php echo $form->textField($modelheader,'stk_cd',array('class'=>'span8','readonly'=>true));?>
		<?php echo $form->textField($modelheader,'distrib_dt',array('style'=>'display:none;'));?>
	</div>
	<div class="span1">
		<label>Cum Date</label>
	</div>
	<div class="span2">
		<?php echo $form->textField($modelheader,'cum_date',array('readonly'=>true,'style'=>'margin-left:0px;','class'=>'span8','placeholder'=>'dd/mm/yyyy'));?>
	</div>
	<div class="span2">
		<!--<label>Voucher No.</label>-->
	</div>
	<div class="span2" style="margin-left: -50px;">
		<?php //echo $form->textField($modelheader,'vch_number',array('class'=>'span12','readonly'=>true));?>
	</div>
</div>
		
	<div class="row-fluid control-group">
		<div class="span2">
		<label>Voucher Date</label>	
		</div>
		<div class="span2">
		<?php echo $form->textField($modelheader,'vch_date',array('style'=>'margin-left:0px;','class'=>'tdate span8','placeholder'=>'dd/mm/yyyy'));?>
		</div>
		<div class="span1 branch_code" >
			<label style="width:150px;">Branch Code</label>
		</div>
		<div class="span6 branch_code" >
			<?php echo $form->dropDownList($modelheader,'branch_cd',CHtml::listData(Branch::model()->findAll(array('order'=>'brch_cd')), 'brch_cd', 'brch_cd'),array('class'=>'span2','style'=>'width:95px;','prompt'=>'-Select-'));?>
		</div>
	</div>
	<div class="row-fluid control-group">
	<div class="span2">
		<label><?php echo $cek_pape=='Y'?'Piutang Dividen': 'Bank Gl Acct Cd';?></label>
	</div>
	<div class="span2">
		<?php echo $form->textField($modelheader,'gl_acct_cd',array('class'=>'span5'));?>
		<?php echo $form->textField($modelheader,'sl_acct_cd',array('class'=>'span7'));?>
	</div>
	<div class="span1">
		<label>Amount</label>
	</div>
	<div class="span2">
		<?php echo $form->textField($modelheader,'div_amt',array('class'=>'span12  tnumberdec','style'=>'text-align:right'));?>
	</div>
	</div>	
			
<div class="row-fluid">
	<div class="span2">
		<label>File No.</label>
	</div>
	<div class="span2">
		<?php echo $form->textField($modelheader,'file_no',array('class'=>'span8'));?>
	</div>
	<div class="span1">
		<label>
			Remarks
		</label>
	</div>
	<div class="span7">
		<?php echo $form->textField($modelheader,'remarks',array('class'=>'span10'));?>
	</div>
</div>		
			<div class="form-actions">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnAccept',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'Save',
		'htmlOptions' => array('style'=>'margin-left:0em;','class'=>'btn btn-default'),
	)); ?>	
			</div>
		


<div class="detail" id="detail">
	<table id='tableDetail' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="10%">GL Account</th>
				<th width="13%">SL Account</th>
				<th width="18%">Amount</th>
				<th width="9%">Db/Cr</th>
				<th width="30%">Journal Description</th>
				<th width="3%">
					<a style="cursor: pointer" title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modeldetail as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td class="glAcct">
					<?php if($x == 1): ?>
						<?php echo $form->textField($row,'gl_acct_cd',array('class'=>'span','name'=>'Tpayrecd['.$x.'][gl_acct_cd]','readonly'=>'readonly')); ?>
					<?php else: ?>
						<?php echo $form->dropDownList($row,'gl_acct_cd',CHtml::listData($gl_a, 'gl_a', 'glDescrip'),array('class'=>'span','name'=>'Tpayrecd['.$x.'][gl_acct_cd]','prompt'=>'-Choose-','onChange'=>'filterSlAcct(this)')); ?>
					<?php endif; ?>
				</td>
				<td class="slAcct">
					<?php echo $form->textField($row,'sl_acct_cd',array('class'=>'span','name'=>'Tpayrecd['.$x.'][sl_acct_cd]','readonly'=>$x==1?'readonly':'')); ?>
				</td>
				<td class="amt">
					<?php echo $form->textField($row,'payrec_amt',array('style'=>'text-align:right;','class'=>'span tnumberdec','name'=>'Tpayrecd['.$x.'][payrec_amt]','readonly'=>false)); ?>
				</td>
				<td class="dbcr">
					<?php if($x == 1): ?>
						<?php echo $form->textField($row,'db_cr_flg',array('value'=>$row->db_cr_flg =='D'?'DEBIT':'DEBIT','class'=>'span','name'=>'Tpayrecd['.$x.'][db_cr_flg]','readonly'=>'readonly')); ?>
					<?php else: ?>
						<?php echo $form->dropDownList($row,'db_cr_flg',array('D'=>'DEBIT','C'=>'CREDIT'),array('class'=>'span','name'=>'Tpayrecd['.$x.'][db_cr_flg]','prompt'=>'-Choose-','required'=>'required')); ?>
					<?php endif; ?>
				</td>
				<td class="remarks">
					<?php echo $form->textField($row,'remarks',array('class'=>'span','name'=>'Tpayrecd['.$x.'][remarks]','id'=>"remarks_$x", 'onchange'=>"remarks_detail($x)")); ?>
				</td>
				<td>
					<?php if($x > 1): ?>
					<a title="delete" onclick="deleteRow(this)" style="cursor: pointer">
						<img  src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
					</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	
	<input type="hidden" id="detailCount" name="detailCount"/>
</div>


</div><!--end jurnal-->

	<?php echo $form->datePickerRow($model,'cre_dt',array('style'=>'display:none','label'=>false,'disabled'=>true));?>		
<?php $this->endWidget(); ?>


<script>
	var detailCount = <?php echo count($modeldetail) ?>;
	var cek_pape ='<?php echo $cek_pape;?>';
	var today_date ='<?php echo date('d/m/Y')?>';
	var cek_branch = '<?php echo $cek_branch;?>';
	var default_branch = '<?php echo $default_branch;?>'
	$('#btnRetrieve').prop('disabled',true);
if(detailCount <=1){
$('#head').hide();	
$('#filter').show();
}
else{
	$('#head').show();
	$('#filter').hide();
}


if(cek_branch=='Y')
	{
		$('.branch_code').hide();
	}
	else{
		$('.branch_code').show();
	}


$('#remarks_1').val($('#Tcashdividen_remarks').val());



	function addRow()
	{
		$("#tableDetail").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(detailCount+1))
    			.append($('<td>')
    				 .attr('class','glAcct')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('id','gl_acct_cd_'+(detailCount+1))
               		 	.attr('name','Tpayrecd['+(detailCount+1)+'][gl_acct_cd]')
               		 	.change(function()
               		 	{
               		 		filterSlAcct(this)
               		 	})
               		 	.append($('<option>')
               		 		.val('')
               		 		.html('-Choose-')
               		 	)
               		 	<?php 
               		 		foreach($gl_a as $row){ 
               		 	?>
               		 	.append($('<option>')
               		 		.val('<?php echo $row->gl_a ?>')
               		 		.html('<?php echo $row->gl_a. ' - ' .$row->acct_name?>')
               		 	)		
               		 	<?php 
							} 
						?>
               		)
               	).append($('<td>')
               		 .attr('class','slAcct')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tpayrecd['+(detailCount+1)+'][sl_acct_cd]')
               		 	.attr('type','text')
               		 	.autocomplete(
	         			{
	         				source: function (request, response) 
	         				{
						        $.ajax({
						        	'type'		: 'POST',
						        	'url'		: '<?php echo $this->createUrl('getSlAcct'); ?>',
						        	'dataType' 	: 'json',
						        	'data'		:	{
						        						'term': request.term,
						        						'gl_acct_cd' : ''
						        					},
						        	'success'	: 	function (data) 
						        					{
								           				 response(data);
								    				}
								});
						    },
						    change: function(event,ui)
					        {
					        	if (ui.item==null)
					            {
						            $(this).val('');
						            //$(this).focus();
					            }
					        },
						    minLength: 1,
						    open: function() { 
						        $(this).autocomplete("widget").width(400); 
						    } 
	         			})
               		)
               	).append($('<td>')
               		 .attr('class','amt')
               		 .append($('<input>')
               		 	.attr('class','span tnumberdec')
               		 	.attr('name','Tpayrecd['+(detailCount+1)+'][payrec_amt]')
               		 	.attr('type','text')
               		 	.attr('onchange','amount()')
               		 	.css('text-align','right')
               		 	.focus(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.removeCommas($(this).val()));
               		 		}
               		 	)
               		 	.blur(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.addCommasDec($(this).val()));
               		 		}
               		 	)
               		)
               	).append($('<td>')
               		 .attr('class','dbcr')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Tpayrecd['+(detailCount+1)+'][db_cr_flg]')
               		 	.attr('required','required')
               		 	.attr('onchange','amount()')
               		 	.append($('<option>')
               		 		.val('')
               		 		.html('-Choose-')
               		 	)
               		 	.append($('<option>')
               		 		.val('D')
               		 		.html('DEBIT')
               		 	).append($('<option>')
               		 		.val('C')
               		 		.html('CREDIT')
               		 	)			
               		)
               	).append($('<td>')
               		 .attr('class','remarks')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('id','remarks_'+(detailCount+1))
               		 	.attr('onchange','remarks_detail('+(detailCount+1)+')')
               		 	.attr('name','Tpayrecd['+(detailCount+1)+'][remarks]')
               		 	.attr('required',true)
               		 	.attr('type','text')
               		 	.change(function()
               		 	{
               		 		$(this).val($(this).val().toUpperCase());
               		 	})
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRow(this)')
               		 	.attr('title','delete')
               		 	.css('cursor','pointer')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		)
               	)  	
    		);
    	
    	detailCount++;
    	//reassignId();
    	//$(window).trigger('resize');
    	amount();
    	$('#gl_acct_cd_'+(detailCount)).focus();
	}
	
	
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		detailCount--;
		reassignId();
		//$(window).trigger('resize');
		amount();
	}
	
	function filterSlAcct(obj)
	{
		var glAcctCd = $(obj).val();
		var result = [];
				
		$(obj).parent().next().children("[type=text]").val('').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getSlAcct'); ?>',
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
	            	
		            if(!match)
		            {
		            	alert("SL Account not found in chart of accounts");
		            	$(this).val('');
		            }
		            
		            //$(this).focus();
	            }
	        },
		    minLength: 1
		});
	}
	
	function reassignId()
	{
		var x = 1;
		$("#tableDetail").children("tbody").children("tr").each(function()
		{
			$(this).children("td.glAcct").children("select").attr("id","gl_acct_cd_"+x);
			$(this).children("td.glAcct").children("select").attr("name","Tpayrecd["+x+"][gl_acct_cd]");
			$(this).children("td.slAcct").children("[type=text]").attr("name","Tpayrecd["+x+"][sl_acct_cd]");
			$(this).children("td.amt").children("[type=text]").attr("name","Tpayrecd["+x+"][payrec_amt]");
			$(this).children("td.amt").children("[type=text]").attr("onchange","amount()");
			$(this).children("td.dbcr").children("select").attr("name","Tpayrecd["+x+"][db_cr_flg]");
			$(this).children("td.dbcr").children("select").attr("onchange","amount()");
			$(this).children("td.remarks").children("[type=text]").attr("name","Tpayrecd["+x+"][remarks]");
			$(this).children("td.remarks").children("[type=text]").attr("id","remarks_"+x);
			//$(this).children("td.remarks").children("[type=text]").attr("onchange","remarks_detail("+x+")");
			x++;
		});
	}



$('#btnRetrieve').click(function(){
	$('#scenario').val('filter');

});
$('#btnAccept').click(function(){
	
	if(!checkBalance()){
		var deb = $('#debit').val();
		var cre = $('#credit').val();
		alert('              Amount not balance \n'+'Debit : '+deb +' Credit : '+cre);
		return false;
	}
	else{
		
	$('#scenario').val('save');
	$('#detailCount').val(detailCount);
	
	}
	
})


init();
function init(){
	$('.tdate').datepicker({format : "dd/mm/yyyy"});
	cek_date();
	// $("#tableDetail").children('tbody').children('tr:first').children('td.glAcct').children('[type=text]').val($('#Tcashdividen_gl_acct_cd').val());
	// $("#tableDetail").children('tbody').children('tr:first').children('td.slAcct').children('[type=text]').val($('#Tcashdividen_sl_acct_cd').val());
	// $("#tableDetail").children('tbody').children('tr:first').children('td.amt').children('[type=text]').val($('#Tcashdividen_div_amt').val());

}

$('#Tcashdividen_gl_acct_cd').change(function(){
	
	var glText = $('#Tcashdividen_gl_acct_cd').val();
	
	
	$("#tableDetail").children('tbody').children('tr:first').children('td.glAcct').children('[type=text]').val(glText);
});
	$('#Tcashdividen_sl_acct_cd').change(function(){
		var slText = $('#Tcashdividen_sl_acct_cd').val();
		$("#tableDetail").children('tbody').children('tr:first').children('td.slAcct').children('[type=text]').val(slText);
	});
	
	$(window).resize(function() {
		alignColumn();
	})
	$(window).trigger('resize');

	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableDetail").find('thead');
		var firstRow = $("#tableDetail").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		//firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
	//	firstRow.find('td:eq(5)').css('width',(header.find('th:eq(5)').width())-17 + 'px');
		
	}
	$('#Tcashdividen_remarks').change(function(){
		$('#Tcashdividen_remarks').val($('#Tcashdividen_remarks').val().toUpperCase());
		
		
		$("#tableDetail").children('tbody').children('tr:first').children('td.remarks').children('[type=text]').val($('#Tcashdividen_remarks').val());
	})
	
			function checkBalance()
	{
		var balance = 0;
		var debit =0;
		var credit =0;
		var x=0;
		$("#tableDetail").children('tbody').children('tr').each(function()
		{
			//var amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;
			 var curr_amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;
			var amt = parseInt(setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()).replace('.',''));
			
			//alert(amt);
			$(this).children('td.remarks').children('[type=text]').val($(this).children('td.remarks').children('[type=text]').val().toUpperCase());
			
			
			if(x==0)
			{
				var dbcrFlg = $(this).children('td.dbcr').children('[type=text]').val()=='DEBIT'?'D':'C';
			}
			else
			{
				var dbcrFlg = $(this).children('td.dbcr').children('select').val();
			}
			
			
			if(dbcrFlg == 'D' )
			{
				balance += amt;
				debit += curr_amt;
			}
			else if(dbcrFlg == 'C' )
			{
				balance -= amt;
				credit +=curr_amt;
			}
			else
			{
				return false;
			}
			x++;
		//alert(balance);			
		
		});
		
		if(balance != 0){
			$('#credit').val(setting.func.number.addCommasDec(credit/100));
			$('#debit').val(setting.func.number.addCommasDec(debit/100));
			return false;
		}
		else{
			return true;
			balance=balance/100;
		credit=credit/100;
		debit=debit/100;
		$('#balance').val(balance);
		
		
		}
		
	}
	
	$('#Tcashdividen_file_no').change(function(){
		
	$('#Tcashdividen_file_no').val($('#Tcashdividen_file_no').val().toUpperCase());	
	})
	
	function amount(){
		
		var debit = 0;
		var x=0;
		$("#tableDetail").children('tbody').children('tr').each(function()
		{
			
			var amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;
			
			if(x==0)
			{
				
				var dbcrFlg = $(this).children('td.dbcr').children('[type=text]').val()=='DEBIT'?'D':'C';
			
			}
			else
			{
				var dbcrFlg = $(this).children('td.dbcr').children('select').val();
			}
			
			
			if(dbcrFlg == "D" )
			{
				
				debit += amt;
			}
			x++;
		});
		debit = debit/100;
		$('#Tcashdividen_div_amt').val(setting.func.number.addCommasDec(debit));
	}
	
	$('#Tcashdividen_stock_code').change(function(){
		$('#Tcashdividen_stock_code').val($('#Tcashdividen_stock_code').val().toUpperCase());
	})
	
	
	
	
	$('#Tcashdividen_stock_code').change(function(){
		var stock_code = $('#Tcashdividen_stock_code').val();
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('Cek_cum_date'); ?>',
				'dataType' : 'json',
				'data'     : { 'stock_code':stock_code},						
				
				'success'  : function(data)
				{	
					var cum_dt = data.cum_dt;
					var recording_dt = data.recording_dt;
					var distrib_dt = data.distrib_dt;
					$('#Tcashdividen_cum_date1').val(cum_dt);
					$('#Tcashdividen_recording_dt').val(recording_dt);
					$('#Tcashdividen_cum_date1').datepicker('update');
					$('#Tcashdividen_recording_dt').datepicker('update');
					if(cek_pape =='N')
					{
						$('#Tcashdividen_today_date').val(distrib_dt);
						
					}
					else
					{	
					$('#Tcashdividen_today_date').val(today_date);
					}
					$('#Tcashdividen_today_date').datepicker('update');
					
					cek_date();
				}
				});
	})
	
	$('#Tcashdividen_today_date').change(function(){
		cek_date();
		});

	$('#Tcashdividen_cum_date1').change(function(){
		cek_date();
	})
	
	function cek_date(){
		
		var today1 = today_date.split('/');
		var today =today1[2]+today1[1]+today1[0];
		var cum_date1 = $('#Tcashdividen_cum_date1').val().split('/');
		var cum_date = cum_date1[2]+cum_date1[1]+cum_date1[0];
		var recording_dt1 = $('#Tcashdividen_recording_dt').val().split('/');
		var recording_dt = recording_dt1[2]+recording_dt1[1]+recording_dt1[0];
		
		
		if(cek_pape=='Y')
		{
			if(today<=cum_date)
			{
				$('#check_cum_date').prop('checked',true);
				$('#check_today_date').prop('checked',false);
			}
			else if(today> cum_date && today<= recording_dt)
			{
				$('#check_cum_date').prop('checked',false);
				$('#check_today_date').prop('checked',false);
				$('#btnRetrieve').prop('disabled',true);
			}
			else if(today>recording_dt)
			{
				$('#check_cum_date').prop('checked',false);
				$('#check_today_date').prop('checked',true);
			}
			if(today>cum_date)
			{
				$('#btnRetrieve').prop('disabled',false);
			}
			else{
				$('#btnRetrieve').prop('disabled',true);
			}
		}
		else
		{
			 if(today>recording_dt)
			 {
				$('#check_cum_date').prop('checked',false);
				$('#check_today_date').prop('checked',true);
				$('#btnRetrieve').prop('disabled',false);	
			}
			
		}
		cekVoucher();
		
	}
	
		$(document).ready(function(){
			setSaldo();
		});
	
	
	
	function setSaldo(){
		var debit=0;
		var credit=0;
		var balance=0;
		$("#tableDetail").children('tbody').children('tr').each(function()
		{
			var dbcrFlg = $(this).children('td.dbcr').children('select').val();
			var amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;
			if(dbcrFlg == 'D'){
				debit += amt;
			}
		
		});
		$("#tableDetail").children('tbody').children('tr').each(function()
		{
			var dbcrFlg = $(this).children('td.dbcr').children('select').val();
			var amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;
			if(dbcrFlg == 'C'){
				credit += amt;
			}
		
		});
		
		if(debit>credit){
			balance=debit-credit;
			balance=  setting.func.number.addCommasDec(balance/100);
			$("#tableDetail").children('tbody').children('tr:first').children('td.amt').children('[type=text]').val(balance);
			$("#tableDetail").children('tbody').children('tr:first').children('td.dbcr').children('[type=text]').val('CREDIT');
			
		}
		else{
			balance = credit-debit;
			balance=  setting.func.number.addCommasDec(balance/100);
			$("#tableDetail").children('tbody').children('tr:first').children('td.amt').children('[type=text]').val(balance);
			$("#tableDetail").children('tbody').children('tr:first').children('td.dbcr').children('[type=text]').val('DEBIT');
		}
	amount();
	}
	function remarks_detail(num){
			var remarks= $('#remarks_'+num).val();
			$('#remarks_'+num).val(remarks.toUpperCase())
	}
	
	$('#Tcashdividen_brch_cd').change(function(){
		cekVoucher();
	});
	
	function cekVoucher()
	{
		var stk_cd = $('#Tcashdividen_stock_code').val();
		var today_date = $('#Tcashdividen_today_date').val();
		var cum_date = $('#Tcashdividen_cum_date1').val();
		var branch_cd;
	
		if(cek_branch=='N')
		{
			branch_cd = $('#Tcashdividen_brch_cd').val();
		}
		else
		{
			branch_cd = default_branch;
		}
		
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('Cek_Voucher'); ?>',
				'dataType' : 'json',
				'data'     : { 'stk_cd':branch_cd+stk_cd,
							'today_date':today_date,
							'cum_date':cum_date
						},						
				
				'success'  : function(data)
				{	
					if(data.status=='success')
					{
						alert('Sudah dibuat Voucher');
						$('#btnRetrieve').prop('disabled',true);
					}
					
				}
				});
	}
	
</script>