<?php

if (getenv('TYPEFORM_FORM_ID')) {
    $tp_form_id = getenv('TYPEFORM_FORM_ID');
} else {
  $tp_form_id ='a96bhF';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connecting</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://c4wstatic.cloud4wi.com/css/bootstrap/bootstrap.min.css">

    <script>
        console.log('<?php echo $fb_pixel_id ?>');
    </script>

    <style type="text/css">

    body {
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    h1 {
      font-size: 50px;
      text-align: center;
    }

    .container {
      margin: 0 auto;
      width: 100%;
      position: absolute;
      top:0px;
      bottom:0px;
      left:0px;
      right:0px;
    }

    </style>

</head>
<body>

  <div class="container">
    <!-- This is the DOM element that will contain your embedded typeform -->
    <div id="my-embedded-typeform"
         style="width: 100%; height: 100%;"></div>
  </div>


  <script src="https://splashportal.cloud4wi.com/myapps/v1/myapps-sdk.js"></script>
  <!-- jQuery -->
  <script src="https://splashportal.cloud4wi.com/js/jquery.min.js"></script>
  <script src="https://embed.typeform.com/embed.js" type="text/javascript"></script>

  <script>

    var firstname = customerid = lastname = email = gender = phone = storename = marketing = null;
    var printSession = function(sessionData) {

      let str = JSON.stringify(sessionData, null, 4);
      console.log("session data ="+str);

      if(sessionData.data.customer.first_name !== "" && sessionData.data.customer.first_name !== null ) {
        firstname = sessionData.data.customer.first_name.toLowerCase();
        console.log('FirstName:'+firstname);
      }
      if(sessionData.data.customer.id !== "" && sessionData.data.customer.id !== null ) {
        customerid = sessionData.data.customer.id;
        console.log('CustomerId:'+customerid);
      }
      if(sessionData.data.customer.last_name !== "" && sessionData.data.customer.last_name !== null ) {
        lastname = sessionData.data.customer.last_name.toLowerCase();
        console.log('Laste Name:'+lastname);
      }
      if(sessionData.data.customer.email !== "" && sessionData.data.customer.email !== null ) {
        email = sessionData.data.customer.email.toLowerCase();
        console.log('Email:'+email);
      }
      if(sessionData.data.customer.gender !== "" && sessionData.data.customer.gender !== null ) {
        gender = sessionData.data.customer.gender.toLowerCase();
        console.log('gender:'+gender);
      }
      if(sessionData.data.customer.phone !== "" && sessionData.data.customer.phone !== null ) {
        phone = sessionData.data.customer.phone;
        console.log('phone:'+phone);
      }
      if(sessionData.data.wifiarea.name !== "" && sessionData.data.wifiarea.name !== null ) {
        storename = sessionData.data.wifiarea.name.toLowerCase();
        console.log('storename:'+storename);
      }
      if(sessionData.data.customer.mktgCommunications !== "" && sessionData.data.customer.mktgCommunications !== null ) {
        marketing = sessionData.data.customer.mktgCommunications;
        console.log('Marketing Opt-in:'+marketing);
      }

      var surveyid='<?php echo $tp_form_id ?>';
      var surveyurl="https://cloud4wi.typeform.com/to/"+surveyid+"?email="+email+"&customer_id="+customerid+"&phone="+phone+"&marketing="+marketing+"&gender="+gender;
      console.log(surveyurl);

      var el = document.getElementById("my-embedded-typeform");

      // When instantiating a widget embed, you must provide the DOM element
      // that will contain your typeform, the URL of your typeform, and your
      // desired embed settings
      window.typeformEmbed.makeWidget(el, surveyurl, {
        hideFooter: true,
        hideHeaders: true,
        onSubmit: function () {
          MYAPPS.goNext();
        }
      });

    }

  MYAPPS.session(printSession);

  </script>


</body>
</html>
