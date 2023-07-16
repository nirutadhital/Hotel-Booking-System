<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'inc/links.php' ?>
    <title><?php echo $settings_r['site_title'] ?>-CONFIRM BOOKING</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AWMKHb5r3AwEJiXpL4Grm476qP1PBvKyjy9LqjkrCL4Hl4n8e1rNxbzF4Gs5afzwjVIW9wB9EgnsppTK&currency=USD"></script>
</head>
<body class="bg-light" >

  <?php require 'inc/header.php'  ?>

  <?php

    /*
    check room id from url is present or not
    shut down is active or not
    user is logged in or not
    */
  if(!isset($_GET['id']) || $settings_r['shutdown']==true) {
    redirect('rooms.php');
  }
  else if(!(isset($_SESSION['login']) && $_SESSION['login']==true)) {
    redirect('rooms.php');
  }

  //filter and get room and user data
  $data = filteration($_GET);
  $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?" , [$data['id'],1,0],'iii');
  if(mysqli_num_rows($room_res)==0){
    redirect('rooms.php');
  }
  $room_data = mysqli_fetch_assoc($room_res);

  $_SESSION['room']=[
    "id" => $room_data['id'],
    "name" => $room_data['name'],
    "price" => $room_data['price'],
    "payment" => null,
    "available" => false,
  ];
 

  $user_res = select("SELECT * FROM `user_cred` WHERE `id`=?  LIMIT 1", [$_SESSION['uId']], "i");
  $user_data= mysqli_fetch_assoc($user_res);

  ?>

    

    <div class="container">
        <div class="row">
        <div class=" col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold">CONFIRM BOOKING</h2>
            <!-- breadcrums -->
            <div style="font-size: 14px;" >
            <a href="index.php" class="text-secondary text-decoration-none" >HOME</a>
            <span class="text-secondary" > > </span>
            <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
            <span class="text-secondary" > > </span>
            <a href="#" class="text-secondary text-decoration-none">CONFIRM</a>
            </div>
        </div>
        <div class="col-lg-7 col-md-12 px-4">
            <?php
            //get thumbnail of image
            $room_thumb = ROOMS_IMG_PATH."hbs_thumbnail.png";
            $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");

            if(mysqli_num_rows($thumb_q)>0) {
                $thumb_res = mysqli_fetch_assoc($thumb_q);
                $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
            }


            echo<<<data
                <div class="card p-3 shadow-sm rounded">
                    <img src="$room_thumb" class="img-fluid rounded-start mb-3" alt="...">
                    <h5>$room_data[name]</h5>
                    <h6>रु $room_data[price] per Night</h6>

                </div>


            data;




            ?>

        </div>


        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <form action="pay_now.php" id="booking_form" >
                        <h6 class="mb-3">BOOKING DETAILS</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label  class="form-label">Name</label>
                                <input type="text" name="name" value="<?php  echo $user_data['name']?>" class="form-control shadow-none" required readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label  class="form-label">Phone Number</label>
                                <input type="number" name="phonenum" value="<?php  echo $user_data['phonenum']?>"class="form-control shadow-none" required readonly>
                            </div>
                            <div class="col-md-12 p-0 mb-3">
                                <label  class="form-label">Address</label>
                                <textarea name="address" class="form-control shadow-none"  rows="1" required readonly><?php  echo $user_data['address']?></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label  class="form-label ">Check-in </label>
                                <input type="date" name="checkin" onchange="check_availability()" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label  class="form-label">Check-out </label>
                                <input type="date" name="checkout" onchange="check_availability()" class="form-control shadow-none" required>
                            </div>
                            <div class="col-12">
                            <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h6 class="mb-3 text-danger" id="pay_info">Provide Check-in and Check-out Date !</h6>
                            <button  name="pay_now" class="btn w-100 text-white  shadow-none mb-1" disabled>Pay Now
                            <div id="paypal-button-container" ></div>
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>
    <!-- footer -->
<?php require 'inc/footer.php'; ?>


<script>
    let booking_form =document.getElementById('booking_form');
    let info_loader =document.getElementById('info_loader');
    let pay_info =document.getElementById('pay_info');

    function check_availability()
    {
        let checkin_val=booking_form.elements['checkin'].value;
        let checkout_val=booking_form.elements['checkout'].value;
        booking_form.elements['pay_now'].setAttribute('disabled',true);

        if(checkin_val!='' && checkout_val!='')
        {
            pay_info.classList.add('d-none');
            pay_info.classList.replace('text-dark','text-danger');
            info_loader.classList.remove('d-none');


            let data= new FormData();
            data.append('check_availability','');
            data.append('check_in', checkin_val);
            data.append('check_out', checkout_val);

            let xhr=new XMLHttpRequest();
            xhr.open("POST","ajax/confirm_booking.php", true);
            xhr.onload=function() { 
                let data= JSON.parse(this.responseText);
                if(data.status== 'check_in_out_equal'){
                    pay_info.innerText= "You Cannot check-out on the same day !";
                } else if(data.status=='check_out_earlier') {
                    pay_info.innerText= "check-out date is earlier than check-in date!";
                }else if(data.status=='check_in_earlier') {
                    pay_info.innerText= "check-in date is earlier than today's date!";
                }else if(data.status=='unavailable') {
                    pay_info.innerText= "Room is not Available for this check-in date !";
                } else {
                    pay_info.innerHTML="NO. of Days:" + data.days + "<br>Total Amount to Pay: रु" + data.payment;
                    pay_info.classList.replace('text-danger', 'text-dark');
                    booking_form.elements['pay_now'].removeAttribute('disabled');
                }
                pay_info.classList.remove('d-none');
                info_loader.classList.add('d-none');
            }
            xhr.send(data);   

        }
    }


    

  
    
    paypal.Buttons({
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
                value: '10.0',
                currency_code: 'USD' // Change the currency code if necessary
            }
          }]
        });
      },
      onApprove: function(data, actions) {
    return actions.order.capture().then(function(orderData) {
    const transaction=orderData.purchase_units[0].payments.captures[0];
    // alert('Transaction completed by ' + details.payer.name.given_name + '!');

    // $.ajax({
    //     method:"POST",
    //     url:"url",
    //     data:"data",
    //     dataType:"dataType",
    //     success:function(response) {

    //     }
    // })

    // Make an AJAX call to your PHP backend to handle the payment completion
    // Example: $.post('handle_payment.php', { orderID: data.orderID, payerID: data.payerID })
    // var orderID = data.orderID;
    // var payerID = data.payerID;
    // var formData = new FormData();
    // formData.append('orderID', orderID);
    // formData.append('payerID', payerID);

    // var xhr = new XMLHttpRequest();
    // xhr.open("POST", "pay_now.php", true);
    // xhr.onload = function() {
    //   if (xhr.status === 200) {
    //     console.log(xhr.responseText);
    //     // Handle the response from the server
    //   } else {
    //     console.error('Error:', xhr.status);
    //     // Handle any errors
    //   }
    // };
    // xhr.onerror = function() {
    //   console.error('Request failed');
    //   // Handle any errors
    // };
    // xhr.send(formData);
  });
}
}).render('#paypal-button-container');
</script>
</body>
</html>