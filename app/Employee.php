<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  protected $table = 'empleado';
  public $timestamps = false;
  public $primaryKey = 'cedula';
  public $incrementing = false;
}