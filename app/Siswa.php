<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
  protected $table = 'siswa';
  // protected $fillable = ['id','nis','nama','id_kelas','alamat','no_telp','id_spp'];
  protected $guarded = [];
}
