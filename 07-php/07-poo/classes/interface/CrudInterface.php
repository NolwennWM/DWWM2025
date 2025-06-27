<?php 
namespace Classes\Interface;

/**
 * Interface indicating that a class used as a CRUD must contain one function for each CRUD action.
 */
interface CrudInterface
{
    function create();
    function read();
    function update();
    function delete();
}
