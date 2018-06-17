<p>
    <a title="Soundcloud" href="https://soundcloud.com/pascal-sommer" class="social-media-link">@include('icons.soundcloud')</a>
    <a title="Twitter" href="https://twitter.com/sommerpascal" class="social-media-link">@include('icons.twitter')</a>
    <a title="Github" href="https://github.com/pascal-so" class="social-media-link">@include('icons.github')</a>
    <a title="Medium" href="https://medium.com/@pascal.sommer.ch" class="social-media-link">@include('icons.medium')</a>
    <a title="Google Play" href="https://play.google.com/store/apps/developer?id=Pascal+Sommer" class="social-media-link">@include('icons.googleplay')</a>
    <a title="Youtube" href="https://youtube.com/pascalsommermovies" class="social-media-link">@include('icons.youtube')</a>
    <a title="RSS feed - {{ config('feed.feeds.posts.title') }}" type="application/atom+xml" href="{{ asset('feed') }}" class="social-media-link">@include('icons.rss')</a>
</p>