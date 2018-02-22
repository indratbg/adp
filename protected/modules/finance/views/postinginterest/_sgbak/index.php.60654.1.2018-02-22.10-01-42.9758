<style>
	.tablePosting
	{
		background-color:#C3D9FF;
	}
	.tablePosting thead, .tablePosting tbody
	{
		display:block;
	}
	.tablePosting tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	/*
	.radio.inline{
		width: 130px;
	}*/
	
#tablePosting thead tr th{
	vertical-align: bottom;
}


</style>
<?php

$this->breadcrumbs=array(
	'Posting Interest'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Posting Interest', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>


<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tinterest-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',

)); 
 ?>
 
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
	//$bgnYear = DateTime::createFromFormat('Y-m-d H:i:s',$bgnDate)->format('Y');
 	
	for($x=$currYear;$x>=2012;$x--)
	{
		$year[$x] = $x;
	}
	?>
 <?php echo $form->errorSummary(array($model));?>
 
<?php $branch = Branch::model()->findAllBySql("select brch_cd||' - '|| brch_name as brch_name ,brch_cd from mst_branch order by brch_cd");?>

<input type="hidden" name="scenario" id="scenario" />
<input type="hidden" name="rowCount" id="rowCount" />
 <br/>
 <center><strong style="font-size: 15pt;"> Interest Option</strong></center>
 <br/>
 <div class="row-fluid control-group">
 	<div class="span2">
		<?php echo $form->radioButton($model, 'option_posting',array('id'=>'option1','value'=>'0','class'=>'span1 option')). " All Client" ?>		 		
 	</div>
 	<div class="span2">
 		<label>Branch code</label>
 	</div>
 	<div class="span2 ">
 		<?php echo $form->dropDownList($model,'brch_cd',CHtml::listData($branch,'brch_cd', 'brch_name'),array('disabled'=>$cek_branch=='Y'?false:true,'class'=>'span10','style'=>'margin-left:-20px','prompt'=>'-All-'));?>
 	</div>
	
</div>		
<div class="row-fluid control-group">
	<div class="span2">
		<?php echo $form->radioButton($model, 'option_posting',array('id'=>'option2','value'=>'1','class'=>'span1 option')). " Selected Client" ?>
	</div>
	<div class="span2">
		<?php echo $form->textField($model,'client_cd',array('class'=>'span10'));?>
	</div>
	<div clas="span8">
		<?php echo $form->textField($model,'client_name',array('class'=>'span6','readonly'=>true));?>
	</div>
</div>
<div class="row-fluid control-group">
<div class="span2">
	
</div>
	<div class="span2">
		
		<?php echo "Client Type &emsp;" .$form->textField($model,'client_type',array('class'=>'span4','style'=>'width:40px;','readonly'=>true));?>
	</div>
	<div class="span2" style="margin-left: -1px;" >
		<?php echo $form->textField($model,'type_desc',array('class'=>'span10','readonly'=>true));?>
	</div>
</div>
<div class="row-fluid control-group">
	<div class="span2">
		<label>For the month of</label>
	</div>
	<div class="span2">
			<?php echo $form->dropDownList($model,'bulan',$month,array('class'=>'span10'));?>
	</div>
	<div class="span1">
			<?php echo $form->dropDownList($model,'year',$year,array('id'=>'year','class'=>'span','style'=>'margin-left:-20px;')) ?>
	</div>
</div>
<div class="row-fluid control-group">
	<div class="span2">
		<label>Interest date from</label>
	</div>
		<div class="span8">
			<?php echo $form->textField($model,'int_dt_from',array('class'=>'span2 tdate','placeholder'=>'dd/mm/yyyy'));?>
	
			<?php echo "To  &emsp;&emsp;&nbsp;".$form->textField($model,'int_dt_to',array('class'=>'span2 tdate','placeholder'=>'dd/mm/yyyy'));?>
		<?php echo "&emsp;Journal Date  &emsp;&emsp;&nbsp;".$form->textField($model,'journal_dt',array('class'=>'span2 tdate','placeholder'=>'dd/mm/yyyy'));?>
		
		<?php $this->widget('bootstrap.widgets.TbButton',
			    array('label' => 'Retrieve',
				        'size' => 'medium',
				        'id' => 'btnFilter',
				        'buttonType'=>'submit',
				        'htmlOptions'=>array('class'=>'btn-primary','style'=>'margin-left:15px;')
	    )
	); ?>
	</div>
	<div class="span2">
		<?php $this->widget('bootstrap.widgets.TbButton',
			    array('label' => 'Start Posting',
				        'size' => 'medium',
				        'id' => 'btnPosting',
				        'buttonType'=>'submit',
				        'htmlOptions'=>array('class'=>'btn-primary','style'=>'margin-left:-80px;')
	    )
	); ?>
		</div>
		
</div>


<div id="dataDetail" style="overflow-x: auto;">
	<div style="width:1200px;"> 
<br/>
		<table id='tablePosting' class='table-bordered table-condensed tablePosting'>
			<thead>
				<tr>
				<th width="90px">Client</th>
				<th width="90px">Jatuh Tempo</th>
				<th width="120px">Net Beli - Jual</th>
				<th width="120px">Saldo s/d hari ini</th>
				<th width="100px">Terlambat bayar</th>
				<th width="100px">Kompensasi</th>
				<th width="120px">Non Transaksi</th>
				<th width="40px">Posting</th>
				<th width="40px">ovr</th>
				<th width="90px">Tgl beli</th>
				<th width="90px">Tgl jual RDI</th>
				<th width="120px">Accumulate Interest</th>
				
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetail as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td>
				<?php echo $form->textField($row,'client_cd',array('name'=>'Tinterest['.$x.'][client_cd]','class'=>'span','readonly'=>true)) ;?>
				</td>
				<td>
				<?php echo $form->textField($row,'int_dt',array('name'=>'Tinterest['.$x.'][int_dt]','class'=>'span','readonly'=>true)) ;?>
				</td>
				<td>
					<?php echo $form->textField($row,'today_trx',array('style'=>'text-align:right','class'=>'span tnumberdec','name'=>'Tinterest['.$x.'][today_trx]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'int_accum',array('style'=>'text-align:right','class'=>'span tnumberdec','name'=>'Tinterest['.$x.'][int_accum]','readonly'=>true)); ?>
				</td>
				<td>
						<?php echo $form->textField($row,'pay_late',array('style'=>'text-align:right','class'=>'span tnumberdec','name'=>'Tinterest['.$x.'][pay_late]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'compensation',array('style'=>'text-align:right','class'=>'span tnumberdec','name'=>'Tinterest['.$x.'][compensation]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'nontrx',array('style'=>'text-align:right','class'=>'span tnumberdec','name'=>'Tinterest['.$x.'][nontrx]','readonly'=>true)); ?>
					
				</td>
				<td>
					<?php echo $form->textField($row,'post_flg',array('class'=>'span','name'=>'Tinterest['.$x.'][post_flg]','readonly'=>true)); ?>
				</td>
				<td >
					<?php echo $form->textField($row,'ovr_flg',array('class'=>'span tnumber','name'=>'Tinterest['.$x.'][ovr_flg]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'trx_dt_beli',array('style'=>'text-align:right','class'=>'span','name'=>'Tinterest['.$x.'][trx_dt_beli]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'trx_dt_jual',array('style'=>'text-align:right','class'=>'span ','name'=>'Tinterest['.$x.'][trx_dt_jual]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'int_deb_accum',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tinterest['.$x.'][int_deb_accum]','readonly'=>true)); ?>
				</td>
			
			</tr>
		<?php $x++;} ?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>
				<?php echo $form->textField($model,'total_pay_late',array('style'=>'text-align:right','class'=>'span tnumberdec'));?>
			</td>
			<td>
				<?php echo $form->textField($model,'total_compensation',array('style'=>'text-align:right','class'=>'span tnumberdec'));?>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align: right">
				<strong>Total Amount</strong>
			</td>
			<td>
				<?php echo $form->textField($model,'total_int_amt',array('style'=>'text-align:right','class'=>'span tnumberdec'));?>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		</tbody>
	</table>
	
	
</div><!--END scrollbar bawah-->	
</div>



<?php echo $form->datePickerRow($model,'cre_dt',array('style'=>'display:none','label'=>false));?>

<?php $this->endWidget(); ?>

<script>

var rowCountDetail = '<?php echo count($modelDetail)?>';
var authorizedSpv = true;
init();

function init()
{
	optionClientCd();
	checkSpv();
	getClient();
	$('.tdate').datepicker({format : "dd/mm/yyyy"});
	if(rowCountDetail>0)
	{
		$("#dataDetail").show();
	}
	else
	{
		$("#dataDetail").hide();
	}
	
}

$(window).resize(function() {
		alignColumn();
		//$("#tablePosting").offset({left:2});
		//$("#tablePosting").css('width',($(window).width()+));
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tablePosting").find('thead');
		var firstRow = $("#tablePosting").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() +'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() +'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() +'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width() +'px');
		firstRow.find('td:eq(10)').css('width',header.find('th:eq(10)').width() +'px');
		firstRow.find('td:eq(11)').css('width',header.find('th:eq(11)').width()-17 +'px');
		
	}
$('.option').change(function(){
	
	optionClientCd();
})

function optionClientCd()
{
	if($('#option1').is(':checked'))
	{
		if(!checkSpv())
		{
			alert('You are not authorized to perform this action');
			$('#btnFilter').prop('disabled',true);
			$('#option2').prop('checked',true);
		
		}
		else{
			$('#btnFilter').prop('disabled',true);
			$('#Tinterest_client_cd').attr('readonly',true);
		}
		
		
	}
	else
	{	
		$('#Tinterest_client_cd').attr('readonly',false);
		$('#btnFilter').prop('disabled',false);
	
	}
}
	
	$('#btnFilter').click(function(){
		$('#scenario').val('filter');
	})
	
	$('#btnPosting').click(function(){
		$('#scenario').val('posting');
		
	})
	
	$('#Tinterest_client_cd').change(function(){
		checkClient();
	})
	
	
	function checkClient(){
		
		var client_cd= $('#Tinterest_client_cd').val();
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('CheckClient'); ?>',
				'dataType' : 'json',
				'data'     : { 'client_cd':client_cd},							
				'success'  : function(data){
					$('#Tinterest_client_name').val(data.client_name);
					$('#Tinterest_client_type').val(data.client_type);
					$('#Tinterest_type_desc').val(data.cl_desc);
				
			}
			})			
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
			}
		});
		
		return authorizedSpv;
}		


function getClient()
	{
		//alert('est');
		//var glAcctCd = $(obj).val();
		var result = [];
		$('#Tinterest_client_cd').autocomplete(
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
	            	
	            }
	        },
		    minLength: 1,
		    open: function()
		   {
        		$(this).autocomplete("widget").width(500); 
           },
           position: 
           {
           	    offset: '0 0' // Shift 150px to the left, 0px vertically.
    	   }
		});
	}
	
	$("#Tinterest_bulan, #year").change(function()
	{
		var firstDate = new Date($("#year").val(),$("#Tinterest_bulan").val()-1,1);
		var lastDate = new Date($("#year").val(),$("#Tinterest_bulan").val(),0);
		var month = $('#Tinterest_bulan').val();
		var year= $('#year').val();
				
		$("#Tinterest_int_dt_from").val('0'+firstDate.getDate() + '/' + ('0'+(firstDate.getMonth()+1)).slice(-2) + '/' + firstDate.getFullYear()).datepicker('update');
		$("#Tinterest_int_dt_to").val(lastDate.getDate() + '/' + ('0'+(lastDate.getMonth()+1)).slice(-2) + '/' + lastDate.getFullYear()).datepicker('update');
	
	
	 	$.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getJournalDate'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'month': month,
		        						'year':year
		        						
		        					},
		        	'success'	: 	function (data) 
		        					{
				           			$('#Tinterest_journal_dt').val(data.journal_date);
				    				}
				});
	
	
	});
</script>
