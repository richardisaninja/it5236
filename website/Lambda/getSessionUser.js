var mysql = require('./node_modules/mysql');
var config = require('./config.json');
//var validator = require('./validation.js');

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
	//validator.validateUserPassword(event.passwordhash, event.userid, errors);
	
	
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
		var sql = "SELECT usersessionid, usersessions.userid, email, username, usersessions.registrationcode, isadmin FROM usersessions LEFT JOIN users on usersessions.userid = users.userid WHERE usersessionid = ?";
		
		conn.query(sql, [event.sessionid], function (err, result) {
		  	if (err) {
				// This should be a "Internal Server Error" error
				callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
					console.log("internal server error");
		  	} else {
				// Pull out just the codes from the "result" array (index '1')
		  		var codes = [];
		  		for(var i=0; i<result.length; i++) {
					codes.push(result[i]['registrationcode']);
				}

				 //Build an object for the JSON response with the userid and reg codes
				var json = { 
					usersessionid: event.sessionid,
					userid: result[0].userid,
					registrationcode : result[0].registrationcode,
					username: result[0].username,
					email: result[0].email,
					isadmin: result[0].isadmin
				};
				// Return the json object
				
      			callback(null, json);
      			
      			setTimeout(function(){conn.end();}, 3000);
		  	}
		  	}); //query logout codes
		}); //connect database
	} //no validation errors
}; //handler
