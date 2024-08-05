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
            <form id="frmchannel" class="card">
                <div align="left">
                    <h3>Channel</h3>
                </div>

                <div align="left">
                    <label class="form-label">Channel No</label>
                    <input type="text" class="form-control" placeholder="Channel No" id="cno" name="cno" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Doctor Name</label>
                    <select class="form-control" id="dname" name="dname">
                        <option value="">Please Select</option>
                    </select>

                </div>

                <div align="left">
                    <label class="form-label">Patient Name</label>
                    <select class="form-control" id="pname" name="pname">
                        <option value="">Please Select</option>
                    </select>
                </div>

                <div align="left">
                    <label class="form-label">Room No</label>
                    <input type="text" class="form-control" placeholder="Room No" id="rno" name="rno" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Channel Date</label>
                    <input type="date" class="form-control" placeholder="Date" id="date" name="date" size="30px" required>
                </div>





                </br>

                <div align="right">
                    <button type="button" id="save" class="btn btn-info" onclick="addChannel()">Add</button>
                    <button type="button" id="clear" class="btn btn-warning" onclick="reset()">Reset</button>

                </div>


            </form>
        </div>

        <div class="col-sm-8">
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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="compn/jquery.validate.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>






<script>
    getall();





    getDoctor();
    getPatient();
    var isNew = true;

    var patient_id = null;

    getAutoid();



    function getDoctor()
    {
        $.ajax({

            type : "GET",
            url : 'php/Doctor/get_doctor.php',
            dataType : "JSON",

            success: function(data) {

                for(var i = 0; i < data.length; i++)
                {

                    $('#dname').append($("<option/>",
                     {
                        value : data[i].doctorno,
                         text : data[i].dname,
                    }));

                }
            }
              });
    }


    function getPatient()
    {
        $.ajax({

            type : "GET",
            url : 'get_patient.php',
            dataType : "JSON",

            success: function(data) {

                for(var i = 0; i < data.length; i++)
                {

                    $('#pname').append($("<option/>",
                        {
                            value : data[i].patientno,
                            text : data[i].name,
                        }));

                }
            }
        });
    }














    function getAutoid()
    {
        $('#cno').empty();

        $.ajax({
            type : "GET",
            url : 'php/Channel/autoid.php',
            dataType : "JSON",
            success : function (data)
            {
                $("#cno").val(data);
            }

        });

    }



    function addChannel()
    {

        if($("#frmchannel").valid())
        {
            var url = '';
            var data = '';
            var method = '';

            if(isNew == true)
            {
                url = 'php/Channel/add_channel.php';
                data = $('#frmchannel').serialize();
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
                        alert("Channel Booked");
                    }
                    else
                    {
                        alert("Patient Updatedddd");

                    }
                    getall();
                    getAutoid();
                    $('#frmpatient')[0].reset();
                    $('#pno').removeAttr("disabled");

                }

            });

        }

    }

    function getall()
    {

        $('#tbl-channel').dataTable().fnDestroy();
        $.ajax({

            url : "php/Channel/all_channel.php",
            type : "GET",
            dataType : "JSON",

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
                            "sTitle": "Edit",
                            "mData" : "chno",
                            "render" : function(mData,type,row,meta)
                            {
                                return '<button class="btn btn-success" onclick="getdetails('+ mData + ')">Edit</button>';
                            }
                        },
                        {
                            "sTitle": "Cancel",
                            "mData" : "chno",
                            "render" : function(mData,type,row,meta)
                            {
                                return '<button class="btn btn-danger" onclick="removedetails('+ mData + ')">Cancel</button>';
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


