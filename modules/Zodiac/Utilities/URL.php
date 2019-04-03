<?php

namespace Zodiac\Utilities;

class URL {
  
  public static function getBaseUrl($abs = true, $script = true, $domain = false) {
    $S = &$_SERVER;

    $name = $S['SERVER_NAME'];
    if(empty($name)) return false;
    $sn = $S['SCRIPT_NAME'];
    $uri = explode('?', $S['REQUEST_URI']);
    $uri = $uri[0];
    $sneu = strpos($uri, $sn)===0;//$uri===$sn;

    $proto = !empty($S['HTTPS']) && $S['HTTPS']=== 'on' ? 'https' : 'http';
    $port = $S['SERVER_PORT'];
    if($port==='80' || $port==='443') $port = '';
    else $port = ':'.$port;

    $pos = strrpos($sn, '/');
    $path = (!empty($S['PATH_INFO']) && $script) || ($sneu && $script)
      ? $sn.'/' : substr($sn, 0, $pos+1);

    if($abs) {
      if($domain) return $proto.'://'.$name.$port.'/';
      else return $proto.'://'.$name.$port.$path;
    }
    else return $path;
  }
  
    
  public static function isHttpUrl($url) {
    return !!preg_match('#^https?://.+#i', $url);
  }
}