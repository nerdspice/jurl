<?php

namespace Jurl;

use Pixie\QueryBuilder\Raw;

class SqliteAdapter extends \Pixie\QueryBuilder\Adapters\Sqlite {
  //protected $sanitizer = '';
  
  // overrides Pixie\QueryBuilder\Adapters\BaseAdapter
  public function wrapSanitizer($value) {
    if ($value instanceof Raw) {
      return (string)$value;
    } elseif ($value instanceof \Closure) {
      return $value;
    }

    $valueArr = explode('.', $value, 2);

    foreach ($valueArr as $key => $subValue) {
      $valueArr[$key] = trim($subValue) == '*' ? $subValue : 
        $this->sanitizer . $this->filterIdentifier($subValue) . $this->sanitizer;
    }

    return implode('.', $valueArr);
  }
  
	public function filterIdentifier($arg) {
    $max_len = 64;
		$pattern = '/[^a-zA-Z0-9_]/';

		if(is_array($arg)) {
			$ret = array();

			foreach($arg as $k=>$v) {
				if(is_string($k)) {
					$k = preg_replace($pattern, '', $k);
          $k = substr($k, 0, $max_len);
        }
				$ret[$k] = $v;
			}

			return $ret;
		}
    
    $arg = preg_replace($pattern, '', $arg);
		return substr($arg, 0, $max_len);
	}
}
