<div class="featured-area featured-area2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="featured-active2 owl-carousel next-prev-style">
                  @foreach($category_info as $category)
                    <div class="featured-wrap">
                        <div class="featured-img">
                            <img src="{{ asset('uploads/category_photos') }}/{{ $category->category_photo }}" alt="{{ $category->category_photo }}">
                            <div class="featured-content">
                                <a href="shop.html">{{ $category->category_name }}</a>
                            </div>
                        </div>
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
