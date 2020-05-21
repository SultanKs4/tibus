<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Tiket;
use App\Payment;
use App\Trayek;

class TiketController extends Controller
{
    public function get(Request $request)
    {
        $id = $request->id;
        $data = Tiket::select('tiket.id', 'tiket.nama_penumpang', 'tiket.no_ktp_penumpang', 'tiket.no_duduk', 'akun.email', 'tiket.id_trayek', 'tiket.id_duduk', 'tiket.id_payment')
            ->join('akun', 'tiket.id_akun', '=', 'akun.id')
            ->when($id, function ($query, $id) {
                return $query->where('tiket.id', $id);
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

    public function trans(Request $request)
    {
        $dataPayment = new Payment();
        $dataPayment->id_akun = $request->id_akun;
        $dataPayment->total = $request->total;
        $dataPayment->metode_bayar = $request->metode_bayar;
        $dataPayment->status = $request->status;

        $dataTiket = new Tiket();
        $dataTiket->nama_penumpang = $request->nama_penumpang;
        $dataTiket->no_ktp_penumpang = $request->no_ktp_penumpang;
        $dataTiket->no_duduk = $request->no_duduk;
        $dataTiket->id_akun = $request->id_akun;
        $dataTiket->id_trayek = $request->id_trayek;
        $dataTiket->id_duduk = $request->id_duduk;

        $dataTrayek = Trayek::find($request->id_trayek);
        $dataTrayek->id_po = $request->id_po;
        $dataTrayek->dari = $request->dari;
        $dataTrayek->tujuan = $request->tujuan;
        $dataTrayek->jam_berangkat = $request->jam_berangkat;
        $dataTrayek->jam_tiba = $request->jam_tiba;
        $dataTrayek->tanggal_berangkat = $request->tanggal_berangkat;
        $dataTrayek->tanggal_tiba = $request->tanggal_tiba;
        $dataTrayek->harga = $request->harga;
        $dataTrayek->sisa_kursi = $request->sisa_kursi;

        try {
            DB::transaction(function () use ($dataPayment, $dataTiket, $dataTrayek) {
                $dataPayment->save();
                $dataTiket->id_payment = $dataPayment->id;
                $dataTiket->save();
                $dataTrayek->save();
            });
            $result = true;
        } catch (\Exception $th) {
            $result = false;
        }

        if ($result) {
            $res['status'] = true;
            $res['message'] = "Data Tiket ditambahkan";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal membuat data Tiket";
            return response($res);
        }
    }

    public function create(Request $request)
    {
        $data = new Tiket();
        $data->nama_penumpang = $request->nama_penumpang;
        $data->no_ktp_penumpang = $request->no_ktp_penumpang;
        $data->no_duduk = $request->no_duduk;
        $data->id_akun = $request->id_akun;
        $data->id_trayek = $request->id_trayek;
        $data->id_payment = $request->id_payment;
        $data->id_duduk = $request->id_duduk;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data Tiket ditambahkan";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal membuat data Tiket";
            return response($res);
        }
    }

    public function update(Request $request)
    {
        $data = Tiket::find($request->id);
        $data->nama_penumpang = $request->nama_penumpang;
        $data->no_ktp_penumpang = $request->no_ktp_penumpang;
        $data->no_duduk = $request->no_duduk;
        $data->id_akun = $request->id_akun;
        $data->id_trayek = $request->id_trayek;
        $data->id_payment = $request->id_payment;
        $data->id_duduk = $request->id_duduk;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data Tiket diubah";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal mengubah data Tiket";
            return response($res);
        }
    }

    public function getBooked(Request $request)
    {
        $id_trayek = $request->id_trayek;
        $data = Tiket::select('id_duduk')->where('id_trayek', $id_trayek)->get();

        if (count($data) > 0) {
            $res['status'] = true;
            $res['data'] = $data;
            return response($res);
        } else {
            $res['status'] = false;
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
            $data = Tiket::where('id', $request->id);

            if ($data->delete()) {
                $res['status'] = true;
                $res['message'] = "Tiket deleted";
                return response($res);
            } else {
                $res['status'] = false;
                $res['message'] = "Tiket fail to delete";
                return response($res);
            }
        }
    }
}
