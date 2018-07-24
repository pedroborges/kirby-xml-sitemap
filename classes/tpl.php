<?php

namespace Pedroborges;

https://github.com/getkirby/toolkit/blob/84530101e95e8ca7ffc4f350b409b7b7c0ce3feb/lib/tpl.php

/**
 * Tpl
 *
 * Super simple template engine
 *
 * @package   Kirby Toolkit
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Tpl extends \Pedroborges\Silo {
  public static $data = array();
  public static function load($_file, $_data = array(), $_return = true) {
    if(!file_exists($_file)) return false;
    ob_start();
    extract(array_merge(static::$data, (array)$_data));
    require($_file);
    $_content = ob_get_contents();
    ob_end_clean();
    if($_return) return $_content;
    echo $_content;
  }
}