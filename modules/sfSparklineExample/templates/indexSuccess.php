<h1>sparkline test</h1>

<hr />

<h2>example line graph</h2>
<?php sfSparkline::createLine('@sparkline_line', 250, 60, array(
  'title' => 'sparkline line style',
  'alt' => 'sparkline alternative text',
)); ?>

<hr />

<h2>example bar graph</h2>
<?php sfSparkline::createBar('@sparkline_bar', 7, 3, 50, array(
  'title' => 'sparkline bar style',
  'alt' => 'sparkline alternative text',
)); ?>

<hr />

<h2>example yahoo chart</h2>
<?php sfSparkline::createLine('sfSparklineExample/yahooChart', 400, 100); ?>