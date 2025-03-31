<?php

namespace App\Http\Controllers;

use App\Models\OrderMaster;
use App\Models\CustomVoucher;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use Illuminate\Support\Facades\DB;  // Add this import
use Illuminate\Support\Facades\Log; // Add this import
use Illuminate\Support\Str;
use App\Helper\CommonHelper;

use Exception;

class OrderController extends Controller
{
    public function save_order(StoreOrderRequest $request)
    {

        $orderRequest = $request->all();
        $orderMaster =(object)$orderRequest['orderMaster'];
        $orderDetails =$orderRequest['orderDetails'];


        DB::beginTransaction();
        try {
            $voucherName="ORD";
            $accountingYear=CommonHelper::getCurrentAccountingYear();
            //creating automatic voucher
            $voucher = DB::transaction(function () use ($voucherName, $accountingYear) {
                return CustomVoucher::updateOrCreate(
                    // First array: The attributes to find the record
                    [
                        'voucher_name' => $voucherName,
                        'accounting_year' => $accountingYear
                    ],
                    // Second array: The values to update or create
                    [
                        'last_counter' => DB::raw('IFNULL(last_counter, 0) + 1'),
                        'prefix'=> $voucherName,
                        'delimiter' => '-',
                        'inforce' => 1,
                        'min_digits' => 4
                    ]
                );
            });

            $newVoucher=$voucher->fresh();
            $voucherNumber=$newVoucher->prefix.$newVoucher->delimiter.str_pad((string)$newVoucher->last_counter, $newVoucher->min_digits, '0', STR_PAD_LEFT).$newVoucher->delimiter.$newVoucher->accounting_year;


            $orderMaster = OrderMaster::create([
                'order_number'=>$voucherNumber,
                // 'customer_id'=>$request->input('orderMaster.customerId'),
                'customer_id'=>$orderMaster->customerId,
                'agent_id'=>$orderMaster->agentId,
                'order_note'=>$orderMaster->orderNote?? null
            ]);



            DB::commit();
            return ResponseHelper::success('Order created', $orderMaster,200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("Module not found: {$e->getMessage()}");
            return ResponseHelper::error('Module not found', 404);

        } catch (QueryException $e) {
            DB::rollBack();
            Log::error("Database error updating Order: {$e->getMessage()}");
            return ResponseHelper::error('Failed to update Order due to database error', $e->getMessage(),500);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error updating Order: {$e->getMessage()}");
            return ResponseHelper::error('Failed to update Order',$e->getMessage(), 500);
        }

    }
}
