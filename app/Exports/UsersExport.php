<?php

namespace App\Exports;

use App\Models\PDF_crud;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

public $user;
public function __construct($user)
{
    $this->user = $user;
}

    public function view(): View
    {
        return view('exports.users_excel', [
            'users' => $this->user,
        ]);
    }
}
