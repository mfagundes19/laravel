<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ReceivementUpload extends Model
{
    use HasFactory;

    protected $table = ("receivement_upload");
}
