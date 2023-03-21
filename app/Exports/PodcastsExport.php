<?php

namespace App\Exports;

use App\Models\Podcast;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PodcastsExport implements WithHeadings, FromQuery, WithMapping
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
            'Title',
            'Category',
            'User Name',
            'User Email',
            'Last Day Views',
            'Last Seven Days Views',
            'Last Thirty Days Views',
            'Total Views',
            'Last Day Downloads',
            'Last Seven Days Downloads',
            'Last Thirty Days Downloads',
            'Total Downloads',
            'PREMIERE DATE',
            'Status',
        ];
    }
    public function query()
    {
        $users = User::where(['belongs_to' => Auth::user()->id])->get();
        $user_ids = [];
        foreach ($users as $user) {
            array_push($user_ids, $user->id);
        }
        $podcasts = Podcast::whereIn('user_id', $user_ids)->withCount(['user', 'category', 'views', 'downloads', 'lastDayViews', 'lastSevenDayViews','lastThirtyDayViews', 'lastDayDownloads', 'lastSevenDayDownloads', 'lastThirtyDayDownloads']);
        return $podcasts;
    }
    
    public function map($podcast): array
    {
        if($podcast->status == 1) {
            $user_status = "Active";
        } else {
            $user_status = "Inactive";
        }
        return [
            $podcast->title,
            $podcast->category->title,
            $podcast->user->name,
            $podcast->user->email,
            strval($podcast->last_day_views_count),
            strval($podcast->last_seven_day_views_count),
            strval($podcast->last_thirty_day_views_count),
            strval($podcast->views_count),
            strval($podcast->last_day_downloads_count),
            strval($podcast->last_seven_day_downloads_count),
            strval($podcast->last_thirty_day_downloads_count),
            strval($podcast->downloads_count),
            strval($podcast->premiere_datetime),
            $user_status
        ];
    }

}
