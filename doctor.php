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
            <form id="frmdoctor" class="card">
                <div align="left">
                    <h3>Doctor</h3>
                </div>

                <div align="left">
                    <label class="form-label">Doctor No</label>
                    <input type="text" class="form-control" placeholder="Doctor No" id="dno" name="dno" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Doctor Name</label>
                    <input type="text" class="form-control" placeholder="Doctor Name" id="dname" name="dname" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Specialization</label>
                    <input type="text" class="form-control" placeholder="Specialization" id="special" name="special" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Qualification</label>
                    <input type="text" class="form-control" placeholder="Qualification" id="quali" name="quali" size="30px" required>
                </div>


                <div align="left">
                    <label class="form-label">Fee</label>
                    <input type="text" class="form-control" placeholder="Fee" id="fee" name="fee" size="30px" required>
                </div>

                <div align="left">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" size="30px" required>
                </div>


                <div align="left">
                    <label class="form-label">Room No</label>
                    <input type="text" class="form-control" placeholder="Room No" id="rno" name="rno" size="30px" required>
                </div>

                <div align="left">

                    <input type="hidden" class="form-control" value="<?php echo $_SESSION['id']; ?>"  id="logid" name="logid" size="30px" required>
                </div>







                </br>

                <div align="right">
                    <button type="button" id="save" class="btn btn-info" onclick="addDoctor()">Add</button>
                    <button type="button" id="clear" class="btn btn-warning" onclick="reset()">Reset</button>

                </div>


            </form>
        </div>

        <div class="col-sm-8">
            <div class="panel-body">
                <table id="tbl-doctor" class="table table-responsive table bordered" cellpadding="0" width="100%">
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
        $('#dno').empty();

        $.ajax({
            type : "GET",
            url : 'php/Doctor/autoid.php',
            success : function (data)
            {
                $("#dno").val(data);
            }

        });

    }



    function addDoctor()
    {

        if($("#frmdoctor").valid())
        {
            var url = '';
            var data = '';
            var method = '';

            if(isNew == true)
            {
                url = 'php/Doctor/add_doctor.php';
                data = $('#frmdoctor').serialize();
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

                success:function(data) {

                    if(data == 2)
                    {
                        alert("Doctor already Added");
                    }
                    else {
                        if (isNew == true)
                        {
                            alert("Doctor Addded");
                        }
                        else
                        {
                            alert("Doctor Updateddd");
                        }
                        getall();
                        getAutoid();
                        $('#frmdoctor')[0].reset();
                        $('#dno').removeAttr("disabled");
                    }

                }
            });

        }

    }

    function getall()
    {
        var logid = $("#logid").val();



        $('#tbl-doctor').dataTable().fnDestroy();
        $.ajax({

            url : "php/Doctor/all_doctor.php",
            type : "POST",
            dataType : "JSON",
            data : {logid :logid },

            success: function(data)
            {
                $('#tbl-doctor').html(data);
                $('#tbl-doctor').dataTable({
                    "aaData" : data ,
                    "scrollX" : true,
                    "aoColumns" : [
                        {"sTitle" : "Doctor No", "mData" : "doctorno"},
                        {"sTitle" : "Doctor Name", "mData" : "dname"},
                        {"sTitle" : "Special", "mData" : "special"},
                        {"sTitle": "Quali", "mData" : "qual"},
                        {"sTitle": "Fee", "mData" : "fee"},
                        {"sTitle": "Phone", "mData" : "phone"},
                        {"sTitle": "Room", "mData" : "room"},



                        {
                            "sTitle": "Edit",
                            "mData" : "patientno",
                            "render" : function(mData,type,row,meta)
                            {
                                return '<button class="btn btn-success" onclick="getdetails('+ mData + ')">Edit</button>';
                            }
                        },
                        {
                            "sTitle": "Delete",
                            "mData" : "patientno",
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


