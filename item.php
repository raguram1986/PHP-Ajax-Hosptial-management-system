<?php
session_start();

?>


<html>
<head>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
</head>

<body>

<?php

if($_SESSION["utype"] == 1)
{
    include("header.php");


}
else if($_SESSION["utype"] == 2)
{
    include("header1.php");
}

else if($_SESSION["utype"] == 3)
{
    include("header2.php");
}


?>


<br>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <form id="frmitem" class="card">
                <div align="left">
                    <h3>Create Item</h3>
                </div>

                <div align="left">
                    <label class="form-label">Item No</label>
                    <input type="text" class="form-control" placeholder="Item No" id="ino" name="ino" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Item Name</label>
                    <input type="text" class="form-control" placeholder="Item Name" id="iname" name="iname" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Description</label>
                    <input type="text" class="form-control" placeholder="Description" id="des" name="des" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Sell Price</label>
                    <input type="number" class="form-control" placeholder="Sell Price" id="sprice" name="sprice" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Buy Price</label>
                    <input type="number" class="form-control" placeholder="Buy Price" id="bprice" name="bprice" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Qty</label>
                    <input type="number" class="form-control" placeholder="Qty" id="qty" name="qty" size="30px" required>
                </div>


                </br>

                <div align="right">
                    <button type="button" id="save" class="btn btn-info" onclick="addItem()">Add</button>
                    <button type="button" id="clear" class="btn btn-warning" onclick="reset()">Reset</button>

                </div>


            </form>
        </div>

        <div class="col-sm-8">
            <div class="panel-body">
                <table id="tbl-item" class="table table-responsive table bordered" cellpadding="0" width="100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>

                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>








<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="compn/jquery.validate.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>






<script>
    getall();
    var isNew = true;

    var patient_id = null;

    getAutoid();

    function getAutoid()
    {
        $('#ino').empty();

        $.ajax({
            type : "GET",
            url : 'php/item/autoid.php',
            dataType : "JSON",
            success : function (data)
            {
              $("#ino").val("CUS" + data);

            }

        });

    }



    function addItem()
    {

        if($("#frmitem").valid())
        {
            var url = '';
            var data = '';
            var method = '';

            if(isNew == true)
            {
                url = 'php/item/add_item.php';
                data = $('#frmitem').serialize();
                method = 'POST';
            }
            else
            {
                url = 'php/edit_patient.php';
                data = $('#frmpatient').serialize() + "&patient_id=" + patient_id ;
                method = 'POST';
            }

            $.ajax({

                type : method,
                url : url,
                dataType : 'JSON',
                data : data,

                success:function(data)
                {

                    if(isNew== true)
                    {
                        alert("Item Addedd");
                    }
                    else
                    {
                        alert("Patient Updatedddd");

                    }
                    getall();
                    getAutoid();
                    $('#frmitem')[0].reset();
                    $('#pno').removeAttr("disabled");

                }

            });

        }

    }

    function getall()
    {

        $('#tbl-item').dataTable().fnDestroy();
        $.ajax({

            url : "php/item/all_item.php",
            type : "GET",
            dataType : "JSON",

            success: function(data)
            {
                $('#tbl-item').html(data);
                $('#tbl-item').dataTable({
                    "aaData" : data ,
                    "scrollX" : true,
                    "aoColumns" : [
                        {"sTitle" : "Item No", "mData" : "id"},
                        {"sTitle" : "Item Name", "mData" : "itemname"},
                        {"sTitle" : "Description", "mData" : "description"},
                        {"sTitle": "Sellprice", "mData" : "sellprice"},
                        {"sTitle": "Sell price", "mData" : "sellprice"},
                        {"sTitle": "Buy price", "mData" : "buyprice"},
                        {"sTitle": "Qty", "mData" : "qty"},


                        {
                            "sTitle": "Edit",
                            "mData" : "id",
                            "render" : function(mData,type,row,meta)
                            {
                                return '<button class="btn btn-success" onclick="getdetails('+ mData + ')">Edit</button>';
                            }
                        },
                        {
                            "sTitle": "Delete",
                            "mData" : "id",
                            "render" : function(mData,type,row,meta)
                            {
                                return '<button class="btn btn-danger" onclick="removedetails('+ mData + ')">Delete</button>';
                            }
                        },
                    ]

                });
            }

        });
    }



    function getdetails(id)
    {
        $.ajax({

            type : 'POST',
            url : 'php/patient_return.php',
            dataType : 'JSON',
            data : {patient_id : id},
            success : function(data)
            {
                isNew = false
                patient_id = data.patientno
                $('#pno').val(data.patientno);
                $("#pno").attr("disabled","disabled");

                $('#pname').val(data.name);
                $('#phone').val(data.phone);
                $('#address').val(data.address);

            }

        });


    }


    function removedetails(id)
    {

        $.ajax({

            type : 'POST',
            url : 'php/patient_delete.php',
            dataType : 'JSON',
            data : {patient_id : id},

            success : function(data)
            {
                getall();


            }





        });




    }














</script>











</body>
</html>


