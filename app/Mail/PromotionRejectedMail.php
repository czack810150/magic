<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\JobPromotion;

class PromotionRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $promotion;
    public function __construct(JobPromotion $promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.promotion.rejected');
    }
}
