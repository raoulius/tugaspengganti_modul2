<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function create()
    {
        return view('admin.add');
    }

    // public function store the value to a table
    /* function store memiliki fungsi untuk memasuki value valuenya kedalam tabel database. $request->validate ada untuk 
    memastikan bahwa id_admin dll tidak memiliki nilai null. 

    DB::insert digunakan untuk insert ke admin dan memasuki value yang dikasih dalam VALUES. 

    dan string'Data Admin berhasil disimpan untuk mengabari bahwa prosesnya berhasil. 
    */
    public function store(Request $request)
    {
        $request->validate([
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        DB::insert(
            'INSERT INTO admin(id_admin,nama_admin, alamat, username, password) VALUES (:id_admin, :nama_admin, :alamat, :username, :password)',
            [
                'id_admin' => $request->id_admin,
                'nama_admin' => $request->nama_admin,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $request->password,
            ]
        );
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil disimpan');
    }

    // public function show all values from a table
    /*dalam function index menggunakan DB::select dan syntax SQL untuk mengambil data/value
    dari tabel admin dan * untuk mengambil semua valuenya, lalu dimasukan ke $datas.

    menggunakan view buat menampilkan data/value yang ada di $datas yang sudah ditarik dari tabel admin
     */
    public function index()
    {
        $datas = DB::select('select * from admin');
        return view('admin.index')->with('datas', $datas);
    }

    // public function edit a row from a table
    /* function edit ini digunakan untuk mengedit satu row dari tabel admin
    $data akan tempat penyimpanannya dan menggunakan DB::table untuk memilih tabel admin. lalu dengan where,
    menunjuk apa yang ingin diambil.

    lalu yang di edit itu yang akan di return. 
    */
    public function edit($id)
    {
        $data = DB::table('admin')->where('id_admin', $id)->first();
        return view('admin.edit')->with('data', $data);
    }

    // public function to update the table value
    /* function update menggunakan DB::update untuk mengupdate records yang sudah ada di dalam databasenya,
    hanya kepada rows yang ditujukannya. Dan yang ditujukan pada function ini ditunjuk menggunakan UPDATE admin SET
    id_admin = : id_admin dll adalah yang ingin di update. 

    Lalu dari semua yang di update itulah yang di return. 
    */
    public function update($id, Request $request)
    {
        $request->validate([
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        DB::update(
            'UPDATE admin SET id_admin = :id_admin, nama_admin = :nama_admin, alamat = :alamat, username = :username, password = :password WHERE id_admin = :id',
            [
                'id' => $id,
                'id_admin' => $request->id_admin,
                'nama_admin' => $request->nama_admin,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $request->password,
            ]
        );

        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil diubah');
    }

    // public function to delete a row from a table
    /* function delete digunakan untuk menghapuskan records dari databasenya. dengan menunjukkan
    DELETE FROM admin WHERE id_admin. Menunjuk untuk membuka tabel admin dan bagian id_admin. 
    mirip seperti DB::update tetapi menghapus. 

    lalu dari rows data yang di delete itulah yang akan di return. 
    */
    public function delete($id)
    {
        DB::delete('DELETE FROM admin WHERE id_admin = :id_admin', ['id_admin' => $id]);
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil dihapus');
    }
}
