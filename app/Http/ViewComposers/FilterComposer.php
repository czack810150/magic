<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\UserRepository;
use App\Location;

class FilterComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $locationOptions;
    protected $yearOptions = [2016,2017,2018];

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->locationOptions = Location::pluck('name','id');
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('locationOptions', $this->locationOptions);
        $view->with('yearOptions',$this->yearOptions);
    }
}