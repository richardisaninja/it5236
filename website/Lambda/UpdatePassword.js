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
//	validator.validatePasswordResetID(event.passwordresetid, errors);
	
	
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
		var sql = "SELECT userid FROM passwordreset WHERE passwordresetid = ?";
		
		conn.query(sql, [event.passwordresetid], function (err, result) {
		  	if (err) {
				// This should be a "Internal Server Error" error
				callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
					console.log("internal server error");
		  	} else {
		  	
				// Build an object for the JSON response with the userid and reg codes
				var json = { 
					userid : result[0].userid
				};
				
		  		console.log("gotThing");
		  		callback(null, json);
		  		setTimeout(function(){conn.end();}, 3000);
		  		//successful logout
				} //good code count
		  	}); //query logout codes
		}); //connect database
	} //no validation errors
}; //handler
