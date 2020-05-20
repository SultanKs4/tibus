<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Akun;

class AkunController extends Controller
{
    public function get($id = null)
    {
        $data = Akun::select('akun.id', 'akun.email', 'akun.nama_depan', 'akun.nama_belakang', 'akun.telpon', 'level.name')
            ->join('level', 'akun.id_level', '=', 'level.id')
            ->when($id, function ($query, $id) {
                return $query->where('akun.id', $id);
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

    public function login(Request $request)
    {
        $email = $request->email;
        $password = hash('sha512', $request->password);

        $data = Akun::select('id', 'email', 'id_level')->where('email', $email)->where('password', $password)->limit(1)->get();

        if (count($data) > 0) {
            $res['status'] = true;
            $res['message'] = "Username dan password benar";
            $res['data'] = $data;
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "Username dan password salah";
            return response($res);
        }
    }

    public function create(Request $request)
    {
        $akun = new Akun();
        $akun->email = $request->email;
        $akun->nama_depan = $request->nama_depan;
        $akun->nama_belakang = $request->nama_belakang;
        $akun->telpon = $request->telpon;
        $akun->password = hash('sha512', $request->password);
        $akun->id_level = $request->id_level;

        if ($akun->save()) {
            $res['status'] = true;
            $res['message'] = "Data akun ditambahkan";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal membuat data akun";
            return response($res);
        }
    }

    public function update(Request $request)
    {
        $data = Akun::find($request->id);
        $data->email = $request->email;
        $data->nama_depan = $request->nama_depan;
        $data->nama_belakang = $request->nama_belakang;
        $data->telpon = $request->telpon;
        $data->password = hash('sha512', $request->password);
        $data->id_level = $request->id_level;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data akun diubah";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal mengubah data akun";
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
            $data = Akun::where('id', $request->id);

            if ($data->delete()) {
                $res['status'] = true;
                $res['message'] = "akun deleted";
                return response($res);
            } else {
                $res['status'] = false;
                $res['message'] = "akun fail to delete";
                return response($res);
            }
        }
    }
}
