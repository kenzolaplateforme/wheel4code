<?php
namespace App\Service;

use App\Entity\Draw;

class DrawService
{
  public function isValid(Draw $draw) {
    return count($draw->getUsers()) > 1;
  }
}
