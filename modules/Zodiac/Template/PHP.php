<?php

namespace Zodiac\Template;

class PHP extends Manager implements Engine {
  public $template_include_max_depth = 100; // prevents render() inf loop
  protected $template_include_depth_count = 0;
  protected $base_path;
  
  public function __construct($base_path, $globals = array()) {
    parent::__construct($globals);
    $real_path = realpath($base_path);
    
    if(!$real_path)
      throw new \Exception('Template base path "'.$base_path.'" is not readable');
    
    $this->base_path = $real_path.DIRECTORY_SEPARATOR;
  }
  
  public function render($template, $args = array(), $ret = false) {
    $this->checkTemplateDepth();
    $this->checkTemplatePath($template);
    $this->filterTemplateArgs($args);
    return $this->doInclude($template, $args, $ret);
  }
  
  protected function checkTemplateDepth() {
    if($this->template_include_depth_count > $this->template_include_max_depth)
      throw new \Exception('Max render() recursion reached');
  }
  
  public function checkTemplatePath($template) {
    $filename = realpath($this->base_path.$template);
    if(!$filename || strpos($filename, $this->base_path)!==0)
      throw new \Exception('Template access violation "'.$template.'" [realpath: '.$filename.']');
  }
  
  protected function doInclude($template, &$args, $ret) {
    $this->template_include_depth_count++;
    $ret = $this->doExtractAndInclude($template, $args, $ret);
    $this->template_include_depth_count--;
    return $ret;
  }
  
  protected function doExtractAndInclude($template, $args, $ret) {
    $func = static function() {
      extract(func_get_arg(1), EXTR_OVERWRITE|EXTR_PREFIX_INVALID|EXTR_REFS, '');
      if(@func_get_arg(2)) { // return as string
        ob_start();
        require(realpath(func_get_arg(3).func_get_arg(0)));
        $ret = ob_get_clean();
      } else { // echo output
        $ret = require(realpath(func_get_arg(3).func_get_arg(0)));
      }
      return $ret;
    };
    
    $func = $func->bindTo(null, '\\stdClass'); // unbinds $this inside template
    return $func($template, $args, $ret, $this->base_path);
  }
}

