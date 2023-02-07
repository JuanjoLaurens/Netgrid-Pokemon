<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDetails;

class UserDetailsController extends Controller
{
    public function index()
    {
        return UserDetails::orderBy('created_at', 'DESC')->get();
    }

    public function store(Request $request)
    {
        $detail = new UserDetails();

        $detail->user_id = $request->detail['user_id'];
        $detail->fname = $request->detail['fname'];
        $detail->lname = $request->detail['lname'];
        $detail->bdate = $request->detail['bdate'];
        $detail->sex = $request->detail['sex'];
        $detail->city = $request->detail['city'];


        if($detail->save()){
            return $detail;
        }

        return "No se pudo guardar";


    }

    public function show($user_id)
    {
        $detail = UserDetails::where('user_id', $user_id)->get();
        return $detail->first();
    }

    public function update(Request $request, $id)
    {

        $existingDetail = UserDetails::find($id);

        if($existingDetail){
            $existingDetail->user_id = $request->detail['user_id'];
            $existingDetail->fname = $request->detail['fname'];
            $existingDetail->lname = $request->detail['lname'];
            $existingDetail->bdate = $request->detail['bdate'];
            $existingDetail->sex = $request->detail['sex'];
            $existingDetail->city = $request->detail['city'];
            $existingDetail->save();

            return $existingDetail;
        }

        return "Datos no encontrados";

    }


    public function destroy($id)
    {
        $detail = UserDetails::find($id);

        if($detail){
            $detail->delete();
            return "Datos guardados.";
        }
        return "Datos no encontrados";
    }
}
