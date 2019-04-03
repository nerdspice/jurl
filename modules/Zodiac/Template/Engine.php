<?php

namespace Zodiac\Template;

interface Engine {
  public function render($template, $args = array(), $ret = false);
}
