<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Review extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'review';

}
