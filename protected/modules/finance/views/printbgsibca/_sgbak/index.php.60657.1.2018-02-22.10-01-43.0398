
<style>
	#tablePrint
	{
		background-color:#C3D9FF;
	}
	#tablePrint thead, #tablePrint tbody
	{
		display:block;
	}
	#tablePrint tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	#tablePrint thead tr th{
		vertical-align: bottom;
	}
</style><?php
$this->breadcrumbs=array(
	'Print Bilyet Giro(BG)/SI'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Print BCA Bilyet Giro, Formulir Transfer / Setoran', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval Penerimaan Dana/Refund','url'=>Yii::app()->request->baseUrl.'?r=inbox/tfundmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Approval Penjatahan (Voucher)','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>


<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php 
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'Payment-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal'
	)); 
?>
<?php
	echo $form->errorSummary($model);
	$chx='';
?>

<br/>
<input type="hidden" name="scenario" id="scenario"/>
<input type="hidden" name="rowCount" id="rowCount"/>
<input type="hidden" name="reSelect" id="reSelect"/>
<div class="row-fluid">
	<div class="control-group">
		<div class="span6">
			<div class="span3">
				<label>Voucher Date</label>
			</div>
			<div class="span3">
				<?php // echo $form->datePickerRow($model,'vch_dt',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
				<?php echo $form->textField($model, 'vch_dt', array(
					'class' => 'span12 tdate',
					'placeholder' => 'dd/mm/yyyy',
					'id'=>'vc_dt'
				));
                ?>
			</div>
		</div>
	</div>
	
	<div class="control-group">
		<div class="span6">
			<div class="control-group">
				<!-- <div class="span12"><h4>Transaksi</h4></div><hr/> -->
				<div class="span3">
					<label>Retrieve Voucher</label>
				</div>
				<div class="span2">
					<input type="radio" name="Rptprintbgsibca[opt_vc]" class="opt_vc" value="%" <?php echo $model->opt_vc=='%'?'checked':'' ?>/> &nbsp; All
				</div>
				<div class="span2">
					<input type="radio" name="Rptprintbgsibca[opt_vc]" class="opt_vc" value="BG" <?php echo $model->opt_vc=='BG'?'checked':'' ?>/> &nbsp; BG
				</div>
				<div class="span3">
					<input type="radio" name="Rptprintbgsibca[opt_vc]" class="opt_vc" value="SI" <?php echo $model->opt_vc=='SI'?'checked':'' ?>/> &nbsp; SI
				</div>
				<div class="span1">
					<?php 
						$this->widget('bootstrap.widgets.TbButton',
						    array('label' => 'Retrieve',
							        'size' => 'medium',
							        'id' => 'btnFilter',
							        'buttonType'=>'submit',
							        'htmlOptions'=>array('class'=>'btn btn-small btn-primary','style'=>'width:70px;')
						    )
						);
					?>
				</div>
			</div>
			
			<div class="control-group">
				
				<div class="span3">
					<label>User ID</label>
				</div>
				<div class="span3">
					<?php echo $form->textField($model,'user_id',array('class'=>'span12'));?>
				</div>
				
				<div class="span1">
					<label>Bank</label>
				</div>
				<div class="span3">
					<?php echo $form->textField($model,'bank_cd',array('class'=>'span12','placeholder'=>'CO: 300002'));?>
				</div>
				<div class="span1">
					<?php
						$this->widget('bootstrap.widgets.TbButton',
							    array('label' => 'Update',
								        'size' => 'medium',
								        'id' => 'btnUpdate',
								        'buttonType'=>'submit',
								        'htmlOptions'=>array('class'=>'btn btn-small btn-primary','style'=>'width:70px;')
						    )
						);
					?>
				</div>
			</div>
			
		</div>
	
		<div class="span6">
			
			<div class="control-group">
				<div class="span1">
					<label>SI No.</label>
				</div>
				<div class="span3">
					<?php echo $form->textField($model,'si_num',array('class'=>'span12','id'=>'chk_print_si'));?>
				</div>
				<div class="span3">
				<?php // echo $form->datePickerRow($model,'vch_dt',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
				<?php echo $form->textField($model, 'vch_dt2', array(
					'class' => 'span12 tdate',
					'placeholder' => 'Voucher Date SI',
					'id'=>'si_dt'
				));
                ?>
				</div>
				<div class="span3">
				<?php $this->widget('bootstrap.widgets.TbButton',
				    array('label' => 'Print SI',
					        'size' => 'medium',
					        'id' => 'btnPrintSI',
					        'buttonType'=>'submit',
					        'htmlOptions'=>array('class'=>'btn btn-small btn-primary','style'=>'width:70px;')
				    )
				); ?>
				</div>
			</div>
			<div class="control-group">
				<div class="offset7">
					<?php $this->widget('bootstrap.widgets.TbButton',
					    array('label' => 'Print BG',
						        'size' => 'medium',
						        'id' => 'btnPrintBG',
						        'buttonType'=>'submit',
						        'htmlOptions'=>array('class'=>'btn btn-small btn-primary','style'=>'width:70px;')
					    )
					); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $form->textField($model,'folder',array('class'=>'span12','style'=>'display:none'));?>
<br/>

<!--<iframe src="<?php echo $url; ?>" class="span12" id="report" style="min-height:600px;max-width: 100%;"></iframe>-->	

<table id='tablePrint' class='table-condensed' >
	<thead>
		<tr>
			<th width="69px">Client Cd</th>
			<th width="79px" style="text-align: right">Amount</th>
			<th width="13px">Print</th>
			<th width="150px">Client Name</th>
			<th width="60px">Voucher</th>
			<th width="20px">Bank</th>
			<th width="40px"></th>
			<th width="100px">BG No.</th>
			<th width="50px" style="text-align: center">Update BG</th>
			<th width="100px">GL Account</th>
			<th width="300px">Description</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelRetrieve as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td>
				<?php echo $row->client_cd ;?>
				<?php echo $form->textField($row,'client_cd',array('name'=>'Printbgsibca['.$x.'][client_cd]','style'=>'display:none'));?>
				<?php echo $form->textField($row,'system_bank_cd',array('name'=>'Printbgsibca['.$x.'][system_bank_cd]','style'=>'display:none'));?>
				<?php echo $form->textField($row,'rvpv_number',array('name'=>'Printbgsibca['.$x.'][rvpv_number]','style'=>'display:none'));?>
				<!--<?php // echo $form->textField($row,'doc_num',array('name'=>'Printbgsibca['.$x.'][doc_num]','style'=>'display:none'));?>-->
			</td>
			<td style="text-align: right">
				<?php echo number_format($row->curr_amt,0,',','.') ;?>
				<?php echo $form->textField($row,'curr_amt',array('name'=>'Printbgsibca['.$x.'][curr_amt]','style'=>'display:none'));?>
			</td>
			<td class="print_flg">
				<?php echo $form->checkBox($row,'flg',array('class'=>'span checkDetail','value' => 'Y','name'=>'Printbgsibca['.$x.'][flg]','id'=>'limit_print['.$x.']','onchange'=>'chq_si()')); ?>
			</td>
			<td>
				<?php echo $row->client_name;?>
				<?php echo $form->textField($row,'client_name',array('name'=>'Printbgsibca['.$x.'][client_name]','style'=>'display:none'))?>
			</td>
			<td>
				<?php echo $row->folder_cd;?>
				<?php echo $form->textField($row,'folder_cd',array('name'=>'Printbgsibca['.$x.'][folder_cd]','style'=>'display:none'))?>
			</td>
			<td>
				<?php echo $row->payee_bank_cd;?>
				<?php echo $form->textField($row,'payee_bank_cd',array('name'=>'Printbgsibca['.$x.'][payee_bank_cd]','style'=>'display:none','id'=>'length_cek'))?>
			</td>
			<td>
				<?php echo $form->textField($row,'bg_cq_flg',array('name'=>'Printbgsibca['.$x.'][bg_cq_flg]','class'=>'span'))?>
			<?php
					$chq_old = $row->chq_num;
					echo $form->textField($row,'chq_old',array('name'=>'Printbgsibca['.$x.'][chq_old]','value'=>$chq_old,'class'=>'span','style'=>'display:none','id'=>'SI['.$x.']'))
				?>
			</td>
			<td class="val">
				<?php echo $form->textField($row,'chq_num',array('name'=>'Printbgsibca['.$x.'][chq_num]','class'=>'span'))?>
			</td>
			<td class="upd_flg">
				<?php echo $form->checkBox($row,'upd_flg',array('class'=>'span checkDetail2','value' => 'Y','name'=>'Printbgsibca['.$x.'][upd_flg]')); ?>
			</td>
			<td>
				<?php echo $row->sl_acct_cd ;?>
				<?php echo $form->textField($row,'sl_acct_cd',array('class'=>'span','name'=>'Printbgsibca['.$x.'][sl_acct_cd]','style'=>'display:none'));?>
			</td>
			<td>
				<?php echo $row->remarks ;?>
				<?php echo $form->textField($row,'remarks',array('class'=>'span','name'=>'Printbgsibca['.$x.'][remarks]','style'=>'display:none'));?>
			</td>
		</tr>
	<?php $x++;?>
	<?php }?> 
	</tbody>
</table>

<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>
<?php echo $form->datePickerRow($model,'dummy_dt',array('label'=>false,'style'=>'display:none')) ?>
<?php $this->endWidget(); ?>

<div role="tabpanel" id="tab_panel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" >
    <li id ="p_bg_h"role="presentation" class="active" ><a href="#p_bg_d" aria-controls="p_bg_d" role="tab" data-toggle="tab">Print BG</a></li>
    <li id ="p_transfer_h" role="presentation"><a href="#p_transfer_d" aria-controls="p_transfer_d" role="tab" data-toggle="tab">Print Transfer</a></li>
    <li id ="p_setoran_h" role="presentation"><a href="#p_setoran_d" aria-controls="p_setoran_d" role="tab" data-toggle="tab">Print Setoran</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="p_bg_d">
       	<iframe src="<?php echo $url_p_bg;?>" class="span12" id="report_p_bg" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="p_transfer_d">
    	<iframe src="<?php echo $url_p_transfer;?>" class="span12" id="report_p_transfer" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
	<div role="tabpanel" class="tab-pane" id="p_setoran_d">
    	<iframe src="<?php echo $url_p_setoran;?>" class="span12" id="report_p_setoran" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
</div>

</div><!--End tab panel-->


<script>

	var rowCount = '<?php echo count($modelRetrieve);?>';
	var url = '<?php echo $url;?>';
	var url_bg='<?php echo $url_p_bg;?>';
	var url_setoran='<?php echo $url_p_setoran;?>';
	var url_trf='<?php echo $url_p_transfer;?>';
	var sql_trf='<?php echo $cnt_trans;?>';
	var sql_setor='<?php echo $cnt_setor;?>';



	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		// checkAll();
		if (url=='')
		{
			$('#iframe').hide();
		}
		
		if(url_bg=='' && url_setoran=='' && url_trf=='')
		{
			$('#tab_panel').hide();
		}
		
		if(rowCount==0)
		{
			$('#tablePrint').hide();
		}
		else
		{
			$('#tablePrint').show();	
		}
		if(sql_trf==0)
		{
			$('#p_transfer_h').hide();
		}
		if(sql_setor==0)
		{
			$('#p_setoran_h').hide();
		}
	// limit_print();	
	}
	function chq_si()
	{
		
 		
		var si_num='';
		$("#tablePrint").children('tbody').children('tr').each(function()
		{
			var cek = $(this).children('td.print_flg').children('[type=checkbox]').is(':checked');
			if(cek){
				si_num = $(this).children('td.val').children('[type=text]').val();
			}
			
		});

		$('#chk_print_si').val(si_num);
		
	}
	
	
	$('#vc_dt').change(function() {
    $('#si_dt').val($(this).val());
		});
	
		
	$('#btnFilter').click(function(){
		$('#scenario').val('filter');
		$('#tab_panel').hide();
	})
	
	$('#btnPrintBG').click(function(){
		$('#scenario').val('print_bg');
		$('#tab_panel').show();
		$('#rowCount').val(rowCount);
	})
	
	$('#btnPrintSI').click(function(){
		$('#scenario').val('print_si');
		$('#tab_panel').hide();
	})
	
	$('#btnUpdate').click(function(){
		$('#scenario').val('update');
		$('#rowCount').val(rowCount);
		$('#tab_panel').hide();
	})
	
	$(window).resize(function() {
		alignColumn();
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tablePrint").find('thead');
		var firstRow = $("#tablePrint").find('tbody');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width() + 'px');
		firstRow.find('td:eq(10)').css('width',(header.find('th:eq(10)').width())-17 + 'px');
	}
	


</script>