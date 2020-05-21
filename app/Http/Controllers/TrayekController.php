<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Trayek;

class TrayekController extends Controller
{
    public function get($id = null, $asal = null, $tujuan = null, $tanggal = null)
    {
        $data = Trayek::select('po_trayek.id', 'po.nama AS po', 't1.nama as dari', 't2.nama as tujuan', 'po_trayek.jam_berangkat', 'po_trayek.jam_tiba', 'po_trayek.tanggal_berangkat', 'po_trayek.tanggal_tiba', 'po_trayek.harga', 'po_trayek.sisa_kursi')
            ->join('po', 'po_trayek.id_po', '=', 'po.id')
            ->join('terminal as t1', 'po_trayek.dari', '=', 't1.id')
            ->join('terminal as t2', 'po_trayek.tujuan', '=', 't2.id')
            ->when($id, function ($query, $id) {
                return $query->where('po_trayek.id', $id);
            })
            ->when($asal, function ($query, $asal) {
                return $query->where('po_trayek.dari', $asal);
            })
            ->when($tujuan, function ($query, $tujuan) {
                return $query->where('po_trayek.tujuan', $tujuan);
            })
            ->when($tanggal, function ($query, $tanggal) {
                return $query->where('po_trayek.tanggal_berangkat', $tanggal);
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
        $data = new Trayek();
        $data->id_po = $request->id_po;
        $data->dari = $request->dari;
        $data->tujuan = $request->tujuan;
        $data->jam_berangkat = $request->jam_berangkat;
        $data->jam_tiba = $request->jam_tiba;
        $data->tanggal_berangkat = $request->tanggal_berangkat;
        $data->tanggal_tiba = $request->tanggal_tiba;
        $data->harga = $request->harga;
        $data->sisa_kursi = $request->sisa_kursi;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data PO Trayek ditambahkan";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal membuat data PO Trayek";
            return response($res);
        }
    }

    public function update(Request $request)
    {
        $data = Trayek::find($request->id);
        $data->id_po = $request->id_po;
        $data->dari = $request->dari;
        $data->tujuan = $request->tujuan;
        $data->jam_berangkat = $request->jam_berangkat;
        $data->jam_tiba = $request->jam_tiba;
        $data->tanggal_berangkat = $request->tanggal_berangkat;
        $data->tanggal_tiba = $request->tanggal_tiba;
        $data->harga = $request->harga;
        $data->sisa_kursi = $request->sisa_kursi;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data PO Trayek diubah";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal mengubah data PO Trayek";
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
            $data = Trayek::where('id', $request->id);

            if ($data->delete()) {
                $res['status'] = true;
                $res['message'] = "PO Trayek deleted";
                return response($res);
            } else {
                $res['status'] = false;
                $res['message'] = "PO Trayek fail to delete";
                return response($res);
            }
        }
    }
}
