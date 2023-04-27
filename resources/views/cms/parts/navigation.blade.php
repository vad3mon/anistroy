<aside class="aside" data-spoilers="767,max">
    <img class="aside__logo" src="{{ asset('/cms/images/logo.png') }}" alt="logo">

    <h3 class="aside__title">Название сайта</h3>

    <ul class="aside__menu">

    @foreach(Config::get('cms.menu') as $menuBlock => $menuBlockData)
            @if(is_array($menuBlockData['modules']))
                <li class="aside__menu-item">
                    <span class="aside__link aside__link--sublist {{ isset($module) && in_array($module, $menuBlockData['modules']) ? 'selected' : '' }}" data-spoiler>
                        {{ $menuBlockData['name'] }}
                    </span>
                    <ul class="aside__submenu">
                        @foreach($menuBlockData['modules'] as $menuModuleSlug)
                            @if(isset($moduleRights[$menuModuleSlug]) && $moduleRights[$menuModuleSlug])
                                @include('cms.parts.navigation-link', [
                                    'name' => $menuModuleSlug,
                                    'data' => Config::get('cms.modules.' . $menuModuleSlug)
                                ])
                            @endif
                        @endforeach
                    </ul>
                </li>
            @else
                @if(isset($moduleRights[$menuBlockData['modules']]) && $moduleRights[$menuBlockData['modules']])
                    @include('cms.parts.navigation-link', [
                        'name' => $menuBlockData['modules'],
                        'data' => Config::get('cms.modules.' . $menuBlockData['modules'])
                    ])
                @endif
            @endif
        @endforeach
    </ul>
</aside>
<button class="burger"></button>
