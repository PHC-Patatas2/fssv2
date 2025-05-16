<?php
// app/Models/EntityEditLock.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityEditLock extends Model
{
    protected $fillable = [
        'user_id',
        'entity_type',
        'entity_id',
        'locked_at',
    ];
    public $timestamps = false;
}
