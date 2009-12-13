<?php

/**
 * sfSparkline class.
 *
 * Class providing easy use of Sparklines in symfony.
 *
 * @package    plugin
 * @subpackage sfSparklinePlugin
 * @class      sfSparkline
 * @author     Tomasz Ducin <tomasz.ducin@gmail.com>
 */
class sfSparkline
{
 /**
  * Embeds a sparkline line style inside HTML code.
  *
  * @param String $url URL of the action generating image
  * @param Integer $bar Width of a single bar
  * @param Integer $spacing Spacing between distinct bars
  * @param Integer $height Height of the sparkline
  * @param Array $attributes Array of additional parameters such as title, alt,
  * etc.
  */
  static public function createBar($url, $bar, $spacing, $height, $attributes = array())
  {
    $src_attribute = ' src="'.url_for($url.'?bar='.$bar.'&spacing='.$spacing.'&height='.$height).'"';
    $other_attributes = '';
    foreach($attributes as $key => $value)
    {
      $other_attributes .= ' '.$key.'="'.$value.'"';
    }
    echo '<img'.$src_attribute.$other_attributes.' />';
  }

 /**
  * Embeds a sparkline line style inside HTML code.
  *
  * @param String $url URL of the action generating image
  * @param Integer $width Width of the sparkline
  * @param Integer $height Height of the sparkline
  * @param Array $attributes Array of additional parameters such as title, alt,
  * etc.
  */
  static public function createLine($url, $width, $height, $attributes = array())
  {
    $src_attribute = ' src="'.url_for($url.'?width='.$width.'&height='.$height).'"';
    $other_attributes = '';
    foreach($attributes as $key => $value)
    {
      $other_attributes .= ' '.$key.'="'.$value.'"';
    }
    echo '<img'.$src_attribute.$other_attributes.' />';
  }

 /**
  * Embeds a sparkline inside HTML code with static sparkline size.
  *
  * @param String $url URL of the action generating image
  * @param Array $attributes Array of additional parameters such as title, alt,
  * etc.
  */
  static public function createStatic($url, $attributes = array())
  {
    $src_attribute = ' src="'.$url.'"';
    $other_attributes = '';
    foreach($attributes as $key => $value)
    {
      $other_attributes .= ' '.$key.'="'.$value.'"';
    }
    echo '<img'.$src_attribute.$other_attributes.' />';
  }
}


