<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Cra extends Model
{

	public static function payStub($grossIncome,$D = 0,$D1 = 0,$P,$year,$zone,$code)
	{
		if($zone == 'ON'){
			$ca = 'CA';
		}
			$stub = new PayStub();
			$stub->grossIncome = $grossIncome;
			$stub->CPP = self::CPP($grossIncome,$P,$D,$year,$ca);
			$stub->EI = self::EI($grossIncome,$D1,$year,$ca);
			$stub->federalTax = self::basicFedTax($grossIncome,$P,$stub->CPP,$stub->EI,$year,$code);
			$stub->provincialTax = self::ontarioTax($grossIncome,$P,$stub->CPP,$stub->EI,$year,$code);
			$stub->net = $grossIncome - $stub->CPP - $stub->EI - $stub->provincialTax - $stub->federalTax;
		
		return $stub;
	}

    public static function getCRA($year,$jurisdiction)
    {
    	return DB::table('payroll_cra_setting')->where('year',$year)->where('zone',$jurisdiction)->first();
    }

    public static function EI($IE,$YTD,$year,$jurisdiction)
    {
    	$cra = self::getCRA($year,$jurisdiction);
    	$rate = $cra->EI;
		$max = $cra->Max_EI;
		if(($max - $YTD) > $IE * $rate ){
			return round($IE * $rate,2);
		} else {
			return round($max - $YTD,2);
		}
    }
    public static function CPP($PI,$P,$YTD,$year,$jurisdiction)
    {
    	$cra = self::getCRA($year,$jurisdiction);
    	$rate = $cra->CPP;
		$max = $cra->Max_CPP;
		$CPP1 = $rate * ($PI - $cra->CPP_EXP / $P);
		$CPP2 = $max - $YTD;
		if(($CPP2 > $CPP1) && $CPP1 >= 0){
			return round($CPP1,2);
		} else if(($CPP2 < $CPP1) && $CPP2 >= 0){
			return round($CPP2,2);
		} else {
			return 0;
		}
    }

    private static function annualTaxableIncome($i,$p)
    {
    	$F = 0; //payroll deductions for the pay period for employee contributions to a registered pesion plan for current and past services.
		$F2 = 0; // Alimoney or maintenance payments required by a legal document dated before May 1, 1997, to be payroll-deducted authroized by a tax services office or tax centre
		$U1 = 0; // Union dues for the pay period paid toa trade union, an association of public servants, or similar.
		$HD = 0; // annual deduction for living in a prescribed zone.
		$F1 = 0; // Annual deductions such as child care expenses and support payments, requested by an employee or pensioner and authrozed by a tax services office or tax centre.
		return $p * ($i - $F - $F2 - $U1) - $HD - $F1;
    }

    public static function basicFedTax($income,$P,$C,$EI,$year,$code)
    {
    	$A = self::annualTaxableIncome($income,$P);
    	$table = self::taxRate($year,'CA',$A);
    	$R = $table->rate;
		$K = $table->k;
		$k1 = DB::table('payroll_cra_claim')->where('year',$year)->where('zone','CA')->where('code',$code)->first()->k;
		$k2 = self::CPP_EI_taxCredits($C,$EI,$P,$year,'CA');
		$k3 = 0;
		$k4 = self::canadaEmploymentCredit($A);
		$T3 = $R * $A - $K - $k1 - $k2 - $k3 - $k4;
		$T1 = self::federalTaxDeduction($T3);
		if($T1>0){
			return round($T1/$P,2);
		} else return 0;

    }
    public static function taxRate($year,$zone,$A)
    {
    	return DB::table('payroll_cra_rates')->where('year',$year)->where('zone',$zone)
    			->where('low','<=',$A)
    			->where('high','>',$A)->first();
    }
    private static function CPP_EI_taxCredits($C,$EI,$P,$year,$zone)
    {
    	$rate = DB::table('payroll_cra_rates')->where('year',$year)->where('zone',$zone)->min('rate');
    	$cra = self::getCRA($year,'CA');
    	$CPP = $P * $C > $cra->Max_CPP ? $cra->Max_CPP:$P * $C;
		$EI = $P * $EI > $cra->Max_EI ? $cra->Max_EI:$P * $EI;
		return  $rate * ($CPP) + $rate * ($EI);
    }
    private static function canadaEmploymentCredit($A)
    {
    	// 2017 $A>1178? $k4 = 0.15 * 1178 : $k4 = 0.15 * $A;
    	// 2018
    	$A > 1195 ? $k4 = 0.15 * 1195 : $k4 = 0.15 * $A;
		return $k4;
    }
    private static function federalTaxDeduction($t3){
		$stock = 0;
		$LCF = (750 > 0.15 * $stock) ? 0.15*$stock : 750;
		return ($t3 - $LCF) >= 0 ? $t3 - $LCF:0;	
	}

	public static function ontarioTax($income,$P,$C,$EI,$year,$code)
	{
		$A = self::annualTaxableIncome($income,$P);
    	$table = self::taxRate($year,'ON',$A);
    	$V = $table->rate;
		$KP = $table->k; // 0 for annual income below 42201 in ontraio
		//$k1p = 0.0505 * 10171.00; // claim amount;
		$k1p = DB::table('payroll_cra_claim')->where('year',$year)->where('zone','ON')->where('code',$code)->first()->k;
		$k2p = self::CPP_EI_taxCredits($C,$EI,$P,$year,'ON');
		$k3p = 0;
		
		$T4 = $V * $A - $KP - $k1p - $k2p - $k3p;
		$T4 = $T4 < 0?0:round($T4,2);
		$V1 = self::ontarioSurtax($T4);
		$V2 = self::additionalTax($A); 
		$S = self::provincialReduction($T4,$V1,0);
		$LCP = 0;
		$T2 = $T4 + $V1 + $V2 - $S - $LCP;
		$T2 = $T2 < 0?0:$T2; 
		return round($T2/$P,2);  
	}
	private static function ontarioSurtax($T4) // for ontario surtax V1
	{
		// 2017
		// if($T4 <= 4556){
		// 	return 0;
		// } else if($T4 > 4556 && $T4 <= 5831){
		// 	return 0.2 * ($T4 - 4556);
		// } else if($T4 > 5831)
		// 	return 0.2 * ($T4 - 4556) + 0.36 * ($T4 - 5831);

		//2018
		if($T4 <= 4638){
			return 0;
		} else if($T4 > 4638 && $T4 <= 5936){
			return 0.2 * ($T4 - 4638);
		} else if($T4 > 5936)
			return 0.2 * ($T4 - 4638) + 0.36 * ($T4 - 5936);
	}
	private static function additionalTax($A){ // for ontario surtax V1
		if($A <= 20000){
			return 0;
		} else if($A > 20000 && $A <= 36000){
					if(0.06 * ($A - 20000) > 300){
						return 300;
					} else {
						return 0.06 * ($A - 20000);}
		} else if($A > 36000 && $A <= 48000){
					if((0.06 * ($A - 36000) + 300) > 450){
							return 450;
					} else {
							return (0.06 * ($A - 36000) + 300);}
		} else if($A > 48000 && $A <= 72000){
					if((0.25 * ($A - 48000) + 450) > 600){
							return 600;
					} else {
							return (0.25 * ($A - 48000) + 450);}
		} else if($A > 72000 && $A <= 200000){
					if((0.25 * ($A - 72000) + 600) > 750){
							return 750;
					} else {
							return (0.25 * ($A - 72000) + 600);}
		} else if($A > 200000){
					if((0.25 * ($A - 200000) + 750) > 900){
							return 900;
					} else {
							return (0.25 * ($A - 200000) + 750);}
		}
	}
	private static function provincialReduction($t4,$v1,$num_dependant){
		// 2017
		// $Y = 434 * $num_dependant;
		// if(($t4 + $v1) > (2*(235 + $Y) - ($t4 + $v1)) ){
		// 	if( (2*(235 + $Y) - ($t4 + $v1)) < 0){
		// 		return 0;
		// 	} else {
		// 		return (2*(235 + $Y) - ($t4 + $v1));
		// 	}
			
		// } else {
		// 	return ($t4 + $v1);
		// }

		// 2018
		$Y = 442 * $num_dependant;
		if(($t4 + $v1) > (2*(239 + $Y) - ($t4 + $v1)) ){
			if( (2*(239 + $Y) - ($t4 + $v1)) < 0){
				return 0;
			} else {
				return (2*(239 + $Y) - ($t4 + $v1));
			}
			
		} else {
			return ($t4 + $v1);
		}
	}
}

class PayStub {
	public $grossIncome = 0;
	public $federalTax = 0;
	public $provincialTax = 0;
	public $CPP = 0;
	public $EI = 0;
	public $net = 0;
}
