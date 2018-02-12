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
	'Reconcile DHK vs Transaction',
);
?>
<?php
$this->menu=array(
	//array('label'=>'Trekdanaksei', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Reconcile DHK vs Transaction', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
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
			<?php echo $form->errorSummary(array($model,$modelReport)); ?>
	<input type="hidden" name="scenario" id="scenario" />
	
	<div class="row-fluid control-group">
		<div class="span5">
			<?php echo $form->datePickerRow($model,'settle_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span4" style="margin-left: -70px;">
				<?php  echo CHTML::activeFileField($model,'file_upload');?>
		</div>
		<div class="span2">
			<?php 
				$this->widget('bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Import DHK',
			        'size' => 'medium',
			        'id' => 'btnImport',
			        'buttonType'=>'submit',
			        'htmlOptions'=>array('class'=>'btn-small btn-primary')
			    )
			); ?>
		</div>
		<div class="span2">
			<?php 
				$this->widget('bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Show Report',
			        'size' => 'medium',
			        'id' => 'btnReport',
			        'buttonType'=>'submit',
			        'htmlOptions'=>array('class'=>'btn-small btn-primary')
			    )
			); ?>
		</div>
	</div>

<div class="row-fluid control-group">
	<div class="span4" >
	<?php  echo $form->radioButtonListInlineRow($model, 'import_type', AConstant::$reconcile_dhk,array('label'=>false)); ?>
	
	</div>	
	<div class="span6">
		<?php  echo $form->radioButtonListInlineRow($model, 'type', array('AB'=>'Anggota Bursa','CLIENT'=>'Nasabah'),array('label'=>false)); ?>
	</div>	
</div>
<pre>
<b>Persiapan File Import :</b>
1. Download file dari KPEI
2. Buka file dengan xls.
3. Find tanggal yang akan diimport
4. Copy ke worksheet baru 
5. Delete worksheet lama
6. Lebar kolom O dan P disesuaikan dengan isinya
7. Tidak pake HEADER
8. Hapus 2 baris terakhir(e.g : baris CS_MEMBER_NAME dan baris LOTUS ANDALAN SEKURITAS) 
9. Save as ke text file tab delimited baru
</pre>						
<iframe src="<?php echo $url.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'; ?>" class="span12" id="report" style="min-height:600px;max-width: 100%;"></iframe>		

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
var url = '<?php echo $url;?>'
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
	init();
	function init()
	{
		if(url=='')
		{
			$('#report').hide();
		}
	}
</script>