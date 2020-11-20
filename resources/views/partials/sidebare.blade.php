<div class="sidebar" data-color="red" data-image="assets/img/sidebar-5.jpg">
    <div class="sidebar-wrapper" style="border-bottom-right-radius: 100%;box-shadow: 0px 0px 19px 0px #080808;">
        <div class="logo" style="border-bottom-right-radius: 50px;box-shadow: 0px 0px 19px 0px #080808;">
            <a href="{{route('home')}}" class="simple-text" style="font-family: 'Cooper Black'; font-size: 28px">
                <i class="pe-7s-coffee"></i>
                {{ config('app.name', 'fiiFoods') }}
            </a>
        </div>

        <ul class="nav">
            <li class="{{active('home')}}">
                <a href="{{route('home')}}">
                    <i class="pe-7s-display1"></i>
                    <p>Tableau de bord</p>
                </a>
            </li>
            <li class="{{active('achats.index')}}">
                <a href="{{route('achats.index')}}">
                    <i class="pe-7s-box1"></i>
                    <p>Commandes</p>
                </a>
            </li>
            <li class="{{active('ventes.index')}}">
                <a href="{{route('ventes.index')}}">
                    <i class="pe-7s-cart"></i>
                    <p>Ventes</p>
                </a>
            </li>
            <li class="{{active('historique')}}">
                <a href="{{route('historique')}}" rel="tooltip">
                    <i class="pe-7s-display2"></i>
                    <p>Historiques</p>
                </a>
            </li>
            <li class="{{active('activiste')}}">
                <a href="{{route('activiste')}}">
                    <i class="pe-7s-users"></i>
                    <p>Mes Clients / Four</p>
                </a>
            </li>
            <li class="{{active('users.index')}}">
                <a href="{{route('users.index')}}" rel="tooltip">
                    <i class="pe-7s-add-user"></i>
                    <p>Utilisateurs</p>
                </a>
            </li>
            <li class="{{active('depense.index')}}">
                <a href="{{route('depense.index')}}" rel="tooltip" title="En cours de développement">
                    <i class="pe-7s-graph"></i>
                    <p>Dépenses</p>
                </a>
            </li>
            <li class="{{active('pipeline')}}">
                <a href="{{route('pipeline')}}">
                    <i class="pe-7s-graph1"></i>
                    <p>Rapports</p>
                </a>
            </li>
        </ul>
    </div>
</div>