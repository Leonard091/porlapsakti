<?php

namespace App\Http\Controllers;

use App\Models\Profiluser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class usersController extends Controller
{
    public function index(){
        // mengambil data dari table
        $user = DB::table('users')
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->leftJoin('profilusers', 'users.id','=','profilusers.user_id')
            ->select('users.id', 'users.username', 'roles.nama_role', 'profilusers.nama_pj', 
            'profilusers.alamat', 'profilusers.no_wa')
            ->union(
                DB::table('users')
                    ->rightJoin('roles', 'roles.id', '=', 'users.role_id')
                    ->rightJoin('profilusers', 'users.id','=','profilusers.user_id')
                    ->select('users.id', 'users.username', 'roles.nama_role', 'profilusers.nama_pj', 
                    'profilusers.alamat', 'profilusers.no_wa')
            )
            ->get();


        // mengirim data ke view index
        return view('adminpus.users.users',compact('user'));
    }

    //hapus 
    public function destroy($id){
    	$user=User::find($id);
    	$user->delete();

    	return redirect('users');
    }

    //update 
    public function update($id){
    	
        $user = User::with('profil_user')->findOrFail($id);
        // passing data pegawai yang didapat ke view edit.blade.php
        return view('adminpus.users.update', compact('user'));
 
    }

    //proses update tabel user dan profil user
    public function processupdate(Request $request, $id){

        request()->validate([
            'nama_pj'       => 'required|string|min:2|max:100',
            'alamat'      => 'required|string|min:2|max:100',
            'no_wa'     =>'required|numeric|min:0',
        ]);

        //find user by id
        $user = User::find($id);
        $user = User::where('id',$id)->first();
        $user->username = $request->input('username');
        if($user->save())
        {
            $profile = Profiluser::find($id);
            $profile = Profiluser::where('user_id',$id)->first();
            $profile->nama_pj = $request->input('nama_pj');
            $profile->alamat = $request->input('alamat');
            $profile->no_wa = $request->input('no_wa');
            
            // if ($request->hasFile('photo')) {
            //     $photo = $request->file('photo');
            //     $filename = 'photo' . '-' . time() . '.' . $photo->getClientOriginalExtension();
            //     $location = public_path('images/' . $filename);
            //     Image::make($photo)->resize(1300, 362)->save($location);
            //     $profile->photo = $filename;
    
            //     $oldFilename = $profile->photo;
            //     $profile->photo = $filename;
            //     Storage::delete($oldFilename);
            // }

            $profile->save();
            if($profile){
                return redirect('users')->with('success', 'Your info are updated');
            }else{
                return redirect('users')->with('failed', 'failed info to updated');
            }
        }

        return redirect('users');
    }

     //change password
     public function userchangepw(Request $request, $id)
     {
         $this->validate($request, [
             'current_password' => 'required|string',
             'new_password_confirmation' => 'required|confirmed|min:8|string'
         ]);
         
         $user =  User::find($id);

         if (!(Hash::check($request->get('current_password'), $user->password))) {
             // The passwords matches
            //  return redirect()->back()->with("eror","Password Anda saat ini tidak cocok dengan password yang Anda berikan. Silakan coba lagi.");
            return back()->with("error","Password Anda saat ini tidak cocok dengan password yang Anda berikan. Silakan coba lagi.");
        }
          
         if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
             //Current password and new password are same
            //  return redirect()->back()->with("eror","Password Baru tidak boleh sama dengan Password Anda saat ini. Silakan pilih kata sandi lain.");
             return back()->with("error","Password Baru tidak boleh sama dengan Password Anda saat ini. Silakan pilih kata sandi lain.");
         }
 
         if(!(strcmp($request->get('new_password'), $request->get('new_password_confirmation'))) == 0){
             //New password and confirm password are not same
            //  return redirect()->back()->with("eror","Password baru harus sama dengan dengan password konfirmasi. Silakan ketik ulang.");
             return back()->with("error","Password baru harus sama dengan dengan password konfirmasi. Silakan ketik ulang.");
         }
 
         //Change Password
         $user =  User::where('id',$id)->first();
         $user -> password = bcrypt($request->get('new_password'));
         $user -> save();
          
        //  return back()->with("success","Password Berhasil Diubah !");
         if($user){
            return back()->with('success', 'Password Berhasil Diubah !');
        }else{
            return back()->with('failed', 'Password Gagal Diubah!, Silakan Coba Lagi');
        }

     
     }

    //add akun
    public function add()
    {
    
        // memanggil view tambah
        return view('adminpus.users.add');
    
    }

    //proses insert db
    public function store(Request $request){

        request()->validate([
            'username'       => 'required|string|min:2|max:100',
            'password'      => 'required|min:8|string'
        ]);

        // insert data ke table pegawai
	    $user=DB::table('users')->insert([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'remember_token' => Str::random(10)
	    ]);

        // return redirect('akun');
        // return redirect()->back()->with("success","akun berhasil ditambahkan!");
        if($user){
            return redirect('users')->with('success', 'akun berhasil ditambahkan!');
        }else{
            return redirect('users')->with('failed', 'akun gagal ditambahkan!');
        }
    }

}
