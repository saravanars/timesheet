<?php
namespace App\Models;

use CodeIgniter\Model;

class ProjectlistModel extends Model
{
    protected $table = 'project_list';
    protected $allowedFields = ['project_id', 'project_name', 'status'];




    

}
