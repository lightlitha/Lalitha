<?php

namespace Modules\Lightlitha\Entities\Template\LLAbstract;

abstract class DynamicNavigation {
  public abstract function initialize($NavItems);
  public abstract function design();

  //template method
  public function create(){
     initialize();
     design();
  }
}