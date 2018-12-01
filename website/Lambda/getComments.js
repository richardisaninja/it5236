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
		var sql = "SELECT commentid, commenttext, convert_tz(comments.commentposted,@@session.time_zone,'America/New_York') as commentposted, username, attachmentid, filename FROM comments LEFT JOIN users ON comments.commentuserid = users.userid LEFT JOIN attachments ON comments.commentattachmentid = attachments.attachmentid WHERE commentthingid = ? ORDER BY commentposted ASC";
		
		conn.query(sql, [event.thingid], function (err, result) {
		  	if (err) {
				// This should be a "Internal Server Error" error
				callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
					console.log("internal server error");
		  	} else {
		  		//Test Event for username
				var things = [];
				for(var i=0; i<result.length; i++){
					
					things[i] = {
					commentid : result[i].commentid,
					commenttext : result[i].commenttext,
					commentposted: result[i].commentposted,
					attachmentid: result[i].attachmentid,
					username: result[i].username,
					filename: result[i].filename
					}
					
				}
				 //Build an object for the JSON response with the userid and reg codes
				var json = { 
					list : things
				};
				
		  		console.log("gotThing");
		  		callback(null, json);
		  		//successful logout
				} //good code count
		  	}); //query logout codes
		}); //connect database
	} //no validation errors
}; //handler
