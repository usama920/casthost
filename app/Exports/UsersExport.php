<?php

namespace App\Exports;

use App\Models\Downloads;
use App\Models\User;
use App\Models\Views;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;

class UsersExport implements WithHeadings, FromQuery, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return User::all();
    // }

    

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Username',
            'Memory Limit',
            'Memory Used',
            'Podcasts',
            'Subscribers',
            'Views',
            'Downloads',
            'Status',
            'Created At',
        ];
    }
    public function query()
    {
        $users = User::where(['role' => 2, 'belongs_to' => Auth::user()->id])->withCount(['podcasts', 'subscribers']);
        return $users;
    }
    
    public function map($user): array
    {
        $total_views = 0;
        $total_downloads = 0;
        $podcasts = $user->podcasts;
        foreach ($podcasts as $podcast) {
            $total_views += Views::where(['podcast_id' => $podcast->id])->count();
            $total_downloads += Downloads::where(['podcast_id' => $podcast->id])->count();
        }
        if($user->status == 1) {
            $user_status = "Active";
        } else {
            $user_status = "Inactive";
        }
        return [
            $user->name,
            $user->email,
            $user->username,
            strval("$user->memory_limit GB"),
            strVal(get_memory_usage($user->id, "user")),
            strval($user->podcasts_count),
            strval($user->subscribers_count),
            strval($total_views),
            strval($total_downloads),
            $user_status,
            date_format($user->created_at, "Y-m-d H:i:s")
        ];
    }

}
