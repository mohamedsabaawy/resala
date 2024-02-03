<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    protected $users;
    protected $filter_from;
    protected $filter_to;

    public function __construct($users, $filter_from, $filter_to)
    {
        $this->users = $users;
        $this->filter_from = $filter_from;
        $this->filter_to = $filter_to;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        $users = $this->users;
        $filter_from = $this->filter_from;
        $filter_to = $this->filter_to;

        return view('admin.export', compact(['users','filter_from','filter_to']));
//        return $this->users;
    }

    public function collection()
    {
        // TODO: Implement collection() method.
    }
}
