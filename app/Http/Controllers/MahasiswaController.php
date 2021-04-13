<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetak_pdf($nim){
        $mahasiswa = Nilai::with('mahasiswa')
            ->where('mahasiswa_id', $nim)
            ->first();
        $nilai = Nilai::with('matakuliah')
            ->where('mahasiswa_id', $nim)
            ->get();
        $pdf = PDF::loadview('users.nilai', compact('mahasiswa', 'nilai'));
        return $pdf->stream();
    }

    public function index(Request $request)
    {
        // $mahasiswa = Mahasiswa::where([
        //     ['nama','!=',Null],
        //     [function($query)use($request){
        //         if (($term = $request->term)) {
        //             $query->orWhere('nama','LIKE','%'.$term.'%')->get();
        //         }
        //     }]
        // ])
        // ->orderBy('nim','desc')
        // ->simplePaginate(5);
        
        // return view('users.index' , compact('mahasiswa'))
        // ->with('i',(request()->input('page',1)-1)*5);

        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('nim','asc')->simplePaginate(3);
        return view('users.index',['mahasiswa'=>$mahasiswa,'paginate'=>$paginate]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('users.create',['kelas' =>$kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas_Id' => 'required',
            'Jurusan' => 'required',
            ]);

            if($request->file('image')){
                $image_name = $request->file('image')->store('images', 'public');
            } else {
                $image_name = 'images/user.png';
            }
            // Mahasiswa::create([
            //     'image' => $image_name,
            // ]);

            $mahasiswa  = New Mahasiswa;
            $mahasiswa->nim = $request->get('Nim');
            $mahasiswa->nama = $request->get('Nama');
            $mahasiswa->jurusan = $request->get('Jurusan');
            $mahasiswa->kelas_id = $request->get('Kelas_Id');
            $mahasiswa->image = $image_name;
            $mahasiswa->save();
   
            // $kelas = new Kelas;
            // $kelas->id = $request->get('Kelas_Id');


        //fungsi eloquent untuk menambah data dengan relasi belongsTo
            // $mahasiswa->kelas()->associate($kelas);
            // $mahasiswa->save();
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
        }
       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim',$nim)->first();
        return view('users.detail', ['Mahasiswa'=>$Mahasiswa]);
    }
    public function Nilai($nim){
        $mahasiswa = Nilai::with('mahasiswa')
        ->where('mahasiswa_id',$nim)
        ->first();
         $nilai = Nilai::with('matakuliah')
        ->where('mahasiswa_id',$nim)
        ->get();
    return view('users.nilai', compact('mahasiswa', 'nilai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim',$nim)->first();
        $kelas =Kelas::all();
         return view('users.edit', compact('Mahasiswa','kelas'));
    }
    public function update(Request $request, $nim)
    {//melakukan validasi data
         $request->validate([
         'Nim' => 'required',
         'Nama' => 'required',
         'image' => 'required',
         'Kelas' => 'required',
         'Jurusan' => 'required',
         ]);
         $mahasiswa = Mahasiswa::find($nim);
         if($request->file('image')){
            if($mahasiswa->image != 'images/user.png' && file_exists(storage_path('app/public/' . $mahasiswa->image))){
                Storage::delete('public/' . $mahasiswa->image);
            }
            $image_name = $request->file('image')->store('images', 'public');
            $mahasiswa->image = $image_name;
        }

        //  $mahasiswa  = Mahasiswa::with('kelas')->where('nim',$nim)->first();
         $mahasiswa->nim = $request->get('Nim');
         $mahasiswa->nama = $request->get('Nama');
         $mahasiswa->jurusan = $request->get('Jurusan');

        $mahasiswa->save();

         $kelas = new Kelas;
         $kelas->id = $request->get('Kelas');

         
        //fungsi eloquent untuk mengupdate data inputan kita
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil diupdate, akan kembali ke halaman utama
         return redirect()->route('mahasiswa.index')
         ->with('success', 'Mahasiswa Berhasil Diupdate');
    }
    public function destroy($nim)
    {
        //fungsi eloquent untuk menghapus data
         Mahasiswa::find($nim)->delete();
         return redirect()->route('mahasiswa.index')
         -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

};
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    


