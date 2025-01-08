<?php
namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contact_messages';
    protected $allowedFields = ['name', 'email', 'subject', 'message'];
    protected $useTimestamps = true;
}
