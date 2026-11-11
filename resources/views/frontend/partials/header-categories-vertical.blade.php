<ul class="menu-content display-none">
    @forelse($headerCategories as $category)
        @php
            $hasChildren = $category->children->isNotEmpty();
            $hasGrandChildren = $hasChildren && $category->children->contains(fn ($sub) => $sub->children->isNotEmpty());
        @endphp

        <li class="menu-item">
            <a href="{{ route('categories.shop', ['category' => $category->slug]) }}">
                {{ $category->name }}
                @if($hasChildren)
                    <i class="ion-ios-arrow-right"></i>
                @endif
            </a>

            @if($hasGrandChildren)
                <ul class="sub-menu flex-wrap">
                    @foreach($category->children as $subCategory)
                        <li>
                            <a href="{{ route('categories.shop', ['category' => $subCategory->slug]) }}">
                                <span><strong>{{ $subCategory->name }}</strong></span>
                            </a>
                            @if($subCategory->children->isNotEmpty())
                                <ul class="submenu-item">
                                    @foreach($subCategory->children as $childCategory)
                                        <li>
                                            <a href="{{ route('categories.shop', ['category' => $childCategory->slug]) }}">
                                                {{ $childCategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @elseif($hasChildren)
                <ul class="sub-menu sub-menu-2">
                    <li>
                        <ul class="submenu-item">
                            @foreach($category->children as $subCategory)
                                <li>
                                    <a href="{{ route('categories.shop', ['category' => $subCategory->slug]) }}">
                                        {{ $subCategory->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            @endif
        </li>
    @empty
        <li class="menu-item"><a href="{{ route('categories.index') }}">No categories found</a></li>
    @endforelse
</ul>
