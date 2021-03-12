<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i> Nuevo Vehiculo
    </h5>     
    <i class="icon-close icons openside reset_form h3" data-reset="/"></i>     
</div>

<form class="needs-validation" id="veh_newform" method="POST" novalidate>
    <div class="modal-body h-100">  

        <div class="row mb-2"> 
            <label for="newuser_username" class="col-form-label">Vehiculo</label>
            <input type="text" name="newv_name" id="newv_name" class="form-control" required="" >            
        </div> 
 
        <div class="row mb-2"> 
            <label for="newv_plate" class="col-form-label">Placas</label>
            <input type="text" name="newv_plate" id="newv_plate" class="form-control" required="" >            
        </div>

        <div class="row mb-2"> 
            <label for="newv_model" class="col-form-label">Modelo</label>
            <input type="text" name="newv_model" id="newv_model" class="form-control" required="" >            
        </div> 

        <div class="row mb-2">
            <label for="newv_company">Empresa</label>
            <select class="form-control select-form" id="newv_company" name="newv_company" required="">                
                <?php foreach($companylist as $comp): ?>
                <option value="<?=$comp->id_empresa?>"><?=$comp->razon_social?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row mb-2">
            <label for="newv_status">Estatus</label>
            <select class="form-control select-form" id="newv_status" name="newv_status" required="">                
                <?php foreach($statuslist as $statusid => $status): ?>
                <option <?=($statusid==1)?"selected":""?> value="<?=$statusid?>"><?=$status?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="row mb-2"> 
            <label for="newv_idsepro" class="col-form-label">ID Sepromex</label>
            <input type="text" name="newv_idsepro" id="newv_idsepro" class="form-control" required="" >            
        </div>

        <div class="row mb-2"> 
            <label for="newv_detail" class="col-form-label">Detalle</label>
            <textarea name="newv_detail" id="newv_detail" class="form-control" required="" ></textarea>
        </div> 
         

    </div> 
    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside reset_form" data-reset="reset_user" >Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="velidate_form('veh_newform','new')">Agregar Vehiculo</button>
    </div>
</form>  