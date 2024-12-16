<?php

namespace App\Models;

class LineitemManager extends BaseModel
{
    public $fillable = ['module', 'product_type_id', 'product_id', 'product_group_id', 'revision', 'user_id'];

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'product_group_id');
    }

    public function attributes()
    {
        return $this->hasMany(LineitemAttribute::class);
    }


    public static function header()
    {
        $headers = [];
        return array_merge($headers, [
            ['field' => '', 'title' => 'Product Code Name', 'sortable' => false],
            ['field' => '', 'title' => 'Product Group', 'sortable' => false],
            ['field' => 'module', 'title' => 'Module', 'sortable' => true],
            ['field' => '', 'title' => 'Created By'],
            ['field' => 'created_at', 'title' => 'Created At'],
        ]);
    }
}
