<?php

namespace App\Services\LLRoute;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use View;

//You can create a BaseController:

class Controller extends BaseController {

  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public $navitems = [
    [
      'path' => 'employees.index',
      'icon' => 'fa fa-tachometer-alt',
      'name' => 'Dashboard',
    ],
  
    [
      'path' => 'employees.index',
      'icon' => 'fa fa-user-shield',
      'name' => 'Admin',
      'children' => [
        [
          'path' => 'employees.index',
          'icon' => 'fa fa-users',
          'name' => 'Employees',
        ],
        [
          'path' => 'employees.index',
          'icon' => 'fa fa-id-card',
          'name' => 'Roles',
        ],
      ],
    ],
  
    [
      'path' => 'employees.index',
      'icon' => 'fa fa-cash-register',
      'name' => 'POS',
      'children' => [
        [
          'path' => 'employees.index',
          'icon' => 'fa fa-dollar-sign',
          'name' => 'Charges',
        ],
        [
          'path' => 'employees.index',
          'icon' => 'fa fa-credit-card',
          'name' => 'Pay Methods',
        ],
      ],
    ],
  ];

  public function __construct() {
    $items = new Navigation($this->navitems);
    $navigation = $items->design();

      View::share ( 'navitems', $navigation );
  }

  public function employee_tabs($employee) {
    $tabs = [
      [
        'name' => 'general',
        'route' => 'employees.show',
        'param' => $employee
      ],
      [
        'name' => 'address',
        'route' => 'address.create',
        'param' => 'emp_id=' . $employee->id,
      ],
      [
        'name' => 'contact',
        'route' => 'contact.create',
        'param' => 'emp_id=' . $employee->id,
      ],
      [
        'name' => 'family',
        'route' => 'next_of_kin.create',
        'param' => 'emp_id=' . $employee->id,
      ],
      [
        'name' => 'contract',
        'route' => 'contract.create',
        'param' => 'emp_id=' . $employee->id,
      ],
      // [
      //   'name' => 'avatar',
      //   'route' => 'employees.avatar',
      //   'param' => 'emp_id=' . $employee->id,
      // ],
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
      // [
      //   'name' => 'multimedia',
      //   'route' => 'contact.show',
      //   'param' => $contact,
      //   'blade' => 'pages.address.read'
      // ],
    ];

    return $tabs;
  }

}