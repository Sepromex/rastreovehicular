

var mysql = require('mysql');
var con = mysql.createConnection({
    host : '127.0.0.1',
    database : 'rasteo_vehicular',
    user : 'root',
    password : 'Sepromex2021@_',
});


con.connect(function(err) {
    if (err) throw err;
    //Select all customers and return the result object:
    con.query("SELECT usuario FROM usuarios", function (err, result, fields) {
      if (err) throw err;
      console.log(result);
    });
  });
  
 

/*conexion.query('SELECT usuario FROM usuarios', function (error, results, fields) {
    if (error)
        throw error;

    results.forEach(result => {
        console.log(result);
    });
});*/


connection.end(); 