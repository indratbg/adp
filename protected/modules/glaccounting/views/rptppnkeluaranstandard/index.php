<style>
    input[type=radio] {
        margin-top: -3px;
    }

    #tablePPN {
        background-color: #C3D9FF;
    }
    #tablePPN thead, #tablePPN tbody {
        display: block;
    }
    #tablePPN tbody {
        height: 300px;
        overflow: auto;
        background-color: #FFFFFF;
    }
</style>
<?php
$this->breadcrumbs = array(
	'List of PPN Keluaran Standard' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'List of PPN Keluaran Standard',
		'itemOptions' => array('style' => 'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
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
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'importTransaction-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>

<?php AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<input type="hidden" name="scenario" id="scenario" />
<input type="hidden" name="rowCount" id="rowCount" />
<?php // echo $form->textField($model, 'rand_val'); ?>
<br />
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <div class="span3">
                <label>Month</label>
            </div>
            <div class="span3">
                <?php echo $form->dropDownList($model, 'month', AConstant::getArrayMonth(), array(
					'class' => 'span10',
					'prompt' => '-Select-'
				));
                ?>
            </div>
            <div class="span1">
                <label>Year</label>
            </div>
            <div class="span3">
                <?php echo $form->textField($model, 'year', array('class' => 'span10 numeric')); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span3">
                <label>From Date</label>
            </div>
            <div class="span3">
                <?php echo $form->textField($model, 'bgn_date', array(
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
                ?>
            </div>
            <div class="span1">
                <label>To</label>
            </div>
            <div class="span3">
                <?php echo $form->textField($model, 'end_date', array(
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span3">
                <label>Report Type</label>
            </div>
            <div class="span5">
            	<div class="span4">
                <?php echo $form->radioButton($model, 'report_mode', array('value' => '0')) . "&nbsp Detail"; ?>
                </div>
                <div class="span8">
                <?php echo $form->radioButton($model, 'report_mode', array('value' => '1')) . "&nbsp Summary By Client"; ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="span8">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
							'label' => 'Print',
							'type' => 'primary',
							'id' => 'btnPrint',
							'buttonType' => 'submit',
						));
                ?>
                <!-- <a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a> -->
                <a href="<?php echo Yii::app()->request->baseUrl . '?r=glaccounting/Rptppnkeluaranstandard/GetXls&rand_value=' . $rand_value . '&user_id=' . $user_id; ?> " id="btn_xls" class="btn btn-primary">Save to Excel</a>
                <?php $this->widget('bootstrap.widgets.TbButton', array(
					'label' => 'Retrieve',
					'type' => 'primary',
					'id' => 'btnSeries',
					'buttonType' => 'submit',
					'htmlOptions' => array('class' => 'btn'),
					'visible'=>($no_seri_flg=='Y'),
				));
                ?>
            </div>
        </div>
    </div>
    
    <div class="span6">
        <div class="control-group">
            <div class="span4">
                <?php if($no_seri_flg=='Y'){echo"<label>Nomor series mulai</label>";}?>
            </div>
            <div class="span3">
                <?php if($no_seri_flg=='Y'){echo $form->textField($model, 'no_seri', array('class' => 'seriisi span12'));} ?>
            </div>
            
        </div>
    </div>
</div>
<br />

<table id='tablePPN' class='table-bordered table-condensed'  >
    <thead>
        <tr>
            <th width="30px"></th>
            <th width="90px"></th>
            <th width="220px">Nama WP</th>
            <th width="150px">NPWP</th>
            <th width="100px">DPP</th>
            <th width="110px">PPN</th>
            <th width="20px"><input type="checkbox" id="checkBoxAll" name="checkAll" class="checkAll" value="1" onclick= "changeAll()"/></th>
            <th width="150px">No. Series</th>
        </tr>
    </thead>
    <tbody>
        <?php $x = 1;
        foreach($modelDetail as $row){ ?>
        <tr id="row<?php echo $x ?>" class="save">
            <td>
            	<?php echo $x; ?>
            </td>
            <td>
            	<?php echo $form->textfield($row, 'client_cd', array(
					'name' => 'Rppnkeluaran[' . $x . '][client_cd]',
					'class' => 'span',
					'readonly' => true
				));?>
			</td>
            <td>
            	<?php echo $form->textfield($row, 'client_name', array(
					'name' => 'Rppnkeluaran[' . $x . '][client_name]',
					'class' => 'span',
					'readonly' => true
				));?>
			</td>
            <td>
            	<?php echo $form->textfield($row, 'npwp_no', array(
					'name' => 'Rppnkeluaran[' . $x . '][npwp_no]',
					'class' => 'span',
					'readonly' => true
				));?>
			</td>
            <td>
            	<?php echo $form->textfield($row, 'dpp', array(
					'name' => 'Rppnkeluaran[' . $x . '][dpp]',
					'class' => 'span tnumber',
					'readonly' => true,
					'style' => 'text-align:right'
				));?>
			</td>
			<td>
            	<?php echo $form->textfield($row, 'ppn', array(
					'name' => 'Rppnkeluaran[' . $x . '][ppn]',
					'class' => 'span tnumber',
					'readonly' => true,
					'style' => 'text-align:right'
				));?>
			</td>
            <td class="save_flg">
            	<?php echo $form->checkBox($row, 'save_flg', array(
					'class' => 'checkBoxDetail',
					'id' => 'save_flg_' . $x . '',
					'value' => 'Y',
					'name' => 'Rppnkeluaran[' . $x . '][save_flg]'
					// 'style' => 'margin-left:10px;'
				));?>
			</td>
            <td class="seri">
            	<?php echo $form->textfield($row, 'no_series', array(
					'name' => 'Rppnkeluaran[' . $x . '][no_series]',
					'class' => 'span'
				));?>
			</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="4"> <?php echo $form->textfield($row, 'alamat', array(
					'name' => 'Rppnkeluaran[' . $x . '][alamat]',
					'class' => 'span',
					'readonly' => true
				));
			?> </td>
			<td></td>
            <td></td>
        </tr>

        <?php
		$x++;
		}
 		?>
    </tbody>
</table>

<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php echo $form->datePickerRow($model, 'dummy_date', array(
		'label' => false,
		'style' => 'display:none'
	));
?>
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
	var url_xls =  '<?php echo $url_xls ?>';
	var rowCount = '<?php echo count($modelDetail) ?>';
	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		if(url_xls=='')
		{
		$('#btn_xls').attr('disabled','disabled');
		}
		
		if(rowCount == 0){
			$('#tablePPN').hide();
		}
		
		
	}

	$('#Rptppnkeluaranstandard_month').change(function(){
		var from_date = $('#Rptppnkeluaranstandard_bgn_date').val().split('/');
		$('#Rptppnkeluaranstandard_bgn_date').val(from_date[0]+'/'+$('#Rptppnkeluaranstandard_month').val()+'/'+from_date[2]);
		var end_date = $('#Rptppnkeluaranstandard_end_date').val().split('/');
		$('#Rptppnkeluaranstandard_end_date').val(end_date[0]+'/'+$('#Rptppnkeluaranstandard_month').val()+'/'+end_date[2]);
		Get_End_Date($('#Rptppnkeluaranstandard_bgn_date').val());
	});

	$('#Rptppnkeluaranstandard_year').on('keyup',function(){
		var from_date = $('#Rptppnkeluaranstandard_bgn_date').val().split('/');
		$('#Rptppnkeluaranstandard_bgn_date').val(from_date[0]+'/'+from_date[1]+'/'+$('#Rptppnkeluaranstandard_year').val());
		var end_date = $('#Rptppnkeluaranstandard_end_date').val().split('/');
		$('#Rptppnkeluaranstandard_end_date').val(end_date[0]+'/'+end_date[1]+'/'+$('#Rptppnkeluaranstandard_year').val());
	})
	
	function Get_End_Date(tgl)
	{
		var date = tgl.split('/');
		var day = parseInt(date[0]);
		var month = parseInt(date[1]);
		var year = parseInt(date[2]);
	
		var d = new Date(year,month,day);
		d.setDate(d.getDate() - day);
		var month = d.getMonth()+1;
		var new_date = d.getDate()+'/'+month+'/'+d.getFullYear();
	
		$('#Rptppnkeluaranstandard_end_date').val(new_date);
		$('.tdate').datepicker('update');
	}
	$('#btnPrint').click(function(){
		$('#mywaitdialog').dialog('open');
		$('#scenario').val('print');
		$('#rowCount').val(rowCount);
	})
	$('#btnSeries').click(function(){
		$('#scenario').val('retrieve');
	})
	$(window).resize(function() {
		alignColumn();
	})
	$(window).trigger('resize');

	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tablePPN").find('thead');
		var firstRow = $("#tablePPN").find('tbody tr:eq(0)');
	
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',(header.find('th:eq(7)').width())-17 + 'px');

	}
	
	function changeAll()
	{
		var initseri = $('#Rptppnkeluaranstandard_no_seri').val();
		if($("#checkBoxAll").is(':checked'))
		{
			$(".checkBoxDetail").prop('checked',true);
			$("#tablePPN").children('tbody').children('tr.save').each(function()
			{
				var save_flg = $(this).children('td.save_flg').children('[type=checkbox]').is(':checked');
				if(save_flg){
					$(this).children('td.seri').children('[type=text]').val(initseri);
					initseri++;
				}
			});
		}
		else
		{
			$(".checkBoxDetail").prop('checked',false);
			$("#tablePPN").children('tbody').children('tr.save').each(function()
			{
				$(this).children('td.seri').children('[type=text]').val(0);
			});
		}
	}//RD 9DES2016
	
	$('.checkBoxDetail').change(function(){
		var initseri = $('#Rptppnkeluaranstandard_no_seri').val();
		var cntsaveflg = 0;
		$("#tablePPN").children('tbody').children('tr.save').each(function()
		{
			var save_flg = $(this).children('td.save_flg').children('[type=checkbox]').is(':checked');
			if(save_flg){
				$(this).children('td.seri').children('[type=text]').val(initseri);
				initseri++;
			}else{
				$(this).children('td.seri').children('[type=text]').val(0);
				cntsaveflg++;
			}
		});
		if(cntsaveflg>0){
			$('#checkBoxAll').prop('checked',false);
		}
	});	//RD 9DES2016
	
	// function showTable(){
		// if($('#btnSeries').click()){
			// $('#tablePPN')
		// }
	// }
	
</script>
