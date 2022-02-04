<?php
namespace heephp\template;

interface templateInterface{
    function assign($name,$value);
    function fetch($basedir,$viewpage);
}