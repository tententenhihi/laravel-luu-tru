@php
    $brands = get_all_brands(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable'], ['products']);
    $categories = get_product_categories(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable'], ['products'], true);
    $tags = app(\Botble\Ecommerce\Repositories\Interfaces\ProductTagInterface::class)->advancedGet([
        'condition' => ['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED],
        'with'      => ['slugable'],
        'withCount' => ['products'],
        'order_by'  => ['products_count' => 'desc'],
        'take'      => 10,
    ]);

    Theme::asset()->usePath()->add('jquery-ui-css', 'css/jquery-ui.css');
    Theme::asset()->container('footer')->usePath()->add('jquery-ui-js', 'js/jquery-ui.js', ['jquery']);
    Theme::asset()->container('footer')->usePath()->add('touch-punch', 'js/jquery.ui.touch-punch.min.js', ['jquery-ui-js']);
@endphp

<div class="widget">
    <h5 class="widget_title">{{ __('Danh mục sản phẩm') }}</h5>
    <ul class="widget_categories">
        <li @if (URL::current() == route('public.products') && empty(request()->input('categories'))) class="active" @endif><a href="{{ route('public.products') }}">{{ __('Tất cả sản phẩm') }}</a></li>
        @foreach($categories as $category)
            <li @if (URL::current() == $category->url || (!empty(request()->input('categories', [])) && in_array($category->id, request()->input('categories', [])))) class="active" @endif><a href="{{ $category->url }}">{{ $category->name }} <span class="categories_num">({{ $category->products_count }})</span></a></li>
        @endforeach
    </ul>
</div>

@if (count($brands) > 0)
    <aside class="widget">
        <h5 class="widget_title">{{ __('Thương hiệu') }}</h5>
        <ul class="list_brand">
            @foreach($brands as $brand)
                <li>
                    <div class="custome-checkbox">
                        <input class="form-check-input submit-form-on-change" type="checkbox" name="brands[]" id="brand-{{ $brand->id }}" value="{{ $brand->id }}" @if (in_array($brand->id, request()->input('brands', []))) checked @endif>
                        <label class="form-check-label" for="brand-{{ $brand->id }}"><span>{{ $brand->name }} <span class="d-inline-block">({{ $brand->products_count }})</span> </span></label>
                    </div>
                </li>
            @endforeach
        </ul>
    </aside>
@endif
<aside class="widget" style="border: none">
    {!! render_product_swatches_filter([
        'view' => Theme::getThemeNamespace() . '::views.ecommerce.attributes.attributes-filter-renderer'
    ]) !!}
</aside>
<aside class="widget widget--tags">
    <h5 class="widget_title">{{ __('Loại sản phẩm') }}</h5>
    <ul class="list_brand">
        @foreach($tags as $tag)
            <li>
                <div class="custome-checkbox">
                    <input class="form-check-input submit-form-on-change" type="checkbox" name="tags[]" id="tag-{{ $tag->id }}" value="{{ $tag->id }}" @if (in_array($tag->id, request()->input('tags', []))) checked @endif>
                    <label class="form-check-label" for="tag-{{ $tag->id }}"><span>{{ $tag->name }} <span class="d-inline-block">({{ $tag->products_count }})</span> </span></label>
                </div>
            </li>
        @endforeach
    </ul>
</aside>


 
