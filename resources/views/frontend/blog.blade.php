@extends('frontend.layout.app')
<body id="topPage" data-spy="scroll" data-target=".navbar" data-offset="100">


<!-- Blog Area
        ===================================== -->
@section('main-content')
<div class="col-md-9">

    <div class="blog-three-mini">
        <h2 class="color-dark"><a href="#">{{$blog->title}}</a></h2>
        <div class="blog-three-attrib">
            <div><i class="fa fa-calendar"></i>{{$blog->published_at->diffForHumans()}}</div> |
            <div><i class="fa fa-pencil"></i><a href="#">{{$blog->author->name}}</a></div> |
            <div><i class="fa fa-comment-o"></i><a href="#">90 Comments</a></div> |
            <div><a href="#"><i class="fa fa-thumbs-o-up"></i></a>150 Likes</div> |
            <div>
                Share:  <a href="#"><i class="fa fa-facebook-official"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa-google-plus"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
            </div>
        </div>

        <img src="{{asset($blog->image_path)}}" alt="Blog Image" class="img-responsive">


        <div class="blog-post-read-tag mt50">
            <i class="fa fa-tags"></i> Tags:
            @foreach ($blogTags as $tag)
            <a href="{{asset(route('frontend.tag', $tag->id))}}"> {{$tag->name}}</a>,
            @endforeach

        </div>

    </div>
</div>

    <div class="blog-post-author mb50 pt30 bt-solid-1">
        <img src="assets/img/other/photo-1.jpg" class="img-circle" alt="image">
        <span class="blog-post-author-name">John Boo</span> <a href="https://twitter.com/booisme"><i class="fa fa-twitter"></i></a>
        <p>
            Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
        </p>
    </div>


    <div id="disqus_thread"></div>
    <script>
        /**
        *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
        *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
        /*
        var disqus_config = function () {
        this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        */
        (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://pen-it-mu9ahdggnx.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
@endsection

