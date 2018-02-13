<style>
	.sign{
		background-color: #3CB371;
		border:1px solid black;
		
	}
	.sign1{
		background-color: #3CB371;
		border:1px solid black;
		height:15px !important;
		width:100px;
		float:left;
	}
	
	
	.text{
		float:left;
		margin-left:10px;
		margin-right:10px;
	}
	#tableCash
	{
		background-color:#C3D9FF;
	}
	#tableCash thead, #tableCash tbody
	{
		display:block;
	}
	#tableCash tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
</style>
<?php
$this->breadcrumbs=array(
	'IPO Securities Journal'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'IPO Securities Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tstkmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>



<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tcorpact-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>


<br/>
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 
<?php echo $form->errorSummary(array($modelfilter)); ?>
<?php foreach($model as $row)echo $form->errorSummary(array($row)); ?>


<div class="row-fluid control-group">
	<div class="sign1"></div>
	<div class="text">Belum dijurnal</div>

	

</div>

	<div class="row-fluid control-group">
	<div class="span3">
	<?php echo "Kode Stock Sementara ".$form->dropDownList($modelfilter,'stk_cd_temp',CHtml::listData(Tpee::model()->findAll(array('order'=>'distrib_dt_fr desc')), "stk_cd","DropDownList"),array('style'=>'font-family: Courier;','class'=>'span5','prompt'=>'-Choose-'));?>
	</div>
	<div class="span3" style="margin-left: 10px">
	
		<?php echo "Stock Code KSEI ".$form->dropDownList($modelfilter,'stk_cd_ksei',CHtml::listData(Counter::model()->findAll(), 'stk_cd','DropDownList'),array('style'=>'font-family: Courier;','class'=>'span6','prompt'=>'-Choose-'));?>
	</div>
	<div class="span3" style="margin-left: -10px">
	<label>Distribution Date Sesudah</label>
	</div>
	<div class="span2" >
		<?php echo $form->textField($modelfilter,'distrib_dt_fr',array('class'=>'tdate span8','placeholder'=>'dd/mm/yyyy','style'=>'margin-left:-80px;')); ?>
	
	</div>
	<div class="span1">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
							'id'=>'btnFilter',
							'buttonType'=>'submit',
							'type'=>'primary',
							'htmlOptions'=>array('style'=>'margin-left:-10em;','class'=>'btn btn-small btn-primary'),
							'label'=> 'Search',
						)); ?>
	</div>
	</div>	

<br/>
<table id="tableCash" class="table-bordered table-condensed">
	<thead>
		<tr>
			<th width= "10%">Stock Code</th>
			<th width= "10%">Stock Code KSEI</th>
			<th width="45%">Name</th>
			<th width="10%"> Distribution Date</th>
			<th width="10%"> </th>
			<th width="15%">Price</th>
		</tr>
	</thead>
	<tbody>
		
	<?php $x = 1;

		foreach($model as $row){
		
		?>
	
	<tr id="row<?php echo $x ?>"  class="<?php echo $row->jurnal_distribdt=='Y'?'':'sign'?>">
			<td>
				<?php echo $form->textField($row,'stk_cd',array('id'=>"stk_cd_$x",'name'=>'Tpee['.$x.'][stk_cd]','class'=>'span','readonly'=>TRUE));?>
				<?php echo $form->textField($row,'jurnal_distribdt',array('id'=>"jurnal_distribdt_$x",'name'=>'Tpee['.$x.'][jurnal_distribdt]','class'=>'span','style'=>'display:none'));?>
			</td>
				<td>
				<?php echo $form->textField($row,'stk_cd_ksei',array('onchange'=>'upper_ksei('.$x.')','id'=>"stk_cd_ksei_$x",'name'=>'Tpee['.$x.'][stk_cd_ksei]','class'=>'span'));?>
				
			</td>
			<td>
			<?php echo $form->textField($row,'stk_name',array('id'=>"ca_type_$x",'name'=>'Tpee['.$x.'][stk_name]','class'=>'span','readonly'=>true));?>
			</td>
		
			<td>
				<?php echo $form->textField($row,'distrib_dt_fr',array('id'=>"distrib_dt_fr_$x",'name'=>'Tpee['.$x.'][distrib_dt_fr]','class'=>'span','readonly'=>true));?>
				
			</td>
			<td style="text-align: center;">
			
 <?php		//echo CHtml::button('Pilih',
			    // array('submit'=>array('Geniposecujournal/pilih','stk_cd'=>$row->stk_cd,'distrib_dt_fr'=>$row->distrib_dt_fr,'jurnal_distribdt'=>$row->jurnal_distribdt),
					   // 'class'=>'btn btn-small btn-primary'
					// ));?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
							'id'=>'btnPilih_'.$x,
						//	'buttonType'=>'submit',
							'type'=>'primary',
							'htmlOptions'=>array('class'=>'btn btn-small btn-primary','onclick'=>'pass('.$x.')'),
							'label'=> 'Pilih',
						)); ?>
			
			</td>
			<td >
					<?php echo $form->textField($row,'price',array('value'=>number_format($row->price,0,'.',','),'name'=>'Tpee['.$x.'][price]','class'=>'span','readonly'=>true,'style'=>'text-align:right;'));?>
			</td>
		</tr>
	
	<?php  $x++;

}?>
	</tbody>
</table>



<?php echo $form->datePickerRow($modelfilter,'cre_dt',array('label'=>false,'disabled'=>'disabled','style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<?php $this->endWidget(); ?>
<script>
	
	function upper_ksei(num){
		$('#stk_cd_ksei_'+num).val($('#stk_cd_ksei_'+num).val().toUpperCase());
		
	}
	
	function pass(num){
		var stk_cd = $('#stk_cd_'+num).val();
		var stk_cd_ksei = $('#stk_cd_ksei_'+num).val();
		var distrib_dt_fr = $('#distrib_dt_fr_'+num).val();
		var jurnal_distribdt = $('#jurnal_distribdt_'+num).val();
		var link = '<?php Yii::app()->request->baseUrl ?>'+'?r=custody/Geniposecujournal/pilih&stk_cd='+stk_cd+'&stk_cd_ksei='+stk_cd_ksei+'&distrib_dt_fr='+distrib_dt_fr+'&jurnal_distribdt='+jurnal_distribdt;
		//alert(stk_cd_ksei);
		$('#btnPilih_'+num).attr('href',link);
		
	}
	
	
	
	
	$('.tdate').datepicker({format : "dd/mm/yyyy"});
	
	$(window).resize(function() {
		alignColumn();
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableCash").find('thead');
		var firstRow = $("#tableCash").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',(header.find('th:eq(5)').width())-17 + 'px');
		
	}
	
	
	
</script>