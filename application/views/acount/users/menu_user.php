<ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-3 px-lg-4 <?=($custom['page'] == 'Users')?'active':''?>" href="/Acount/User">Usuarios</a>
    </li>
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-4 px-lg-4 <?=($custom['page'] == 'Profile')?'active':''?>" href="/Acount/User/Profile"> Perfil </a>
    </li>
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-4 px-lg-4 <?=($custom['page'] == 'Rol')?'active':''?>" href="/Acount/Rol"> Roles de usuarios </a>
    </li>
</ul>              