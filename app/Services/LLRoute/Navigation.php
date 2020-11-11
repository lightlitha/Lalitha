<?php

namespace App\Services\LLRoute;

/**
 * Makes Dynamic Navigation Bar Items
 */
class Navigation extends DynamicNavigation
{
  protected $navitems = array();

  function __construct($ni = []) {
    $this->initialize($ni);
  }

  public function initialize($ni) {
    $this->navitems = $ni;
  }

  public function design() {
    $html = "<ul>\n";
    foreach($this->navitems as $item) {
      if(!empty($item['children'])) {
        $html .= "<li class=\"sidebar-dropdown\">\n";
        $html .= "<a href=\"#\">\n";
        $html .= "<i class=\"" . $item['icon'] ."\"></i>\n";
        $html .= "<span>" . $item['name'] ."</span>\n";
        $html .= "</a>\n";
        $html .= "<div class=\"sidebar-submenu\"><ul>";
        foreach($item['children'] as $subitem) {
          $html .= "<li>\n<a href=\"" . route($subitem['path']) ."\">\n";
          $html .= "<i class=\"" . $subitem['icon'] ."\"></i>\n";
          $html .= "<span>" . $subitem['name'] ."</span>\n";
          $html .= "</a>\n</li>\n";
        }
        $html .= "</ul></div>";
        $html .= "</li>\n";
      } else {
        $html .= "<li>\n<a href=\"" . route($item['path']) ."\">\n";
        $html .= "<i class=\"" . $item['icon'] ."\"></i>\n";
        $html .= "<span>" . $item['name'] ."</span>\n";
        $html .= "</a>\n</li>\n";
      }
    }
    $html .= "</ul>\n";
    return $html;
  }
}
