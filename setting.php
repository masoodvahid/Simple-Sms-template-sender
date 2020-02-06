<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>تنظیمات پنل پیامک</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="img/favicon.jpg">
  <script src="js/jquery.min.js"></script>
  <!-- <script src="js/vuex.js"></script> -->
  
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <div class="aligner">
<?php require_once('library/config.php');
    $mysql = mysql_query("SELECT * FROM settings ") or die (mysql_error());
	$result = mysql_fetch_assoc($mysql);
    // var_dump($result);  // For Debuging
?>
      <form class="message" style="text-align: right" id="message">
        <div class="message-header">
          <h1 class="message-title">
            تنظیمات پنل پیامک            
          </h1>
        </div>      
        <p>
            <input type="hidden" name="type" value="setting">             
            <div>
                <div class='title'>شروع کد باکس سری اول</div>
                <input name="code_sms_one" type="text" class="message-input message-setting" placeholder="801" value="<?php echo $result['code1'] ?>">
            </div>        
            <div>
                <div class='title'>شروع کد باکس سری دوم</div>
                <input name="code_sms_two" type="text" class="message-input message-setting" placeholder="901" value="<?php echo $result['code2'] ?>">
            </div>     
            <div>
                <div class='title'>سامانه پیامک</div>
                <select class="message-input message-setting">
                    <option value='farazsms' selected>فراز اسمس</option>
                </select>                
            </div>                        
            <div>
                <div class='title'>نام کاربری</div>
                <input type="text" name="panel_username" class="message-input message-setting" value="<?php echo $result['panel_username'] ?>">
            </div>
            <div>
                <div class='title'>رمز عبور</div>
                <input type="password" name="panel_password" class="message-input message-setting" value="<?php echo $result['panel_password'] ?>">
            </div>  
            <div>
                <div class='title'>شماره ارسال پیامک</div>
                <input type="text" name="panel_line_number" class="message-input message-setting" value="<?php echo $result['panel_line_number'] ?>">
            </div>           
        </p> 
        <span class='error'></span>
        <p>
          <input type="submit" value="ذخیره" class="save-btn first-button-color" style="margin-top: 10px;">
        </p>
      </form>
    <div class="about">
        <p class="about-links">
            <a href="index.php">صفحه اصلی</a>  
            <a href="template.php">قالب‌ها</a>              
        </p>         
    </div>    
</div>
<script type = "text/javascript">
  $(document).ready(function() {
    $(".save-btn").on("click", function(){
      event.preventDefault();
      console.log();

      // console.log($("input:empty").length); 
      if (
          $("input").filter(function () {
            return $.trim($(this).val()).length == 0
          }).length != 0 
        ){
            alert ('تکمیل تمامی فیلدها الزامی است');
      }else{        
        $.ajax({
            url: "library/process.php",
            method: "POST",
            dataType: 'json',
            data: $(this.form).serialize(),
            beforeSend: function() { 
              $('.save-btn').val('در حال ارسال...');         
            },
            success: function(response) {
              if(response.status == 'success'){
                $(".save-btn").addClass("success").removeClass("warning");
                $(".save-btn").val('ثبت شد.');
              }else{
                $(".error").text(response.value);
                $(".save-btn").val('ارسال ناموفق');
                $(".save-btn").addClass("warning");              
              }
            },
            error: function() {
              $(".save-btn").addClass("warning");
              $(".save-btn").val('در ارسال خطایی رخ داد');
            },
        }) 
      }         
    });    
  });
</script>

</body>
</html>
