<?php
echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title>{{ $user->name }}</title>
        <language>en-us</language>
        <copyright>© 2023 {{ $user->name }}</copyright>
        <itunes:author>{{ $user->name }}</itunes:author>
        <description>{{ $userAbout->text }}</description>
        <itunes:owner>
            <itunes:name>Sunset name</itunes:name>
            <itunes:email>{{ $user->email }}</itunes:email>
        </itunes:owner>
        <itunes:image href="{{ url('project_assets/images/' . $userAbout->profile_image) }}" />
        <itunes:category text="Non-Profit" />
        <link>{{ $link }}</link>
        <itunes:explicit>false</itunes:explicit>

        @foreach ($podcasts as $podcast)
            <item>
                <itunes:title>{{ $podcast->title }}</itunes:title>
                <title>{{ $podcast->title }}</title>
                <description>{{ $podcast->description }}</description>
                <enclosure url="{{ url('storage/podcast/' . $podcast->id . '/' . $podcast->podcast) }}" type="audio/mpeg"
                    length="{{ $podcast->length }}" />
                <itunes:image href="{{ url('storage/podcast/' . $podcast->id . '/images/' . $podcast->other_rss_image) }}" />
                <itunes:duration>{{ $podcast->duration }}</itunes:duration>
                <pubDate>{{ $podcast->pub_date }}</pubDate>
                <itunes:explicit>false</itunes:explicit>
            </item>
        @endforeach

    </channel>
</rss>
