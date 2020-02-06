<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>ارسال پیامک</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="img/favicon.jpg">
  <script src="js/jquery.min.js"></script>
  <!-- <script src="js/vuex.js"></script> -->
  
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <div class="aligner">
  <?php
  require_once('library/config.php');
    for ($i=0;$i+1<=$box_numbers;$i++){ 
      $mysql = mysql_query("SELECT * FROM templates WHERE CODE = ($settings[code1]+$i)") or die (mysql_error());  
      $template = mysql_fetch_assoc($mysql);         
      ?>
      <form class="message" id="message_<?php echo $i ?>">
        <div class="message-header">
          <h1 class="message-title">
            <?php echo $template['title'] ?>
            <span class="message-number"><?php echo $template['code'] ?></span>
          </h1>
        </div>
        <P>
        <input name="phone" type="text" class="message-input message-name phone" placeholder="شماره موبایل" autofocus required>
          <input type="text" class="message-input message-exp receipte" placeholder="رسید" value="" disabled>      
        </P>       
        <p>
          <textarea name="content" class="message-input message-card content" rows="4" placeholder="متن پیام" required><?php echo @$template['content'] ?></textarea>       
        </p>
        <span class='error'></span>
        <p>
          <input type="hidden" name="type" value="sms">
          <input type="submit" value="ارسال" id="button_<?php echo $i ?>"class="message-btn first-button-color">
        </p>
      </form>
    <?php
    }
    echo "<br>";
    for ($i=0;$i+1<=$retry_box_numbers;$i++){
      $mysql = mysql_query("SELECT * FROM templates WHERE CODE = ($settings[code2]+$i)") or die (mysql_error());  
      $template = mysql_fetch_assoc($mysql);    
      ?>
      <form class="message border-second-color" id="message_<?php echo $i ?>">
        <div class="message-header">
          <h1 class="message-title second-background-color">
            <?php echo $template['title'] ?>
            <span class="message-number second-counter-color"><?php echo @$template['code'] ?></span>
          </h1>
        </div>
        <p>
          <input name="phone" type="text" class="message-input message-name phone" placeholder="شماره موبایل" autofocus required>
            <input type="text" class="message-input message-exp receipte" placeholder="رسید" value="" disabled>      
        </P>        
        <p>
          <textarea name="content" class="message-input message-card content" rows="4" placeholder="متن پیام" required><?php echo @$template['content'] ?></textarea>       
        </p>
        <span class='error'></span>
        <p>
          <input type="hidden" name="type" value="sms">
          <input type="submit" value="ارسال" id="button_<?php echo $i ?>"class="message-btn second-button-color">
        </p>
      </form>
    <?php
    }
    ?>
  <div class="about">
    <p class="about-links">
      <a href="setting.php" id="">تنظیمات</a> 
      <a href="#" id="panel_credites_btn">اعتبار پنل(ریال)</a>
    </p> 
    <p class="about-links" id="panel_credites_result">           
    </p>  
  </div>
</div>
<script type = "text/javascript" language = "javascript">
  $(document).ready(function() {
    
    $(".message-btn").on("click", function(){
      event.preventDefault();
      $(this).closest('.message').find('.message').text(); 
      if ( 
        $(this).closest('.message').find('.phone').val() == '' ||        
        $(this).closest('.message').find('.content').val() == '')
      {
        alert ('تکمیل تمامی فیلدها الزامی است');
      }else{
        var elm = this;      
        $.ajax({
            url: "library/process.php",
            method: "POST",
            dataType: 'json',
            data: $(this.form).serialize(),
            beforeSend: function() { 
              $(elm).val('در حال ارسال...');         
            },
            success: function(response) {
              if(response.status == 'success'){
                $(elm).closest('.message').find(".message-number, .message-btn").removeClass("warning").addClass("success");
                $(elm).val('ارسال شد').prop('disabled', true);
                $(elm).closest('.message').find('.receipte').val(response.value)
              }else{
                $(elm).closest('.message').find(".error").text(response.value);
                $(elm).val('ارسال ناموفق');
                $(elm).closest('.message').find(".message-number, .message-btn").addClass("warning");              
              }
            },
            error: function() {
              $(elm).closest('.message').find(".message-number, .message-btn").addClass("warning");
              $(elm).val('در ارسال خطایی رخ داد');
            },
        }) 
      }         
    });



    $("#panel_credites_btn").on("click", function(){
      event.preventDefault();        
        $.ajax({
            url: "library/process.php",
            method: "POST",
            dataType: 'json',
            data: { type : 'panel_credites'},
            beforeSend: function() { 
              $("#panel_credites_result").html('در حال دریافت...');         
            },
            success: function(response) {              
              $("#panel_credites_result").text(response.value);
            },
            error: function (request, status, error) {
              $("#panel_credites_result").text(request.responseText);
            }
            // error: function() {              
            //   $("#panel_credites_result").text('خطایی رخ داد');
            // }
        }) 
      }) 
  });
</script>

</body>
</html>
