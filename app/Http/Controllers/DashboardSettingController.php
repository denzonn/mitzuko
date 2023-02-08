<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSettingController extends Controller
{
    public function account()
    {
        $user = Auth::user();
        return view('pages.dashboard-settings-account', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        // Ubah path dari photo
        // $data['photo'] = $request->file('photo')->store(
        //     'assets/user',
        //     'public'
        // );
        if ($request->hasFile('photo')) {
            $images = $request->file('photo');

            $extension = $images->getClientOriginalExtension();

            $random = \Str::random(10);
            $file_name = "profil" . $random . "." . $extension;

            $images->storeAs('public/assets/users', $file_name);
            $data['photo'] = 'public/assets/users' . '/' . $file_name;
        }

        $item = Auth::user();
        $users = $item->update($data);

        return redirect()->route('dashboard-settings-account');
    }
}
