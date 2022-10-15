<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RegistrasiPasien;
// use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\Facade\Pdf;
use PDF;
use DateTime;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
            // dd($data);
            $id = Pasien::select('pasiens.id as pasien_id')->get()->last();
            if ($id == null) {
                $id = 1;
            }
            // dd($id['pasien_id']);
            $id  = substr($id['pasien_id'], 4);
            $id = (int) $id;
            $id += 1;
            $id  = "PS" . str_pad($id, 4, "0", STR_PAD_LEFT);

            return response()->json(['data' => $data, 'id' => $id, 'message' => 'Successfully.', 'status' => 'success']);
        } else {
            $data = Pasien::join('registrasi_pasiens', 'pasiens.id', '=', 'registrasi_pasiens.pasien_id')
                ->where('pasiens.id', $request->param)
                ->select(
                    'pasiens.id as pasien_id',
                    'pasiens.nama',
                    'pasiens.no_ktp',
                    'pasiens.jenis_kelamin',
                    'pasiens.tgl_lahir',
                    'pasiens.pekerjaan',
                    'pasiens.no_hp',
                    'pasiens.alamat',
                    'pasiens.dokter_id',
                    'registrasi_pasiens.id as regis_id'
                )
                ->first();

            $lahir = new DateTime($data->tgl_lahir);
            $today = new DateTime(date('Y-m-d'));
            $umur = $today->diff($lahir)->y;

            $id = Pasien::select('id')->get()->last();
            if ($id == null) {
                $id = 1;
            }
            $id  = substr($id['id'], 4);
            $id = (int) $id;
            $id += 1;
            $id  = "PS" . str_pad($id, 4, "0", STR_PAD_LEFT);

            return response()->json(['data' => $data, 'umur' => $umur, 'message' => 'Successfully.', 'status' => 'success']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = new Pasien();
        $store->id = $request->id;
        $store->nama = $request->nama;
        $store->no_ktp = $request->no_ktp;
        $store->jenis_kelamin = $request->jenis_kelamin;
        $store->tgl_lahir = $request->tgl_lahir;
        $store->pekerjaan = $request->pekerjaan;
        $store->no_hp = $request->no_hp;
        $store->alamat = $request->alamat;
        $store->dokter_id = $request->dokter_id;
        $store->save();

        $store1 = new RegistrasiPasien();
        $store1->pasien_id = $request->id;
        $store1->dokter_id = $request->dokter_id;
        $store1->jenis_pembayaran = $request->jenis_pembayaran;
        $store1->status = "antri";
        $store1->tgl = date('Y-m-d');
        $store1->save();
        return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan!', 'data' => $this->filter($request)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pasien::where('id', $id)->first();
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Pasien::where('id', $id)->update([
            'nama' => $request->nama,
            'no_ktp' => $request->no_ktp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir' => $request->tgl_lahir,
            'pekerjaan' => $request->pekerjaan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'dokter_id' => $request->dokter_id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil diubah!', 'data' => $this->filter($request)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        dd($id);
        if ($id == null) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus!', 'errors' => 'ID kosong']);
        }

        Pasien::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Pasien::when(!empty($search), function ($query) use ($search) {
            $query->where('nama', 'LIKE', '%' . $search . '%')
                ->orwhere('no_ktp', 'LIKE', '%' . $search . '%')
                ->orwhere('id', 'LIKE', '%' . $search . '%');
        })
            // ->join('dokters', 'pasiens.dokter_id', '=', 'dokters.id')
            //     ->join('users', 'dokters.user_id', '=', 'users.id')
            ->orderBy($request->sortBy, $request->orderBy)
            ->select(
                'pasiens.id as pasien_id',
                'pasiens.nama',
                'pasiens.no_ktp',
                'pasiens.jenis_kelamin',
                'pasiens.tgl_lahir',
                'pasiens.pekerjaan',
                'pasiens.no_hp',
                'pasiens.alamat',
                'pasiens.dokter_id',
                // 'users.name as user_nama'
            )
            ->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }

    public function statusUpdate(Request $request)
    {
        // dd($id, $request->status);
        // RegistrasiPasien::where('id', $id)->update([
        //     'status'    => "antri",
        // ]);

        $store = new RegistrasiPasien();
        $store->pasien_id = $request->pasien_id;
        $store->dokter_id = $request->dokter_id;
        $store->jenis_pembayaran = $request->jenis_pembayaran;
        $store->status = 'antri';
        $store->tgl = date('Y-m-d');
        $store->save();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil diubah!', 'data' => $this->filter($request)]);
    }

    public function statusRemove(Request $request, $id)
    {
        RegistrasiPasien::where('id', $id)->update([
            'status'    => "Belum Selesai",
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil diubah!', 'data' => $this->filter($request)]);
    }

    public function statusGetAntri()
    {
        $data = Pasien::join('registrasi_pasiens', 'pasiens.id', '=', 'registrasi_pasiens.pasien_id')
            ->where('registrasi_pasiens.status', '=', 'antri')
            ->select('registrasi_pasiens.id', 'registrasi_pasiens.status', 'pasiens.nama', 'registrasi_pasiens.tgl', 'pasiens.id as pasien_id')->get();
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
    public function statusGetSelesai()
    {
        $data = Pasien::join('registrasi_pasiens', 'pasiens.id', '=', 'registrasi_pasiens.pasien_id')
            ->where('registrasi_pasiens.tgl', '=', date('Y-m-d'))
            ->where('registrasi_pasiens.status', '=', 'selesai')
            ->select('pasiens.id', 'registrasi_pasiens.status', 'pasiens.nama', 'registrasi_pasiens.tgl')->get();
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
    public function statusGet()
    {
        $data = Pasien::join('registrasi_pasiens', 'pasiens.id', '=', 'registrasi_pasiens.pasien_id')
            ->where('registrasi_pasiens.tgl', '=', date('Y-m-d'))
            ->select('pasiens.id', 'registrasi_pasiens.status', 'pasiens.nama', 'registrasi_pasiens.tgl')->get();
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    public function printPdf(Request $request, $id)
    {
        // dd($id);
        $data = Pasien::where('id', $id)->first();
        // dd($data);
        // $customPaper = array(0,0,567.00,283.80);
        $pdf = PDF::loadview('pdf.kartuberobat_pdf', ['data' => $data]);
        // dd($pdf);
        return $pdf->download('kartu-berobat.pdf');
    }
}
