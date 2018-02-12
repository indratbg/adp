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
        background-color: #d38c14;
        border: 1px solid black;
        height: 15px;
        width: 100px;
        float: left;
    }

    .paid {
        background-color: #d38c14;
        border: 1px solid black;

    }
    .bofo1 {
        background-color: red ;
        border: 1px solid black;
        height: 15px;
        width: 100px;
        float: left;
    }

    .bofo {
        background-color: red;
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
<?php
$this->breadcrumbs = array(
    'Corporate Action Journal' => array('index'),
    'List',
);

$this->menu = array(
    array('label' => 'Corporate Action Journal', 'itemOptions' => array('style' => 'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),

    array('label' => 'List', 'url' => array('index'), 'icon' => 'list', 'itemOptions' => array('class' => 'active', 'style' => 'float:right')),
    array('label' => 'Approval', 'url' => Yii::app()->request->baseUrl . '?r=inbox/tstkmovementall/index', 'icon' => 'list', 'itemOptions' => array('style' => 'float:right')),
);
?>



<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'Tcorpact-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal'
)); ?>

<br/>
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?>

<div class="row-fluid control-group">
    <div class="sign1"></div>
    <div class="text">Belum dijurnal</div>
    <div class="paid1"></div>
    <div class="text">Sudah jurnal Cum Date / X Date</div>
    <div class="bofo1"></div>
    <div class="text">Belum proses BO to FO</div>

</div>

<div class="row-fluid control-group">
    <div class="span3">
        <?php echo "Stock Code " . $form->textField($modeldummy, 'stk_cd_filter', array('class' => 'span5')); ?>
    </div>
    <div class="span3" style="margin-left: -50px">

        <?php echo "Corporate Type " . $form->dropDownList($modeldummy, 'ca_type_filter', CHtml::listData(Parameter::model()->findAll(array('condition' => "prm_cd_1 = 'CATYPE' and prm_desc <> 'CASHDIV' ", 'order' => 'prm_cd_2')), 'prm_desc', 'prm_desc2'), array('class' => 'span6', 'prompt' => '-Choose-')); ?>
    </div>
    <div class="span3" style="margin-left: -10px">
        <label>Distribution Date Sesudah</label>
    </div>
    <div class="span2">
        <?php echo $form->textField($modeldummy, 'distrib_dt', array('class' => 'tdate span8', 'placeholder' => 'dd/mm/yyyy', 'style' => 'margin-left:-80px;')); ?>

    </div>
    <div class="span2">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'id' => 'btnFilter',
            'buttonType' => 'submit',
            'type' => 'primary',
            'htmlOptions' => array('style' => 'margin-left:-10em;', 'class' => 'btn btn-small btn-primary'),
            'label' => 'Search',
        )); ?>
    </div>
</div>

<br/>
<table id="tableCash" class="table-bordered table-condensed">
    <thead>
    <!--<tr>
        <th colspan="6"></th>
        <th colspan="3" style="text-align: center;">Share Dividen</th>

    </tr>-->
    <tr>
        <th width="6%">Stock</th>
        <th width="5%">Corporate Action Type</th>
        <th width="8%">To Stock</th>
        <th width="8%"> Cum Date</th>
        <th width="8%"> X Date</th>
        <th width="8%"> Recording Date</th>
        <th width="8%"> Distribution Date</th>
        <th width="5%"></th>
        <th width="5%"> Setiap</th>
        <th width="5%"> Menjadi/ Mendapat</th>
        <th width="5%"> Rate</th>
    </tr>
    </thead>
    <tbody>

    <?php $x = 1;

    foreach ($model as $row) {

        ?>

        <tr id="row<?php echo $x ?>" class="<?php if ($cek_pape == 'Y') {
            if ($row->jurnal_cumdt == 'N' && $row->jurnal_distribdt == 'N') {
                echo 'sign';
            } else if ($row->jurnal_cumdt == 'Y' && $row->jurnal_distribdt == 'N') {
                echo 'paid';
            }
        } else {
            if($row->x_dt_bofo_flg== 'N')
            {
                echo 'bofo';
            }
            else if ($row->distrib_dt_journal == 'N' && $row->jurnal_distribdt == 'N') {
                echo 'sign';
            }
           
        } ?>">
            <td>
                <?php echo $form->textField($row, 'stk_cd', array('id' => "stk_cd_$x", 'name' => 'Tcorpact[' . $x . '][stk_cd]', 'class' => 'span', 'readonly' => TRUE)); ?>
                <input type="hidden" name="jurnal_cumdt" id="jur_cumdt" value="<?php echo $row->jurnal_cumdt; ?>"/>
                <?php echo $form->textField($row, 'jurnal_cumdt', array('id' => "jurnal_cumdt_$x", 'name' => 'Tcorpact[' . $x . '][jurnal_cumdt]', 'style' => 'display:none;')); ?>
                <?php //echo $form->textField($row,'distrib_dt_journal',array('name'=>'Tcorpact['.$x.'][distrib_dt_journal]','style'=>'display:none;'));
                ?>
            </td>
            <td>
                <?php echo $form->textField($row, 'ca_type', array('id' => "ca_type_$x", 'name' => 'Tcorpact[' . $x . '][ca_type]', 'class' => 'span', 'readonly' => true)); ?>
            </td>
            <td>
                <?php echo $form->textField($row, 'stk_cd_merge', array('name' => 'Tcorpact[' . $x . '][stk_cd_merge]', 'class' => 'span', 'readonly' => true)); ?>
            </td>
            <td>
                <?php echo $form->textField($row, 'cum_dt', array('id' => "cum_dt_$x", 'name' => 'Tcorpact[' . $x . '][cum_dt]', 'class' => 'span', 'readonly' => true)); ?>
                <?php echo $form->textField($row, 'distrib_dt', array('id' => "distrib_dt_$x", 'name' => 'Tcorpact[' . $x . '][distrib_dt]', 'style' => 'display:none')); ?>
            </td>
            <td>
                <?php echo $form->textField($row, 'x_dt', array('id' => "x_dt_$x", 'name' => 'Tcorpact[' . $x . '][x_dt]', 'class' => 'span', 'readonly' => true)); ?>
            </td>
            <td>
                <?php echo $form->textField($row, 'recording_dt', array('id' => "recording_dt_$x", 'name' => 'Tcorpact[' . $x . '][recording_dt]', 'class' => 'span', 'readonly' => true)); ?>
            </td>
            <td>
                <?php echo $form->textField($row, 'distrib_dt', array('id' => "recording_dt_$x", 'name' => 'Tcorpact[' . $x . '][recording_dt]', 'class' => 'span', 'readonly' => true)); ?>

            </td>
            <td style="text-align: center;">

                <?php echo CHtml::button('Pilih',
                    array('submit' => array('Corpactjournal/param', 'stk_cd' => $row->stk_cd, 'ca_type' => $row->ca_type, 'cum_dt' => $row->cum_dt, 'jurnal_cumdt' => $row->jurnal_cumdt, 'distrib_dt' => $row->distrib_dt, 'x_dt' => $row->x_dt, 'from_qty' => $row->from_qty, 'to_qty' => $row->to_qty, 'recording_dt' => $row->recording_dt, 'jurnal_distribdt' => $row->jurnal_distribdt, 'rate' => $row->rate, 'distrib_dt_journal' => $row->distrib_dt_journal, 'stk_cd_merge' => $row->stk_cd_merge),
                        'class' => 'btn btn-small btn-primary'
                    )); ?>

            </td>
            <td>
                <?php echo $form->textField($row, 'from_qty', array('id' => "from_qty_$x", 'class' => 'span', 'readonly' => true, 'style' => 'text-align:right;')); ?>
            </td>
            <td>
                <?php echo $form->textField($row, 'to_qty', array('id' => "to_qty_$x", 'class' => 'span', 'readonly' => true, 'style' => 'text-align:right;')); ?>
            </td>
            <td>
                <?php echo $form->textField($row, 'rate', array('class' => 'span', 'readonly' => true, 'style' => 'text-align:right;')); ?>
            </td>

        </tr>

        <?php $x++;

    } ?>
    </tbody>
</table>


<?php echo $form->datePickerRow($modeldummy, 'cre_dt', array('label' => false, 'disabled' => 'disabled', 'style' => 'display:none', 'options' => array('format' => 'dd/mm/yyyy'))); ?>
<?php $this->endWidget(); ?>
<script>
    $('.tdate').datepicker({format: "dd/mm/yyyy"});
    getStock();
    $(window).resize(function () {
        alignColumn();
    })
    $(window).trigger('resize');

    function alignColumn()//align columns in thead and tbody
    {
        var header = $("#tableCash").find('thead');
        var firstRow = $("#tableCash").find('tbody tr:eq(0)');

        firstRow.find('td:eq(0)').css('width', header.find('th:eq(0)').width() + 'px');
        firstRow.find('td:eq(1)').css('width', header.find('th:eq(1)').width() + 'px');
        firstRow.find('td:eq(2)').css('width', header.find('th:eq(2)').width() + 'px');
        firstRow.find('td:eq(3)').css('width', header.find('th:eq(3)').width() + 'px');
        firstRow.find('td:eq(4)').css('width', header.find('th:eq(4)').width() + 'px');
        firstRow.find('td:eq(5)').css('width', header.find('th:eq(5)').width() + 'px');
        firstRow.find('td:eq(6)').css('width', header.find('th:eq(6)').width() + 'px');
        firstRow.find('td:eq(7)').css('width', header.find('th:eq(7)').width() + 'px');
        firstRow.find('td:eq(8)').css('width', header.find('th:eq(8)').width() + 'px');
        firstRow.find('td:eq(9)').css('width', header.find('th:eq(9)').width() + 'px');
        firstRow.find('td:eq(10)').css('width', (header.find('th:eq(10)').width()) - 17 + 'px');

    }
function getStock()
{ 
        var result = [];
        $('#Tcorpact_stk_cd_filter').autocomplete(
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