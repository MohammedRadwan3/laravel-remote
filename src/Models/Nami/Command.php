<?php

namespace src\Models\Nami;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;
    protected $table = 'commands';
    protected $fillable = ['command'];
}
