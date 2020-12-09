<p>
    <a title="Soundcloud" href="https://soundcloud.com/pascal-sommer" class="external-platform-link">@include('icons.soundcloud')</a>
    <a title="Twitter" href="https://twitter.com/sommerpascal" class="external-platform-link">@include('icons.twitter')</a>
    <a title="Github" href="https://github.com/pascal-so" class="external-platform-link">@include('icons.github')</a>
    <a title="Medium" href="https://medium.com/@pascal.sommer.ch" class="external-platform-link">@include('icons.medium')</a>
    <a title="Google Play" href="https://play.google.com/store/apps/developer?id=Pascal+Sommer" class="external-platform-link">@include('icons.googleplay')</a>
    <a title="Youtube" href="https://youtube.com/pascalsommermovies" class="external-platform-link">@include('icons.youtube')</a>
    <a title="RSS feed - {{ config('feed.feeds.posts.title') }}" type="application/atom+xml" href="{{ asset('feed') }}" class="external-platform-link">@include('icons.rss')</a>
</p>