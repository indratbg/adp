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
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tcorpact-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br/>
<?php //$stk_cd_list = Counter::model()->findAllBySql("SELECT STK_CD,stk_cd ||'- '|| stk_desc stk_desc FROM MST_COUNTER ORDER BY STK_CD"); 
	//$stk_cd_list_sementara = Tpee::model()->findAll(array('select'=>"stk_cd, stk_cd||' - '||stk_name stk_name",'order'=>'distrib_dt_fr desc'));
?>
<input type="hidden" name="scenario" id="scenario"  />


<?php echo $form->errorSummary(array($model)); ?>
<div class="row-fluid control-group">
	<div class="span2">
		<label>Stock code Sementara</label>
	</div>
	<div class="span2">
		<?php //echo $form->dropDownList($model,'stk_cd_temp',CHtml::listData($stk_cd_list_sementara, 'stk_cd','stk_name'),array('class'=>'span8','prompt'=>'-Choose-'));?>
		<?php echo $form->textField($model,'stk_cd_temp',array('class'=>'span6'));?>
	</div>
	<div class="span2">
		<label style="margin-left: 50px;">Stock code KSEI</label>
	</div>
	<div class="span2" >
		<?php //echo$form->dropDownList($model,'stk_cd_ksei',CHtml::listData($stk_cd_list, 'stk_cd','stk_desc'),array('class'=>'span7','prompt'=>'-Choose-'));?>
		<?php echo $form->textField($model,'stk_cd_ksei',array('class'=>'span7'));?>	
	</div>
	
	<div class="span4">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
							'id'=>'btnJournal',
							'buttonType'=>'submit',
							'type'=>'primary',
							'htmlOptions'=>array('style'=>'margin-left:0em;','class'=>'btn btn-primary'),
							'label'=> 'Create Journal')); ?>
	</div>
	
</div>

<div class="row-fluid control-group">
	<div class="span2">
		<label>Journal Description</label>
	</div>
	<div class="span7">
		<?php echo $form->textField($model,'remarks',array('class'=>'span9','required'=>TRUE));?>
	</div>	
	
	
</div>

<br/>


<iframe src= "<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100% ;"></iframe>
<?php $this->endWidget();?>
<script>
var jur_distribdt = '<?php echo $jurnal_distribdt ?>';
if(jur_distribdt =='Y'){
	$('#btnJournal').prop('disabled',true);
}

	$('#Rptgeniposecujournal_remarks').change(function(){
		$('#Rptgeniposecujournal_remarks').val($('#Rptgeniposecujournal_remarks').val().toUpperCase());
	})
	
	
	$('#Rptgeniposecujournal_stk_cd_ksei').change(function(){
		$('#Rptgeniposecujournal_stk_cd_ksei').val($('#Rptgeniposecujournal_stk_cd_ksei').val().toUpperCase());
	})
	$('#Rptgeniposecujournal_stk_cd_temp').change(function(){
		$('#Rptgeniposecujournal_stk_cd_temp').val($('#Rptgeniposecujournal_stk_cd_temp').val().toUpperCase());
	})
</script>