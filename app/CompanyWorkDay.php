<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CompanyWorkDay extends Model
{

    protected $table = 'company_work_days' ;

    protected $fillable = [
        'company_id' , 'day' , 'from' , 'to'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
