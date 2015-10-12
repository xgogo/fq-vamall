<?php
/**
 * 邮件发送函数
 * @param string to      要发送的邮箱地址
 * @param string subject 邮件标题
 * @param string content 邮件内容
 * @return array
 */
function WSTSendMail($to, $subject, $content) {
	require_cache(VENDOR_PATH."PHPMailer/class.smtp.php");
    require_cache(VENDOR_PATH."PHPMailer/class.phpmailer.php");
    $mail = new PHPMailer();
    // 装配邮件服务器
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = $GLOBALS['CONFIG']['mailSmtp'];
    $mail->SMTPAuth = $GLOBALS['CONFIG']['mailAuth'];
    $mail->Username = $GLOBALS['CONFIG']['mailUserName'];
    $mail->Password = $GLOBALS['CONFIG']['mailPassword'];
    $mail->CharSet = 'utf-8';
    // 装配邮件头信息
    $mail->From = $GLOBALS['CONFIG']['mailUserName'];
    $mail->AddAddress($to);
    $mail->FromName = $GLOBALS['CONFIG']['mailSendTitle'];
    $mail->IsHTML(true);
    // 装配邮件正文信息
    $mail->Subject = $subject;
    $mail->Body = $content;
    // 发送邮件
    $rs =array();
    if (!$mail->Send()) {
    	$rs['status'] = 0;
    	$rs['msg'] = $mail->ErrorInfo;
        return $rs;
    } else {
    	$rs['status'] = 1;
        return $rs;
    }
}
/**
 * 发送短信
 * 此接口要根据不同的短信服务商去写，这里只是一个参考
 * @param string $phoneNumer  手机号码
 * @param string $content     短信内容
 */
function WSTSendSMS($phoneNumer,$content){
	$url = '短信接口';
	$ch=curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置否输出到页面
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30 ); //设置连接等待时间
    curl_setopt($ch, CURLOPT_ENCODING, "gzip" );
    $data=curl_exec($ch);
    curl_close($ch);
    return "$data";
}
/**
 * 字符串替换
 * @param string $str     要替换的字符串
 * @param string $repStr  即将被替换的字符串
 * @param int $start      要替换的起始位置,从0开始
 * @param string $splilt  遇到这个指定的字符串就停止替换
 */
function WSTStrReplace($str,$repStr,$start,$splilt = ''){
	$newStr = substr($str,0,$start);
	$breakNum = -1;
	for ($i=$start;$i<strlen($str);$i++){
		$char = substr($str,$i,1);
		if($char==$splilt){
			$breakNum = $i;
			break;
		}
		$newStr.=$repStr;
	}
	if($splilt!='' && $breakNum>-1){
		for ($i=$breakNum;$i<strlen($str);$i++){
			$char = substr($str,$i,1);
			$newStr.=$char;
		}
	}
	return $newStr;
}
/**
 * 循环删除指定目录下的文件及文件夹
 * @param string $dirpath 文件夹路径
 */
function WSTDelDir($dirpath){
	$dh=opendir($dirpath);
	while (($file=readdir($dh))!==false) {
		if($file!="." && $file!="..") {
		    $fullpath=$dirpath."/".$file;
		    if(!is_dir($fullpath)) {
		        unlink($fullpath);
		    } else {
		        WSTDelDir($fullpath);
		        rmdir($fullpath);
		    }
	    }
	}	 
	closedir($dh);
    $isEmpty = 1;
	$dh=opendir($dirpath);
	while (($file=readdir($dh))!== false) {
		if($file!="." && $file!="..") {
			$isEmpty = 0;
			break;
		}
	}
	return $isEmpty;
}
/**
 * 获取网站域名
 */
function WSTDomain(){
	$server = $_SERVER['HTTP_HOST'];
	$http = is_ssl()?'https://':'http://';
	return $http.$server.__ROOT__;
}
/**
 * 获取网站根域名
 */
function WSTRootDomain(){
	$server = $_SERVER['HTTP_HOST'];
	$http = is_ssl()?'https://':'http://';
	return $http.$server;
}
/**
 * 设置当前页面对象
 * @param int 0-用户  1-商家
 */
function WSTLoginTarget($target = 0){
	$WST_USER = session('WST_USER');
	$WST_USER['loginTarget'] = $target;
	session('WST_USER',$WST_USER);
}

/**
 * 生成缓存文件
 */
function WSTDataFile($name, $path = '',$data=array()){
	$key = C('DATA_CACHE_KEY');
	$name = md5($key.$name);
	if(is_array($data) && !empty($data)){
		if($data['mallLicense']==''){
			if(stripos($data['mallTitle'],'Powered By WSTMall')===false)$data['mallTitle'] = $data['mallTitle']." - Powered By WSTMall";
		}
		$configStr="<?php \n return array(\n";
	    foreach($data as $key=>$v){
	        $configStr.="\t'".$key."'=>'".$v."',\n";
	    }
	    $configStr.=");\n?>\n";
	    if(DATA_PATH.$path)mkdir(DATA_PATH.$path,0777,true);
	    file_put_contents(DATA_PATH.$path.$name.".php",$configStr);
	    clearstatcache();
	}else if(is_null($data)){
	    unlink(DATA_PATH.$path.$name.".php");
	}else{
		if(file_exists(DATA_PATH.$path.$name.'.php')){
			return include DATA_PATH.$path.$name.'.php';
		}else{
		    return null;
		}
	}
}