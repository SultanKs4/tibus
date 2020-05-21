<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Terminal;

class TerminalController extends Controller
{
    public function get(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            $data = Terminal::all();
        } else {
            $data = Terminal::where('id', $id)->get();
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
        $data = new Terminal();
        $data->nama = $request->nama;
        $data->kota = $request->kota;
        $data->alamat = $request->alamat;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data Terminal ditambahkan";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal membuat data Terminal";
            return response($res);
        }
    }

    public function update(Request $request)
    {
        $data = Terminal::find($request->id);
        $data->nama = $request->nama;
        $data->kota = $request->kota;
        $data->alamat = $request->alamat;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data Terminal diubah";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal mengubah data Terminal";
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
            $data = Terminal::where('id', $request->id);

            if ($data->delete()) {
                $res['status'] = true;
                $res['message'] = "Terminal deleted";
                return response($res);
            } else {
                $res['status'] = false;
                $res['message'] = "Terminal fail to delete";
                return response($res);
            }
        }
    }
}
