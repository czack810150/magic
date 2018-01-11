<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll_log extends Model
{
    //
    public function employee(){
    	return $this->belongsTo('App\Employee');
    }
    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function getRegularPayAttribute($value)
    {
    	return $value/100;
    }
    public function getOvertimePayAttribute($value)
    {
    	return $value/100;
    }
    public function getGrossIncomeAttribute($value)
    {
    	return $value/100;
    }
    public function getVacationPayAttribute($value)
    {
        return $value/100;
    }
    public function getEIAttribute($value)
    {
    	return $value/100;
    }
    public function getCPPAttribute($value)
    {
    	return $value/100;
    }
    public function getFederalTaxAttribute($value)
    {
    	return $value/100;
    }
    public function getProvincialTaxAttribute($value)
    {
    	return $value/100;
    }
    public function getChequeAttribute($value)
    {
    	return $value/100;
    }
    public function getPositionRateAttribute($value)
    {
    	return $value/100;
    }
    public function getHourlyTipAttribute($value)
    {
    	return $value/100;
    }
    public function getMealRateAttribute($value)
    {
    	return $value/100;
    }
    public function getNightRateAttribute($value)
    {
    	return $value/100;
    }
    public function getBonusAttribute($value)
    {
    	return $value/100;
    }
    public function getVariablePayAttribute($value)
    {
    	return $value/100;
    }
    public function getTotalPayAttribute($value)
    {
    	return $value/100;
    }
    public function getPremiumPayAttribute($value)
    {
    	return $value/100;
    }
    public function getHolidayPayAttribute($value)
    {
    	return $value/100;
    }
}
