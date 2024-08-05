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
                <table id="tbl-channel" class="table table-responsive table bordered" cellpadding="0" width="100%">
                    <thead>
                    <tr>
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



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Precription</h5>
            </div>

            <div class="modal-body">

                <form id="frmpres" class="card">


                    <div align="left">
                        <label class="form-label">Prescrption No</label>
                        <input type="text" class="form-control" placeholder="Prescrption No" id="pno" name="pno" size="30px" required>
                    </div>

                    <div align="left">
                        <label class="form-label">Channel No</label>
                        <input type="text" class="form-control" placeholder="Channel No" id="cno" name="cno" size="30px" required>
                    </div>

                    <div align="left">
                        <label class="form-label">Desease Type</label>
                        <input type="text" class="form-control" placeholder="Desease Type" id="dtype" name="dtype" size="30px" required>
                    </div>

                    <div align="left">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" placeholder="Description" id="des" name="des" size="30px" required>
                    </div>

                    </br>




                </form>






            </div>



            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  onclick="addPres()">Save</button>
                <button type="button" class="btn btn-primary">Close</button>
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





function getall()
{

    $('#tbl-channel').dataTable().fnDestroy();

    var logid = $('#logid').val();

    $.ajax({



        url : "php/Doctor/channeldoctor.php",
        type : "POST",
        dataType : "JSON",
        data : {logid : logid},

        success: function(data)
        {
            $('#tbl-channel').html(data);
            $('#tbl-channel').dataTable({
                "aaData" : data ,
                "scrollX" : true,
                "aoColumns" : [
                    {"sTitle" : "Channel No", "mData" : "chno"},
                    {"sTitle" : "Doctor Name", "mData" : "dname"},
                    {"sTitle" : "Patient Name", "mData" : "pname"},
                    {"sTitle": "Room No", "mData" : "rno"},
                    {"sTitle": "Date", "mData" : "date"},

                    {
                        "sTitle": "Prescription",
                        "mData" : "chno",
                        "render" : function(mData,type,row,meta)
                        {
                            return '<button class="btn btn-success" data-toggle="modal" data-target="#exampleModal" onclick="getPres('+ mData + ')">Prescription</button>';
                        }
                    }







                ]

            });
        }

    });
}


function getPres(id)
{
    $('#cno').val(id);

    $('#exampleModal').model('show');

}

    getAutoid();


    function getAutoid()
    {
        $('#pno').empty();

        $.ajax({
            type : "GET",
            url : 'php/Pres/autoid.php',
            dataType : "JSON",
            success : function (data)
            {
                $("#pno").val(data);
            }

        });

    }



    function addPres()
    {

        if($("#frmpres").valid())
        {
            var url = '';
            var data = '';
            var method = '';

            if(isNew == true)
            {
                url = 'php/Pres/add_pres.php';
                data = $('#frmpres').serialize();
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
                        alert("Prescription Addedd");
                    }




                }

            });

        }

    }
















</script>











</body>
</html>


