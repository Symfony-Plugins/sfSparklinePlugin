<?php

/**
 * sfSparklineExample actions.
 *
 * @package     sfSparklinePlugin
 * @author      Tomasz Ducin <tomasz.ducin@gmail.com>
 */

class sfSparklineExampleActions extends sfActions
{
  /**
   * Demo action. Displays line and bar example graphs and a live-data
   * yahoo charts for USD.
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
  }

  /**
   * Creates a line graph from random data
   *
   * @param sfRequest $request A request object
   */
  public function executeLineGraphData(sfWebRequest $request)
  {
    // retrieving size parameters
    $width = $request->getParameter('width');
    $height = $request->getParameter('height');

    // initializing object
    $sparkline = new sfSparklineLine();

    // setting size
    $sparkline->SetYMin(0);
    $sparkline->SetYMax(25);

    // some random data
    for( $i = 0; $i < 100; $i++ )
    {
      $sparkline->SetData($i, rand(1, $i/4));
    }

    // additional points on the image
    $sparkline->SetFeaturePoint(1, 1, 'red', 3, 'start', TEXT_TOP, FONT_3);
    $sparkline->SetFeaturePoint(50, 15, 'blue', 3);

    // internal sparkline calculation method
    $sparkline->Render($width, $height);

    // displaying sparkline
    $sparkline->Output();

    return sfView::NONE;
  }

  /**
   * Creates a bar graph from random data
   *
   * @param sfRequest $request A request object
   */
  public function executeBarGraphData(sfWebRequest $request)
  {
    // retrieving size parameters
    $bar = $request->getParameter('bar');
    $spacing = $request->getParameter('spacing');
    $height = $request->getParameter('height');

    // Next, create a new instance of Sparkline_Bar
    $graph = new sfSparklineBar();

    // Set the width of each bar in the graph
    $graph->setBarWidth($bar);

    // Set the spacing between the bars
    $graph->setBarSpacing($spacing);

    // Add a color called "mygray" to the available color list
    $graph->setColorHtml('background', '#EEEEEE');

    // Set the background color to this new color
    // As of 0.2, if you didn't set the color beforehand,
    // your background would be black
    $graph->setColorBackground('background');

    // Loop adding the data
    srand(microtime()*1000000);
    for ($ind = 0; $ind < 20; $ind++)
    {
      $color_int = rand(0,2);
      switch($color_int)
      {
        case 0:
          $color = 'red';
          break;
        case 1:
          $color = 'blue';
          break;
        case 2:
          $color = 'green';
          break;
      }
      $graph->setData($ind, rand(30,50), $color);
    }

    // Draw all necessary objects for our graph
    $graph->Render($height);

    // Displays the graph by sending a 'Content-type: image/png'
    // header then outputting the image data
    echo $graph->Output();

    return sfView::NONE;
  }

  /**
   * Creates a line graph from yahoo ichart data
   *
   * @param sfRequest $request A request object
   */
  public function executeYahooChart(sfWebRequest $request)
  {
    // retrieving size parameters
    $width = $request->getParameter('width');
    $height = $request->getParameter('height');

    // load and process data from Yahoo! ichart csv source
    $currency = 'USD';
    $m  = date('n') - 1;
    $d  = date('d');
    $y2 = date('Y');
    $y1 = $y2 - 5;

    // data sample:
    //   0        1     2     3     4     5        6
    //   Date,Open,High,Low,Close,Volume,Adj. Close*
    //   5-Nov-04,29.21,29.36,29.03,29.31,95337696,29.31
    $url = "http://ichart.finance.yahoo.com/table.csv?s=$currency&y=5&g=d&ignore=.csv";
    if (!$data = @file($url)) {
      die('error fetching stock data; verify ticker symbol');
    }

    $sparkline = new sfSparklineLine();
    $sparkline->SetDebugLevel(DEBUG_NONE);
    //$sparkline->SetDebugLevel(DEBUG_ERROR | DEBUG_WARNING | DEBUG_STATS | DEBUG_CALLS, '../log.txt');

    if (isset($_GET['b'])) {
      $sparkline->SetColorHtml('background', $_GET['b']);
      $sparkline->SetColorBackground('background');
    }

    $data = array_reverse($data);
    $i = 0;
    $min  = null;
    $max  = null;
    $last = null;
    while (list(, $v) = each($data))
    {
      $elements = explode(',', $v);
      $value = @trim($elements[6]);

      if (ereg('^[0-9\.]+$', $value))
      {
        $sparkline->SetData($i, $value);
        if (null == $max || $value >= $max[1])
        {
          $max = array($i, $value);
        }
        if (null == $min || $value <= $min[1])
        {
          $min = array($i, $value);
        }
        $last = array($i, $value);
        $i++;
      }
    }

    // set y-bound, min and max extent lines
    $sparkline->SetYMin(0);

    // setpadding is additive
    $sparkline->SetPadding(2);
    $sparkline->SetPadding(imagefontheight(FONT_2),
      imagefontwidth(FONT_2) * strlen(" $last[1]"), 0, 0);
    $sparkline->SetFeaturePoint($min[0],  $min[1],  'red',   5, $min[1],     TEXT_TOP,    FONT_2);
    $sparkline->SetFeaturePoint($max[0],  $max[1],  'green', 5, $max[1],     TEXT_TOP,    FONT_2);
    $sparkline->SetFeaturePoint($last[0], $last[1], 'blue',  5, " $last[1]", TEXT_RIGHT,  FONT_2);

    $sparkline->SetLineSize(3);
    $sparkline->RenderResampled($width, $height);

    // manually add a stock ticker label
    $sparkline->DrawText(
      strtoupper($currency),
      $sparkline->GetImageWidth() - (imagefontwidth(FONT_5) * strlen($currency)),
      $sparkline->GetImageHeight() - imagefontheight(FONT_5),
      'black',
      FONT_5);

    $sparkline->Output();
  }
}
