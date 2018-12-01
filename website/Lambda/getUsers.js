var mysql = require('./node_modules/mysql');
var config = require('./config.json');
var validator = require('./validation.js');

function formatErrorResponse(code, errs) {
	return JSON.stringify({ 
		error  : code,
		errors : errs
	});
}

exports.handler = (event, context, callback) => {
	
	context.callbackWaitsForEmptyEventLoop = false;

	//validate input
	var errors = new Array();
	
	 // Validate the user input
	//validator.validatethingId(event.thingid, errors);
	
	
	if(errors.length > 0) {
		// This should be a "Bad Request" error
		callback(formatErrorResponse('BAD_REQUEST', errors));
	} else {
	
	//getConnection equivalent
	var conn = mysql.createConnection({
		host 	: config.dbhost,
		user 	: config.dbuser,
		password : config.dbpassword,
		database : config.dbname
	});
	
	//prevent timeout from waiting event loop
	context.callbackWaitsForEmptyEventLoop = false;

	//attempts to connect to the database
	conn.connect(function(err) {
	  	
		if (err)  {
			// This should be a "Internal Server Error" error
			callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
		}
		console.log("Connected!");
		var sql = "SELECT userid, username, email, isadmin FROM users ORDER BY username";
		
		conn.query(sql, function (err, result) {
		  	if (err) {
				// This should be a "Internal Server Error" error
				callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
					console.log("internal server error");
		  	} else {
		  	
					//Test Event for username
				var things = [];
				for(var i=0; i<result.length; i++){
					
					things[i] = {
					userid : result[i].userid,
					username : result[i].username,
					email: result[i].email,
					isadmin: result[i].isadmin
					}
					
				}
				 //Build an object for the JSON response with the userid and reg codes
				var json = { 
					list : things
				};
		  		console.log("gotUsers");
		  		callback(null, json);
		  		  			setTimeout(function(){conn.end();}, 3000);
		  		//successful logout
				} //good code count
		  	}); //query logout codes
		}); //connect database
	} //no validation errors
}; //handler
