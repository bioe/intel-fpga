<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'active',
        'user_id',
        'product_type_id',
    ];

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function productGroups()
    {
        return $this->hasMany(ProductGroup::class, 'product_id');
    }

    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [];
        return array_merge($headers, [
            ['field' => 'name', 'title' => 'Name', 'sortable' => true],
            ['field' => 'product_type_id', 'title' => 'Product Type'],
            ['field' => 'created_at', 'title' => 'Created At', 'sortable' => true],
        ]);
    }
}
