<?php 
require('config.php');
require_once('functions.php');

$message['phone'] = $_POST['phone'];
$message['code'] = $_POST['code'];
$message['content'] = $_POST['content'];
$message['type'] = $_POST['type'];

if ($message['type'] == 'panel_credites'){
    $result = panel_credites($settings);    
} else if ($message['type'] == 'sms'){
    $result = sending_message($settings, $message);    
} else if ($message['type'] == 'setting'){    
    $mysql = mysql_query(
                "UPDATE settings SET                 
                code1='$_POST[code_sms_one]',                
                code2='$_POST[code_sms_two]',
                panel_username = '$_POST[panel_username]',
                panel_password = '$_POST[panel_password]',
                panel_line_number = '$_POST[panel_line_number]'
                WHERE id = 1"
            ) or die (mysql_error());
    $result['value'] = 'اطلاعات با موفقیت بروز رسانی شد';
    $result['status'] = 'success';
    $result = json_encode($result);                 
}else if ($message['type'] == 'update_template'){    
    $mysql = mysql_query(
                "UPDATE templates SET                
                content='$_POST[content]', 
                title='$_POST[title]'
                WHERE code = '$_POST[code]'"
            ) or die (mysql_error());    
    $result['status'] = 'success';
    $result = json_encode($result);                 
}else if ($message['type'] == 'save_template'){    
    $mysql = mysql_query(
                "INSERT INTO templates                
                ( code , title, content ) VALUES
                ('$_POST[code]','$_POST[title]','$_POST[content]')"
            ) or die (mysql_error());    
    $result['status'] = 'success';
    $result = json_encode($result);                 
}else{
    $result['value'] = 'دستور ناشناخته است';
    $result['status'] = 'failed';
    $result = json_encode($result);
}
echo $result;

?>