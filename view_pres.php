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

        <div align="left">

            <input type="hidden" class="form-control" value="<?php echo $_SESSION['id']; ?>"  id="logid" name="logid" size="30px" required>
        </div>




        <div class="col-sm-12">
            <div class="panel-body">
                <table id="tbl-pres" class="table table-responsive table bordered" cellpadding="0" width="100%">
                    <thead>
                    <tr>
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







    function getall()
    {

        $('#tbl-pres').dataTable().fnDestroy();



        $.ajax({



            url : "php/Pres/all_pres.php",
            type : "GET",
            dataType : "JSON",


            success: function(data)
            {
                $('#tbl-pres').html(data);
                $('#tbl-pres').dataTable({
                    "aaData" : data ,
                    "scrollX" : true,
                    "aoColumns" : [
                        {"sTitle" : "Prescription No", "mData" : "pid"},
                        {"sTitle" : "Channel no", "mData" : "cno"},
                        {"sTitle" : "Desease type", "mData" : "dtype"},
                        {"sTitle": "Description", "mData" : "des"},

                        {
                            "sTitle": "Invoice",
                            "mData" : "pid",
                            "render" : function(mData,type,row,meta)
                            {
                                return '<button class="btn btn-success"  onclick="getInvoice('+ mData + ')">Invoice</button>';
                            }
                        }


                    ]

                });
            }

        });
    }



    function getInvoice(id)
    {

        window.location.href = "invoice.php?id=" +id;
    }






















</script>











</body>
</html>


