<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Business extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'business';

}
