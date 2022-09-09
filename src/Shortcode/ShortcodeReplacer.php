<?php
/**
 * Created by PhpStorm.
 * User: jl
 * Date: 09/09/22
 * Time: 18:50
 */

namespace Isalid\Shortcode;


interface ShortcodeReplacer
{
    public function replace($text, array $data = []);
}