<?php

$src    = $argv[1];
$entry  = $argv[2];
$output = $argv[3];


$p = new Phar($output);

$p->buildFromDirectory($src);


$p->setStub("#!/usr/bin/env php\n" . $p->createDefaultStub($entry));


