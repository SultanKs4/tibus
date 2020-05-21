<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Payment;

class PaymentController extends Controller
{
    public function get(Request $request)
    {
        $id = $request->id;
        $data = Payment::select('payment.id', 'akun.email as akun', 'payment.total', 'payment_method.name as method', 'payment.bukti_bayar', 'payment_status.name as status')
            ->join('akun', 'payment.id_akun', '=', 'akun.id')
            ->join('payment_method', 'payment.metode_bayar', '=', 'payment_method.id')
            ->join('payment_status', 'payment.status', '=', 'payment_status.id')
            ->when($id, function ($query, $id) {
                return $query->where('payment.id', $id);
            })->get();

        if (count($data) > 0) {
            $res['status'] = true;
            $res['data'] = $data;
            return response($res);
        } else {
            $res['status'] = false;
            return response($res);
        }
    }

    public function create(Request $request)
    {
        $data = new Payment();
        $data->id_akun = $request->id_akun;
        $data->total = $request->total;
        $data->metode_bayar = $request->metode_bayar;
        // $data->bukti_bayar = $request->bukti_bayar;
        $data->status = $request->status;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data payment ditambahkan";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal membuat data payment";
            return response($res);
        }
    }

    public function update(Request $request)
    {
        $data = Payment::find($request->id);
        $data->id_akun = $request->id_akun;
        $data->total = $request->total;
        $data->metode_bayar = $request->metode_bayar;
        $data->bukti_bayar = $request->bukti_bayar;
        $data->status = $request->status;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data payment diubah";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal mengubah data payment";
            return response($res);
        }
    }

    public function delete(Request $request)
    {
        if ($request->id == null) {
            $res['status'] = false;
            $res['message'] = "id not provided!";
            return response($res);
        } else {
            $data = Payment::where('id', $request->id);

            if ($data->delete()) {
                $res['status'] = true;
                $res['message'] = "payment deleted";
                return response($res);
            } else {
                $res['status'] = false;
                $res['message'] = "payment fail to delete";
                return response($res);
            }
        }
    }
}
