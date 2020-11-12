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
        'route' => 'employees.index',
        'icon' => 'fa fa-user-shield',
        'name' => 'Admin',
        'children' => array(
          [
            'route' => 'employees.index',
            'icon' => 'fa fa-users',
            'name' => 'Employees',
          ],
          [
            'route' => 'employees.index',
            'icon' => 'fa fa-id-card',
            'name' => 'Roles',
          ],
        ),
      ),
      array(
        'route' => 'employees.index',
        'icon' => 'fa fa-cash-register',
        'name' => 'POS',
        'children' => array(
          [
            'route' => 'employees.index',
            'icon' => 'fa fa-dollar-sign',
            'name' => 'Charges',
          ],
          [
            'route' => 'employees.index',
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
    ),

    /**
     * Employee Navigation Items
     */
    'employee_tabs' => 
    [
      [
        'name' => 'general',
        'route' => 'employees.show',
        // 'param' => $employee
      ],
      [
        'name' => 'address',
        'route' => 'address.create',
        // 'param' => 'emp_id=' . $employee->id,
      ],
      [
        'name' => 'contact',
        'route' => 'contact.create',
        // 'param' => 'emp_id=' . $employee->id,
      ],
      [
        'name' => 'family',
        'route' => 'next_of_kin.create',
        // 'param' => 'emp_id=' . $employee->id,
      ],
      [
        'name' => 'contract',
        'route' => 'contract.create',
        // 'param' => 'emp_id=' . $employee->id,
      ],
      [
        'name' => 'multimedia',
        'route' => 'employee.multimedia',
        // 'param' => 'i=' . $employee->id,
      ]
      // [
      //   'name' => 'setting',
      //   'route' => 'contact.show',
      //   'param' => $contact,
      //   'blade' => 'pages.address.read'
      // ],
      // [
      //   'name' => 'report',
      //   'route' => 'contact.show',
      //   'param' => $contact,
      //   'blade' => 'pages.address.read'
      // ],
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