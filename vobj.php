<?php

/*

vobj.php

Version 1.0.0

This is VOBJ, a basic extendable object for use with things
stored in databases.

Requires VCRUD.

*/

require_once('vcrud.php');

class Vobj
{
    protected $crud;
    protected $table;
    protected $index;
    public $fields;

    function __construct(Vcrud $crud)
    {
        $this->crud = $crud;
        $this->table = '';
        $this->index = '';
    }

    function load($id)
    {
        $results = $this->crud->read($this->table, [[$this->index, '=', $id]]);
        if (count($results) != 1) {
            return false;
        }

        $this->fields = $results[0];
        return true;
    }

    function save()
    {
        if (!empty($this->fields[$this->index])) {
            $this->crud->update($this->table, $this->fields, [[$this->index, '=', $this->fields[$this->index]]]);
            return true;
        } else {
            $id = $this->crud->create($this->table, $this->fields);
            return $id;
        }
    }
}