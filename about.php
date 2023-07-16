<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'inc/links.php' ?>
    <title><?php echo $settings_r['site_title'] ?>-ABOUT</title>


<!-- swiperjs -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
<style>
    .box {
        border-top-color: var(--teal) !important;
    }
</style>
</head>
<body class="bg-light" >

  <?php require 'inc/header.php'  ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">ABOUT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus, excepturi?<br>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex, accusantium!
        </p>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
              <h3>Lorem ipsum possimus.</h3>
              <p>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                 Vero voluptates illo quae sunt natus? Corrupti incidunt facere optio amet suscipit.
              </p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-1 order-1">
            <img src="images/abouts/1.jpg"class="w-100">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/abouts/hotel.svg"  width="70px">
                        <h4 class="mt-3">100+ ROOMS</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/abouts/customers.png"  width="70px">
                        <h4 class="mt-3">100+ CUSTOMERS</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/abouts/rating.png"  width="70px">
                        <h4 class="mt-3">100+ REVIEWS</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/abouts/staff.png"  width="70px">
                        <h4 class="mt-3">100+ STAFFS</h4>
                </div>
            </div>
        </div>
    </div>

    <h3 class="my-5 fw-bold h-font text-center">MANAGEMENT TEAM</h3>
    <div class="container px-4">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">
                <?php
                $about_r = selectAll('team_details');
                $path=ABOUT_IMG_PATH;  //constant lai directly hero doc vitra lekhyo vane string ko rup ma linxa tesaile ABOUT_IMG_PATH lai euta variable ma rakhera use garni
                while($row = mysqli_fetch_assoc($about_r)) {
                    echo<<<data
                        <div class="swiper-slide bg-white text-center overflow-hidden rounded ">
                            <IMG src="$path$row[picture]" class="w-100" > 
                            <h5 class="mt-2" >$row[name]</h5>
                        </div>
                    data;
                }

                ?>
            
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!-- footer -->
    <?php require 'inc/footer.php'; ?>

     <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        spaceBetween:40,
        pagination: {
        el: ".swiper-pagination",
        },
        breakpoints: {
        320: {
            slidesPerView:1,
        },
        640: {
            slidesPerView:1,
        },
        768: {
            slidesPerView:3,
        },
        1024: {
            slidesPerView:3,
        },
      }
    });
</script>

</body>
</html>