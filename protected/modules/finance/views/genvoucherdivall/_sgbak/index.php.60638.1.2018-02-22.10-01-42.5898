<?php
$this->breadcrumbs = array(
	'Generate Receipt Dividen Voucher (All)' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Generate Receipt Dividen Voucher (All)',
		'itemOptions' => array('style' => 'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
	),
	array(
		'label' => 'List',
		'url' => array('index'),
		'icon' => 'list',
		'itemOptions' => array(
			'class' => 'active',
			'style' => 'float:right'
		)
	),
	array(
		'label' => 'Approval',
		'url' => Yii::app()->request->baseUrl . '?r=inbox/tpayrechall/index',
		'icon' => 'list',
		'itemOptions' => array('style' => 'float:right')
	),
);
?>

<?php AHelper::showFlash($this)
?>
<!-- show flash -->
<?php AHelper::applyFormatting() ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'transferarap-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>
<br/>
<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
	<div class="control-group">
		<div class="span5">
			<?php echo $form->datePickerRow($model, 'distrib_dt', array(
				'prepend' => '<i class="icon-calendar"></i>',
				'placeholder' => 'dd/mm/yyyy',
				'class' => 'tdate span8',
				'options' => array('format' => 'dd/mm/yyyy')
			));
			?>
		</div>
	</div>
	<div class="control-group">
		<div class="span5">
			<?php echo $form->textFieldRow($model, 'folder_cd', array('class' => 'span4','required'=>$folder_flg=='Y'?true:false)); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="span4">
			<?php echo $form->dropDownListRow($model, 'branch_cd', CHtml::listData(Branch::model()->findAll(array(
				'select' => "brch_cd, brch_cd||' - '||brch_name brch_name",
				'condition' => " approved_stat='A'",
				'order' => 'brch_cd'
			)), 'brch_cd', 'brch_name'), array(
				'class' => 'span5',
				'prompt' => '-Select-',
				'style' => 'font-family:courier',
				'disabled' => $branch_flg == 'Y' ? true : false,
				'required'=>$branch_flg == 'Y' ? '' : 'required'
			));
			?>
		</div>
	</div>
	<div class="control-group">
		<div class="span2">

			<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'submit',
		'type' => 'primary',
		'label' => 'Generate',
		'id' => 'btnGenerate',
		//	'htmlOptions'=>array('style'=>'margin-left:-6em;','disabled'=>$flg=='Y'?true:false)
	));
			?>
		</div>
	</div>
</div>

<?php $this->endWidget()?>

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

<script type="text/javascript" charset="utf-8">
var check_branch ='<?php echo $branch_flg ;?>';
var folder_flg = '<?php echo $folder_flg ;?>';

init();
function init()
{
	if(folder_flg =='N')
	{
		$('#Genvoucherdivall_folder_cd').val('');
		$('#Genvoucherdivall_folder_cd').prop('disabled','disabled');	
	}	
}

	$('#btnGenerate').click(function(event){
		if(( $('#Genvoucherdivall_branch_cd').val() !='' && check_branch=='N') || check_branch=='Y')
		{
			$('#mywaitdialog').dialog('open');	
		}			
	})
	
	$('#Genvoucherdivall_folder_cd').change(function(){
		$('#Genvoucherdivall_folder_cd').val($('#Genvoucherdivall_folder_cd').val().toUpperCase());
		
	})
	
	
	
</script>
