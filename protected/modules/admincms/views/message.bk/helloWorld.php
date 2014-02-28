<?php
$this->breadcrumbs=array(
	'Message'=>array('message/index'),
	'HelloWorld',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>You may change the content of this page by modifying the file <tt><?php echo __FILE__; ?></tt>.</p>
<h1> Hello World </h1>
<h3><?php echo $time; ?></h3>
<a href="http://localhost/3003online/index.php?r=message/goodbye">Goodbye!</a>
<p><?php echo CHtml::link("Goodbye",array('message/goodbye')); 
?></p>