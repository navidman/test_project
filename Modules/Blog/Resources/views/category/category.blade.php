@if ($category->children)
    <ul>
        @foreach($category->children as $category)
            <li>{{ $category->title }}

                @if($category->parent)
                    @include('blog::category.category', $category)
                @endif
            </li>
        @endforeach
    </ul>
@endif
