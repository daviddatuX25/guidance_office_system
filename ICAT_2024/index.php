<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ICAT Result</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

        <!-- Favicon -->
        <link href="../includes/img/logo.png" rel="icon">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- Boxicons -->
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

        <!-- Customized Bootstrap Stylesheet -->
        <link href="../includes/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="../includes/css/style.css" rel="stylesheet">

      </head>
    <body>

      <div class="container mt-5 pt-3">
          <div class="card">
              <div class="card-header">
                  <h4>Excel/PDF</h4>

                      <button type="button" id="add_button" data-bs-toggle="modal" data-bs-target="#userModal" class="btn btn-warning btn-lg m-1"><i class='bx bxs-add-to-queue bx-tada-hover'></i>Add</button>

                      <button type="button" id="add_button" data-bs-toggle="modal" data-bs-target="#userModal1" class="btn btn-primary btn-lg m-1"><i class="fas fa-file-word bx-tada-hover"></i> Print Word</button>

                      <!-- Add Button to Generate Excel -->
                      <button type="button" id="generate_excel" class="btn btn-info btn-lg m-1"><i class="fas fa-file-excel bx-tada-hover"></i> Generate Excel</button>

                      <a href="Upload/index.html" class="btn btn-success btn-lg m-1"><i class="fas fa-file-excel bx-tada-hover"></i> Upload Excel</a>

                      <!--<a type="button" href="reportonline.php" class="btn btn-success btn-lg m-1"><i class='bx bxs-printer bx-tada-hover'></i>Print</a>-->
              </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="user_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Application Number</th>
                                    <th>Family Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Sex</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<div id="userModal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <form method="post" id="user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Person</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="appNo" id="appNo" placeholder="Application Number" class="form-control"/>
                                <label for="appNo">Application Number</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="firstname" id="firstname" placeholder="Firstname" class="form-control"/>
                                <label for="fname">Firstname</label>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="midname" id="midname" placeholder="Middlename" class="form-control"/>
                                <label for="midname">Middlename</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="lastname" id="lastname" placeholder="Lastname" class="form-control"/>
                                <label for="lastname">Lastname</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating mb-3 mt-3">
                                <select class="form-select" id="sex" aria-label="Default select example" name="sex">
                                <option value="">--Sex--</option>
                                <option value="MALE">MALE</option>
                                <option value="FEMALE">FEMALE</option>
                                </select>
                                <label for="sex">Sex</label>
                            </div>                   
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="strand" id="strand" placeholder="Strand" class="form-control"/>
                                <label for="strand">Strand</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="course" id="course" placeholder="Course" class="form-control"/>
                                <label for="course">Course</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="genAbility" id="genAbility" placeholder="General Ability" class="form-control"/>
                                <label for="genAbility">General Ability</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="verbal" id="verbal" placeholder="Verbal Aptitude" class="form-control"/>
                                <label for="verbal">Verbal Aptitude</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="numerical" id="numerical" placeholder="Numerical Aptitude" class="form-control"/>
                                <label for="numerical">Numerical Aptitude</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="s_patial" id="s_patial" placeholder="Spatial Aptitude" class="form-control"/>
                                <label for="s_patial">Spatial Aptitude</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="p_erceptual" id="p_erceptual" placeholder="Perceptual Aptitude" class="form-control"/>
                                <label for="p_erceptual">Perceptual Aptitude</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="m_anDexterity" id="m_anDexterity" placeholder="Manual Dexterity" class="form-control"/>
                                <label for="m_anDexterity">Manual Dexterity</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label>Date Taken</label>
                            <input type="date" name="date_taken" id="date_taken" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" id="user_id" />
                    <input type="hidden" name="operation" id="operation" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="viewModal" class="modal fade">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">View Profile</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="row">
            <div class="col-md-3">
                <div class="form-floating mb-3 mt-3">
                    <h5>Application Number</h5>
                    <p id="view_appNo"></p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-floating mb-3 mt-3">
                    <h5>First Name</h5>
                    <p id="view_firstname"></p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-floating mb-3 mt-3">
                    <h5>Midllle Name</h5>
                    <p id="view_midname"></p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-floating mb-3 mt-3">
                    <h5>Last Name</h5>
                    <p id="view_lastname"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-floating mb-3 mt-3">
                    <h5>Sex</h5>
                    <p id="view_sex"></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating mb-3 mt-3">
                    <h5>Strand</h5>
                    <p id="view_strand"></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating mb-3 mt-3">
                    <h5>Course</h5>
                    <p id="view_course"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-floating mb-3 mt-3">
                    <h5>General Ability</h5>
                    <p id="view_genAbility"></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating mb-3 mt-3">
                    <h5>Verbal Aptitude</h5>
                    <p id="view_verbal"></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating mb-3 mt-3">
                    <h5>Numerical Aptitude</h5>
                    <p id="view_numerical"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-floating mb-3 mt-3">
                    <h5>Spatial Aptitude</h5>
                    <p id="view_s_patial"></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating mb-3 mt-3">
                    <h5>Perceptual Aptitude</h5>
                    <p id="view_p_erceptual"></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating mb-3 mt-3">
                    <h5>Manual Dexterity</h5>
                    <p id="view_m_anDexterity"></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating mb-3 mt-3">
                    <h5>Date Taken</h5>
                    <p id="view_date_taken"></p>
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <div id="userModal1" class="modal fade" data-bs-backdrop="static">
        <div class="modal-dialog">
            <form action="generate/generate_word.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4> Generate Word</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div>
                                <label for="id">Select Student:</label>
                                <select class="form-control" id="id" name="id">
                                    <?php
                                        $conn = mysqli_connect("localhost", "root", "", "rohanne");

                                        if (!$conn) {
                                            die("Connection failed: " . mysqli_connect_error());
                                        }

                                        $sql = "SELECT * FROM tbl_applicants"; // Modified query to retrieve distinct strands
                                        $result = mysqli_query($conn, $sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $fname = $row['firstname'].' '.$row['midname'].' '.$row['lastname'];
                                                echo "<option value='{$row['id']}'>$fname</option>";
                                            }
                                        } else {
                                            echo "<option value='' disabled>No data available</option>";
                                        }

                                        mysqli_close($conn);
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="user_id" id="user_id" />
                        <input type="hidden" name="operation" id="operation" />
                        <button type="submit" class="btn btn-primary">Generate</button>
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<!-- Footer Start -->
    <div class="container-fluid text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s" style="background-color: #38761d;">
    </div>
    <!-- Footer End -->


    <script src="script.js"></script>

<script type="text/javascript" language="javascript" >

    $(document).ready(function() {
        $('#generate_excel').click(function() {
            window.location = 'generate/generate_excel.php';
        });
    });

    $(document).ready(function(){
        $('#add_button').click(function(){
            $('#user_form')[0].reset();
            $('.modal-title').text("Add Profile");
            $('#action').val("Add");
            $('#operation').val("Add");
        });
        
        var dataTable = $('#user_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"fetch.php",
                type:"POST"
            },
            "columnDefs":[
                {
                    "targets":[0,4],
                    "orderable":false,
                },
            ],
        });
        $(document).on('submit', '#user_form', function(event){
        event.preventDefault();
        var appNo = $('#appNo').val();
        var lastname = $('#lastname').val();
        var firstname = $('#firstname').val();
        var midname = $('#midname').val();
        var sex = $('#sex').val();
        var strand = $('#strand').val();
        var course = $('#course').val();
        var genAbility = $('#genAbility').val();
        var verbal = $('#verbal').val();
        var numerical = $('#numerical').val();
        var s_patial = $('#s_patial').val();
        var p_erceptual = $('#p_erceptual').val();
        var m_anDexterity = $('#m_anDexterity').val();
        var date_taken = $('#date_taken').val();

        if(firstname != '' && lastname != '')
        {
            $.ajax({
                url:"insert.php",
                method:'POST',
                data:$(this).serialize(), // Use serialize() to gather form data
                success:function(data)
                {
                    alert(data);
                    $('#user_form')[0].reset();
                    $('#userModal').modal('hide');
                    $('#viewModal').modal('hide');
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            alert("Both Fields are Required");
        }
    });
    
    $(document).on('click', '.update', function(){
        var user_id = $(this).attr("id");
        $.ajax({
            url:"fetch_single.php",
            method:"POST",
            data:{user_id:user_id},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');

                $('#appNo').val(data.appNo);
                $('#lastname').val(data.lastname);
                $('#firstname').val(data.firstname);
                $('#midname').val(data.midname);
                $('#sex').val(data.sex);
                $('#strand').val(data.strand);
                $('#course').val(data.course);
                $('#genAbility').val(data.genAbility);
                $('#verbal').val(data.verbal);
                $('#numerical').val(data.numerical);
                $('#s_patial').val(data.s_patial);
                $('#p_erceptual').val(data.p_erceptual);
                $('#m_anDexterity').val(data.m_anDexterity);
                $('#date_taken').val(data.date_taken);

                $('.modal-title').text("Edit Profile");
                $('#user_id').val(user_id);
                $('#action').val("Edit");
                $('#operation').val("Edit");
            }
        })
    });

    $(document).on('click', '.view', function(){
      var user_id = $(this).attr("id");
      $.ajax({
        url: "fetch_single.php",
        method: "POST",
        data: { user_id: user_id },
        dataType: "json",
        success: function(data) {
          $('#viewModal').modal('show');
          $('.modal-title').text("View Profile");

          $('#view_appNo').text(data.appNo);
          $('#view_lastname').text(data.lastname);
          $('#view_firstname').text(data.firstname);
          $('#view_midname').text(data.midname);
          $('#view_sex').text(data.sex);
          $('#view_strand').text(data.strand);
          $('#view_course').text(data.course);
          $('#view_genAbility').text(data.genAbility);
          $('#view_verbal').text(data.verbal);
          $('#view_numerical').text(data.numerical);
          $('#view_s_patial').text(data.s_patial);
          $('#view_p_erceptual').text(data.p_erceptual);
          $('#view_m_anDexterity').text(data.m_anDexterity);
          $('#view_date_taken').text(data.date_taken);

        }
      });
    });

    
    $(document).on('click', '.delete', function(){
        var user_id = $(this).attr("id");
        if(confirm("Are you sure you want to delete this?"))
        {
            $.ajax({
                url:"delete.php",
                method:"POST",
                data:{user_id:user_id},
                success:function(data)
                {
                    alert(data);
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;   
        }
    });
});

</script>