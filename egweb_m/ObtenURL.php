<?php 
function curPageURL() {
 $pageURL = 'http';
 //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}//no aplica por el momento
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

//Esta funcion genera el API KEY dependiendo la URL por la cual el usuario ha entrado
function GetKey()
{
	$resultado = curPageURL();

	if( strpos($resultado,"www.sepromex.com.mx") > 0 ) //Entraron por Sepromex.com.mx
		echo "<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;false=true&amp;key=ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RS6tFE1rR0LV4ryqT8iCO2IKV5WVRRuggmx9p6HiLmoeJulFgJrVKX6IQ\" type=\"text/javascript\"></script>";
	else if ( strpos($resultado,"egweb.seprosat.mx") > 0 ) //Entraron por Egweb.seprosat.MX
		echo "<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RR0aDMuaRqYj2Z6f2o1nHwVv9XrYxTQjD25Jb_61omuLoMIvaI58zu63Q\" type=\"text/javascript\"></script>";
	else if ( strpos($resultado,"egweb.seprosat.com.mx") > 0 ) //Entraron por Egweb.seprosat.COM.MX
		echo "<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RQ5CEXRpWs9mIsCiSd5qkw2giD0jRSaMjjFkrJg-DCOiu8iJaSwhy8HSQ\" type=\"text/javascript\"></script>";
	else if ( strpos($resultado,"160.16.18.3") > 0) //Entraron por la direccion interna
		echo "<script src=\"http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAvvCDspsox0cIcm7N5XsVFhSD6fwXvyiVv52eBtZsNLpj7UPYtxQ3ajMFGTQXxAE-duIYN_EZu-JIMg\" type=\"text/javascript\"></script>";
}

function getOnlyKey()
{
	$resultado = curPageURL();

	if( strpos($resultado,"www.sepromex.com.mx") > 0 ) //Entraron por Sepromex.com.mx
		return "ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RS6tFE1rR0LV4ryqT8iCO2IKV5WVRRuggmx9p6HiLmoeJulFgJrVKX6IQ";
	else if ( strpos($resultado,"egweb.seprosat.mx") > 0 ) //Entraron por Egweb.seprosat.MX
		return "ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RR0aDMuaRqYj2Z6f2o1nHwVv9XrYxTQjD25Jb_61omuLoMIvaI58zu63Q";
	else if ( strpos($resultado,"egweb.seprosat.com.mx") > 0 ) //Entraron por Egweb.seprosat.COM.MX
		return "ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RQ5CEXRpWs9mIsCiSd5qkw2giD0jRSaMjjFkrJg-DCOiu8iJaSwhy8HSQ";
}

function getURL()
{
	$resultado = curPageURL();

	if( strpos($resultado,"www.sepromex.com.mx") > 0 ) //Entraron por Sepromex.com.mx
		return "sepromex";
	else if ( strpos($resultado,"egweb.seprosat.mx") > 0 ) //Entraron por Egweb.seprosat.MX
		return "egweb.mx";
	else if ( strpos($resultado,"egweb.seprosat.com.mx") > 0 ) //Entraron por Egweb.seprosat.COM.MX
		return "egweb.com.mx";
}

function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 
$OSList = array
(
        // Match user agent string with operating systems
        'Windows 3.11' => 'Win16',
        'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
        'Windows 98' => '(Windows 98)|(Win98)',
        'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
        'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
        'Windows Server 2003' => '(Windows NT 5.2)',
        'Windows Vista' => '(Windows NT 6.0)',
        'Windows 7' => '(Windows NT 6.1)',
		'Windows 8' => '(Windows NT 6.2)',
        'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
        'Windows ME' => 'Windows ME',
        'Open BSD' => 'OpenBSD',
        'Sun OS' => 'SunOS',
        'Linux' => '(Linux)|(X11)',
        'Mac OS' => '(Mac_PowerPC)|(Macintosh)',
        'QNX' => 'QNX',
        'BeOS' => 'BeOS',
        'OS/2' => 'OS/2',
        'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)'
);
foreach($OSList as $CurrOS=>$Match)
{
        // Find a match
        if (eregi($Match, $_SERVER['HTTP_USER_AGENT']))
        {
                // We found the correct match
                break;
        }
}
//echo $CurrOS;
//$yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
?>