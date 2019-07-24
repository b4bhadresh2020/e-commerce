<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            table{
                width: 100%;
                border-collapse: collapse;
            }
            table tr th{
                border: 1px solid
            }
            table p{
                margin-bottom: 0;
                font-size: 16px;
            }
            table tr td:first-child{
                vertical-align: initial
            }
            .consignor tr,.consignor td{
                border: 1px solid;
            }
            p.box{
                padding: 1px;
                border: 1px solid;
            }
            p.signature{
                padding: 15px;
                border: 1px solid;
            }

            p{margin-bottom: 0;
              margin-top: 0px;
              padding: 5px;}

            h3{
                margin-top: 5px;
                padding: 5px;
                margin-bottom: 0px;
            }

        </style>
    </head>
    <?php
    if (isset($order)) {
        $cod_amount = 0;
        $paid_amount = 0;
        $weight = 0;

        $sold_by = $order->business_name;
        $customer_name = $order->first_name . " " . $order->last_name;
        $vat_no = $order->tin_id;
        $weight = $order->weight / 1000;
        if ($order->pay_method == 'cod') {
            $cod_amount += $order->payment_price;
        } else {
            $paid_amount += $order->payment_price;
        }
    }
    ?>
    <body>
        <table style="width: 100%;line-height: 15px;"   align="center">  
            <tr>
                <td colspan="2">
                    <table style="width: 100%;margin-top: 1%" class="consignor">
                        <thead>
                            <tr>
                                <th>SHIP FROM</th>
                                <th>SHIP TO</th>                                
                            </tr>
                        </thead>
                        <tr>
                            <td style="padding-left: 20px;">
                                <h4 style="margin-bottom: 0px;margin-left: 5px;margin-top: 0px"><?= isset($customer_name) ? $customer_name : '-' ?></h4>
                                <p>Contact - <?= isset($order->customer_contact) ? $order->customer_contact : '-' ?></p>
                                <p><?= isset($order->address) ? $order->address . ", " . $order->landmark : '-' ?><br/>
                                    <?= isset($order->city) ? $order->city : '-' ?><br/>
                                    <?= isset($order->state) ? $this->common->getStateName($order->state) : '-' ?> - <?= isset($order->pincode) ? $order->pincode : '-' ?>
                                </p>
                            </td>
                            <td style="padding-left: 20px;">
                                <h4 style="margin-bottom: 0px;margin-left: 5px;margin-top: 0px"><?= isset($sold_by) ? $sold_by : '-' ?></h4>                               
                                <p><?= isset($order->pickup_address) ? $order->pickup_address : '-' ?><br/>
                                    <?= isset($order->pickup_city) ? $order->pickup_city : '-' ?><br/>
                                    <?= isset($order->pickup_state) ? $this->common->getStateName($order->pickup_state) : '-' ?> - <?= isset($order->pickup_pincode) ? $order->pickup_pincode : '-' ?>
                                </p>
                                <p>Contact No : <?= isset($order->seller_contact) ? $order->seller_contact : '-' ?></p>
                                <p><strong>VAT/TIN No: </strong><?= isset($vat_no) ? $vat_no : '-' ?></p> 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>                     
            <tr>
                <td colspan="2">
                    <table style="width: 100%;border: 1px solid;">
                        <tr>
                            <td style="width:45%;padding-left: 20px;">                                
                                <h1>FedEx</h1>
                                <p><strong>Shipping Date : <?= isset($order->ready_date) ? date('d M Y', strtotime($order->ready_date)) : '-' ?> </strong></p>
                                <p><strong>Shipment Weight : <?= isset($weight) ? $weight : '-' ?> kg</strong></p>
                                <p><strong>Fedex Meter: 118692262</strong></p>
                                <p>Bill T/C: Sender &nbsp;&nbsp;&nbsp; Bill D/T: Recipient</p>
                            </td>
                            <td>
                                <h3><?= isset($order->service_type) ? $order->service_type : '' ?>
                                    <?= isset($order->destination_area) ? $order->destination_area : '' ?></h3>
                                <h3>TRK# <?= isset($order->awb_no) ? chunk_split($order->awb_no, '4', ' ') : '' ?>&nbsp;&nbsp;&nbsp; Form Id :<?= isset($order->form_id) ? $order->form_id : '' ?></h3>
                                <h3 style="margin-bottom: 0;margin-right: 10px;font-size: 30px;margin-top: 15px;"> <?= isset($order->routing_code) ? $order->routing_code : '-' ?></h3> <h3><?= isset($order->pickup_pincode) ? $order->pickup_pincode : '-' ?> &nbsp;&nbsp;<?= isset($order->airport_id) ? $order->airport_id : '-' ?> &nbsp;<?= isset($order->pickup_pincode) ? $this->common->getFedExStateId($order->pickup_pincode) : '' ?>-IN</h3><br/>
                                <img src="http://barcodes4.me/barcode/c128c/<?= isset($order->barcode_string) ? $order->barcode_string : '' ?>.png?width=330&height=120"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr> 
            <tr>
                <td colspan="2">
                    <table style="width: 100%;margin-top: 1%" class="consignor">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Order ID</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total Price</th>                                
                                <th>COD</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($order)) {
                                $total_amount = 0;
                                $total_amount += $order->payment_price;
                                ?>   
                                <tr>
                                    <td><?= $order->product_name ?></td>
                                    <td><?= $order->order_id ?></td>
                                    <td><?= $order->qty ?></td>
                                    <td>Rs. <?= $order->selling_price ?></td>
                                    <td>Rs. <?= $order->total_price ?></td>                                        
                                    <td>Rs. <?= $order->cod_charge ?></td>
                                    <td>Rs. <?= $order->payment_price ?></td>
                                </tr>
                                <?php
                            }
                            ?>         
                            <tr>
                                <td colspan="7" style="text-align: right">
                                    <strong>Total Price : Rs. <?= isset($total_amount) ? $total_amount : '' ?></strong>
                                    <p>All value are in INR</p>
                                </td>
                            </tr>
                            <tr style="background: grey">
                                <td colspan="6">Form to be Attached: <strong>402</strong></td>
                                <td><strong>MAA/PER</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="border-bottom: 2px dashed">
                <td colspan="2">
                    <h3>SHOPKING24.COM</h3>
                    <p>104-Shyamdham Society, Near Shyamdham Mandir, Sarthana Jakatnaka, Surat-395006<br>Phone:0261-6452111  Email:info@shopking24.com</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                    Subject to the FedEx Conditions of Carriage,which limit the liability of FedEx for loss,delay or damage to the consignment.Visit www.fedex.com/in to view the Conditions of Carriage.
                </td>
            </tr>
        </table>
    </body>
</html>
