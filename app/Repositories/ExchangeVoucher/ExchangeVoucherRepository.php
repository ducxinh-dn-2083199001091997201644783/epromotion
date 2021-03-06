<?php

namespace App\Repositories\ExchangeVoucher;

use App\Repositories\BaseRepository;
use App\Repositories\ExchangeVoucher\ExchangeVoucherRepositoryInterface;
use App\Models\ExchangeVoucher;
use Auth;

class ExchangeVoucherRepository extends BaseRepository implements ExchangeVoucherRepositoryInterface
{
    /**
     * The ExchangeVoucher instance
     *
     * @param ExchangeVoucher $exchangeVoucher [description]
     *
     * @return void
     */
    public function __construct(ExchangeVoucher $exchangeVoucher)
    {
        $this->model = $exchangeVoucher;
    }

    /**
     * Find a exchange_voucher
     *
     * @param int $id [id of voucher]
     *
     * @return voucher
     */
    public function findByIdVoucher($id)
    {
        $data['message'] = "";
        $data['list'] = $this->model->join('user', 'exchange_vouchers.user_id', '=', 'user.id')
                                    ->join('vouchers', 'vouchers.id', '=', 'exchange_vouchers.voucher_id')
                                    ->select('user.*', 'exchange_vouchers.status', 'exchange_vouchers.id as idExVoucher')
                                    ->where('vouchers.id', $id)
                                    ->get();
        if (count($data['list']) == config('constants.ZERO')) {
            $data['message'] = trans('voucher.message_null_user_register');
        }
        return $data;
    }

    /**
     * List voucher of user
     *
     * @return mixed
     */
    public function listVouchersUser()
    {
        return $this->model->join('vouchers', 'exchange_vouchers.voucher_id', '=', 'vouchers.id')
                           ->where('user_id', Auth::user()->id)
                           ->select('exchange_vouchers.*', 'vouchers.name', 'vouchers.point', 'vouchers.value')
                           ->get();
    }

    /**
     * Register voucher of user
     *
     * @param int $voucherId [description]
     *
     * @return void
     */
    public function registerVoucher($voucherId)
    {
        $this->model->create(['user_id' => Auth::user()->id, 'voucher_id' => $voucherId]);
    }

    /**
     * Accept voucher of user
     *
     * @param int $exchangeVoucherId [description]
     *
     * @return void
     */
    public function acceptVoucher($exchangeVoucherId)
    {
        $this->model->where('id', $exchangeVoucherId)->update(['status' => config('constants.STATUS_RECEIVED')]);
    }
}
