<?php

namespace Modules\Lalitha\Config;

class ClientRoutes
{
  /**
   * Navigation Items
   * 
   */
  private static $navigation_items = array(
    /**
     * Navigation Items for the main Navigation
     */
    'main' => array(
      array(
        'route' => 'employees.index',
        'icon' => 'fa fa-tachometer-alt',
        'name' => 'Dashboard',
      ),
      array(
        'route' => '#',
        'icon' => 'fa fa-user-shield',
        'name' => 'Admin',
        'children' => array(
          [
            'route' => 'employees.index',
            'icon' => 'fa fa-users',
            'name' => 'Employees',
          ],
          [
            'route' => 'roles.index',
            'icon' => 'fa fa-id-card',
            'name' => 'Access Control',
          ],
        ),
      ),
      array(
        'route' => '#',
        'icon' => 'fa fa-cash-register',
        'name' => 'POS',
        'children' => array(
          [
            'route' => 'commissions.index',
            'icon' => 'fa fa-handshake',
            'name' => 'Commission',
          ],
          [
            'route' => 'payment_methods.index',
            'icon' => 'fa fa-credit-card',
            'name' => 'Pay Methods',
          ],
        ),
      ),
      array(
        'route' => 'venue.index',
        'icon' => 'fa fa-door-open',
        'name' => 'Venue',
      ),
      array(
        'route' => 'store_services.index',
        'icon' => 'fa fa-concierge-bell',
        'name' => 'Services',
      ),
    ),

    /**
     * Employee Navigation Items
     */
    'employee_tabs' => 
    [
      [
        'name' => 'general',
        'route' => 'employees.show',
      ],
      [
        'name' => 'address',
        'route' => 'address.create',
      ],
      [
        'name' => 'contact',
        'route' => 'contact.create',
      ],
      [
        'name' => 'family',
        'route' => 'next_of_kin.create',
      ],
      [
        'name' => 'contract',
        'route' => 'contract.create',
      ],
      [
        'name' => 'multimedia',
        'route' => 'employee.multimedia',
      ],
      [
        'name' => 'acl',
        'route' => 'employee.acl',
      ]
    ]
  );

  /**
   * Returns Navigation
   */
  public static function client_routes() 
  {
    return self::$navigation_items;
  }
}