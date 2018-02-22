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
$this->breadcrumbs = array(
	'Generate Payment Dividen Voucher' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Generate Payment Dividen Voucher',
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

<?php
//$bankAccount = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = 'RDI_PAY' AND param_cd2 = 'BANK' and param_cd3 = 'BCA02'");
$bankAccountNonRdi = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = 'NON_RDI' AND param_cd2 = 'BANK'");
?>

<?php AHelper::showFlash($this) ?>
<!-- show flash -->
<?php AHelper::applyFormatting() ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'tpayrech-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>

<?php
echo $form->errorSummary($model);

foreach ($modeldetail as $row)
{
	echo $form->errorSummary($row);
}
?>

<br />

<input type="hidden" name="scenario" id="scenario" />
<input type="hidden" name="rowCount" id="rowCount" />

<div class="row-fluid">
	<div class="span5">
		<div class="control-group">
			<div class="span12">
				<?php echo $form->datePickerRow($model, 'payrec_date', array(
					'prepend' => '<i class="icon-calendar"></i>',
					'placeholder' => 'dd/mm/yyyy',
					'class' => 'tdate span8',
					'options' => array('format' => 'dd/mm/yyyy'),
				));
				?>
			</div>
		</div>
	</div>
	<div class="span7">

		<div class="control-group">
			<div class="span1">
				<label>Branch</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model, 'brch_cd', CHtml::listData(Branch::model()->findAll(array(
					'select' => "brch_cd, brch_cd|| ' - '||brch_name as brch_name",
					'condition' => "approved_stat='A' ",
					'order' => 'brch_cd'
				)), 'brch_cd', 'brch_name'), array(
					'class' => 'span8',
					'prompt' => '-All-'
				));
				?>
			</div>
			<div class="span2">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnRetrieve',
				'buttonType' => 'submit',
				'type' => 'primary',
				'label' => 'Retrieve',
				'htmlOptions' => array(
					'name' => 'submit',
					'value' => 'retrieve'
				)
			));
			?>
			</div>
			<div class="span2">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnSubmit',
				'buttonType' => 'submit',
				'type' => 'primary',
				'label' => 'Process',
				'htmlOptions' => array(
					'name' => 'submit',
					'value' => 'submit',
					//'disabled' => !$retrieved
				)
			));
			?>
			</div>
		</div>
	</div>
</div>


<br/>

	<table id='tableDetail' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="40px">Branch</th>
				<th width="100px">Client Cd</th>
				<th width="230px">Client Name</th>
				<th width="70px">Bank Cd</th>
				<th width="130px">Bank Acct Num</th>
				<th width="180px">Amount</th>
				<th width="100px">Pembulatan</th>
				<th width="100px">File No.</th>
				<th width="50px" >
					<input type="checkbox" name="checkAll" id="checkAll" class="span7"/>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modeldetail as $row){ 
		?>
			<tr id="row<?php echo $x ?>" class="save_flg">
				<td>
					<?php echo $form->textField($row,'brch_cd',array('name'=>'Genpaymentdivvch['.$x.'][brch_cd]','class'=>'span','readonly'=>true));?>
					<?php echo $form->textField($row,'rowid',array('name'=>'Genpaymentdivvch['.$x.'][rowid]','style'=>'display:none'));?>
					<?php echo $form->textField($row,'rdi_bank_cd',array('name'=>'Genpaymentdivvch['.$x.'][rdi_bank_cd]','style'=>'display:none'));?>
					<?php echo $form->textField($row,'stk_cd',array('name'=>'Genpaymentdivvch['.$x.'][stk_cd]','style'=>'display:none'));?>
				</td>
				<td>
					<?php echo $form->textField($row,'client_cd',array('name'=>'Genpaymentdivvch['.$x.'][client_cd]','class'=>'span','readonly'=>true));?>
				</td>
				<td>
					<?php echo $form->textField($row,'client_name',array('name'=>'Genpaymentdivvch['.$x.'][client_name]','class'=>'span','readonly'=>true));?>
				</td>
				<td>
					<?php echo $form->textField($row,'bank_cd',array('name'=>'Genpaymentdivvch['.$x.'][bank_cd]','class'=>'span','readonly'=>true));?>
				</td>
				<td>
					<?php echo $form->textField($row,'bank_acct_num',array('name'=>'Genpaymentdivvch['.$x.'][bank_acct_num]','class'=>'span','readonly'=>true));?>
				</td>
				<td>
					<?php echo $form->textField($row,'curr_amt',array('name'=>'Genpaymentdivvch['.$x.'][curr_amt]','class'=>'span tnumberdec','style'=>'text-align:right','readonly'=>true));?>
				</td>
				<td>
					<?php echo $form->textField($row,'pembulatan',array('name'=>'Genpaymentdivvch['.$x.'][pembulatan]','class'=>'span tnumberdec','style'=>'text-align:right'));?>
				</td>
				<td>
					<?php echo $form->textField($row,'folder_cd',array('id'=>"folder_cd_$x",'onchange'=>"folder_cd($x)",'name'=>'Genpaymentdivvch['.$x.'][folder_cd]','class'=>'span folder_flg'));?>
				</td>
				<td class="saveFlg">
					<?php echo $form->checkbox($row,'save_flg',array('class'=>'span checkDetail','name'=>'Genpaymentdivvch['.$x.'][save_flg]','value'=>'Y'));?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<?php echo $form->textField($row,'remarks',array('id'=>"remarks_$x",'onchange'=>"remarks($x)",'name'=>'Genpaymentdivvch['.$x.'][remarks]','class'=>'span','readonly'=>false));?>
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>


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

	var rowCount = '<?php echo count($modeldetail);?>';
	var folder_flg = '<?php echo $folder_flg ;?>';

init();
function init()
{
	if(folder_flg=='N')
	{
		$('.folder_flg').prop('disabled',true);
	}
	if(rowCount==0)
	{
		$("#tableDetail").hide();
	}
}


$('#btnRetrieve').click(function(){
	$('#scenario').val('filter');
	$('#mywaitdialog').dialog('open');
})

$('#btnSubmit').click(function(){
	$('#scenario').val('save');
	$('#rowCount').val(rowCount);
	$('#mywaitdialog').dialog('open');
})

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
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',(header.find('th:eq(8)').width())-17 + 'px');
		
	}
	
	$('#checkAll').change(function(){
		
		if($('#checkAll').is(':checked'))
		{
			$('.checkDetail').prop('checked',true);	
		}
		else
		{
			$('.checkDetail').prop('checked',false);
		}
	});
	$('.checkDetail').change(function(){
		cek_all();
	})
	
	function cek_all()
	{
		var sign='Y';
		$("#tableDetail").children('tbody').children('tr.save_flg').each(function()
		{
			var cek = $(this).children('td.saveFlg').children('[type=checkbox]').is(':checked');
			
			if(!cek){
				sign='N';
			}
		});
		if(sign=='N'){
			$('#checkAll').prop('checked',false)	
		}
		else{
			$('#checkAll').prop('checked',true)
		}
	}
	
	function remarks(num)
	{
		$('#remarks_'+num).val($('#remarks_'+num).val().toUpperCase());
		
	}
	
	function folder_cd(num)
	{
		$('#folder_cd_'+num).val($('#folder_cd_'+num).val().toUpperCase());
		
	}
</script>