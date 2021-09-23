<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>VAS TALLY MAKER</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" />

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <script src="js/all.min.js" crossorigin="anonymous"></script>

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">卌 VTMv1.0</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><h4>≡</h4></button>

            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <input style="display: none;" type="file" name="file_upload" id="file_upload" class="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" multiple>
            </form>

            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link active" href="index.php">
                                <div class="sb-nav-link-icon">📁 VAS-LIST UPLOADER</div>
                            </a>
                            <a class="nav-link" href="uploaded.php">
                                <div class="sb-nav-link-icon">📊 UPLOADED VAS</div>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">卌 VAS TALLY MAKER v1.0</h1>
                        <hr>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">📝 Number of Tally Sheets created</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <p class="text-white stretched-link" id="num_tally_sheet"><img src="load.gif" height="25" width="25"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">👩‍👧‍👧 Number of Vaccinees uploaded</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <p class="text-white stretched-link" id="num_vaccinees"><img src="load.gif" height="25" width="25"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                🏢
                                <span id="hf_name">Health Facility Name</span>
                                <span style="float: right;">
                                    <button class="btn btn-default" data-toggle="modal" data-target="#modal_upload">➕ Add Data</button>
                                </span>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td id="loader_shit">No data. 😔</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="modal_upload" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-plus"></i> Add Data</h4>
                              </div>
                              <div class="modal-body">
                                <div>Create a tally sheet for&nbsp;&nbsp;<input id="tally_facility" type="text" onblur="validate_()" placeholder="(Facility Name)">.</div>
                                <br>
                                <div>Upload VAS Files (.xlsx) <span id="u_tf"></span>:&nbsp;&nbsp;<button class="btn btn-default btn-xs" id="upload_files" onclick="upload_data();" disabled=""><i class="fa fa-upload"></i></button>
                                <br>
                                <br>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-danger close" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
        <script src="js/scripts.js"></script>
        <script type="text/javascript">
            load_numbers();
        </script>
    </body>
</html>
