<?php
/* qtip options after you have included ii::import('application.modules.admincms.extensions.qtip.QTip'); file
you must include this file inorder to setup the options for qtip.
To import this file in the view use below code
Yii::import('application.modules.admincms.extensions.qtip.QTipSetup',true); // true parameter is used to include the file forcefully
*/
$opts = array(
    'position' => array(
        'corner' => array(
            'target' => 'topRight',
            'tooltip' => 'bottomLeft'
            )
        ),
    'show' => array(
        'when' => array('event' => 'mouseover' ),
        'effect' => array( 'length' => 300 )
    ),
    'hide' => array(
        'when' => array('event' => 'mouseout' ),
        'effect' => array( 'length' => 500 )
    ),
    'style' => array(
        'color' => 'black',
        'name' => 'blue',
        'border' => array(
            'width' => 1,
            'radius' => 3,
        ),
    )
);
// apply tooltip on the jQuery selector (1 parameter)
QTip::qtip('.row a[title]', $opts);
?>