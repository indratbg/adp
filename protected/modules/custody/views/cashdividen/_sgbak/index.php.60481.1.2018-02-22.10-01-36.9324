<style>
    .sign {
        background-color: #3CB371;
        border: 1px solid black;
    }
    .sign1 {
        background-color: #3CB371;
        border: 1px solid black;
        height: 15px !important;
        width: 100px;
        float: left;
    }

    .paid1 {
        background-color: #4D94FF;
        border: 1px solid black;
        height: 15px;
        width: 100px;
        float: left;
    }
    .paid {
        background-color: #4D94FF;
        border: 1px solid black;
    }
    .text {
        float: left;
        margin-left: 10px;
        margin-right: 10px;
    }
    #tableCash {
        background-color: #C3D9FF;
    }
    #tableCash thead, #tableCash tbody {
        display: block;
    }
    #tableCash tbody {
        max-height: 300px;
        overflow: auto;
        background-color: #FFFFFF;
    }

</style>
<?php $this->breadcrumbs = array(
        'List of cash Dividen'=> array('index'),
        'List',
    );

    $this->menu = array(
        array(
            'label'=>'List of cash Dividen',
            'itemOptions'=> array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
        ),
        array(
            'label'=>'List',
            'url'=> array('index'),
            'icon'=>'list',
            'itemOptions'=> array(
                'class'=>'active',
                'style'=>'float:right'
            )
        ),
    );
?>

<?php AHelper::showFlash($this) ?>
<!-- show flash -->
<?php AHelper::applyFormatting() ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'Tcorpact-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal'
    ));
?>

<br/>

<div class="row-fluid">
	<div class="sign1"></div>
	<div class="text">
		Sudah save for finance
	</div>
	<div class="paid1"></div>
	<div class="text">
		Sudah dibuat voucher
	</div>

</div>

<input type="hidden" name="scenario" id="scenario" />
<br/>

<div class="row-fluid">
    <div class="span1">
        <label>Stock Code</label>
    </div>
    <div class="span1">
        <?php echo $form->textField($modeldummy,'stk_cd',array('class'=>'span12','placeholder'=>'TLKM'));?>
    </div>
    <div class="span1">
        <label style="width: 120px;">Payment Date</label>
    </div>
    <div class="span2">
        <?php echo $form->textField($modeldummy,'distrib_dt',array('class'=>'span7 tdate','placeholder'=>'dd/mm/yyyy'));?>
    </div>
    <div class="span1">
        <label style="width: 120px;">Recording Date</label>
    </div>
    <div class="span2">
        <?php echo $form->textField($modeldummy,'recording_dt',array('class'=>'span7 tdate','placeholder'=>'dd/mm/yyyy'));?>
    </div>
    <div class="span2">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                                'id'=>'btnFilter',
                                'buttonType'=>'submit',
                                'type'=>'primary',
                                'htmlOptions'=> array('class'=>'btn btn-small btn-primary'),
                                'label'=>'Search',
                            ));
                 ?>
    </div>
</div>

<br/>

<table id="tableCash" class="table-bordered table-condensed">
	<thead>
		<tr>
			<th colspan="6"></th>
			<th colspan="3" style="text-align: center;">Share Dividen</th>
		</tr>
		<tr>
			<th width="5%"> Stock</th>
			<th width="10%"> Cum Date</th>
			<th width="10%"> Recording Date</th>
			<th width="10%"> Payment Date</th>
			<th width="10%"> Rate</th>
			<th width="10%"></th>
			<th width="10%"> Setiap</th>
			<th width="10%"> Mendapat</th>
			<th width="10%"> Price</th>

		</tr>
	</thead>
	<tbody>
		<?php $x = 1;
		foreach($model as $row){
		?>
		<tr id="row<?php echo $x ?>" class="<?php
        if ($row->saved == 'Y' && $row->paid == "Y")
        {
            echo 'paid';
        }
        else if ($row->saved == 'Y' && $row->paid != 'Y')
        {
            echo 'sign';
        }
		?>" >
			<td > <?php echo $row->stk_cd; ?> </td>
			<td>
			<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $row->cum_dt)->format('d/m/Y'); ?>
			</td>

			<td>
			<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $row->recording_dt)->format('d/m/Y'); ?>
			</td>
			<td>
			<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $row->distrib_dt)->format('d/m/Y'); ?>
			</td>
			<td style="text-align: right;"> <?php echo number_format((float)$row->rate, 2, '.', ','); ?>
			</td>
			<td style="text-align: center;"> <?php echo CHtml::button('Pilih', array(
                    'submit'=> array(
                        'cashdividen/pilih',
                        'stk_cd'=>$row->stk_cd,
                        'cum_dt'=>$row->cum_dt,
                        'recording_dt'=>$row->recording_dt,
                        'distrib_dt'=>$row->distrib_dt
                    ),
                    'class'=>'btn btn-small btn-primary',
                    //'disabled'=>$rowsign->stk_cd == $row->stk_cd?true:false
                ));
			?> </td>
			<td style="text-align: right;"> <?php echo $row->from_qty; ?>
			</td>
			<td style="text-align: right;"> <?php echo $row->to_qty; ?> </td>
			<td style="text-align: right;"> <?php echo $row->price; ?> </td>
		</tr>

		<?php $x++;
    }
		?>
	</tbody>
</table>
<?php echo $form->datePickerRow($modeldummy, 'cre_dt', array(
        'label'=>false,
        'disabled'=>'disabled',
        'style'=>'display:none',
        'options'=> array('format'=>'dd/mm/yyyy')
    ));
?>
<?php $this->endWidget(); ?>
<script>

    init();
    function init()
    {
        $('.tdate').datepicker(
        {
            format : "dd/mm/yyyy"
        });
        getStock();
    }
	$('#btnFilter').click(function()
	{
		$('#scenario').val('filter');
	});
	

	$(window).resize(function()
	{
		alignColumn();
	})
	$(window).trigger('resize');

	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableCash").find('tbody tr:eq(0)');
		var firstRow = $("#tableCash").find('thead tr:eq(1)');
		header.find('td:eq(0)').css('width', firstRow.find('th:eq(0)').width() + 'px');
		header.find('td:eq(1)').css('width', firstRow.find('th:eq(1)').width() + 'px');
		header.find('td:eq(2)').css('width', firstRow.find('th:eq(2)').width() + 'px');
		header.find('td:eq(3)').css('width', firstRow.find('th:eq(3)').width() + 'px');
		header.find('td:eq(4)').css('width', firstRow.find('th:eq(4)').width() + 'px');
		header.find('td:eq(5)').css('width', firstRow.find('th:eq(5)').width() + 'px');
		header.find('td:eq(6)').css('width', firstRow.find('th:eq(6)').width() + 'px');
		header.find('td:eq(7)').css('width', firstRow.find('th:eq(7)').width() + 'px');
		header.find('td:eq(8)').css('width', firstRow.find('th:eq(8)').width() - 17 + 'px');
	}
	
	
function getStock()
{ 
        var result = [];
        $('#Tcorpact_stk_cd').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getstock'); ?>',
                    'dataType'  : 'json',
                    'data'      :   {
                                        'term': request.term,
                                        
                                    },
                    'success'   :   function (data) 
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
                     if(!match)
                    {
                        $(this).val('');
                    }
                }
            },
            minLength: 0,
           open: function() { 
                    $(this).autocomplete("widget").width(500);
                      $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
</script>