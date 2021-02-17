<ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-3 px-lg-4 <?=($custom['page'] == 'CompanyList')?'active':''?>"  href="/Acount/Companys">Empresas</a>
    </li>
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-4 px-lg-4 <?=($custom['page'] == 'MyCompany')?'active':''?>"  href="/Acount/Companys/MyCompany/<?=$_SESSION["user"]["company"]?>"> Mi Empresa </a>
    </li>
    <li class="nav-item ml-0">
        <a class="nav-link py-2 px-4 px-lg-4 <?=($custom['page'] == 'OfficeList')?'active':''?>"  href="/Acount/Office"> Sucursales </a>
    </li>           
</ul>