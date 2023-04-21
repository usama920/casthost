<?php
echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">
    <channel>
        <title>{{ $user->name }}</title>
        <itunes:owner>
            <itunes:email>{{ $user->email }}</itunes:email>
        </itunes:owner>
        <itunes:author>{{ $user->name }}</itunes:author>
        <link>{{ $link }}</link>
        <description>{{ $userAbout->text }}</description>
        <language>en-us</language>
        <itunes:image href="{{ url('project_assets/images/' . $userAbout->profile_image) }}" />

        @foreach ($podcasts as $podcast)
            <item>
                <title>{{ $podcast->title }}</title>
                <description>{{ $podcast->description }}</description>
                <enclosure url="{{ url('storage/podcast/' . $podcast->id . '/' . $podcast->podcast) }}" type="audio/mpeg"
                    length="{{$podcast->duration}}" />
            </item>
        @endforeach

    </channel>
</rss>
