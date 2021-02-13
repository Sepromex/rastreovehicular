<ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-3 px-lg-4 <?=($custom['page'] == 'ContactList')?'active':''?>"  href="/Acount/Contact">Contactos</a>
    </li>
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-4 px-lg-4 <?=($custom['page'] == 'MyCompany')?'active':''?>"  href="#"> Empresas </a>
    </li>
    <li class="nav-item ml-0">
        <a class="nav-link py-2 px-4 px-lg-4 <?=($custom['page'] == 'Users')?'BranchOffice':''?>"  href="#"> Sucursales </a>
    </li>
</ul>