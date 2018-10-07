<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\JobPromotion;

class PromotionApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $promotion;
    public function __construct(JobPromotion $promotion)
    {
        $this->promotion = $promotion;
    }

    public function build()
    {
        return $this->markdown('email.promotion.approved');
    }
}
