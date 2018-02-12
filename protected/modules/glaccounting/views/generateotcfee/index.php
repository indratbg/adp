<style>
	.filter-group *
	{
		float:left;
	}
	#tableGen
	{
		background-color:#C3D9FF;
	}
	#tableGen thead, #tableGen tbody
	{
		display:block;
	}
	#tableGen tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>

<?php
$this->breadcrumbs=array(
	'Generate OTC Fee Journal'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Generate OTC Fee Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
		//array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/gljournalledger/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
	
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'treksnab-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php echo $form->errorSummary(array($modelheader,$modelfilter,$modelfolder)); ?>

<?php 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>
<?php 
	foreach($modelledger as $row)
		echo $form->errorSummary(array($row)); 
?>
<br/>


<div class="row-fluid">
    <div class="control-group">
    	<div class="span2">
    		<label>Date from</label>
    	</div>
    	<div class="span2">
    		<label>To date</label>
    	</div>
    	<div class="span2">
    		<label>Journal Date</label>
    	</div>
    	<div class="span2">
    		<label>File No.</label>
    	</div>
    	<div class="span4">
    		<label>Account code</label>
    	</div>
	</div>
</div>
<div class="row-fluid ">
    <div class="control-group">
    	<div class="span2">
    	<?php echo $form->textField($modelfilter,'from_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy'));?>
    	</div>
    	<div class="span2">
    	<?php echo $form->textField($modelfilter,'end_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy'));?>
    	</div>
    	<div class="span2">
    		<?php echo $form->textField($modelfilter,'jur_date',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy'));?>
    	</div>
    	<div class="span2">
    		<?php echo $form->textField($modelfilter,'folder_cd',array('class'=>'span'));?>
    	</div>
    	<div class="span2">
    		<label>Jasa KSEI (Debit)</label>
    	</div>
    	<div class="span1">
    			<?php echo $form->textField($modelfilter,'jasa_gl_acct_cd',array('class'=>'span'));?>
    	</div>
    	<div class="span1">
    			<?php echo $form->textField($modelfilter,'jasa_sl_acct_cd',array('class'=>'span'));?>
    	</div>
	</div>
</div>


<div class="row-fluid">
    <div class="control-group">
            <div class="span1">
            	<label>OTC Fee</label>
            </div>
        	<div class="span2" >
        		<?php echo $form->textField($modelfilter,'otc_fee',array('class'=>'span7 tnumber','style'=>'text-align:right'));?>
        	</div>
        	<div class="span1">
        		<label>Description</label>
        	</div>
        	<div class="span4">
        		<?php echo $form->textField($modelfilter,'desc',array('class'=>'span12'));?>
        	</div>
        	<div class="span2">
        		<label>Biaya ymh (Credit)</label>
        	</div>
        	<div class="span1">
        			<?php echo $form->textField($modelfilter,'ymh_gl_acct_cd',array('class'=>'span'));?>
        	</div>
        	<div class="span1">
        			<?php echo $form->textField($modelfilter,'ymh_sl_acct_cd',array('class'=>'span'));?>
        	</div>
	</div>
</div>

<div class="row-fluid control-group">
	<div class="span1">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnFilter','style'=>'margin-left:0px;','class'=>'btn-small'),
			'label'=>'Retrieve',
		)); ?>
	</div>
	<div class="span3">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnPrint','style'=>'margin-left:0px;','class'=>'btn-small'),
			'label'=>'Print Report',
			//'url'=>Yii::app()->request->baseUrl.'?r=glaccounting/Generateotcfee/report'
		)); ?>
	</div>
<div class="span4" style="text-align: right">
	<label>Journal</label>
</div>
<div class="span2">
	<label>Account Code</label>
</div>
<div class="span1">
	<label>Debit</label>
</div>
<div class="span1">
<label>Credit</label>
</div>
	</div>
<div class="row-fluid control-group">
	<div class="span8" style="text-align: right">
		OTC Client
	</div>
	<div class="span1">
		<label id="otc_client">1422</label>
	</div>
	<div class="span1">
		<label>Client Cd</label>
	</div>
	<div class="span1">
	<label id="otc_client_debit"></label>
	</div>
	<div class="span1">
		<label id="otc_client_credit"></label>
	</div>
</div>
<div class="row-fluid control-group">
	<div class="span8" style="text-align: right">
		<label>(non charged) OTC Client</label>
	</div>
	<div class="span1">
		<label id="otc_client_gl_acct_cd"></label>
	</div>
	<div class="span1">
		<label id="otc_client_sl_acct_cd"></label>
	</div>
	<div class="span1">
	<label id="otc_client_debit_non"></label>
	</div>
	<div class="span1">
		<label id="otc_client_credit_non"></label>
	</div>
</div>
<div class="row-fluid control-group">
	<div class="span8" style="text-align: right">
		<label>(repo jual) OTC Repo</label>
	</div>
	<div class="span1">
		<label id="otc_client_gl_acct_cd_jual"></label>
	</div>
	<div class="span1">
		<label id="otc_client_sl_acct_cd_jual"></label>
	</div>
	<div class="span1">
	<label id="otc_repo_jual"></label>
	</div>
	<div class="span1">
		<label></label>
	</div>
</div>

<div class="row-fluid control-group">
	<div class="span8" style="text-align: right">
		<label>Biaya ymh</label>
	</div>
	<div class="span1">
		<label id="otc_client_gl_acct_cd_ymh"></label>
	</div>
	<div class="span1">
		<label id="otc_client_sl_acct_cd_ymh"></label>
	</div>
	<div class="span1">

	</div>
	<div class="span1">
		<label id="otc_client_credit_ymh"></label>
	</div>
</div>




<input type="hidden" name="rowCount" id="rowCount" />
<input type="hidden" name="scenario" id="scenario" />
<input type="hidden" name="Generateotcfee[tot_fee_uncheck]" id="tot_fee_uncheck"/>
<input type="hidden" name="Generateotcfee[tot_fee]" id="tot_fee"/>
<input type="hidden" name="Generateotcfee[count_uncheck]" id="count_uncheck"/>
<table id='tableGen' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="100px">Client</th>
			<th width="500px">Client Name</th>
			<th width="150px">OTC Client</th>
			<th width="100px">Journal</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
		
	?>
		<tr id="row<?php echo $x ?>">
			<td width="100px">
			<?php echo $row->client_cd;?>
			<input type="hidden" name="Generateotcfee[<?php echo $x;?>][client_cd]" value="<?php echo $row->client_cd;?>"/>
			</td>
			<td width="500px">
			<?php echo $row->client_name ;?>
			<input type="hidden" name="Generateotcfee[<?php echo $x;?>][client_name]" value="<?php echo $row->client_name;?>"/>
			</td>
			<td width="150px" class="otc_client" style="text-align: right">
				<?php echo number_format((float)$row->sum_otc_client,0,'.',',') ;?>
				<input type="hidden" name="Generateotcfee[<?php echo $x;?>][sum_otc_client]" value="<?php echo $row->sum_otc_client;?>"/>
					<input type="text" style="display: none" name="Generateotcfee[<?php echo $x;?>][sum_otc_repo_jual]" value="<?php echo $row->sum_otc_repo_jual==''?0:$row->sum_otc_repo_jual ;?>"/>
			</td>
			<td width="100px" class="save_flg">
				<?php echo $form->checkBox($row,'save_flg',array('checked'=>$row->jur =='Y'?true:FALSE,'id'=>'save_flg_'.$x.'','onchange'=>'countFee()','value' => 'Y','name'=>'Generateotcfee['.$x.'][save_flg]','style'=>'margin-left:10px;')).' '.$row->closed; ?>
				<input type="hidden" name="Generateotcfee[<?php echo $x;?>][jur]" value="<?php echo trim($row->jur) ;?>"/>
				<input type="hidden" name="Generateotcfee[<?php echo $x;?>][closed]" value="<?php echo trim($row->closed) ;?>"/>
			</td>
		</tr>
		<?php // if( $row->closed !=null || $row->closed !=''){
		//	echo "<script>alert('$row->closed');</script>";
		//}?>
	<?php $x++;
} ?>
	</tbody>
</table>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnProses','style'=>'margin-left:250px;','class'=>'btn'),
			'label'=>'Process',
		)); ?>
</div>


<?php echo $form->datePickerRow($modelfilter,'cre_dt',array('label'=>false,'disabled'=>'disabled','style'=>'display:none')); ?>
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
var rowCount =<?php echo count($model);?>;

init();
function init(){
		$(".tdate").datepicker({format : "dd/mm/yyyy"});
	
}
	if(rowCount == 0){
		$('#tableGen').hide();
		$('#btnProses').hide();
	}
	else{
		$('#tableGen').show();
		$('#btnProses').show();
	}
	
	$('#Generateotcfee_desc').change(function(){
		var desc =$('#Generateotcfee_desc').val();
		
		$('#Generateotcfee_desc').val(desc.toUpperCase());
		
	});
		$('#Generateotcfee_folder_cd').change(function(){
		var desc =$('#Generateotcfee_folder_cd').val();
		
		$('#Generateotcfee_folder_cd').val(desc.toUpperCase());
		
	});
	$('#btnFilter').click(function(){
	    $('#mywaitdialog').dialog('open')
		$('#scenario').val('filter');
	});
	
	$('#btnProses').click(function(){
	    $('#mywaitdialog').dialog('open')
		$('#scenario').val('proses');
		$('#rowCount').val(rowCount);
	})
	$('#btnPrint').click(function(){
		$('#scenario').val('print');
		
	})
	
countFee();
function countFee(){
	
	var fee=0;
	var fee_uncheck=0;
	var uncheck = 0;
	var fee_check=0;
	var repo_jual=0;
	var check =0;
$("#tableGen").children('tbody').children('tr').each(function()
		{
			var otc_client =  parseInt($(this).children('td.otc_client').children('[type=hidden]').val());
			var otc_jual =  parseInt($(this).children('td.otc_client').children('[type=text]').val());
			
			fee += otc_client;
			repo_jual+=otc_jual;
			if(!$(this).children('td.save_flg').children('[type=checkbox]').is(':checked')){
				fee_uncheck += otc_client;
				uncheck +=1; 
			}
			if($(this).children('td.save_flg').children('[type=checkbox]').is(':checked')){
				fee_check += otc_client;
				check +=1; 
			}
			
		});
		
		
		//alert(uncheck+check);
fee_check=setting.func.number.addCommas(fee_check);
$('#otc_client_debit').html(fee_check);
$('#tot_fee').val(fee);
$('#tot_fee_uncheck').val(fee_uncheck);
$('#count_uncheck').val(uncheck);
var fee_uncheck1 =setting.func.number.addCommas(fee_uncheck);
$('#otc_client_debit_non').html(fee_uncheck1);

$('#otc_repo_jual').html(repo_jual);
var tot_fee= setting.func.number.addCommas(fee);
$('#otc_client_credit_ymh').html(tot_fee);

}
$('#Generateotcfee_jasa_sl_acct_cd').change(function(){
	var sl_acct_cd= $('#Generateotcfee_jasa_sl_acct_cd').val();
	$('#otc_client_sl_acct_cd').html(sl_acct_cd);
	$('#otc_client_sl_acct_cd_jual').html(sl_acct_cd);
})

$('#otc_client_sl_acct_cd').html($('#Generateotcfee_jasa_sl_acct_cd').val());
$('#otc_client_sl_acct_cd_jual').html($('#Generateotcfee_jasa_sl_acct_cd').val());
	
$('#Generateotcfee_jasa_gl_acct_cd').change(function(){
	var gl_acct_cd= $('#Generateotcfee_jasa_gl_acct_cd').val();
	$('#otc_client_gl_acct_cd').html(gl_acct_cd);
	$('#otc_client_gl_acct_cd_jual').html(gl_acct_cd);
});

$('#otc_client_gl_acct_cd').html($('#Generateotcfee_jasa_gl_acct_cd').val());
$('#otc_client_gl_acct_cd_jual').html($('#Generateotcfee_jasa_gl_acct_cd').val());

$('#Generateotcfee_ymh_gl_acct_cd').change(function(){
	var gl_acct_cd = $('#Generateotcfee_ymh_gl_acct_cd').val();
	$('#otc_client_gl_acct_cd_ymh').html(gl_acct_cd);
})
$('#otc_client_gl_acct_cd_ymh').html($('#Generateotcfee_ymh_gl_acct_cd').val());
$('#Generateotcfee_ymh_sl_acct_cd').change(function(){
	var sl_acct_cd = $('#Generateotcfee_ymh_sl_acct_cd').val();
	$('#otc_client_sl_acct_cd_ymh').html(sl_acct_cd);
})
$('#otc_client_sl_acct_cd_ymh').html($('#Generateotcfee_ymh_sl_acct_cd').val());


$('#Generateotcfee_desc').change(function(){
    $('#Generateotcfee_desc').val($('#Generateotcfee_desc').val().toUpperCase())
})

</script>
