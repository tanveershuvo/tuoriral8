<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SubmissionType extends Model
{
    use HasFactory;

    protected $table = "submissiontype";
    protected $primaryKey = 'id';

    public function submissionType(): BelongsTo
    {
        return $this->belongsTo(Paper::class,'submission_type_id','id');
    }

    public function venue(): HasOne
    {
        return $this->hasOne(Venue::class,'id','venue_id');
    }

}
