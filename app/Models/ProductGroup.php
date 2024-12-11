<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGroup extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'active',
        'user_id',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [];
        return array_merge($headers, [
            ['field' => 'name', 'title' => 'Name', 'sortable' => true],
            ['field' => 'product_id', 'title' => 'Product'],
            ['field' => 'created_at', 'title' => 'Created At', 'sortable' => true],
        ]);
    }
}
