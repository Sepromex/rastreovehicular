<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i>  &nbsp; Configurar Usuario
    </h5>     
    <i class="icon-close icons h3" onclick="acount_formtoggle()"></i>     
</div>

<div class="card-body" id="content-form-company">      
    <?php $this->load->view("acount/users/user_form"); ?>
    <?php $this->load->view("acount/users/vehicle_list"); ?>     
</div>

<script>
    //Plugin documentation 
    //https://wakirin.github.io/Lightpick/ 
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
</script>