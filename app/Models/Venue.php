<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venue extends Model
{
    use HasFactory;
    protected $table = 'venue';
    protected $primaryKey = 'id';

//    public function submissionType(): BelongsTo
//    {
//        return $this->belongsTo(Paper::class,'submission_type_id','id');
//    }

}
