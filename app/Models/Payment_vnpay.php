<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment_vnpay extends Model
{
    use HasFactory;
    protected $table = 'payment_vnpay';
    protected $fillable = ['id',"vnp_Amount","vnp_BankCode","vnp_BankTranNo","vnp_CardType", "vnp_OrderInfo","vnp_PayDate","vnp_ResponseCode","vnp_TransactionNo","vnp_TmnCode" ,"vnp_TransactionStatus", "vnp_TxnRef","vnp_SecureHash",'created_at', 'updated_at'];
    public static function getMoneyMonthly(){
        $monthRange = array();
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::today()->startOfMonth()->subMonth($i);
            $year = Carbon::today()->startOfMonth()->subMonth($i)->format('Y');
            array_push($monthRange, array(
                'month' => $month->month,
                'year' => $year
            ));
        }
        $totalMoney = Payment_vnpay::
            where('vnp_ResponseCode', '00')
            ->select(DB::raw('sum(vnp_Amount) as totalMoney'), DB::raw('MONTH(created_at) as month'))
            ->groupBy('month')
            ->get()->toArray();
        $staticMoneyFolowMonth = [];
        foreach ($monthRange as $month) {
            $total = 0;
            foreach ($totalMoney as $key => $value) {
                if ($value['month'] == $month['month']) {
                    $total = $value['totalMoney'];
                    break;
                }
            }
            $staticMoneyFolowMonth[] = $total;
            $months[] = $month['month'].'/'.$month['year'];
        }
        $data = [
            'time' => $months,
            'money' => $staticMoneyFolowMonth
        ];
        return $data;
    }
}
