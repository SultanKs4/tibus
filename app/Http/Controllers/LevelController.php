<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Level;

class LevelController extends Controller
{
    public function get($id = null)
    {
        if ($id == null) {
            $data = Level::all();
        } else {
            $data = Level::where('id', $id)->get();
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
        $data = new Level();
        $data->name = $request->name;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data level ditambahkan";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal membuat data level";
            return response($res);
        }
    }

    public function update(Request $request)
    {
        $data = Level::find($request->id);
        $data->name = $request->name;

        if ($data->save()) {
            $res['status'] = true;
            $res['message'] = "Data level diubah";
            return response($res);
        } else {
            $res['status'] = false;
            $res['message'] = "gagal mengubah data level";
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
            $data = Level::where('id', $request->id);

            if ($data->delete()) {
                $res['status'] = true;
                $res['message'] = "level deleted";
                return response($res);
            } else {
                $res['status'] = false;
                $res['message'] = "level fail to delete";
                return response($res);
            }
        }
    }
}
