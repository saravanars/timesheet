<?php

namespace App\Models;

use DateTime;
use DateInterval;
use CodeIgniter\Model;

class Team_master extends Model
{
  protected $table = 'team_master';

  protected $allowedFields = ['team_id', 'team_name', 'status'];

 
}
