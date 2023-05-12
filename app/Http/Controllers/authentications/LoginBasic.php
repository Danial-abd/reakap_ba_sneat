<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\Jobdesk;
use App\Models\Karyawan;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginBasic extends Controller
{
  public function index()
  {
    $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
    return view('content.authentications.auth-login-basic', compact('tglnow'));
  }

  public function register()
  {
    $karyawan = Karyawan::all();
    $teamdetail = Teamdetail::all();
    $jobdesk = Jobdesk::all();
    $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');

    return view('content.authentications.auth-register-basic', compact(['jobdesk', 'karyawan', 'teamdetail','tglnow']));
  }

  public function login(Request $request)
  {
    $nik = $request->id_karyawan;
    $password = $request->password;
    $name = Karyawan::where('nik', $nik)->value('id');

    $request->validate([
      'id_karyawan' => ['required'],
      'password' => ['required'],
    ]);

    // dd(Auth::attempt(['id_karyawan' => $name, 'password' => $password]));
    if (Auth::attempt(['id_karyawan' => $name, 'password' => $password])) {

      $request->session()->regenerate();
      return redirect()->intended('/');
    }
    return redirect('/auth/login')->with('loginError', 'Username atau Password salah!!');
  }

  public function signin(Request $request)
  {
    $validate = $request->validate([
      'id_karyawan' => 'required',
      'email' => 'required',
      'password' => 'required',
      'role' => 'required',
      'role_t' => 'nullable'
    ]);

    $validate['password'] = Hash::make($validate['password']);

    User::create($validate);

    return redirect('/auth/login')->with('success', 'Data Berhasil di Simpan');
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/auth/login');
  }

  public function page()
  {
    $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
    $user = User::all();
    return view('content.authentications.auth-page', compact(['user', 'tglnow']));
  }

  public function edit($id)
  {
    $teamdetail = Teamdetail::all();
    $karyawan = Karyawan::all();
    $jobdesk = Jobdesk::all();
    $user = User::find($id);
    return view('content.authentications.auth-edit-basic', compact(['user', 'teamdetail', 'karyawan', 'jobdesk']));
  }

  public function update(Request $request, $id)
  {

    if ($request->password == null) {
      $validate = $request->validate([
        'role' => 'required',
        'id_karyawan' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'role_t' => 'nullable',
      ]);

      $user = User::find($id);
      $user->update($validate);
      return redirect('/page/user')->with('success', 'Data Berhasil di Simpan');
    } else

      $validate = $request->validate([
        'role' => 'required',
        'id_karyawan' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable',
        'role_t' => 'nullable',
      ]);

    $validate['password'] = Hash::make($validate['password']);

    $user = User::find($id);
    $user->update($validate);
    return redirect('/page/user')->with('success', 'Data Berhasil di Simpan');
  }
}
