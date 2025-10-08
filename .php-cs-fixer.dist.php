<?php

$config = new Rshop\CS\Config\Rshop();

$config->setUsingCache(false);

$config->getFinder()->in(__DIR__);

return $config;
