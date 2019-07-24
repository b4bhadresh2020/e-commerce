<style type="text/css">
    th{
        text-align: center;
    }
</style>    
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Courier Profit/loss Master</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?= site_url() ?>admin">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
            </ol>
        </div>
    </header>
    <!-- start: page --> 
    <div class="row">
        <div class="col-md-12">
            <a href="<?= site_url() ?>admin/others/addCourier" class="btn btn-success btn-md" >Add Courier Profit/Loss</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel panel-featured panel-featured-primary">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-up"></a>                        
                    </div>

                    <h2 class="panel-title">Advance Search</h2>                    
                </header>
                <div class="panel-body" style="display:none"> 
                    <form name="search" method="POST" action="<?= site_url() ?>admin/others/searchExpense">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label">Date</label>
                                <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>    
                                    </span>
                                    <input type="text" class="form-control" name="start">
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="form-control" name="end" style="width: 115px;">
                                </div>   
                            </div>                            
                        </div>                        
                        <div class="row" style="margin-top: 15px">
                            <div class="col-md-4">
                                <button class="btn btn-success btn-sm" type="submit" style="width:80px">Search</button>
                                <button class="btn btn-warning btn-sm" type="reset" style="width:80px">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel panel-featured panel-featured-primary">
                <header class="panel-heading">                  
                    <h2 class="panel-title">Profit/loss Detail</h2>                    
                </header>
                <div class="panel-body">
                    <form id="tableform" method="post" name="expensetableform" action="<?= site_url() ?>admin/others/deleteCourierData">
                        <button id="btnExport1" class="btn btn-warning btn-sm" type="button" style="width:80px;margin-bottom: 15px">Export</button>
                        <button id="delete" class="btn btn-danger btn-sm mycheck" type="submit" style="width:80px;margin-bottom: 15px">Delete</button>
                        <table class="table table-bordered table-striped mb-none" id="datatable-default" style="text-align: center">
                            <thead>
                                <tr>
                                    <th style="font-size: 17px;padding-right: 18px;text-align: center;">
                                        <i class="fa fa-level-down"></i>     
                                    </th>
                                    <th>Date</th>
                                    <th>Orders</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>  
                                <?php
                                if (isset($courier)) {
                                    $cr = 0;
                                    $dr = 0;
                                    foreach ($courier as $val) {
                                        if (($val->type == 0)) {
                                            $cr += $val->amount;
                                        } else {
                                            $dr += $val->amount;
                                        }
                                        ?>
                                        <tr>
                                            <td><input name="allCourier[]" value="<?= $val->id ?>" type="checkbox" ></td>
                                            <td><?= date('d-m-Y', strtotime($val->reg_date)) ?></td>
                                            <td><?= $val->orders ?></td>
                                            <td><?php if ($val->type == 0) { ?>
                                                    <i class="fa fa-rupee"></i> <?php
                                                    echo $val->amount;
                                                }
                                                ?>
                                            </td>                                            
                                            <td><?php if ($val->type == 1) { ?>
                                                    <i class="fa fa-rupee"></i> <?php
                                                    echo $val->amount;
                                                }
                                                ?>
                                            </td>                                             
                                            <td>
                                                <a href="<?= site_url() ?>admin/others/getCourierData?id=<?= base64_encode($val->id) ?>" class="btn btn-success btn-xs" >Edit</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">Total Credit</td>
                                    <td><i class="fa fa-rupee"></i> <?= isset($cr) ? $cr : "0" ?></td>                                    
                                </tr>  
                                <tr>
                                    <td colspan="5" class="text-right">Total Debit</td>
                                    <td><i class="fa fa-rupee"></i> <?= isset($dr) ? $dr : "0" ?></td>                                    
                                </tr>  
                                <tr>
                                    <td colspan="5" class="text-right">Total Profit/loss</td>
                                    <td><i class="fa fa-rupee"></i> <?= isset($cr) ? $cr -$dr : "0" ?></td>                                    
                                </tr>  
                            </tfoot>
                        </table>
                    </form>
                </div>
            </section>            
        </div>
    </div>
    <!-- end: page -->
</section>
<script type="text/javascript">
    $(function () {
        $('#datatable-default').dataTable({
            order: [],
            aLengthMenu: [[10, 15, 20, 25, -1], [10, 15, 20, 25, 'All']],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 2, 3, 4, 5]
                }],
            iDisplayLength: 10
        });

        $("#btnExport1").click(function () {
            $("#datatable-default").btechco_excelexport({
                containerid: "datatable-default",
                datatype: $datatype.Table
            });
        });

    });
</script>