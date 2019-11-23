<?php
namespace Interfaces;

interface ILogger
{
    public static function in(string $message, int $type);
    public static function out();
}
