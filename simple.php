<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "layhospital";

$conn = new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error)
{
    die("connection failed" . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  $id = $_GET['id'];





}
?>
<?php
session_start();

?>


<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

</head>

<body>

<?php include("header.php")?>

<br><br>

<div class="container-fluid bg-2 text-center">
<div class="row">
    <div class="col-sm-8">
        <form  id="frmInvoice">
        <form  id="frmInvoice">

            <table class="table table-bordered">
                <caption> Add Products  </caption>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Option</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" placeholder="barcode" id="barcode" name="barcode"  size="25px"  required>
                    </td>
                    <td>
                        <label id="pro_name" name="pname" id="pname"></label>
                        <input  type="text" class="form-control" placeholder="barcode" id="pname" name="pname" size="50px"  disabled >
                    </td>
                    <td>
                        <input type="text" class="form-control pro_price" id="pro_price" size="25px"   name="pro_price"
                               placeholder="price" disabled>
                    </td>
                    <td>
                        <input type="number" class="form-control pro_price" id="qty" name="qty"
                               placeholder="qty" min="1" value="1" size="10px" required>
                    </td>

                    <td>
                        <input type="text" class="form-control" placeholder="total_cost" size="35px" id="total_cost" name="total_cost" disabled>
                    </td>
                    <td>
                        <button class="btn btn-success" type="button" onclick="addproduct()">Add
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <table id="tbl-item" class="table table-dark table-bordered" cellspacing="0" width="100%" align="center">
            <thead>
            <tr>
                <th>Delete</th>
                <th>Item No</th>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>

            </tr>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="col-sm-4">
        <div class="col s12 m6 offset-m4">

            <div class="form-group" align="left">
                <label class="form-label">Total</label>
                <input type="text" class="form-control" placeholder="Total" id="total" name="total" size="30px" required disabled>
            </div>


            <div class="form-group" align="left">
                <label class="form-label">Pay</label>
                <input type="text" class="form-control" placeholder="Pay" id="pay" name="pay" size="30px" required>
            </div>

            <div class="form-group" align="left">
                <label class="form-label">Balance</label>
                <input type="text" class="form-control" placeholder="Balance" id="balance" name="balance" size="30px" required disabled>
            </div>

            <div class="form-group" align="left">
                <label class="col-sm-2 control-label">Status</label>
                <select class="form-control" id="payment" name="payment"
                        placeholder="Project Status" required>
                    <option value="">Please Select</option>
                    <option value="1">Cash</option>
                    <option value="2">Cheque</option>
                </select>
            </div>
            <div class="card" align="right">

                <button type="button" id="save" class="btn btn-info" onclick="addProject()">Print Invoice
                </button>
                <button type="button" id="clear" class="btn btn-warning" onclick="reset()">Reset</button>

            </div>
        </div>
        </form>
    </div>
</div>

<br><br>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="compn/jquery.validate.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>

var isNew=true;
var version_id=null;
var current_stock=0;
var product_no =0;
var total = 0;
var tot = 0;
getProductcode();

function getProductcode() {
    $("#barcode").empty();
    $("#barcode").keyup(function(e) {
        $.ajax({
            type: "POST",
            url: "php/item/get_item.php",
            dataType: "JSON",
            data: { barcode: $("#barcode").val() },
            success: function(data) {

                $("#pname").val(data[0].itemname);
                $("#pro_price").val(data[0].sellprice);

                $("#qty").focus();

            },
            error: function(xhr, status, error) {

            }
        });
    });
}
$(function() {
    $("#pro_price, #qty").on("keydown keyup click", qty);

    function qty() {
        var sum = (
        Number($("#pro_price").val()) * Number($("#qty").val())
        );
        $('#total_cost').val(sum);
        console.log(sum);
    }
});

$(function() {
    $("#qty, #discount").on("keydown keyup click", discount);
    function discount() {
        var sum1 = (
        Number($("#qty").val()) * Number($("#discount").val())
        );

        console.log(sum1);
    }
});

$(function() {
    $("#total, #pay").on("keydown keyup", per);

    function per() {
        var totalamount = (
        Number($("#pay").val()) - Number($("#total").val())
        );
        $("#balance").val(totalamount);
    }

});

function reset()
{
window.location.href = "view_pres.php";
}
function addproduct()
{
var barcode = $('#barcode').val();
var pname = $('#pname').val();
var pro_price = $('#pro_price').val();
var qty = $('#qty').val();
  tot = qty * pro_price;
var table1 =
    "<tr>" +
    "<td><button type='button' name='record' class='btn btn-warning' onclick='deleterow(this)'>Delete </td>" +
    "<td>" + barcode + "</td>" +
    "<td>" +  pname +  "</td>" +
    "<td>" +  pro_price +  "</td>" +
    "<td>" +  qty +  "</td>" +
    "<td>" +  tot +  "</td>" +
    "</tr>" ;

total += Number(tot);
$('#total').val(total);
$("#tbl-item tbody").append(table1);
$('#qty').val("1");
}
function deleterow(e)
{
    total_cost = parseInt($(e).parent().parent().find('td:last').text(),10);
    total -= total_cost;
    $('#total').val(total);
    $(e).parent().parent().remove();
}







function addProject() {
    var table_data = [];
    $('#product_list tbody tr').each(function (row, tr){
        var sub = {
            'barcode': $(tr).find('td:eq(1)').text(),
            'pname': $(tr).find('td:eq(2)').text(),
            'pro_price': $(tr).find('td:eq(3)').text(),
            'qty': $(tr).find('td:eq(4)').text(),
            'discount': $(tr).find('td:eq(5)').text(),
            'total_cost': $(tr).find('td:eq(6)').text(),
        };
        table_data.push(sub);
    });
    console.log(table_data);
    var _url = '';
    var _data = '';
    var _method;
    var total = $("#total").val();
    var discounttotal = $("#discounttotal").val();
    var grandtotal = $("#grandtotal").val();
    var pay = $("#pay").val();
    var balance = $("#balance").val();
    $.ajax({
        type: "POST",
        url: "sales_add.php",
        dataType: 'JSON',
        data: {
            total: $('#total').val(),
            discounttotal: $('#discounttotal').val(),
            grandtotal: $('#grandtotal').val(),
            pay: $('#pay').val(),
            balance: $('#balance').val(),
            payment: $('#payment').val(),
            data: table_data
        },
        success: function (data) {
            console.log(_data);
            //    $('#frmProject')[0].reset();
            $('#save').prop('disabled', false);
            $('#save').html('');
            $('#save').append('Add');
            var msg;
            if (isNew) {
                msg = "Sales Completed";
            }

            last_id = data.last_id
            window.location.href = "print.php?last_id=" + last_id;

            $.alert({
                title: 'Success!',
                content: msg,
                type: 'green',
                boxWidth: '400px',
                theme: 'light',
                useBootstrap: false,
                autoClose: 'ok|2000'
            });
            isNew = true;
        },

        error: function (xhr, status, error) {
            alert(xhr);
            console.log(xhr.responseText);
            $.alert({
                title: 'Fail!',
                //            content: xhr.responseJSON.errors.product_code + '<br>' + xhr.responseJSON.msg,
                type: 'red',
                autoClose: 'ok|2000'
            });
            $('#save').prop('disabled', false);
            $('#save').html('');
            $('#save').append('Save');

        }

    });
}

</script>



</body>


</html>