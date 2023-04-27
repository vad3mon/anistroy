@if(isset($data['route']))
    <li class="aside__menu-item">
        <a class="aside__link {{ request()->routeIs($data['route'] . '*') ? 'selected' : '' }}" href="{{ route($data['route'] . 'home') }}">
            {{ $data['name'] }}
        </a>
    </li>
@elseif(isset($data['model']))
    <li class="aside__menu-item">
        <a class="aside__link {{ (request()->routeIs('cms.models.*')) && $name == $module ? 'selected' : '' }}" href="{{ route('cms.models.home', $name) }}">
            {{ $data['name'] }}
        </a>
    </li>
@endif