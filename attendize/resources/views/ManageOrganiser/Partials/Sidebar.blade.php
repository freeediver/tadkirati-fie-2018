<aside class="sidebar sidebar-left sidebar-menu">
    <section class="content">
        <h5 class="heading">Menu</h5>

        <ul id="nav" class="topmenu">
            <li class="{{ Request::is('*dashboard*') ? 'active' : '' }}">
                <a href="{{route('showOrganiserDashboard', array('organiser_id' => $organiser->id))}}">
                    <span class="figure"><i class="ico-home2"></i></span>
                    <span class="text">Tableau de board</span>
                </a>
            </li>
            <li class="{{ Request::is('*events*') ? 'active' : '' }}">
                <a href="{{route('showOrganiserEvents', array('organiser_id' => $organiser->id))}}">
                    <span class="figure"><i class="ico-calendar"></i></span>
                    <span class="text">Évenements</span>
                </a>
            </li>

            <li class="{{ Request::is('*customize*') ? 'active' : '' }}">
                <a href="{{route('showOrganiserCustomize', array('organiser_id' => $organiser->id))}}">
                    <span class="figure"><i class="ico-cog"></i></span>
                    <span class="text">Personnaliser</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
