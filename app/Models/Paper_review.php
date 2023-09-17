<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paper_review extends Model
{
    use HasFactory;
    protected $table='paper_review';

    public function reviewers(): BelongsTo
    {
        return $this->belongsTo(Participant::class,'reviewer_id','id');
    }

}
