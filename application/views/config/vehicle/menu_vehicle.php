<ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-3 px-lg-4 <?=($custom['page'] == 'Vehicles')?'active':''?>" href="/Config/Vehicles">Vehiculos</a>
    </li>
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-4 px-lg-4 <?=($custom['page'] == 'Speeds')?'active':''?>" href="/Config/Speeds"> Velocidades </a>
    </li>
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-4 px-lg-4 text-muted"> Reglas </a>
    </li>    
    <li class="nav-item ml-0">
        <a class="nav-link  py-2 px-4 px-lg-4 text-muted"> Alertas </a>
    </li>
</ul>

<!-- <?=($custom['page'] == 'Rules')?'active':''?>" href="/Config/Rules" -->
<!-- <?=($custom['page'] == 'Alerts')?'active':''?>" href="/Config/Alerts" -->