@include('partials.header')

    <div class="wrapper">

        @include('partials.sidebare')

        <div class="main-panel">
            @include('partials.nav')
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            @include('partials.footerContent')

        </div>
    </div>
@include('partials.footer')
