<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>قالب پیامک‌ها</title>
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
  
  $code1 = $settings['code1'];
  $code2 = $settings['code2'];

    for ($i=0;$i+1<=$box_numbers;$i++){
      $mysql = mysql_query("SELECT * FROM templates WHERE CODE = ($code1+$i)") or die (mysql_error());  
      $template = mysql_fetch_assoc($mysql);      
      ?>
      <form class="message" id="message_<?php echo $i ?>">
        <div class="message-header">
          <h1 class="message-title">
            پیامک سری اول <span class="charachters"></span>
            <span class="message-number"><?php echo $i+1 ?></span>
          </h1>
        </div>
        <p>
          <input type="hidden" name="type" value="template">          
          <input name="title" type="text" class="message-input message-name title" placeholder="قالب پیامک  <?php echo $i+1 ?>" value="<?php echo @$template['title'] ?>" required>
          <input name="code" type="text" class="message-input message-exp code" placeholder="<?php echo $settings['code1'] + $i ?>" value="<?php echo $settings['code1'] + $i ?>" required readonly>      
        </p>
        <p>
          <textarea name="content" class="message-input message-card content" rows="4" placeholder="متن پیام" required><?php echo @$template['content'] ?></textarea>       
        </p>
        <span class='error'></span>
        <p>
          <?php 
            if ($template){
              echo '<input type="hidden" name="type" value="update_template">';
              echo "<input type='submit' value='بروز رسانی' id='button_".$i."' class='message-btn first-button-color'>";
            }else{
              echo '<input type="hidden" name="type" value="save_template">';
              echo "<input type='submit' value='ذخیره' id='button_".$i."' class='message-btn first-button-color'>";
            }
          ?>
        </p>
      </form>
    <?php
    }
    echo "<br>";
    for ($i=0;$i+1<=$retry_box_numbers;$i++){
      $mysql = mysql_query("SELECT * FROM templates WHERE CODE = ($code2+$i)") or die (mysql_error());  
      $template = mysql_fetch_assoc($mysql);  
      ?>
      <form class="message border-second-color" id="message_<?php echo $i ?>">
        <div class="message-header">
          <h1 class="message-title second-background-color">
            پیامک سری دوم
            <span class="message-number second-counter-color"><?php echo $i+1 ?></span>
          </h1>
        </div>
        <p>                   
          <input name="title" type="text" class="message-input message-name title" placeholder="قالب پیامک  <?php echo $i+1 ?>" value="<?php echo @$template['title'] ?>" required>
          <input name="code" type="text" class="message-input message-exp code" placeholder="<?php echo $settings['code2'] + $i ?>" value="<?php echo $settings['code2'] + $i ?>" required readonly>      
        </p>
        <p>
          <textarea name="content" class="message-input message-card content" rows="4" placeholder="متن پیام" required><?php echo @$template['content'] ?></textarea>            
        </p>
        <span class='error'></span>
        <p>
        <?php 
            if ($template){
              echo '<input type="hidden" name="type" value="update_template">';
              echo "<input type='submit' value='بروز رسانی' id='button_".$i."' class='message-btn second-button-color'>";
            }else{
              echo '<input type="hidden" name="type" value="save_template">';
              echo "<input type='submit' value='ذخیره' id='button_".$i."' class='message-btn second-button-color'>";
            }
          ?>
        </p>
      </form>
    <?php
    }
    ?>
  <div class="about">
    <p class="about-links">
      <a href="index.php">صفحه اصلی</a>
      <a href="setting.php">تنظیمات</a> 
    </p>       
  </div>
</div>
<script type = "text/javascript" language = "javascript">
  $(document).ready(function() {
    
    $('.content').keyup(function () { 
        var len = $(this).closest('.message').find('.content').val().length;           
        var sms = parseInt(len / 60);    
        $(this).closest('.message').find('.charachters').text( ' | ' + len + 'کاراکتر (' + ++sms + ' پیامک)');    
    });
        

    $(".message-btn").on("click", function(){
      event.preventDefault();
      $(this).closest('.message').find('.message').text(); 
      if ( 
        $(this).closest('.message').find('.title').val() == '' || 
        $(this).closest('.message').find('.code').val() == '' ||
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
                $(elm).val('ثبت شد');
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
  });
</script>

</body>
</html>
