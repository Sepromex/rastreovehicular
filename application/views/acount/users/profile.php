<div class="card-header  justify-content-between align-items-center"> 
    <div class="sub-header   px-md-0 align-self-center d-sm-flex w-100 rounded">
        <div class="w-sm-100 mr-auto">
            <h4 class="card-title">Usuarios</h4>                          
        </div>  
    </div>
</div>  
 
<div class="profile-menu theme-background border  z-index-1 p-2">
    <div class="d-sm-flex">
        <div class="align-self-center">
            <?php $this->load->view("acount/users/menu_user"); ?>
        </div>        
    </div>
</div> 
 
<div class="card-body"> 
    <div class="row">
        <div class="col-12 mt-3">
            <div class="position-relative">
                <div class="background-image-maker py-5"></div>
                <div class="holder-image">
                    <img src="/dist/images/Acount/profile_banner.jpeg" alt="" class="img-fluid d-none">
                </div>
                <div class="position-relative px-3 py-5">
                    <div class="media d-md-flex d-block">
                        <a href="#"><img src="/dist/images/Acount/profile.png" width="100" alt="" class="img-fluid rounded-circle"></a>
                        <div class="media-body z-index-1">
                            <div class="pl-4">
                                <h1 class="display-4 text-uppercase text-white mb-0" id="company_labelname"><?=(isset($company["razon_social"]))?$company["razon_social"]:""?></h1>
                                <h6 class="text-uppercase text-white mb-0" id="company_labeltype"><?=(isset($company["giro"]))?$company["giro"]:""?></h6>
                                <h6 class="text-uppercase text-white mb-0" id="company_labeldate"><?=(isset($company["fecha_reg"]))?$company["fecha_reg"]:""?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>    
    <?php $this->load->view("acount/users/user_form"); ?>
    <?php $this->load->view("acount/users/vehicle_list"); ?>   
</div>

<script>
    //Plugin documentation 
    //https://wakirin.github.io/Lightpick/
window.onload = function () {
    var gists = [
        'https://gist.github.com/wakirin/c0100ee7e886fe74b3256ddb74f16adf.json?callback=callbackJson',
        'https://gist.github.com/wakirin/d4f00465b259590233f0727f01eaba66.json?callback=callbackJson',
        'https://gist.github.com/wakirin/c4e84bf9c5546a9656337236491a75f6.json?callback=callbackJson',
        'https://gist.github.com/wakirin/cdc9423464346f2de381cb3df0c78860.json?callback=callbackJson',
        'https://gist.github.com/wakirin/917c0e596078c1fcf51bff945004a4f2.json?callback=callbackJson',
        'https://gist.github.com/wakirin/4b9917aa9bda42f25124875c91385c7f.json?callback=callbackJson',
        'https://gist.github.com/wakirin/8782b1f9e3580a26fb70cdc78c4ed6d3.json?callback=callbackJson',
        'https://gist.github.com/wakirin/a76eaf1f7860aa0add9ba384bec8e0aa.json?callback=callbackJson',
        'https://gist.github.com/wakirin/b526e49275dc02c4ab3f3b72c3f0f3af.json?callback=callbackJson',
        'https://gist.github.com/wakirin/8fdf443726f097326d927e0e85dbc5dd.json?callback=callbackJson',
        'https://gist.github.com/wakirin/a10bbe7a2d22d1c285cd4763e4a5de80.json?callback=callbackJson',
    ];
    
    var datepicker = new Lightpick({
        field: document.getElementById('conf_userfechainicio'),
        secondField: document.getElementById('conf_userfechafin'),
        repick: true,
        dropdowns:{
            years: {
                min: '2010',
                max: '2035'
            }
        },
        onSelect: function(start, end){
            document.getElementById('fecha_desc').innerHTML = rangeText(start, end);
        }
    }); 
    $('.select-form').select2();
};

    
</script>