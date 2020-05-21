<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Status;

class StatusController extends Controller
{
    public function get($id = null)
    {
        if ($id == null) {
            $data = Status::all();
        } else {
            $data = Status::where('id', $id)->get();
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
        $data = new Status();
        $data->name = $request->name;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data Payment Status ditambahkan";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal membuat data Payment Status";
            return response($res);
        }
    }

    public function update(Request $request)
    {
        $data = Status::find($request->id);
        $data->name = $request->name;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data Payment Status diubah";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal mengubah data Payment Status";
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
            $data = Status::where('id', $request->id);

            if ($data->delete()) {
                $res['status'] = true;
                $res['message'] = "Payment Status deleted";
                return response($res);
            } else {
                $res['status'] = false;
                $res['message'] = "Payment Status fail to delete";
                return response($res);
            }
        }
    }
}
