<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class MeetingsExport implements FromView
{
    protected $users;
    protected $filter_from;
    protected $filter_to;

    public function __construct($meetings)
    {
        $this->meetings = $meetings;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        $meetings = $this->meetings;

        return view('admin.meeting-export', compact(['meetings']));
    }

    public function collection()
    {
        // TODO: Implement collection() method.
    }
}
