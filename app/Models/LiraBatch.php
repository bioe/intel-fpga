<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiraBatch extends Model
{
    use HasFactory;

    protected $table = 'lira_batchs';

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lira()
    {
        return $this->hasMany(Lira::class);
    }

    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [];
        return array_merge($headers, [
            ['field' => 'user_id', 'title' => 'User Name', 'sortable' => true],
            ['field' => 'created_at', 'title' => 'Created At', 'sortable' => true],
        ]);
    }
}
