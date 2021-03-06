<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'client_id', 'user_item_id', 'about_cash', 'refund', 'points_old', 'points_new',
    ];

    /**
     * @param int $id
     * @return mixed
     */
    static public function scopeUserReceiptLists(int $id) {
        return self::where('user_id', $id)->get();
    }

    /**
     * @param int $id
     * @param int $receiptId
     * @return mixed
     */
    static public function scopeUserReceiptDetail(int $id, int $receiptId) {
        return self::where('user_id', $id)->where('id', $receiptId)->get();
    }
}
