<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Beritaacara;
use App\Models\Jenistiket;
use App\Models\Teamlist;
use App\Models\Tiketlist;
use App\Models\Tikettim;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Analytics extends Controller
{
  public function index()
  {
    $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
    $bln = '02';

    // date('m')
    //psb
    $inputpsb = Tiketlist::where(function ($query) use ($bln) {
      $query->whereMonth('created_at', $bln);
    })->whereHas('jenistiket', function ($query) {
      $query->where('id', '2');
    })->count();

    $updatedpsb = Tikettim::where(function ($query) use ($bln) {
      $query->whereMonth('created_at', $bln);
    })->whereHas('tiketlist', function ($query) {
      $query->whereHas('jenistiket', function ($query) {
        $query->where('id', '2');
      });
    })->count();

    $bapsb = Beritaacara::whereMonth('created_at', $bln)->whereHas('teamdetail', function ($query){
      $query->whereHas('jobdesk', function ($query) {
        $query->where('id', '3');
      });
    })->count();

    //ggn
    $inputggn = Tiketlist::where(function ($query) use ($bln) {
      $query->whereMonth('created_at', $bln);
    })->whereHas('jenistiket', function ($query) {
      $query->where('id', '1');
    })->count();

    $updatedggn = Tikettim::where(function ($query) use ($bln) {
      $query->whereMonth('created_at', $bln);
    })->whereHas('tiketlist', function ($query) {
      $query->whereHas('jenistiket', function ($query) {
        $query->where('id', '1');
      });
    })->count();

    $baggn = Beritaacara::whereMonth('created_at', $bln)->whereHas('teamdetail', function ($query){
      $query->whereHas('jobdesk', function ($query) {
        $query->where('id', '7');
      });
    })->count();

    //mtn
    $inputmtn = Tiketlist::where(function ($query) use ($bln) {
      $query->whereMonth('created_at', $bln);
    })->whereHas('jenistiket', function ($query) {
      $query->where('id', '3');
    })->count();

    $updatedmtn = Tikettim::where(function ($query) use ($bln) {
      $query->whereMonth('created_at', $bln);
    })->whereHas('tiketlist', function ($query) {
      $query->whereHas('jenistiket', function ($query) {
        $query->where('id', '3');
      });
    })->count();

    $bamtn = Beritaacara::whereMonth('created_at', $bln)->whereHas('teamdetail', function ($query){
      $query->whereHas('jobdesk', function ($query) {
        $query->where('id', '8');
      });
    })->count();

    //total
    $inputtotal = Tiketlist::where(function ($query) use ($bln) {
      $query->whereMonth('created_at', $bln);
    })->count();

    $updatedtotal = Tikettim::where(function ($query) use ($bln) {
      $query->whereMonth('created_at', $bln);
    })->count();

    $batotal = Beritaacara::where(function ($query) use ($bln) {
      $query->whereMonth('created_at', $bln);
    })->count();


    //hitung jumlah
    $tim = auth()->user()->teamdetail->teamlist->list_tim ?? '';

    $jumlah = Teamlist::withCount([
      'ba' => function (Builder $query) use ($bln) {
        $query->whereMonth('updated_at', $bln);
      },
      'tikettims'  => function (Builder $query) use ($bln) {
        $query->whereMonth('updated_at', $bln);
      }, 'rekapbas'  => function (Builder $query) use ($bln) {
        $query->whereMonth('updated_at', $bln);
      }
    ])->filter(request(['jtiket']));

    //page teknisi
    $hitungTeknisi = $jumlah->whereHas('teamdetail', function ($query) use ($tim) {
      $query->whereHas('teamlist', function ($query) use ($tim) {
        $query->where('list_tim', $tim);
      });
    })->get();

    //tabel
    $hitung = Teamlist::withCount(['ba' => function (Builder $query) use ($bln) {
      $query->whereMonth('updated_at', $bln);
    }, 'tikettims'  => function (Builder $query) use ($bln) {
      $query->whereMonth('updated_at', $bln);
    }, 'rekapbas'  => function (Builder $query) use ($bln) {
      $query->whereMonth('updated_at', $bln);
    }])->filter(request(['jtiket']))->get();

    //jenis tiket
    $jenistiket = Jenistiket::all();

    return view('content.dashboard.dashboards-analytics', compact([
      'tglnow',
      'inputpsb',
      'updatedpsb',
      'inputggn',
      'updatedggn',
      'inputmtn',
      'updatedmtn',
      'inputtotal',
      'updatedtotal',
      'hitung',
      'jenistiket',
      'hitungTeknisi',
      'bapsb',
      'baggn',
      'bamtn',
      'batotal'
    ]));
  }
}
