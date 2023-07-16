<?php
require 'inc/essentials.php';
adminLogin();
session_regenerate_id(true);  //to secure from session hijacking(harek choti refresh garda naya session id banauxa)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel-Carousel</title>
    <?php require 'inc/links.php'; ?>
</head>
<body class="bg-light">
        <?php require 'inc/header.php';   ?>

        <div class="container-fluid" id="main-content" >
            <div class="row">
                <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                    <h3>CAROUSEL</h3>

                      <!-- CAROUSEL SECTION -->
                      <div class="card border-0 shadow mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="card-title m-0" >Images</h5>
                                <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#carousel-s">
                                <i class="bi bi-file-plus"></i> Add
                                </button>
                            </div>

                            <div class="row" id="carousel-data">
                                <!-- <div class="col-md-2 mb-3">
                                <div class="card text-bg-dark">
                                    <img src="../images/abouts/tm1.jpg" class="card-img">
                                    <div class="card-img-overlay text-end">
                                        <button type="button" class="btn btn-danger btn-sm shadow-none" >
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                    </div>
                                    <p class="card-text text-center px-3 py-2 "><small>Random Name</small></p>
                                    </div>
                                </div> -->
                            </div>

                        </div>
                    </div>
                    <!--Carousel  modal -->
                    <div class="modal fade" id="carousel-s" tabindex="-1" data-bs-keyboard="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form  id="carousel_s_form" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Image</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label  class="form-label fw-bold">Picture</label>
                                        <input type="file" name="carousel_picture" id="carousel_picture_inp" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" onclick="carousel_picture.value='' "  data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>




<?php require 'inc/scripts.php'; ?>  
<!-- ajax -->
<script src="scripts/carousel.js"></script>
</body>
</html>