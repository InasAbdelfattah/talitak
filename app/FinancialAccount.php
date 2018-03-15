<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialAccount extends Model
{
 
    protected $table = 'financial_accounts' ;
    
    public function Company()
    {
        return $this->belongsTo(Company::class , 'company_id');

    }

    
}
