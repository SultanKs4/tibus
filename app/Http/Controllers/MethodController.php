<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Method;

class MethodController extends Controller
{
    public function get($id = null)
    {
        if ($id == null) {
            $data = Method::all();
        } else {
            $data = Method::where('id', $id)->get();
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
        $akun = new Method();
        $akun->name = $request->name;
        $akun->no = $request->no;
        $akun->an = $request->an;

        if ($akun->save()) {
            $res['status'] = true;
            $res['message'] = "Data payment method ditambahkan";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal membuat data payment method";
            return response($res);
        }
    }

    public function update(Request $request)
    {
        $data = Method::find($request->id);
        $data->name = $request->name;
        $data->no = $request->no;
        $data->an = $request->an;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data payment method diubah";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal mengubah data payment method";
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
            $data = Method::where('id', $request->id);

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
