//decrementa la cantidad de caracteres que tiene permitidos escribir
function decrementa(texto,cuenta, limite) {
	if (texto.value.length > limite){
		texto.value = texto.value.substring(0, limite);
		alert('Sólo se te permiten: '+limite+' Caracteres');
	}
	else 
		cuenta.value = limite - texto.value.length;
}

function validarext(Filename) { 
var I = Filename.lastIndexOf("."); 
return (I > -1) ? Filename.substring(I + 1, Filename.length).toLowerCase() : ""; 
}

function validarimg() { 
var Form = document.formulario; 
var File = Form.ruta.value; 
 
var Ext = ""; 
if (File== "") 
   { alert("No haz seleccionado ninguna imagen"); return false; } 
 if (File != "") 
 { 
   Ext = validarext(File); 
   if (Ext != "jpeg" && Ext != "jpg" && Ext != "png" && Ext != "gif") 
   { alert("El archivo no es una imagen válida"); return false; } 
   }

return true;   
}

function subirarch()
{
	   if (validarimg(true))
	   {  
	        document.formulario.txtimagen.value=1;
	        document.formulario.txtruta1.value=document.formulario.ruta.value; 
			document.formulario.imagen.src=document.formulario.ruta.value;
		}else{return false;}
}

function validalfa(str,op)
{
     if(op==0)
	 {
       var checkOK = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚ" + "abcdefghijklmnñopqrstuvwxyzáéíóú " + "01234567890";
     }
	 if(op==1)
	 {
	  var checkOK = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚ" + "abcdefghijklmnñopqrstuvwxyzáéíóú ";
	 }
	 if(op==2)
	 {
	  var checkOK = "01234567890";
	 }
     if(op==3)
	 {
       var checkOK = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚ" + "abcdefghijklmnñopqrstuvwxyzáéíóú " + "01234567890" + "#";
     }
	 var checkStr = str;
     var allValid = true;
     for (i = 0; i < checkStr.length; i++) 
	 {
         ch = checkStr.charAt(i);
         for (j = 0; j < checkOK.length; j++)
         if (ch == checkOK.charAt(j))
              break;
         if (j == checkOK.length) 
		 {
              allValid = false;
              break;
          }

      }
	  return allValid;
}

function validar(opt){ 
    //Valido el rfc 
	str1=true;	
    if (document.formulario.txtrfc.value.length==0){ 
       alert("Tiene que escribir su RFC"); 
       document.formulario.txtrfc.focus(); 
       return 0; 
    } 
	else
	{
      str=document.formulario.txtrfc.value;
	  str1=validalfa(str,0);  
	  if (!str1) 
	  {
        alert("Escriba caracteres válidos en el campo RFC");
        formulario.txtrfc.focus();
        return (false);
      }
    }
	
	//Valido Teléfono
	if (document.formulario.txttppal.value.length==0){ 
       alert("Tiene que escribir su teléfono"); 
       document.formulario.txttppal.focus(); 
       return 0; 
    } 
	else
	{
      str=document.formulario.txttppal.value;
	  str1=validalfa(str,2);  
	  if (!str1) 
	  {
        alert("Escriba solo números en el campo Teléfono");
        formulario.txttppal.focus();
        return (false);
      }
	  if(str.lenght<10)
	  {
        alert("El Teléfono debe ser de 10 dígitos");
        formulario.txttppal.focus();
        return (false);	  
	  }
	}

    //Valido CP
    cp = document.formulario.txtcp.value; 
    if (cp==""){ 
       alert("Tiene que introducir un número entero en CP") 
       document.formulario.txtcp.focus(); 
       return 0; 
    }else{ 
       if (cp<10000){ 
          alert("Debe ser un CP válido.");
          document.formulario.txtcp.focus(); 
          return 0; 
       }
	   str=document.formulario.txtcp.value;
	   str1=validalfa(str,2);  
	   if (!str1) 
	   {
         alert("Escriba solo números en el campo CP");
         formulario.txtcp.focus();
         return (false);
       } 
    } 
	
    //Validar domicilio	
   if (document.formulario.txtdom.value.length==0){ 
       alert("Tiene que escribir su domicilio"); 
       document.formulario.txtdom.focus(); 
       return 0; 
    } 
	else
	{
	  str=document.formulario.txtdom.value;
	  str1=validalfa(str,3);  
	  if (!str1) 
	  {
        alert("Escriba solo caracteres válidos en el campo Domicilio");
        formulario.txtdom.focus();
        return (false);
      }
	}
    //valido el Representante Legal 
    if (document.formulario.txtrepleg.value.length==0){ 
       alert("Debe introducir el Representante Legal") 
       document.formulario.txtrepleg.focus() ;
       return 0; 
    } 
	else
	{
	  str=document.formulario.txtrepleg.value;
	  str1=validalfa(str,1);  
	  if (!str1) 
	  {
        alert("Escriba solo caracteres en el campo Representante Legal");
        formulario.txtrepleg.focus();
        return (false);
      }
	
	}
    //el formulario se envia 
    alert("Datos actualizados"); 
	document.formulario.txtguarda.value=1;   
    document.formulario.submit(); 
	Activa(2);
} 

function Activa(op) {
  if (op==1)
  {
	rz=document.forms['formulario'].elements['txtrz'];
	rz.removeAttribute('readOnly');
	rz.style.border="inset";  
	document.forms['formulario'].elements['txtrfc'].removeAttribute('readOnly');
	document.forms['formulario'].elements['txtrfc'].style.border="inset";  
	document.forms['formulario'].elements['txttppal'].removeAttribute('readOnly'); 
	document.forms['formulario'].elements['txttppal'].style.border="inset";  
	document.forms['formulario'].elements['txtcp'].removeAttribute('readOnly'); 
	document.forms['formulario'].elements['txtcp'].style.border="inset";  
	document.forms['formulario'].elements['txtdom'].removeAttribute('readOnly');
	document.forms['formulario'].elements['txtdom'].style.border="inset";  
	document.forms['formulario'].elements['txtrepleg'].removeAttribute('readOnly'); 
	document.forms['formulario'].elements['txtrepleg'].style.border="inset"; 
	document.forms['formulario'].elements['imagen'].removeAttribute('readOnly'); 
	document.forms['formulario'].elements['imagen'].style.border="inset";   
    document.forms['formulario'].elements['editar'].style.visibility="hidden";
    document.forms['formulario'].elements['guardar'].style.visibility="visible";
	document.forms['formulario'].elements['cancelar'].style.visibility="visible";  
	document.forms['formulario'].elements['ruta'].style.visibility="visible";
	document.forms['formulario'].elements['logo'].style.visibility="visible";
	document.formulario.txtruta2.value=document.formulario.imagen.src;
  }
  if(op==3||op==2)
  {
	document.forms['formulario'].elements['txtrz'].setAttribute('readOnly',true);
	document.forms['formulario'].elements['txtrz'].style.backgroundColor = "White"; 
	document.forms['formulario'].elements['txtrz'].style.border="White"; 
	document.forms['formulario'].elements['txtrfc'].setAttribute('readOnly',true);
	document.forms['formulario'].elements['txtrfc'].style.backgroundColor = "White"; 
	document.forms['formulario'].elements['txtrfc'].style.border="White";
	document.forms['formulario'].elements['txttppal'].setAttribute('readOnly',true);
	document.forms['formulario'].elements['txttppal'].style.backgroundColor = "White"; 
	document.forms['formulario'].elements['txttppal'].style.border="White"; 
	document.forms['formulario'].elements['txtdom'].setAttribute('readOnly',true);
	document.forms['formulario'].elements['txtdom'].style.backgroundColor = "White"; 
	document.forms['formulario'].elements['txtdom'].style.border="White"; 
	document.forms['formulario'].elements['txtcp'].setAttribute('readOnly',true);
	document.forms['formulario'].elements['txtcp'].style.backgroundColor = "White"; 
	document.forms['formulario'].elements['txtcp'].style.border="White"; 
	document.forms['formulario'].elements['txtrepleg'].setAttribute('readOnly',true);
	document.forms['formulario'].elements['txtrepleg'].style.backgroundColor = "White"; 
	document.forms['formulario'].elements['txtrepleg'].style.border="White";  
	document.forms['formulario'].elements['imagen'].setAttribute('readOnly',true);
	document.forms['formulario'].elements['imagen'].style.backgroundColor = "White"; 
	document.forms['formulario'].elements['imagen'].style.border="White";  
	document.forms['formulario'].elements['editar'].style.visibility="visible";
    document.forms['formulario'].elements['guardar'].style.visibility="hidden";
	document.forms['formulario'].elements['cancelar'].style.visibility="hidden";
	document.formulario.ruta.style.visibility="hidden";
	document.formulario.logo.style.visibility="hidden";
  }
  if(op==3)
  {
            document.formulario.txtimagen.value=0;
	        document.formulario.txtruta1.value=0; 
			document.formulario.imagen.src=document.formulario.txtruta2.value;
  }
  
  return op;
}