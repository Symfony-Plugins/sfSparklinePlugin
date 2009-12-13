<?php

/**
 * sfSparklineBar class.
 *
 * Class providing easy use of Sparkline_Bar in symfony.
 *
 * @package    plugin
 * @subpackage sfSparklinePlugin
 * @class      sfSparklineBar
 * @author     Tomasz Ducin <tomasz.ducin@gmail.com>
 */
class sfSparklineBar extends Sparkline_Bar
{
  public function __call($method, $arguments)
  {
    return sfMixer::callMixins();
  }
}

// extending sfSparklineBar class using Symfony Mixins
$thisClass = 'sfSparklineBar';
$baseClass = 'sfBaseSparkline';
sfMixer::register($thisClass, array($baseClass, 'save'));