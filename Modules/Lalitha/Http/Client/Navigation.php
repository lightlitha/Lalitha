<?php

namespace Modules\Lalitha\Http\Client;

use Modules\Lalitha\Config\Routes as LLRoutes;

/**
 * Makes Dynamic Navigation Bar Items
 */
class Navigation
{
  use LLRoutes;

  protected $navitems = array();

  private function prepare_items($ni) {
    $this->navitems = $ni;
  }

  public function design($ni) {
    $this->prepare_items($ni);
    $html = "<ul>\n";
    foreach($this->navitems as $key => $item) {
      if(!empty($item['children'])) {
        $html .= ClientView::submenu_item($item);
      } else {
        $html .= ClientView::menu_item($item);
      }
    }
    $html .= "</ul>\n";
    return $html;
  }
  
}
