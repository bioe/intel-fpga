<?php

namespace App\Models;

class LineitemAttribute extends BaseModel
{
    public $fillable = ['active', 'symbol', 'attribute_name', 'value', 'expression', 'lineitem_manager_id'];
}
