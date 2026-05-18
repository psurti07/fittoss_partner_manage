<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'invoices';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'company_id',
        'rec_date',
        'userid',
        'user_type',
        'order_id',
        'payment_id',
        'inv_prefix',
        'inv_number',
        'inv_date',
        'inv_price',
        'inv_cgst',
        'inv_sgst',
        'inv_igst',
        'inv_grandtotal',
        'is_refund',
        'remarks',
        'is_delete',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'userid');
    }

}
