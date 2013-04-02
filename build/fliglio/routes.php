<?php 
$arr = array(); 
$arr['auth'] = new Routing_PatternRoute('/api/auth/:command',array (
  'module' => 'FinTech',
  'commandGroup' => 'Auth',
));
$arr['api'] = new Routing_PatternRoute('/api/:command',array (
  'module' => 'FinTech',
  'commandGroup' => 'Services',
));
$arr['error'] = new Routing_CatchNoneRoute(array (
  'cmd' => 'FinTech.Ui.handleError',
));
$arr['404'] = new Routing_CatchAllRoute(array (
  'cmd' => 'FinTech.Ui.pageNotFound',
)); 
return $arr;
