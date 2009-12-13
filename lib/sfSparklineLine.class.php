<?php

/**
 * sfSparklineLine class.
 *
 * Class providing easy use of SparklineLine in symfony.
 *
 * @package    plugin
 * @subpackage sfSparklinePlugin
 * @class      sfSparklineLine
 * @author     Tomasz Ducin <tomasz.ducin@gmail.com>
 */
class sfSparklineLine extends Sparkline_Line
{
  public function __call($method, $arguments)
  {
    return sfMixer::callMixins();
  }
}

// extending sfSparklineLine class using Symfony Mixins
$thisClass = 'sfSparklineLine';
$baseClass = 'sfBaseSparkline';
sfMixer::register($thisClass, array($baseClass, 'save'));
