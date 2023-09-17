<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Paper extends Model
{
    use HasFactory;

    protected $table = 'Paper';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function authors(): BelongsTo
    {
        return $this->belongsTo(Participant::class,'author_id','id');
    }

    public function submissionType(): HasOne
    {
        return $this->hasOne(SubmissionType::class,'id','submission_type_id');
    }

    public function paper_review(): HasMany
    {
        return $this->hasMany(Paper_review::class,'paper_id','id');
    }

}
