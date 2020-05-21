<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Po;

class PoController extends Controller
{
    public function get(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            $data = Po::all();
        } else {
            $data = Po::where('id', $id)->get();
        }

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
        $data = new Po();
        $data->nama = $request->nama;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data PO ditambahkan";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal membuat data PO";
            return response($res);
        }
    }

    public function update(Request $request)
    {
        $data = Po::find($request->id);
        $data->nama = $request->nama;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data PO diubah";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal mengubah data PO";
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
            $data = Po::where('id', $request->id);

            if ($data->delete()) {
                $res['status'] = true;
                $res['message'] = "PO deleted";
                return response($res);
            } else {
                $res['status'] = false;
                $res['message'] = "PO fail to delete";
                return response($res);
            }
        }
    }
}
