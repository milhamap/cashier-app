<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'type_id',
        'size_id',
        'sch_id',
        'rating_id',
        'spec_id',
        'brand_id',
        'price_brand',
        'price_id',
        'welding',
        'penetran'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function sch()
    {
        return $this->belongsTo(Sch::class);
    }

    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

    public function spec()
    {
        return $this->belongsTo(Spec::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function invoiceItems()
    {
        return $this->belongsToMany(InvoiceItem::class, 'invoice_items', 'product_id', 'invoice_id');
    }
}
