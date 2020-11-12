<?php

namespace Modules\Lalitha\Http\Client;

use Modules\Lalitha\Config\Routes;
use View;

class ClientView 
{
  
  public static function menu_item($item) {
    $html = '';
    $html .= "<li>\n<a href=\"" . route($item['route']) ."\">\n";
    $html .= "<i class=\"" . $item['icon'] ."\"></i>\n";
    $html .= "<span>" . $item['name'] ."</span>\n";
    $html .= "</a>\n</li>\n";
    return $html;
  }

  public static function submenu_item($item) {
    $html = '';
    $html .= "<li class=\"sidebar-dropdown\">\n";
    $html .= "<a href=\"#\">\n";
    $html .= "<i class=\"" . $item['icon'] ."\"></i>\n";
    $html .= "<span>" . $item['name'] ."</span>\n";
    $html .= "</a>\n";
    $html .= "<div class=\"sidebar-submenu\"><ul>";
    foreach($item['children'] as $subitem) {
      $html .= "<li>\n<a href=\"" . route($subitem['route']) ."\">\n";
      $html .= "<i class=\"" . $subitem['icon'] ."\"></i>\n";
      $html .= "<span>" . $subitem['name'] ."</span>\n";
      $html .= "</a>\n</li>\n";
    }
    $html .= "</ul></div>";
    return $html .= "</li>\n";
  }
}