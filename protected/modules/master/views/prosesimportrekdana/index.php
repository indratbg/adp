<style>
	.filter-group *
	{
		float:left;
	}
	#tableImport
	{
		background-color:#C3D9FF;
	}
	#tableImport thead, #tableImport tbody
	{
		display:block;
	}
	#tableImport tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}

	.markCancel
	{
		background-color:#BB0000;
	}
.radio.inline{
	width: 130px;
}

</style>

<?php
$this->breadcrumbs=array(
	'Process Uploaded Rekening Dana',
);
?>




<?php
$this->menu=array(
	//array('label'=>'Trekdanaksei', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Process Uploaded Rekening Dana', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
		array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/import/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
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
			<?php echo $form->errorSummary($model); ?>
			<?php echo $form->errorSummary($modelfail); ?>
			<?php echo $form->errorSummary($modelclient); ?>
			<input type="hidden" id="scenario" name="scenario"/>
			<?php
				/*if(!$model->isNewRecord) 
				{
					if($model->client_po_clientfile!='')
					{
						echo CHtml::link($model->client_po_clientfile, FileUpload::getHttpPath($model->so_cd, FileUpload::CLIENT_PO_PATH), array('id'=>'file_link'));
						//'<a id="file_link" href="'.Yii::app()->request->baseUrl."/upload/client_po/".$model->client_po_clientfile.'" target="_blank">'.$model->client_po_clientfile.'</a>';
						echo ' '. CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete_red.png'), 'javascript://', array('id'=>'del_file')). '<br />';
					}
				}*/
			?>
		
			<div class="row-fluid control-group">
				<div class="span2">
					<?php 
				$this->widget('bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Process',
			        'size' => 'medium',
			        'id' => 'btnImportSave',
			        'buttonType'=>'submit',
			        'htmlOptions'=>array('class'=>'btn-small btn-primary' ,'style'=>'font-weight:bold;margin-left:0px;margin-top:-5px;')
			    )
			); ?>
				</div>
				<div class="span10" style="font-size: 10pt;">
					<?php echo $jum_unprocess;?>	
				</div>
			</div>
				
			
	<p id="desc" style="margin-bottom: -18px;font-size: 9pt;">Centang di kolom paling kanan, untuk <b>TUTUP RDI LAMA </b> dan masukkan <b>RDI BARU</b>, kemudian klik Save</p>


<input type="hidden" id="rowCount" name="rowCount"/>
<br/>
<table id='tableImport' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th id="header1">Client Cd</th>
			<th id="header2">Name</th>
			<th id="header3">Existing Bank</th>
			<th id="header4">Existing Account</th>
			<th id="header5">Balance</th>
			<th id="header6">New Bank</th>
			<th id="header7">New Account</th>
			<th id="header8"></th>
			
		</tr>
	</thead>	
	<tbody>
			<?php $x = 1;
		foreach($modelfail as $row){?>
		<tr id="row<?php echo $x ?>">
			<td width="10%">
				
				<input type="hidden" name="Vfailimprekdana[<?php echo $x ?>][bank_name]" value="<?php echo $row->bank_name ;?>"/>
				<input type="hidden" name="Vfailimprekdana[<?php echo $x ?>][new_acct_fmt]" value="<?php echo $row->new_acct_fmt ;?>"/>
				<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Vfailimprekdana['.$x.'][client_cd]','readonly'=>true));?>
			</td>
			<td width="25%">
				<?php echo $form->textField($row,'name',array('class'=>'span','name'=>'Vfailimprekdana['.$x.'][name]','readonly'=>true));?>
			</td>
			<td width="10%">
				<?php echo $form->textField($row,'bank_cd',array('class'=>'span','name'=>'Vfailimprekdana['.$x.'][bank_cd]','readonly'=>true));?>
			</td>
			<td width="15%">
				<?php echo $form->textField($row,'bank_acct',array('class'=>'span','name'=>'Vfailimprekdana['.$x.'][bank_acct]','readonly'=>true));?>
			</td>
			<td width="10%">
				<?php echo $form->textField($row,'balance',array('class'=>'span tnumber','name'=>'Vfailimprekdana['.$x.'][balance]','style'=>'text-align:right','readonly'=>true));?>
			</td>
			<td width="10%">
				<?php echo $form->textField($row,'new_bank_cd',array('class'=>'span','name'=>'Vfailimprekdana['.$x.'][new_bank_cd]','readonly'=>true));?>
			</td>
			<td width="15%">
				<?php echo $form->textField($row,'new_bank_acct',array('class'=>'span','name'=>'Vfailimprekdana['.$x.'][new_bank_acct]','readonly'=>true));?>
			</td>
			
			<td width="10%">
				<?php echo $form->checkBox($row,'save_flg',array('class'=>'span','style'=>'margin-top:0px;','value' => 'Y','name'=>'Vfailimprekdana['.$x.'][save_flg]','disabled'=>$row->balance=='0'?'':'disabled'));?>
			</td>
	</tr>
		<?php $x++;} ?>
		</tbody>	
</table>
		
<div class="text-center" style="margin-left:-100px">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=> 'Save',
		'htmlOptions'=>array('class'=>'btn btn-primary','id'=>'btnSubmit')
	)); ?>
</div>

<?php $this->endWidget(); ?>
	
<script type="text/javascript" charset="utf-8">


adjustWidth();
var rowCount =<?php echo count($modelfail) ?>;
if (rowCount==0){
	$('#tableImport').hide();
	$('#btnSubmit').hide();
	$('#ImpFail').hide();
	$('#desc').hide();
}
else{
	$('#tableImport').show();
	$('#btnSubmit').show();
	$('#ImpFail').show();
	$('#desc').show();
}
$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
function adjustWidth(){
		$("#header1").width($("#tableImport tbody tr:eq(0) td:eq(0)").width());
		$("#header2").width($("#tableImport tbody tr:eq(0) td:eq(1)").width());
		$("#header3").width($("#tableImport tbody tr:eq(0) td:eq(2)").width());
		$("#header4").width($("#tableImport tbody tr:eq(0) td:eq(3)").width());
		$("#header5").width($("#tableImport tbody tr:eq(0) td:eq(4)").width());
		$("#header6").width($("#tableImport tbody tr:eq(0) td:eq(5)").width());
		$("#header7").width($("#tableImport tbody tr:eq(0) td:eq(6)").width());
		$("#header8").width($("#tableImport tbody tr:eq(0) td:eq(7)").width());
		
	}
	
	
	
	$('#btnImportSave').click(function()
	{
		$('#scenario').val('import');
		//import and save data
		
	});
	
	
	
	$('#btnSubmit').click(function()
	{
		$('#scenario').val('save');
		$('#rowCount').val(rowCount);
	})
	
</script>