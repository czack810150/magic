    <?php

namespace App\Listeners;

use App\Events\EmployeeAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;

class SendEmployeeAddedNotification
{
    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  EmployeeAdded  $event
     * @return void
     */
    public function handle(EmployeeAdded $event)
    {
        // $this->mailer->send(
        //     new EmployeeAddedEmail($event->employee);
        // );
    }
}
