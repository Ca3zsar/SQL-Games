<?php

spl_autoload_register(function ($className)
{
    include dirname(__DIR__) . '\\' . substr($className,4).'.php';
});
