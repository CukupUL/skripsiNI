<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show()
    {
        $data = [
            "user" => Auth::user()
        ];
        // dd($data);

        return \view("user.show", $data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string",
            "password" => "nullable|string",
            "foto" => "nullable|mimes:png,jpg,svg",
        ]);

        $user = Auth::user();

        $values = [
            "name" => $request->name
        ];
        if (!empty($request->password)) {
            $values["password"] = \bcrypt($request->password);
        }
        // dd($request->hasFile("foto"));
        if ($request->hasFile("foto")) {
            $file = $request->file("foto");
            $file_name = $file->hashName();
            $file->move("./img/profile/", $file_name);
            $values["foto"] = $file_name;
        
            $array_foto = \explode("/", $user->foto);
            if (\file_exists("./img/profile/" . end($array_foto))) {
                \unlink("./img/profile/" . end($array_foto));
            }
        }

        // dd($values);
        User::find($user->id)->update($values);

        return \back()->with("message", "<script>alert('Sukses update profile!')</script>");
    }
}
