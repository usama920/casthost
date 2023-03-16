<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title>{{$basic_settings->site_title}}</title>
        <link>{{$link}}</link>
        <description>{{$basic_settings->site_title}} RSS Feed</description>
        <language>en</language>
        <pubDate>{{ now() }}</pubDate>
  
        @foreach($podcasts as $podcast)
            <item>
                <title>{{ $podcast->title }}</title>
                <link>{{ $podcast->slug }}</link>
                <description>{{ $podcast->description }}</description>
                <category>{{ $podcast->category->title }}</category>
                <author>{{ $podcast->user->name }}</author>
                <guid>{{ $link.'/podcasts/'.$podcast->id }}</guid>
                <coverImage>{{ url('storage/podcast/' . $podcast->id . '/images/' . $podcast->cover_image) }}</coverImage>
                <podcastLink>{{ url('storage/podcast/' . $podcast->id . '/' . $podcast->podcast) }}</podcastLink>
                <pubDate>{{ $podcast->premiere_datetime }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>