<?php 
namespace Controller;

use Classes\Abstract\AbstractController;
use Classes\Interface\CrudInterface;

class UserController extends AbstractController implements CrudInterface
{
    public function create(){echo "create user fonctionne";}
    public function read(){echo "read user fonctionne";}
    public function update(){echo "update user fonctionne";}
    public function delete(){echo "delete user fonctionne";}
}